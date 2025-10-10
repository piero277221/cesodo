<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('name')->get();
        $permissions = Permission::all()->groupBy(function ($permission) {
            // Agrupar permisos por módulo basado en el prefijo
            $parts = explode('-', $permission->name);
            return count($parts) > 1 ? $parts[1] : 'general';
        });
        
        return view('role-management.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            $parts = explode('-', $permission->name);
            return count($parts) > 1 ? $parts[1] : 'general';
        });
        
        return view('role-management.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        try {
            DB::beginTransaction();

            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);

            if ($request->has('permissions')) {
                $permissions = Permission::whereIn('id', $request->permissions)->get();
                $role->givePermissionTo($permissions);
            }

            DB::commit();

            return redirect()->route('role-management.index')
                ->with('success', 'Rol creado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al crear el rol: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role_management)
    {
        $role = $role_management->load('permissions', 'users');
        $allPermissions = Permission::all()->groupBy(function ($permission) {
            $parts = explode('-', $permission->name);
            return count($parts) > 1 ? $parts[1] : 'general';
        });
        
        return view('role-management.show', compact('role', 'allPermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role_management)
    {
        $role = $role_management->load('permissions');
        $permissions = Permission::all()->groupBy(function ($permission) {
            $parts = explode('-', $permission->name);
            return count($parts) > 1 ? $parts[1] : 'general';
        });
        
        return view('role-management.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role_management)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role_management->id,
            'description' => 'nullable|string',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        try {
            DB::beginTransaction();

            $role_management->update([
                'name' => $request->name
            ]);

            // Sincronizar permisos
            if ($request->has('permissions')) {
                $permissions = Permission::whereIn('id', $request->permissions)->get();
                $role_management->syncPermissions($permissions);
            } else {
                $role_management->syncPermissions([]);
            }

            DB::commit();

            return redirect()->route('role-management.index')
                ->with('success', 'Rol actualizado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar el rol: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role_management)
    {
        try {
            // Verificar si el rol tiene usuarios asignados
            if ($role_management->users()->count() > 0) {
                return back()->withErrors(['error' => 'No se puede eliminar un rol que tiene usuarios asignados']);
            }

            $role_management->delete();

            return redirect()->route('role-management.index')
                ->with('success', 'Rol eliminado exitosamente');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al eliminar el rol: ' . $e->getMessage()]);
        }
    }

    /**
     * Matriz visual de permisos
     */
    public function matrix()
    {
        $roles = Role::with('permissions')->orderBy('name')->get();
        $permissions = Permission::all()->groupBy(function ($permission) {
            $parts = explode('-', $permission->name);
            return count($parts) > 1 ? $parts[1] : 'general';
        });
        
        return view('role-management.matrix', compact('roles', 'permissions'));
    }

    /**
     * Actualizar matriz de permisos masivamente
     */
    public function updateMatrix(Request $request)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'array',
            'permissions.*.*' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->input('permissions', []) as $roleId => $rolePermissions) {
                $role = Role::findOrFail($roleId);
                $permissionIds = [];

                foreach ($rolePermissions as $permissionId => $granted) {
                    if ($granted) {
                        $permissionIds[] = $permissionId;
                    }
                }

                $permissions = Permission::whereIn('id', $permissionIds)->get();
                $role->syncPermissions($permissions);
            }

            DB::commit();

            return redirect()->route('role-management.matrix')
                ->with('success', 'Matriz de permisos actualizada exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar permisos: ' . $e->getMessage()]);
        }
    }

    /**
     * Clonar rol
     */
    public function clone(Role $role_management)
    {
        try {
            DB::beginTransaction();

            $newRole = Role::create([
                'name' => $role_management->name . ' (Copia)',
                'guard_name' => 'web'
            ]);

            $newRole->givePermissionTo($role_management->permissions);

            DB::commit();

            return redirect()->route('role-management.edit', $newRole)
                ->with('success', 'Rol clonado exitosamente. Puedes editarlo ahora.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al clonar el rol: ' . $e->getMessage()]);
        }
    }

    /**
     * Obtener estadísticas de roles
     */
    public function stats()
    {
        $stats = [
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
            'roles_with_users' => Role::has('users')->count(),
            'most_used_role' => Role::withCount('users')->orderBy('users_count', 'desc')->first(),
            'permissions_by_module' => Permission::all()->groupBy(function ($permission) {
                $parts = explode('-', $permission->name);
                return count($parts) > 1 ? $parts[1] : 'general';
            })->map->count()
        ];

        return view('role-management.stats', compact('stats'));
    }
}
