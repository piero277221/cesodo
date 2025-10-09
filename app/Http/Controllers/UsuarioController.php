<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Persona;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::with(['persona', 'trabajador', 'roles'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $personas = Persona::whereDoesntHave('usuario')->get();
        $trabajadores = Trabajador::whereDoesntHave('usuario')->get();
        $roles = Role::all();

        return view('usuarios.create', compact('personas', 'trabajadores', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'persona_id' => 'nullable|exists:personas,id',
            'trabajador_id' => 'nullable|exists:trabajadores,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'generar_credenciales' => 'boolean',
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $usuario = new User();

            // Si se selecciona una persona, usar sus datos
            if ($request->persona_id) {
                $persona = Persona::find($request->persona_id);
                $usuario->persona_id = $persona->id;
                $usuario->name = $persona->nombre_completo;

                // Generar email automáticamente si no se proporciona
                if (!$request->email) {
                    $usuario->email = $this->generarEmailUnico($persona);
                } else {
                    $usuario->email = $request->email;
                }

                $usuario->dni = $persona->numero_documento;
                $usuario->telefono = $persona->celular;
            } else {
                $usuario->name = $request->name;
                $usuario->email = $request->email;
            }

            // Si se selecciona un trabajador
            if ($request->trabajador_id) {
                $trabajador = Trabajador::find($request->trabajador_id);
                $usuario->trabajador_id = $trabajador->id;
                $usuario->codigo_empleado = $trabajador->codigo;

                // Si el trabajador tiene persona asociada, usar esos datos
                if ($trabajador->persona && !$request->persona_id) {
                    $usuario->persona_id = $trabajador->persona_id;
                    $usuario->name = $trabajador->persona->nombre_completo;
                    $usuario->email = $this->generarEmailUnico($trabajador->persona);
                    $usuario->dni = $trabajador->persona->numero_documento;
                    $usuario->telefono = $trabajador->persona->celular;
                }
            }

            // Generar contraseña automáticamente si se solicita
            if ($request->generar_credenciales) {
                $passwordTemporal = $this->generarPasswordTemporal($usuario);
                $usuario->password = Hash::make($passwordTemporal);
                $usuario->cambiar_password = true;
            } else {
                $usuario->password = Hash::make('password123'); // Password por defecto
                $usuario->cambiar_password = true;
            }

            $usuario->estado = 'activo';
            $usuario->observaciones = $request->observaciones;
            $usuario->save();

            // Asignar roles
            if ($request->roles) {
                $usuario->assignRole($request->roles);
            }

            DB::commit();

            $mensaje = 'Usuario creado exitosamente.';
            if ($request->generar_credenciales) {
                $mensaje .= " Credenciales: {$usuario->email} / {$passwordTemporal}";
            }

            return redirect()->route('usuarios.index')
                ->with('success', $mensaje);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Error al crear usuario: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $usuario)
    {
        $usuario->load(['persona', 'trabajador', 'roles', 'permissions']);
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuario)
    {
        $personas = Persona::whereDoesntHave('usuario')
            ->orWhere('id', $usuario->persona_id)
            ->get();
        $trabajadores = Trabajador::whereDoesntHave('usuario')
            ->orWhere('id', $usuario->trabajador_id)
            ->get();
        $roles = Role::all();
        $usuarioRoles = $usuario->roles->pluck('name')->toArray();

        return view('usuarios.edit', compact('usuario', 'personas', 'trabajadores', 'roles', 'usuarioRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'persona_id' => 'nullable|exists:personas,id',
            'trabajador_id' => 'nullable|exists:trabajadores,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'estado' => 'required|in:activo,inactivo',
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $usuario->update([
                'persona_id' => $request->persona_id,
                'trabajador_id' => $request->trabajador_id,
                'name' => $request->name,
                'email' => $request->email,
                'estado' => $request->estado,
                'observaciones' => $request->observaciones,
            ]);

            // Actualizar roles
            $usuario->syncRoles($request->roles ?? []);

            DB::commit();

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Error al actualizar usuario: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usuario)
    {
        try {
            \Log::info('=== INTENTO DE ELIMINACIÓN DE USUARIO ===');
            \Log::info('Usuario ID: ' . $usuario->id);
            \Log::info('Usuario nombre: ' . $usuario->name);

            $usuario->delete();

            \Log::info('Usuario eliminado exitosamente');

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario eliminado exitosamente.');
        } catch (\Exception $e) {
            \Log::error('Error al eliminar usuario: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return back()->withErrors(['error' => 'Error al eliminar usuario: ' . $e->getMessage()]);
        }
    }

    /**
     * Resetear contraseña del usuario
     */
    public function resetPassword(User $usuario)
    {
        try {
            $nuevaPassword = $this->generarPasswordTemporal($usuario);
            $usuario->update([
                'password' => Hash::make($nuevaPassword),
                'cambiar_password' => true
            ]);

            return back()->with('success', "Contraseña reseteada. Nueva contraseña: {$nuevaPassword}");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al resetear contraseña: ' . $e->getMessage()]);
        }
    }

    /**
     * Generar email único basado en la persona
     */
    private function generarEmailUnico(Persona $persona)
    {
        $emailBase = $persona->email_sugerido;
        $contador = 1;
        $emailFinal = $emailBase;

        while (User::where('email', $emailFinal)->exists()) {
            $emailFinal = str_replace('@cesodo.com', $contador . '@cesodo.com', $emailBase);
            $contador++;
        }

        return $emailFinal;
    }

    /**
     * Generar contraseña temporal
     */
    private function generarPasswordTemporal(User $usuario)
    {
        // Usar iniciales + números del DNI si está disponible
        if ($usuario->dni) {
            $iniciales = '';
            $nombres = explode(' ', $usuario->name);
            foreach ($nombres as $nombre) {
                $iniciales .= strtoupper(substr($nombre, 0, 1));
            }
            return $iniciales . substr($usuario->dni, -4);
        }

        // Fallback: generar password aleatorio
        return 'Temp' . rand(1000, 9999);
    }

    /**
     * API para obtener datos de persona
     */
    public function getPersonaData(Request $request)
    {
        $persona = Persona::find($request->persona_id);

        if (!$persona) {
            return response()->json(['error' => 'Persona no encontrada'], 404);
        }

        return response()->json([
            'nombre_completo' => $persona->nombre_completo,
            'email_sugerido' => $persona->email_sugerido,
            'dni' => $persona->numero_documento,
            'telefono' => $persona->celular,
        ]);
    }

    /**
     * API para obtener datos de trabajador
     */
    public function getTrabajadorData(Request $request)
    {
        $trabajador = Trabajador::with('persona')->find($request->trabajador_id);

        if (!$trabajador) {
            return response()->json(['error' => 'Trabajador no encontrado'], 404);
        }

        return response()->json([
            'codigo' => $trabajador->codigo,
            'nombre_completo' => $trabajador->persona ? $trabajador->persona->nombre_completo : $trabajador->nombre_completo,
            'email_sugerido' => $trabajador->persona ? $trabajador->persona->email_sugerido : null,
            'dni' => $trabajador->persona ? $trabajador->persona->numero_documento : $trabajador->dni,
            'telefono' => $trabajador->persona ? $trabajador->persona->celular : null,
            'persona_id' => $trabajador->persona_id,
        ]);
    }
}
