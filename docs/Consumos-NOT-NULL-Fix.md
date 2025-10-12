# Fix: Error NOT NULL constraint failed en tabla consumos

## ❌ Error Reportado

```
Error al registrar el consumo: SQLSTATE[23000]: Integrity constraint violation: 19 
NOT NULL constraint failed: consumos.trabajador_id
```

## 🔍 Causa del Problema

El error ocurría porque:

1. La tabla `consumos` tenía `trabajador_id` como campo **NOT NULL** (obligatorio)
2. El sistema de menús intenta crear consumos **sin especificar un trabajador**
3. Hay dos flujos diferentes:
   - **Flujo A:** Consumo por trabajador específico (requiere `trabajador_id`)
   - **Flujo B:** Consumo general de menú (NO requiere `trabajador_id`)

## ✅ Solución Aplicada

### 1. Migración Creada

Archivo: `2025_10_12_160112_add_menu_columns_to_consumos_table.php`

**Cambios realizados:**

```php
// 1. Hacer trabajador_id NULLABLE (opcional)
$table->foreignId('trabajador_id')->nullable()->change();

// 2. Agregar columna menu_id
$table->foreignId('menu_id')->nullable()->constrained('menus');

// 3. Agregar columna cantidad
$table->integer('cantidad')->default(1);

// 4. Hacer campos opcionales
$table->time('hora_consumo')->nullable()->change();
$table->string('tipo_comida')->nullable()->change();
```

### 2. Controlador Actualizado

**Archivo:** `app/Http/Controllers/MenuController.php`

**Antes:**
```php
$consumo = new Consumo([
    'menu_id' => $menu->id,
    'cantidad' => $request->cantidad,
    'notas' => $request->notas,
    'created_by' => Auth::id()  // ❌ Campo incorrecto
]);
```

**Después:**
```php
$consumo = new Consumo([
    'menu_id' => $menu->id,
    'cantidad' => $request->cantidad,
    'observaciones' => $request->notas,  // ✅ Nombre correcto
    'user_id' => Auth::id(),              // ✅ Campo correcto
    'fecha_consumo' => now()->toDateString(),
    'hora_consumo' => now()->toTimeString(),
]);
```

### 3. Migración Ejecutada

```bash
php artisan migrate
```

**Resultado:**
```
✅ 2025_10_12_160112_add_menu_columns_to_consumos_table .... DONE
```

## 📊 Estructura Final de la Tabla Consumos

```
consumos
├── id
├── trabajador_id          → trabajadores(id) [NULLABLE] ← MODIFICADO
├── fecha_consumo          [date]
├── hora_consumo           [time, NULLABLE] ← MODIFICADO
├── tipo_comida            [string, NULLABLE] ← MODIFICADO
├── observaciones          [text, nullable]
├── user_id               → users(id) [quien registró]
├── created_at
├── updated_at
├── cantidad               [integer] ← NUEVA
└── menu_id               → menus(id) [NULLABLE] ← NUEVA
```

## 🔄 Dos Flujos de Consumo

### Flujo A: Consumo por Trabajador

**Usado en:** Módulo de Consumos → Nuevo Consumo

```php
Consumo::create([
    'trabajador_id' => $request->trabajador_id,  // ✅ Especificado
    'fecha_consumo' => $request->fecha_consumo,
    'hora_consumo' => $request->hora_consumo,
    'tipo_comida' => $request->tipo_comida,
    'menu_id' => $request->menu_id,
    'user_id' => Auth::id(),
]);
```

### Flujo B: Consumo General de Menú

**Usado en:** Módulo de Menús → Registrar Consumo

```php
Consumo::create([
    'trabajador_id' => null,  // ✅ NULL permitido ahora
    'menu_id' => $menu->id,
    'cantidad' => $request->cantidad,
    'fecha_consumo' => now()->toDateString(),
    'hora_consumo' => now()->toTimeString(),
    'user_id' => Auth::id(),
]);
```

## 🎯 Ahora Puedes Registrar Consumos

### Opción 1: Desde el Módulo de Menús

1. Ve a: Dashboard → Menús
2. Selecciona un menú activo
3. Click en "Registrar Consumo"
4. Ingresa la cantidad de platos consumidos
5. Guardar

**Resultado:**
```
✅ Consumo registrado exitosamente
✅ Platos disponibles actualizados
✅ Sin requerir trabajador específico
```

### Opción 2: Desde el Módulo de Consumos

1. Ve a: Dashboard → Consumos → Nuevo Consumo
2. Selecciona un trabajador
3. Selecciona fecha, hora y tipo de comida
4. Selecciona el menú
5. Guardar

**Resultado:**
```
✅ Consumo registrado con trabajador específico
✅ Registro detallado del consumo
```

## 📋 Validación de Datos

### Campos Requeridos (Flujo Menú)

```php
'cantidad' => 'required|integer|min:1|max:' . $menu->platos_disponibles,
'notas' => 'nullable|string|max:255',
```

### Campos Requeridos (Flujo Trabajador)

```php
'trabajador_id' => 'required|exists:trabajadores,id',
'fecha_consumo' => 'required|date',
'hora_consumo' => 'required|date_format:H:i',
'tipo_comida' => 'required|in:desayuno,almuerzo,cena,refrigerio',
'menu_id' => 'required|exists:menus,id',
```

## ⚠️ Notas Importantes

### 1. Compatibilidad con Registros Existentes

Los consumos existentes en la base de datos NO se ven afectados por esta migración. La migración solo:

- Cambia `trabajador_id` a nullable
- Agrega nuevas columnas con valores por defecto

### 2. Restricción de Unicidad

La restricción única sigue activa para evitar duplicados:

```sql
UNIQUE(trabajador_id, fecha_consumo, tipo_comida)
```

**Nota:** Solo aplica cuando `trabajador_id` NO es NULL.

### 3. Rollback Disponible

Si necesitas revertir los cambios:

```bash
php artisan migrate:rollback --step=1
```

Esto eliminará las columnas agregadas y revertirá `trabajador_id` a NOT NULL.

## 🔧 Verificación

### Ver columnas de la tabla:

```bash
php artisan tinker --execute="
echo json_encode(
    \Illuminate\Support\Facades\Schema::getColumnListing('consumos'),
    JSON_PRETTY_PRINT
);"
```

**Debe mostrar:**
```json
[
    "id",
    "trabajador_id",      ← NULLABLE ahora
    "fecha_consumo",
    "hora_consumo",       ← NULLABLE
    "tipo_comida",        ← NULLABLE
    "observaciones",
    "user_id",
    "created_at",
    "updated_at",
    "cantidad",           ← NUEVA
    "menu_id"             ← NUEVA
]
```

### Probar registro de consumo:

```bash
# Desde la interfaz:
Dashboard → Menús → [Seleccionar menú] → Registrar Consumo
Cantidad: 5
Observaciones: Almuerzo del día
Guardar
```

**Resultado esperado:**
```
✅ Se han consumido 5 platos exitosamente
✅ Platos disponibles: 45 (de 50 totales)
```

## 📁 Archivos Modificados

1. `database/migrations/2025_10_12_160112_add_menu_columns_to_consumos_table.php` - Migración nueva
2. `app/Http/Controllers/MenuController.php` - Corregido método registrarConsumo()
3. `docs/Consumos-NOT-NULL-Fix.md` - Esta documentación

## ✅ Problema Resuelto

- ✅ Campo `trabajador_id` ahora es opcional (nullable)
- ✅ Columnas `menu_id` y `cantidad` agregadas
- ✅ Controlador corregido con campos correctos
- ✅ Soporta dos flujos: con y sin trabajador específico
- ✅ Compatible con registros existentes
- ✅ Rollback disponible

**¡Ahora puedes registrar consumos sin problemas!** 🎉

---

**Fecha:** 12 de Octubre 2025
**Migración:** 2025_10_12_160112
**Estado:** ✅ APLICADA
