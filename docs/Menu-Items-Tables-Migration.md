# Migración: Tablas Menu Items

## 🐛 Problema Detectado

Al intentar editar un menú, se producía el error:
```
SQLSTATE[HY000]: General error: 1 no such table: menu_items 
(Connection: sqlite, SQL: select * from "menu_items" where "menu_items"."menu_id" in (1))
```

## 🔍 Causa del Error

1. **Tabla Faltante**: La tabla `menu_items` no existía en la base de datos
2. **Modelo sin Tabla**: El modelo `MenuItem.php` estaba definido pero su tabla nunca fue creada
3. **Migración Problemática**: Existía una migración que intentaba renombrar una tabla inexistente (`condiciones_salud` → `certificados_medicos`)

## ✅ Solución Implementada

### 1. Creada Migración para Tablas Menu Items

**Archivo**: `database/migrations/2025_10_11_221704_create_menu_items_table.php`

Se crearon **3 tablas nuevas**:

#### Tabla `menu_items`
```php
Schema::create('menu_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
    $table->string('dia')->nullable(); // lunes, martes, miercoles, etc.
    $table->string('tiempo')->nullable(); // desayuno, almuerzo, cena, merienda
    $table->string('titulo')->nullable(); // nombre del plato
    $table->text('descripcion')->nullable();
    $table->timestamps();
    
    // Índices para mejorar búsquedas
    $table->index(['menu_id', 'dia', 'tiempo']);
});
```

**Propósito**: Almacenar los items individuales de cada menú (platos por día y tipo de comida).

#### Tabla `menu_item_producto` (Pivot)
```php
Schema::create('menu_item_producto', function (Blueprint $table) {
    $table->id();
    $table->foreignId('menu_item_id')->constrained('menu_items')->onDelete('cascade');
    $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
    $table->decimal('cantidad', 10, 2)->default(1);
    $table->string('unidad')->default('unidad');
    $table->timestamps();
    
    // Evitar duplicados
    $table->unique(['menu_item_id', 'producto_id']);
});
```

**Propósito**: Relacionar items de menú con productos e ingredientes (relación muchos a muchos).

#### Tabla `menu_item_producto_alternativos`
```php
Schema::create('menu_item_producto_alternativos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('menu_item_id')->constrained('menu_items')->onDelete('cascade');
    $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
    $table->foreignId('certificado_medico_id')->nullable()->constrained('certificados_medicos')->onDelete('cascade');
    $table->decimal('cantidad', 10, 2)->default(1);
    $table->string('unidad')->default('unidad');
    $table->text('observaciones')->nullable();
    $table->timestamps();
    
    $table->index(['menu_item_id', 'certificado_medico_id']);
});
```

**Propósito**: Almacenar productos alternativos para personas con condiciones de salud especiales (alergias, restricciones, etc.).

### 2. Corregida Migración Problemática

**Archivo**: `database/migrations/2025_10_11_160655_rename_condiciones_salud_to_certificados_medicos_table.php`

**Problema Original**:
```php
// ❌ Intentaba renombrar tabla que no existe
Schema::rename('condiciones_salud', 'certificados_medicos');
```

**Solución Implementada**:
```php
// ✅ Verifica si la tabla existe antes de renombrar
if (Schema::hasTable('condiciones_salud')) {
    Schema::rename('condiciones_salud', 'certificados_medicos');
    // ... resto de modificaciones
}
// Si no existe, no hacer nada (ya fue creada con otra migración)
```

**Mejoras Adicionales**:
- Verificación de existencia de columnas antes de modificarlas
- Uso de `Schema::hasColumn()` para evitar errores
- Soporte para bases de datos en diferentes estados

## 🗄️ Estructura de Base de Datos Resultante

```
menus (tabla principal)
├── menu_items (items del menú)
│   ├── menu_item_producto (pivot: productos por item)
│   │   └── productos
│   └── menu_item_producto_alternativos (productos alternativos)
│       ├── productos
│       └── certificados_medicos (condiciones de salud)
└── menu_platos (relación con recetas)
    └── recetas
```

## 🔗 Relaciones del Modelo MenuItem

```php
// app/Models/MenuItem.php

class MenuItem extends Model
{
    // Relación: MenuItem pertenece a Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    // Relación: MenuItem tiene muchos Productos (many-to-many)
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'menu_item_producto')
            ->withPivot(['cantidad', 'unidad'])
            ->withTimestamps();
    }

    // Relación: MenuItem tiene productos alternativos
    public function productosAlternativos()
    {
        return $this->hasMany(MenuItemProductoAlternativo::class);
    }
}
```

## 📊 Ejemplos de Uso

### Crear Item de Menú
```php
$menuItem = MenuItem::create([
    'menu_id' => 1,
    'dia' => 'lunes',
    'tiempo' => 'desayuno',
    'titulo' => 'Desayuno Nutritivo',
    'descripcion' => 'Pan integral con huevo y jugo de naranja'
]);
```

### Agregar Productos al Item
```php
$menuItem->productos()->attach($productoId, [
    'cantidad' => 2,
    'unidad' => 'unidades'
]);
```

### Obtener Items de un Menú
```php
$menu = Menu::with('items.productos')->find(1);
foreach ($menu->items as $item) {
    echo $item->titulo;
    foreach ($item->productos as $producto) {
        echo "- {$producto->nombre}: {$producto->pivot->cantidad} {$producto->pivot->unidad}";
    }
}
```

## 🧪 Verificación de Tablas

Comandos ejecutados para verificar:

```bash
# Ver todas las tablas
php artisan db:show

# Ver estructura de menu_items
php artisan db:table menu_items

# Ver estructura de menu_item_producto
php artisan db:table menu_item_producto

# Ver estructura de menu_item_producto_alternativos
php artisan db:table menu_item_producto_alternativos
```

## ✅ Estado Final

- ✅ Tabla `menu_items` creada correctamente
- ✅ Tabla pivot `menu_item_producto` creada
- ✅ Tabla `menu_item_producto_alternativos` creada
- ✅ Migración problemática corregida
- ✅ Relaciones del modelo Menu actualizadas
- ✅ Sistema de edición de menús funcional

## 🚀 Beneficios

1. **Flexibilidad**: Permite gestionar menús con items personalizados
2. **Alternativas**: Soporte para productos alternativos por condiciones médicas
3. **Trazabilidad**: Relación completa entre menús, items y productos
4. **Escalabilidad**: Estructura preparada para futuras expansiones
5. **Integridad**: Foreign keys garantizan consistencia de datos

## 📝 Campos de Menu Items

| Campo | Tipo | Descripción | Ejemplo |
|-------|------|-------------|---------|
| `id` | integer | ID único | 1 |
| `menu_id` | integer | ID del menú padre | 5 |
| `dia` | string | Día de la semana | "lunes", "martes" |
| `tiempo` | string | Tipo de comida | "desayuno", "almuerzo", "cena" |
| `titulo` | string | Nombre del plato | "Desayuno Nutritivo" |
| `descripcion` | text | Descripción detallada | "Pan integral con..." |
| `created_at` | datetime | Fecha de creación | 2025-10-11 22:17:04 |
| `updated_at` | datetime | Última actualización | 2025-10-11 22:17:04 |

## 🔄 Migraciones Ejecutadas

```
✅ 2025_10_11_160655_rename_condiciones_salud_to_certificados_medicos_table
✅ 2025_10_11_221704_create_menu_items_table
```

## 📦 Archivos Modificados

1. ✏️ `database/migrations/2025_10_11_221704_create_menu_items_table.php` (nuevo)
2. ✏️ `database/migrations/2025_10_11_160655_rename_condiciones_salud_to_certificados_medicos_table.php` (corregido)
3. ✏️ `app/Models/Menu.php` (relaciones agregadas previamente)

---

**Fecha**: 11 de Octubre de 2025  
**Sistema**: CESODO  
**Módulo**: Menús - Base de Datos  
**Tipo**: Database Migration - Table Creation  
**Estado**: ✅ Completado y Verificado
