# Módulo de Configuraciones - Sistema Intuitivo y Mejorado

## 📋 Resumen de Mejoras Implementadas

Se ha creado un **sistema de configuraciones completamente nuevo**, diseñado para ser **intuitivo y fácil de usar** incluso para personas sin conocimientos técnicos.

---

## ✨ Características Principales

### 1. **Interfaz con Tabs Intuitiva**
El sistema se divide en 5 secciones claramente identificadas con iconos:

#### 📌 **Información de Empresa** (Tab Empresa)
- ✅ Carga de **Logo de la Empresa** (aparece en reportes y documentos)
- ✅ Carga de **Icono del Sistema** (aparece en la barra lateral y login)
- ✅ Preview en tiempo real de las imágenes
- ✅ Campos de información básica:
  - Nombre de la empresa
  - Dirección
  - Teléfono
  - Email
- ✅ Botones para eliminar logos con confirmación
- ✅ Formatos permitidos: JPG, PNG, SVG, GIF
- ✅ Límite de tamaño: 2MB

#### 🛡️ **Permisos y Roles** (Tab Permisos)
- ✅ Gestión visual de permisos por rol
- ✅ Agrupación de permisos por módulo (Usuarios, Productos, Consumos, etc.)
- ✅ **Sistema de permisos granular**: Si un rol no tiene permiso, NO verá ese módulo
- ✅ Iconos descriptivos para cada acción (Ver, Crear, Editar, Eliminar)
- ✅ Botones de "Seleccionar Todos" / "Desmarcar Todos"
- ✅ Checkbox por módulo para activar/desactivar todos los permisos de ese módulo
- ✅ Interfaz con cards hover effect para mejor UX

#### ⚙️ **Configuración del Sistema** (Tab Sistema)
- 🔜 En desarrollo: Ajustes generales, límites, timeouts, etc.

#### 🔔 **Notificaciones** (Tab Notificaciones)
- 🔜 En desarrollo: Alertas por email, notificaciones push, recordatorios

#### 🎨 **Apariencia** (Tab Interfaz)
- 🔜 En desarrollo: Colores personalizados, temas, fuentes

---

## 🗂️ Archivos Creados/Modificados

### **Migraciones**
```
database/migrations/2025_10_12_172220_add_logo_fields_to_system_settings_table.php
```
- Agrega campos `logo_path` e `icon_path` a `system_settings`
- Inserta configuraciones iniciales de empresa (6 registros)

### **Controladores**
```
app/Http/Controllers/ConfiguracionesController.php
```
**Métodos principales:**
- `index()` - Dashboard con tabs
- `update()` - Actualiza configuraciones y maneja uploads de imágenes
- `uploadLogo()` - Helper para subir logos/iconos
- `deleteLogo()` - Elimina logos via AJAX
- `updatePermissions()` - Actualiza permisos de roles
- `getLogo()` - Obtiene URL del logo/icono
- `getCompanyInfo()` - Obtiene toda la información de empresa

### **Vistas**
```
resources/views/configuraciones/
├── index.blade.php                    (Vista principal con tabs)
└── tabs/
    ├── empresa.blade.php              (Tab de información de empresa)
    ├── permisos.blade.php             (Tab de gestión de permisos)
    ├── sistema.blade.php              (Tab en desarrollo)
    ├── notificaciones.blade.php       (Tab en desarrollo)
    └── interfaz.blade.php             (Tab en desarrollo)
```

### **Rutas**
```php
// routes/web.php
Route::middleware(['permission:ver-configuraciones'])->group(function () {
    Route::get('configuraciones', [ConfiguracionesController::class, 'index'])
        ->name('configuraciones.index');
    Route::put('configuraciones', [ConfiguracionesController::class, 'update'])
        ->name('configuraciones.update');
    Route::post('configuraciones/delete-logo', [ConfiguracionesController::class, 'deleteLogo'])
        ->name('configuraciones.delete-logo');
    Route::post('configuraciones/update-permissions', [ConfiguracionesController::class, 'updatePermissions'])
        ->name('configuraciones.update-permissions');
});
```

### **Imágenes por Defecto**
```
public/images/
├── default-logo.png                   (Logo por defecto SVG)
└── default-icon.png                   (Icono por defecto SVG)
```

### **Modelos Actualizados**
```
app/Models/SystemSetting.php
```
- Agregados campos `logo_path` e `icon_path` en `$fillable`

### **Navegación Actualizada**
```
resources/views/layouts/navigation.blade.php
```
- Enlace actualizado a `route('configuraciones.index')`
- Descripción mejorada: "Empresa, Sistema y Permisos"

---

## 🎯 Cómo Usar el Sistema

### **Acceso al Módulo**
1. Iniciar sesión con un usuario que tenga el permiso `ver-configuraciones`
2. Ir al menú **Administración** → **Configuraciones**

### **Cargar Logo de la Empresa**
1. Click en el tab **"Información de Empresa"**
2. En la sección "Logo de la Empresa", click en **"Seleccionar Nuevo Logo"**
3. Elegir imagen (JPG, PNG, SVG)
4. Ver preview en tiempo real
5. Click en **"Guardar Configuraciones"**
6. El logo aparecerá en:
   - Reportes PDF
   - Documentos generados
   - Parte superior del sistema

### **Cargar Icono del Sistema**
1. En la sección "Icono del Sistema", click en **"Seleccionar Nuevo Icono"**
2. Elegir imagen (preferiblemente cuadrada)
3. Click en **"Guardar Configuraciones"**
4. El icono aparecerá en:
   - Esquina superior izquierda
   - Pantalla de login
   - Barra lateral

### **Gestionar Permisos**
1. Click en el tab **"Permisos y Roles"**
2. Seleccionar un rol del dropdown
3. Marcar/desmarcar permisos por módulo
4. Usar "Seleccionar Todos" para activar todo
5. Click en **"Guardar Permisos"**
6. ✅ **Los cambios se aplican inmediatamente**
7. ⚠️ **Si un usuario no tiene permiso para un módulo, ese módulo NO aparecerá en su menú**

---

## 🔒 Sistema de Permisos Granular

### **Cómo Funciona**
Cada módulo del sistema tiene permisos individuales:

**Ejemplo: Módulo de Productos**
- `ver-productos` → Ver listado de productos
- `crear-productos` → Crear nuevos productos
- `editar-productos` → Editar productos existentes
- `eliminar-productos` → Eliminar productos

**Si un rol NO tiene `ver-productos`:**
- ❌ El módulo "Productos" NO aparece en el menú
- ❌ No puede acceder a ninguna vista de productos
- ❌ Las rutas están protegidas con middleware

### **Módulos con Permisos**
- Usuarios
- Productos
- Categorías
- Proveedores
- Trabajadores
- Consumos
- Menús
- Recetas
- Contratos
- Certificados Médicos
- Personas
- Inventario
- Reportes
- Configuraciones

---

## 📸 Características Visuales

### **Diseño Moderno**
- ✅ Tabs con hover effects
- ✅ Cards con sombras y transiciones
- ✅ Iconos descriptivos de Bootstrap Icons
- ✅ Paleta de colores: Negro/Rojo/Blanco (consistente con el sistema)
- ✅ Responsive design para móviles
- ✅ Preview en tiempo real de imágenes
- ✅ Confirmaciones antes de eliminar
- ✅ Mensajes de éxito/error visibles

### **Facilidad de Uso**
- ✅ Instrucciones claras en cada sección
- ✅ Tooltips y textos de ayuda
- ✅ Validación de formatos de archivo
- ✅ Límites de tamaño claramente indicados
- ✅ Sin necesidad de conocimientos técnicos

---

## 🚀 Próximas Mejoras (Pendientes)

### **Tab Sistema**
- Configuración de límites (stock mínimo, días de alerta)
- Timeouts de sesión
- Formatos de fecha/hora
- Moneda del sistema
- Idioma predeterminado

### **Tab Notificaciones**
- Activar/desactivar notificaciones por email
- Configurar alertas de vencimiento
- Notificaciones de stock bajo
- Recordatorios de certificados médicos
- Plantillas de emails

### **Tab Interfaz**
- Selección de colores primarios/secundarios
- Tema claro/oscuro
- Tamaño de fuente
- Logo en diferentes posiciones
- Favicon personalizado

---

## 🎨 Helpers Disponibles

### **En el Código**
```php
use App\Http\Controllers\ConfiguracionesController;

// Obtener logo de la empresa
$logo = ConfiguracionesController::getLogo('logo');

// Obtener icono del sistema
$icon = ConfiguracionesController::getLogo('icon');

// Obtener toda la información de empresa
$company = ConfiguracionesController::getCompanyInfo();
// Retorna: ['name', 'address', 'phone', 'email', 'logo', 'icon']
```

### **En las Vistas Blade**
```blade
<!-- Logo de la empresa -->
<img src="{{ \App\Http\Controllers\ConfiguracionesController::getLogo('logo') }}" alt="Logo">

<!-- Icono del sistema -->
<img src="{{ \App\Http\Controllers\ConfiguracionesController::getLogo('icon') }}" alt="Icono">

<!-- Nombre de la empresa -->
{{ \App\Models\SystemSetting::getValue('company_name', 'Mi Empresa') }}
```

---

## ✅ Checklist de Implementación

- [x] Migración de base de datos
- [x] Modelo actualizado
- [x] Controlador con métodos completos
- [x] Rutas configuradas
- [x] Vista principal con tabs
- [x] Tab de Empresa con carga de logos
- [x] Tab de Permisos con gestión visual
- [x] Tabs placeholder para futuras secciones
- [x] Navegación actualizada
- [x] Imágenes por defecto
- [x] Validaciones y seguridad
- [x] Documentación completa

---

## 📝 Notas Técnicas

### **Almacenamiento de Imágenes**
- Directorio: `storage/app/public/logos/`
- Formatos: JPG, JPEG, PNG, GIF, SVG
- Tamaño máximo: 2MB
- Nombres: `company_logo_{timestamp}.ext` y `company_icon_{timestamp}.ext`

### **Seguridad**
- Middleware: `permission:ver-configuraciones`
- CSRF protection en todos los formularios
- Validación de tipos de archivo
- Límite de tamaño de archivo
- No se permite editar configuraciones del sistema (`is_system = true`)

### **Performance**
- Caché de configuraciones (3600 segundos)
- Limpieza de caché al actualizar
- Queries optimizadas con eager loading
- Imágenes comprimidas en el frontend

---

## 🎉 Resultado Final

Se ha creado un **módulo de configuraciones profesional, intuitivo y completo** que permite:

1. ✅ **Personalizar la imagen de la empresa** con logos e iconos
2. ✅ **Gestionar permisos de manera visual** sin necesidad de código
3. ✅ **Control granular de acceso** a cada módulo del sistema
4. ✅ **Interfaz amigable** para usuarios no técnicos
5. ✅ **Escalable** para agregar más configuraciones en el futuro

**El sistema está listo para producción y puede ser usado inmediatamente** 🚀
