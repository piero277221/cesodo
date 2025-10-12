# Sistema de Fecha de Vencimiento para Productos

## 📅 Funcionalidad Implementada

Se agregó un sistema completo de gestión de fechas de vencimiento para productos, con notificaciones automáticas integradas en la campanita general del sistema.

## ✨ Características Principales

### 1. **Campos de Vencimiento**
- **Fecha de Vencimiento:** Campo opcional para indicar cuándo vence el producto
- **Días de Alerta:** Días antes del vencimiento para empezar a notificar (default: 30 días)

### 2. **Notificaciones Automáticas**
- Aparecen en la **campanita general** junto con certificados médicos
- Dos tipos de notificaciones:
  - **Productos próximos a vencer** (dentro del período de alerta)
  - **Productos vencidos**

### 3. **Indicadores Visuales**
- Badges en el formulario de edición:
  - 🔴 **Rojo:** Producto vencido
  - 🟡 **Amarillo:** Próximo a vencer
  - 🟢 **Verde:** Producto vigente

## 🗄️ Estructura de Base de Datos

### Migración: `add_fecha_vencimiento_to_productos_table.php`

```php
Schema::table('productos', function (Blueprint $table) {
    $table->date('fecha_vencimiento')->nullable();
    $table->integer('dias_alerta_vencimiento')->default(30)
          ->comment('Días antes del vencimiento para notificar');
});
```

### Campos Agregados a la Tabla `productos`

| Campo | Tipo | Nullable | Default | Descripción |
|-------|------|----------|---------|-------------|
| `fecha_vencimiento` | DATE | ✅ | NULL | Fecha de vencimiento del producto |
| `dias_alerta_vencimiento` | INTEGER | ❌ | 30 | Días antes para alertar |

## 💻 Modelo Producto

### Nuevos Métodos

```php
// Verificar si está vencido
$producto->estaVencido(); // true/false

// Verificar si está próximo a vencer
$producto->estaProximoAVencer(); // true/false

// Obtener días restantes
$producto->diasRestantesVencimiento(); // int (negativo si vencido)

// Texto legible del tiempo
$producto->tiempoVencimientoTexto(); // "Vence en 5 días"
```

### Nuevos Scopes

```php
// Productos próximos a vencer
Producto::proximosAVencer()->get();
Producto::proximosAVencer(15)->get(); // Próximos 15 días

// Productos vencidos
Producto::vencidos()->get();
```

## 📝 Formularios

### Formulario de Creación

```html
<div class="mt-3">
    <label for="fecha_vencimiento" class="form-label">
        <i class="fas fa-calendar-times me-1 text-warning"></i>
        Fecha de Vencimiento
    </label>
    <input type="date" name="fecha_vencimiento" 
           min="{{ date('Y-m-d') }}">
    <small class="text-muted">
        Opcional. Si el producto no vence, dejar en blanco.
    </small>
</div>

<div class="mt-3">
    <label for="dias_alerta_vencimiento" class="form-label">
        <i class="fas fa-bell me-1 text-info"></i>
        Días de Alerta antes del Vencimiento
    </label>
    <input type="number" name="dias_alerta_vencimiento" 
           value="30" min="1" max="365">
</div>
```

### Formulario de Edición

Incluye los campos anteriores más **badges de estado**:

```blade
@if($producto->fecha_vencimiento)
    <div class="mt-2">
        @if($producto->estaVencido())
            <span class="badge bg-danger">
                <i class="fas fa-exclamation-triangle me-1"></i>
                {{ $producto->tiempoVencimientoTexto() }}
            </span>
        @elseif($producto->estaProximoAVencer())
            <span class="badge bg-warning text-dark">
                <i class="fas fa-clock me-1"></i>
                {{ $producto->tiempoVencimientoTexto() }}
            </span>
        @else
            <span class="badge bg-success">
                <i class="fas fa-check me-1"></i>
                {{ $producto->tiempoVencimientoTexto() }}
            </span>
        @endif
    </div>
@endif
```

## 🔔 Sistema de Notificaciones

### Integración en `NotificacionController`

```php
// 4. Productos próximos a vencer
$productosProximos = Producto::with('categoria')
    ->where('estado', 'activo')
    ->proximosAVencer()
    ->get();

foreach ($productosProximos as $producto) {
    $diasRestantes = $producto->diasRestantesVencimiento();
    $tiempoTexto = $producto->tiempoVencimientoTexto();

    $notificaciones[] = [
        'tipo' => 'producto_proximo_vencer',
        'prioridad' => $diasRestantes <= 7 ? 'alta' : 'media',
        'titulo' => 'Producto próximo a vencer',
        'mensaje' => "{$producto->nombre} - {$tiempoTexto}",
        'icono' => 'fa-box-open',
        'color' => $diasRestantes <= 7 ? 'danger' : 'warning',
        'enlace' => route('productos.show', $producto->id),
        'fecha' => $producto->fecha_vencimiento,
        // ... más datos
    ];
}
```

### Tipos de Notificaciones de Productos

| Tipo | Prioridad | Color | Condición |
|------|-----------|-------|-----------|
| `producto_proximo_vencer` | Alta (≤7 días) / Media (>7 días) | Rojo / Amarillo | Dentro del período de alerta |
| `producto_vencido` | Alta | Rojo | Fecha vencimiento < hoy |

## 🎨 Interfaz de Usuario

### Campanita de Notificaciones

Las notificaciones de productos aparecen en la misma campanita donde se muestran:
- Certificados médicos por vencer
- Certificados médicos vencidos
- Contratos por vencer

### Texto Legible del Tiempo

El método `tiempoVencimientoTexto()` genera textos amigables:

```php
// Vencido
"Vencido hace 1 día"
"Vencido hace 15 días"

// Por vencer
"Vence hoy"
"Vence mañana"
"Vence en 5 días"
"Vence en 2 semanas"
"Vence en 3 meses"
```

## ✅ Validaciones

### En el Controller

```php
$validated = $request->validate([
    // ... otros campos
    'fecha_vencimiento' => 'nullable|date|after_or_equal:today',
    'dias_alerta_vencimiento' => 'nullable|integer|min:1|max:365',
]);
```

### Reglas de Validación

| Campo | Reglas |
|-------|--------|
| `fecha_vencimiento` | Opcional, debe ser fecha, no puede ser pasada |
| `dias_alerta_vencimiento` | Opcional, entero entre 1 y 365 |

## 🔄 Flujo de Uso

### Caso 1: Producto Perecedero

```
1. Crear producto (ej: Leche fresca)
2. Establecer fecha_vencimiento: 2025-10-22
3. Configurar dias_alerta_vencimiento: 7 días
4. El sistema notifica desde: 2025-10-15
5. Si hoy es 2025-10-20:
   → Notificación: "Leche fresca - Vence en 2 días" (Prioridad ALTA)
```

### Caso 2: Producto con Vencimiento Lejano

```
1. Crear producto (ej: Arroz envasado)
2. Establecer fecha_vencimiento: 2026-06-15
3. Configurar dias_alerta_vencimiento: 30 días
4. El sistema notifica desde: 2026-05-16
5. Si hoy es 2025-10-12:
   → Sin notificación (faltan más de 30 días)
```

### Caso 3: Producto Sin Vencimiento

```
1. Crear producto (ej: Sal)
2. Dejar fecha_vencimiento en blanco
3. dias_alerta_vencimiento: valor por defecto (30)
4. Resultado:
   → Nunca genera notificaciones
   → tiempoVencimientoTexto() retorna: "Sin fecha de vencimiento"
```

## 📊 Ejemplo de Datos

### Producto con Vencimiento Próximo

```php
[
    'codigo' => 'LECH001',
    'nombre' => 'Leche Entera Gloria',
    'categoria_id' => 5, // Lácteos
    'unidad_medida' => 'litros',
    'precio_unitario' => 4.50,
    'stock_minimo' => 20,
    'estado' => 'activo',
    'fecha_vencimiento' => '2025-10-18', // ¡Próximo a vencer!
    'dias_alerta_vencimiento' => 7
]
```

**Estado:** Si hoy es 2025-10-12
- Días restantes: 6 días
- Estado: Próximo a vencer
- Prioridad: Alta (≤7 días)
- Notificación: ✅ Sí (dentro del período de alerta)

### Producto Vencido

```php
[
    'codigo' => 'YOGU002',
    'nombre' => 'Yogurt Natural Gloria',
    'fecha_vencimiento' => '2025-10-05', // ¡Vencido!
    'dias_alerta_vencimiento' => 5
]
```

**Estado:** Si hoy es 2025-10-12
- Días restantes: -7 (vencido hace 7 días)
- Estado: Vencido
- Prioridad: Alta
- Texto: "Vencido hace 7 días"

## 🎯 Beneficios del Sistema

### Para la Gestión
- ✅ Control automático de vencimientos
- ✅ Prevención de pérdidas por productos vencidos
- ✅ Alertas tempranas configurables
- ✅ Mejor rotación de inventario

### Para la Seguridad
- ✅ Evita uso de productos vencidos
- ✅ Cumplimiento de normativas sanitarias
- ✅ Trazabilidad de fechas de vencimiento

### Para la Operación
- ✅ Notificaciones centralizadas
- ✅ Priorización automática (alta/media)
- ✅ Textos legibles y claros
- ✅ Integración con sistema existente

## 🔍 Consultas Útiles

### Listar productos próximos a vencer

```php
$productosProximos = Producto::proximosAVencer()
    ->with('categoria')
    ->where('estado', 'activo')
    ->get();
```

### Listar productos vencidos

```php
$productosVencidos = Producto::vencidos()
    ->with('categoria')
    ->where('estado', 'activo')
    ->get();
```

### Contar productos por vencer en los próximos 7 días

```php
$count = Producto::proximosAVencer(7)
    ->where('estado', 'activo')
    ->count();
```

### Productos que vencen hoy

```php
$productsHoy = Producto::where('estado', 'activo')
    ->whereDate('fecha_vencimiento', today())
    ->get();
```

## 📁 Archivos Modificados

### Migración
- `database/migrations/2025_10_12_163748_add_fecha_vencimiento_to_productos_table.php`

### Modelos
- `app/Models/Producto.php`

### Controladores
- `app/Http/Controllers/ProductoController.php`
- `app/Http/Controllers/NotificacionController.php`

### Vistas
- `resources/views/productos/create.blade.php`
- `resources/views/productos/edit.blade.php`

## 🚀 Próximas Mejoras Posibles

1. **Reportes de Vencimiento**
   - Dashboard con productos próximos a vencer
   - Gráficos de vencimientos por categoría
   - Exportación a Excel/PDF

2. **Notificaciones por Email**
   - Envío automático de alertas
   - Resumen diario/semanal
   - Configuración de destinatarios

3. **Historial de Vencimientos**
   - Registro de productos vencidos
   - Análisis de pérdidas
   - Estadísticas mensuales

4. **Lotes y Fechas Múltiples**
   - Gestión de múltiples lotes por producto
   - Diferentes fechas de vencimiento por lote
   - Control FIFO (First In, First Out)

5. **Integración con Pedidos**
   - Bloqueo de productos vencidos
   - Alerta al seleccionar productos próximos a vencer
   - Sugerencia de productos con vencimiento lejano

---

**Fecha de Implementación:** 12 de Octubre 2025  
**Estado:** ✅ IMPLEMENTADO Y FUNCIONAL  
**Versión:** 1.0
