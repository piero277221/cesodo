# Sistema de Cambio de Estado de Menús

## 🎯 Problema Resuelto

Al intentar eliminar un menú con estado "activo", aparecía el error:
```
No se puede eliminar un menú activo
```

Sin embargo, no había una forma fácil de cambiar el estado del menú desde la vista.

## ✅ Solución Implementada

### 1. Nueva Ruta para Cambiar Estado

**Archivo**: `routes/web.php`

```php
Route::patch('/menus/{menu}/cambiar-estado', [MenuController::class, 'cambiarEstado'])
    ->name('menus.cambiar-estado');
```

### 2. Nuevo Método en el Controlador

**Archivo**: `app/Http/Controllers/MenuController.php`

```php
/**
 * Cambiar el estado de un menú
 */
public function cambiarEstado(Request $request, Menu $menu)
{
    try {
        $request->validate([
            'estado' => 'required|in:borrador,planificado,activo,completado,cancelado'
        ]);

        $estadoAnterior = $menu->estado;
        $menu->estado = $request->estado;
        $menu->save();

        return back()->with('success', 
            "Estado del menú cambiado de '{$estadoAnterior}' a '{$request->estado}' exitosamente"
        );

    } catch (\Exception $e) {
        Log::error('Error al cambiar estado del menú: ' . $e->getMessage());
        return back()->with('error', 'Error al cambiar el estado del menú: ' . $e->getMessage());
    }
}
```

### 3. Dropdown de Estados en la Vista

**Archivo**: `resources/views/menus/index.blade.php`

Se agregó un dropdown con opciones para cambiar el estado del menú:

```blade
<!-- Dropdown de estado -->
<div class="btn-group">
    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" 
            data-bs-toggle="dropdown">
        <i class="fas fa-exchange-alt me-1"></i>Estado
    </button>
    <ul class="dropdown-menu">
        <li><h6 class="dropdown-header">Cambiar a:</h6></li>
        <!-- Opciones de estado -->
        <li>
            <form action="{{ route('menus.cambiar-estado', $menu->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="estado" value="borrador">
                <button type="submit" class="dropdown-item">
                    <i class="fas fa-file text-secondary me-2"></i>Borrador
                </button>
            </form>
        </li>
        <!-- ... más opciones -->
    </ul>
</div>
```

### 4. Botón Eliminar Condicional

```blade
@if($menu->estado !== 'activo')
    <!-- Botón Eliminar habilitado -->
    <form action="{{ route('menus.destroy', $menu->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger">
            <i class="far fa-trash-alt me-1"></i>Eliminar
        </button>
    </form>
@else
    <!-- Botón Eliminar deshabilitado -->
    <button type="button" class="btn btn-sm btn-outline-secondary" disabled 
            title="No se puede eliminar un menú activo. Cambia el estado primero.">
        <i class="far fa-trash-alt me-1"></i>Eliminar
    </button>
@endif
```

## 🎨 Estados Disponibles

| Estado | Icono | Color | Descripción |
|--------|-------|-------|-------------|
| **Borrador** | 📄 | Gris | Menú en proceso de creación |
| **Planificado** | 📅 | Azul | Menú planificado para fecha futura |
| **Activo** | ✅ | Verde | Menú actualmente en uso (NO se puede eliminar) |
| **Completado** | 🏁 | Negro | Menú ya ejecutado completamente |
| **Cancelado** | ❌ | Rojo | Menú cancelado |

## 📋 Flujo de Trabajo para Eliminar un Menú Activo

### Antes (❌ Error):
```
1. Usuario intenta eliminar menú activo
2. Sistema muestra: "No se puede eliminar un menú activo"
3. Usuario debe ir a Editar → Cambiar estado → Guardar → Volver → Eliminar
```

### Ahora (✅ Mejorado):
```
1. Usuario ve que el menú está "Activo"
2. Click en dropdown "Estado"
3. Selecciona "Completado" o "Cancelado"
4. Sistema cambia el estado automáticamente
5. Botón "Eliminar" se habilita automáticamente
6. Usuario puede eliminar el menú
```

## 🎯 Características Implementadas

### 1. **Dropdown Inteligente**
- ✅ Solo muestra estados diferentes al actual
- ✅ Iconos visuales para cada estado
- ✅ Colores distintivos
- ✅ Headers informativos

### 2. **Botón Eliminar Condicional**
- ✅ Habilitado solo si el menú NO está activo
- ✅ Deshabilitado con tooltip explicativo si está activo
- ✅ Previene errores del usuario

### 3. **Validación en Controlador**
- ✅ Valida estados permitidos
- ✅ Mensaje de confirmación con estado anterior y nuevo
- ✅ Log de errores para debugging

### 4. **Mensaje Mejorado**
```php
// Antes:
"No se puede eliminar un menú activo"

// Después:
"No se puede eliminar un menú activo. Por favor, cambia el estado del menú primero."
```

## 💡 Ejemplo de Uso

### Escenario 1: Eliminar Menú en Borrador
```
Estado: Borrador
Botón Eliminar: ✅ Habilitado
Acción: Click → Confirmar → Eliminado
```

### Escenario 2: Eliminar Menú Activo
```
Estado: Activo
Botón Eliminar: ❌ Deshabilitado
Acción:
  1. Click en dropdown "Estado"
  2. Seleccionar "Completado"
  3. Confirmar cambio de estado
  4. Botón "Eliminar" se habilita
  5. Click → Confirmar → Eliminado
```

### Escenario 3: Cambiar entre Estados
```
Usuario puede cambiar libremente entre:
  Borrador ↔️ Planificado ↔️ Activo ↔️ Completado
                                    ↔️ Cancelado
```

## 🧪 Validaciones Implementadas

### En el Controlador (`destroy`):
```php
if ($menu->estado === 'activo') {
    return back()->with('error', 
        'No se puede eliminar un menú activo. Por favor, cambia el estado del menú primero.'
    );
}
```

### En el Controlador (`cambiarEstado`):
```php
$request->validate([
    'estado' => 'required|in:borrador,planificado,activo,completado,cancelado'
]);
```

### En la Vista:
```blade
@if($menu->estado !== 'activo')
    <!-- Botón eliminar habilitado -->
@else
    <!-- Botón eliminar deshabilitado con tooltip -->
@endif
```

## 🎨 Estilos Bootstrap

```html
<!-- Dropdown con Bootstrap 5 -->
<div class="btn-group">
    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
            data-bs-toggle="dropdown">
        Estado
    </button>
    <ul class="dropdown-menu">
        <!-- Items del dropdown -->
    </ul>
</div>
```

## 🔧 Estructura de Formularios

Cada opción del dropdown envía un formulario PATCH:

```blade
<form action="{{ route('menus.cambiar-estado', $menu->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <input type="hidden" name="estado" value="completado">
    <button type="submit" class="dropdown-item">
        <i class="fas fa-flag-checkered text-dark me-2"></i>Completado
    </button>
</form>
```

## 📊 Flujo de Datos

```
Vista (index.blade.php)
    ↓
Dropdown Estado → Seleccionar nuevo estado
    ↓
Form POST → Route: menus.cambiar-estado
    ↓
MenuController::cambiarEstado()
    ↓
Validación de estado
    ↓
Actualizar modelo Menu
    ↓
Redirect back con mensaje success
    ↓
Vista actualizada con nuevo estado
    ↓
Botón Eliminar habilitado/deshabilitado según estado
```

## 🎯 Beneficios

1. ✅ **UX Mejorada**: No es necesario ir a editar para cambiar estado
2. ✅ **Menos Clics**: Cambio de estado en 2 clics desde el listado
3. ✅ **Prevención de Errores**: Botón deshabilitado con tooltip explicativo
4. ✅ **Visual Claro**: Iconos y colores distintivos por estado
5. ✅ **Mensajes Informativos**: Confirmación con estado anterior y nuevo
6. ✅ **Consistencia**: Misma paleta de colores CESODO (negro/rojo/blanco)

## 📦 Archivos Modificados

1. ✏️ `routes/web.php` - Nueva ruta `menus.cambiar-estado`
2. ✏️ `app/Http/Controllers/MenuController.php` - Método `cambiarEstado()` y mensaje mejorado en `destroy()`
3. ✏️ `resources/views/menus/index.blade.php` - Dropdown de estados y botón condicional

---

**Fecha**: 11 de Octubre de 2025  
**Sistema**: CESODO  
**Módulo**: Menús - Gestión de Estados  
**Tipo**: Feature - Estado Management & UX Improvement  
**Estado**: ✅ Completado y Verificado
