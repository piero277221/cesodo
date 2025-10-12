<?php
namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Producto;
use App\Models\RecetaIngrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RecetaController extends Controller
{
    public function index(Request $request)
    {
        $query = Receta::with(['ingredientes.producto', 'createdBy'])
                      ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }
        if ($request->filled('tipo_plato')) {
            $query->where('tipo_plato', $request->tipo_plato);
        }
        if ($request->filled('dificultad')) {
            $query->where('dificultad', $request->dificultad);
        }
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        $recetas = $query->paginate(12)->withQueryString();
        return view('recetas.index', compact('recetas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::where('estado', 'activo')
                            ->orderBy('nombre')
                            ->get();

        return view('recetas.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:recetas,nombre',
            'descripcion' => 'nullable|string',
            'tipo_plato' => 'required|in:entrada,plato_principal,postre,bebida,guarnicion,sopa,ensalada',
            'dificultad' => 'required|in:facil,media,intermedio,dificil,muy_dificil',
            'tiempo_preparacion' => 'required|integer|min:1|max:600',
            'porciones' => 'required|integer|min:1|max:50',
            'instrucciones' => 'required|string',
            'notas' => 'nullable|string',
            'ingredientes_especiales' => 'nullable|string',
            'costo_aproximado' => 'nullable|numeric|min:0|max:9999.99',
            'estado' => 'required|in:activo,inactivo',

            // Pasos de preparación
            'pasos_preparacion' => 'required|array|min:1',
            'pasos_preparacion.*' => 'required|string|max:500',

            // Ingredientes
            'ingredientes' => 'required|array|min:1',
            'ingredientes.*.producto_id' => 'required|exists:productos,id',
            'ingredientes.*.cantidad' => 'required|numeric|min:0.01',
            'ingredientes.*.unidad' => 'required|string|max:50',
            'ingredientes.*.notas' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Crear la receta
            $receta = Receta::create([
                'nombre' => $validated['nombre'],
                'descripcion' => $validated['descripcion'],
                'tipo_plato' => $validated['tipo_plato'],
                'dificultad' => $validated['dificultad'],
                'tiempo_preparacion' => $validated['tiempo_preparacion'],
                'porciones' => $validated['porciones'],
                'instrucciones' => $validated['instrucciones'],
                'notas' => $validated['notas'],
                'ingredientes_especiales' => $validated['ingredientes_especiales'],
                'costo_aproximado' => $validated['costo_aproximado'],
                'estado' => $validated['estado'],
                'pasos_preparacion' => json_encode($validated['pasos_preparacion']),
                'created_by' => Auth::id(),
            ]);

            // Crear los ingredientes
            foreach ($validated['ingredientes'] as $ingrediente) {
                RecetaIngrediente::create([
                    'receta_id' => $receta->id,
                    'producto_id' => $ingrediente['producto_id'],
                    'cantidad' => $ingrediente['cantidad'],
                    'unidad_medida' => $ingrediente['unidad'],
                    'observaciones' => $ingrediente['notas'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('recetas.show', $receta)
                           ->with('success', 'Receta creada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                        ->with('error', 'Error al crear la receta: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Receta $receta)
    {
        $receta->load(['ingredientes.producto', 'createdBy']);

        return view('recetas.show', compact('receta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Receta $receta)
    {
        $receta->load(['ingredientes.producto']);

        $productos = Producto::where('estado', 'activo')
                            ->orderBy('nombre')
                            ->get();

        return view('recetas.edit', compact('receta', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Receta $receta)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255',
                        Rule::unique('recetas', 'nombre')->ignore($receta->id)],
            'descripcion' => 'nullable|string',
            'tipo_plato' => 'required|in:entrada,plato_principal,postre,bebida,guarnicion,sopa,ensalada',
            'dificultad' => 'required|in:facil,media,intermedio,dificil,muy_dificil',
            'tiempo_preparacion' => 'required|integer|min:1|max:600',
            'porciones' => 'required|integer|min:1|max:50',
            'instrucciones' => 'required|string',
            'notas' => 'nullable|string',
            'ingredientes_especiales' => 'nullable|string',
            'costo_aproximado' => 'nullable|numeric|min:0|max:9999.99',
            'estado' => 'required|in:activo,inactivo',

            // Ingredientes
            'ingredientes' => 'required|array|min:1',
            'ingredientes.*.producto_id' => 'required|exists:productos,id',
            'ingredientes.*.cantidad' => 'required|numeric|min:0.01',
            'ingredientes.*.unidad' => 'required|string|max:50',
            'ingredientes.*.notas' => 'nullable|string|max:255',
        ]);
    }

    /**
     * Analiza el texto de la receta y detecta ingredientes, cantidades y unidades usando fuzzy search.
     * Devuelve los ingredientes encontrados y advertencias si no existen en inventario.
     */
    public function analizarIngredientes(Request $request)
    {
        $texto = $request->input('texto_receta');
        if (!$texto) {
            return response()->json(['error' => 'No se recibió texto de receta.'], 400);
        }

        // Obtener todos los productos activos
        $productos = Producto::where('estado', 'activo')->get();
        $nombresProductos = $productos->pluck('nombre')->toArray();

        // Tres patrones de regex para capturar diferentes formatos:
        // Patrón 1: "cantidad unidad/palabra de nombre" (ej: 2 tazas de arroz, 4 piernas de pollo)
        $regex1 = '/(\d+[\.,]?\d*|½|⅓|¼|⅔|¾|1\/2|1\/3|1\/4|2\/3|3\/4)\s+([\wáéíóúñ\- ]+?)\s+de\s+([\wáéíóúñ\- ]+)/iu';
        // Patrón 2: "cantidad unidad nombre" con unidades métricas (ej: 2 kg arroz, 500 g tomate)
        $regex2 = '/(\d+[\.,]?\d*|½|⅓|¼|⅔|¾|1\/2|1\/3|1\/4|2\/3|3\/4)\s+(kg|kilogramo|gramos?|g|litros?|l|ml|mililitros?|lb|oz)\s+([\wáéíóúñ\- ]+)/iu';
        // Patrón 3: "cantidad palabra palabra" sin "de" para casos como "4 piernas pollo"
        $regex3 = '/(\d+[\.,]?\d*|½|⅓|¼|⅔|¾|1\/2|1\/3|1\/4|2\/3|3\/4)\s+([\wáéíóúñ]+)\s+([\wáéíóúñ]+)/iu';

        $resultados = [];
        $advertencias = [];
        $ingredientesDetectados = []; // Para evitar duplicados

        // Primero buscar con patrón 1 (con "de")
        preg_match_all($regex1, $texto, $matches1, PREG_SET_ORDER);

        foreach ($matches1 as $m) {
            $cantidadStr = $m[1];
            $unidad = strtolower($m[2]);
            $nombreDetectado = trim($m[3]);

            $this->procesarIngrediente($cantidadStr, $unidad, $nombreDetectado, $productos, $nombresProductos, $resultados, $advertencias, $ingredientesDetectados);
        }

        // Luego buscar con patrón 2 (unidades métricas sin "de")
        preg_match_all($regex2, $texto, $matches2, PREG_SET_ORDER);

        foreach ($matches2 as $m) {
            $cantidadStr = $m[1];
            $unidad = strtolower($m[2]);
            $nombreDetectado = trim($m[3]);

            // Saltar si ya fue procesado
            $yaEncontrado = false;
            foreach ($resultados as $ing) {
                similar_text(mb_strtolower($ing['nombre']), mb_strtolower($nombreDetectado), $sim);
                if ($sim > 80) {
                    $yaEncontrado = true;
                    break;
                }
            }
            if ($yaEncontrado) continue;

            $this->procesarIngrediente($cantidadStr, $unidad, $nombreDetectado, $productos, $nombresProductos, $resultados, $advertencias, $ingredientesDetectados);
        }

        // Por último, patrón 3 (formato simple sin "de")
        preg_match_all($regex3, $texto, $matches3, PREG_SET_ORDER);

        foreach ($matches3 as $m) {
            $cantidadStr = $m[1];
            $unidad = strtolower($m[2]); // Puede ser "taza", "piernas", etc.
            $nombreDetectado = trim($m[3]);

            // Saltar si ya fue procesado
            $yaEncontrado = false;
            foreach ($resultados as $ing) {
                $nombreCompleto = $unidad . ' ' . $nombreDetectado;
                similar_text(mb_strtolower($ing['nombre']), mb_strtolower($nombreDetectado), $sim);
                similar_text(mb_strtolower($ing['nombre']), mb_strtolower($nombreCompleto), $sim2);
                if ($sim > 70 || $sim2 > 70) {
                    $yaEncontrado = true;
                    break;
                }
            }
            if ($yaEncontrado) continue;

            $this->procesarIngrediente($cantidadStr, $unidad, $nombreDetectado, $productos, $nombresProductos, $resultados, $advertencias, $ingredientesDetectados);
        }

        return response()->json([
            'ingredientes' => $resultados,
            'advertencias' => $advertencias,
        ]);
    }

    private function procesarIngrediente($cantidadStr, $unidad, $nombreDetectado, $productos, $nombresProductos, &$resultados, &$advertencias, &$ingredientesDetectados)
    {
        // Saltar nombres muy genéricos o cortos
        $nombresGenericos = ['de', 'del', 'la', 'el', 'los', 'las', 'ingrediente', 'ingredientes', 'y', 'o', 'con'];
        if (strlen($nombreDetectado) < 3 || in_array(mb_strtolower($nombreDetectado), $nombresGenericos)) {
            return;
        }

        // Convertir fracciones a decimales
        if (strpos($cantidadStr, '/') !== false) {
            list($num, $den) = explode('/', $cantidadStr);
            $cantidad = floatval($num) / floatval($den);
        } elseif ($cantidadStr == '½') {
            $cantidad = 0.5;
        } elseif ($cantidadStr == '¼') {
            $cantidad = 0.25;
        } elseif ($cantidadStr == '¾') {
            $cantidad = 0.75;
        } elseif ($cantidadStr == '⅓') {
            $cantidad = 0.33;
        } elseif ($cantidadStr == '⅔') {
            $cantidad = 0.67;
        } else {
            $cantidad = floatval(str_replace(',', '.', $cantidadStr));
        }

        // Fuzzy search: buscar el producto más parecido
        $productoEncontrado = null;
        $maxSimilitud = 0;
        foreach ($nombresProductos as $nombreProducto) {
            similar_text(mb_strtolower($nombreDetectado), mb_strtolower($nombreProducto), $similitud);
            if ($similitud > $maxSimilitud) {
                $maxSimilitud = $similitud;
                $productoEncontrado = $nombreProducto;
            }
        }

        // Considerar coincidencia si similitud > 55% (muy flexible)
        if ($maxSimilitud >= 55) {
            $producto = $productos->firstWhere('nombre', $productoEncontrado);
            $key = $producto->id;
            if (!isset($ingredientesDetectados[$key])) {
                $resultados[] = [
                    'producto_id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'cantidad' => $cantidad,
                    'unidad' => $unidad,
                ];
                $ingredientesDetectados[$key] = true;
            }
        } else {
            // Solo advertencia para nombres significativos
            if (strlen($nombreDetectado) > 5) {
                $advertencias[] = "Ingrediente no encontrado: $nombreDetectado";
            }
        }
    }

// ...existing code...
    /**
     * Calcular costo automáticamente basado en ingredientes
     */
}
