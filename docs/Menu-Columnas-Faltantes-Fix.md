# Fix: Error de Columnas Faltantes en Tabla Menus

## ❌ Error Reportado

```
Error al crear el menú: SQLSTATE[HY000]: General error: 1 
table menus has no column named numero_personas
```

## 🔍 Causa del Problema

La migración original de la tabla `menus` (2023_09_27_000000) no incluía las columnas necesarias para el sistema de gestión de platos disponibles:

- `numero_personas`
- `platos_totales`
- `platos_disponibles`
- `auto_generado`
- `observaciones`

Estas columnas son requeridas por el `MenuController` al crear menús con el cálculo automático de platos disponibles.

## ✅ Solución Aplicada

### 1. Migración Creada

Archivo: `2025_10_12_155213_add_platos_columns_to_menus_table.php`

```php
Schema::table('menus', function (Blueprint $table) {
    $table->integer('numero_personas')->default(1);
    $table->integer('platos_totales')->default(0);
    $table->integer('platos_disponibles')->default(0);
    $table->boolean('auto_generado')->default(false);
    $table->text('observaciones')->nullable();
});
```

### 2. Migración Ejecutada

```bash
php artisan migrate
```

**Resultado:**
```
✅ 2025_10_12_155213_add_platos_columns_to_menus_table .... DONE
```

### 3. Columnas Agregadas

| Columna | Tipo | Default | Descripción |
|---------|------|---------|-------------|
| `numero_personas` | integer | 1 | Cantidad de personas para el menú |
| `platos_totales` | integer | 0 | Total de platos calculados (personas × días × comidas) |
| `platos_disponibles` | integer | 0 | Platos disponibles para consumir |
| `auto_generado` | boolean | false | Indica si el menú fue generado automáticamente |
| `observaciones` | text | null | Notas adicionales del menú |

## 📊 Estructura Final de la Tabla Menus

```
menus
├── id
├── nombre
├── descripcion
├── estado                    (borrador, activo, terminado, cancelado)
├── fecha_inicio
├── fecha_fin
├── costo_estimado
├── tipo_menu                 (semanal, semanal_especial)
├── created_by               → users(id)
├── created_at
├── updated_at
├── deleted_at
├── costo_total
├── observaciones            ← NUEVA
├── platos_disponibles       ← NUEVA
├── platos_totales          ← NUEVA
├── numero_personas         ← NUEVA
└── auto_generado           ← NUEVA
```

## 🎯 Cálculo de Platos

Con las nuevas columnas, el sistema calcula automáticamente:

```php
// En MenuController::store()
$diasMenu = Carbon::parse($request->fecha_inicio)
    ->diffInDays(Carbon::parse($request->fecha_fin)) + 1;

$platosTotal = $request->numero_personas * $diasMenu;

$menu = Menu::create([
    'numero_personas' => $request->numero_personas,
    'platos_totales' => $platosTotal,
    'platos_disponibles' => $platosTotal,
    // ... otros campos
]);
```

**Ejemplo:**
- 10 personas
- 5 días (lunes a viernes)
- `platos_totales` = 10 × 5 = 50
- `platos_disponibles` = 50 (inicial)

## 🚀 Ahora Puedes Crear el Menú

Con la migración aplicada, ya puedes crear tu menú sin problemas:

### Configuración Recomendada

```
Nombre: Menú Semanal - Semana 42
Fecha Inicio: 2025-10-14 (lunes)
Fecha Fin: 2025-10-18 (viernes)
Tipo: Menú Semanal
Personas: 10
Descripción: Menú de prueba con Arroz con Pollo

Días: Lunes a Viernes
Comidas: Almuerzo
Receta: Arroz con Pollo

Resultado esperado:
✅ Menú creado exitosamente
✅ 50 platos disponibles
✅ Stock descontado del inventario
```

## 🔧 Verificación

Para verificar que las columnas existen:

```bash
php artisan tinker --execute="
echo json_encode(
    \Illuminate\Support\Facades\Schema::getColumnListing('menus'),
    JSON_PRETTY_PRINT
);"
```

**Debe mostrar:**
```json
[
    "id",
    "nombre",
    "descripcion",
    "estado",
    "fecha_inicio",
    "fecha_fin",
    "costo_estimado",
    "tipo_menu",
    "created_by",
    "created_at",
    "updated_at",
    "deleted_at",
    "costo_total",
    "observaciones",        ← ✅
    "platos_disponibles",   ← ✅
    "platos_totales",       ← ✅
    "numero_personas",      ← ✅
    "auto_generado"         ← ✅
]
```

## ⚠️ Notas Importantes

### 1. No Requiere Re-migración

Si ya tienes registros en la tabla `menus`, esta migración NO los afectará. Solo agrega las columnas nuevas con valores por defecto:

- Menús existentes tendrán `numero_personas` = 1
- Menús existentes tendrán `platos_totales` = 0
- Menús existentes tendrán `platos_disponibles` = 0

### 2. Compatibilidad con Código Existente

La migración incluye verificación de columnas existentes:

```php
if (!Schema::hasColumn('menus', 'numero_personas')) {
    $table->integer('numero_personas')->default(1);
}
```

Esto evita errores si la migración se ejecuta múltiples veces.

### 3. Rollback Disponible

Si necesitas revertir los cambios:

```bash
php artisan migrate:rollback --step=1
```

Esto eliminará las 5 columnas agregadas.

## 📁 Archivos Modificados

1. `database/migrations/2025_10_12_155213_add_platos_columns_to_menus_table.php` - Migración nueva
2. `docs/Menu-Columnas-Faltantes-Fix.md` - Esta documentación

## ✅ Problema Resuelto

- ✅ Migración creada y ejecutada exitosamente
- ✅ 5 columnas agregadas a la tabla `menus`
- ✅ Sistema listo para crear menús con cálculo de platos
- ✅ Compatible con registros existentes
- ✅ Rollback disponible si es necesario

**¡Puedes proceder a crear tu menú!** 🎉

---

**Fecha:** 12 de Octubre 2025
**Migración:** 2025_10_12_155213
**Estado:** ✅ APLICADA
