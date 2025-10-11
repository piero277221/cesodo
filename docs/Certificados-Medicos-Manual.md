# Módulo de Certificados Médicos

## Descripción

El módulo de Certificados Médicos permite gestionar y controlar los certificados médicos del personal, con seguimiento de fechas de expiración y sistema de notificaciones automáticas.

## Características

### ✅ Funcionalidades Principales

1. **Búsqueda de Persona por DNI**
   - Búsqueda rápida ingresando el DNI (8 dígitos)
   - Carga automática de datos de la persona
   - Validación de existencia en el sistema

2. **Registro de Certificados**
   - Adjuntar archivo del certificado (PDF, JPG, PNG)
   - Fecha de emisión y expiración
   - Observaciones opcionales
   - Límite de archivo: 5MB

3. **Gestión de Certificados**
   - Ver listado completo de certificados
   - Filtros por estado (Vigente, Próximo a vencer, Vencido)
   - Búsqueda por DNI o nombre
   - Descargar archivos adjuntos
   - Editar y eliminar certificados

4. **Sistema de Alertas**
   - **Vigente**: Certificado con más de 30 días antes de expirar (color verde)
   - **Próximo a vencer**: Certificado con 30 días o menos para expirar (color amarillo)
   - **Vencido**: Certificado con fecha de expiración pasada (color rojo)

5. **Notificaciones Automáticas**
   - Comando programado que se ejecuta diariamente a las 8:00 AM
   - Detecta certificados próximos a vencer (30 días o menos)
   - Registra en logs del sistema
   - Marca certificados como notificados

## Instalación y Configuración

### Migración de Base de Datos

La tabla `certificados_medicos` ya fue creada con la siguiente estructura:

```
- id (PK)
- persona_id (FK → personas)
- numero_documento (VARCHAR 20)
- observaciones (TEXT, nullable)
- archivo_certificado (VARCHAR, nullable)
- fecha_emision (DATE, nullable)
- fecha_expiracion (DATE, nullable)
- notificacion_enviada (BOOLEAN, default: false)
- created_at, updated_at
```

### Comando Programado

El comando `certificados:verificar-vencimiento` está programado para ejecutarse automáticamente todos los días a las 8:00 AM (hora de Lima).

Para ejecutarlo manualmente:
```bash
php artisan certificados:verificar-vencimiento
```

### Configuración del Scheduler

Para que el comando se ejecute automáticamente, asegúrate de tener configurado el cron job de Laravel:

```bash
* * * * * cd /ruta/al/proyecto && php artisan schedule:run >> /dev/null 2>&1
```

## Uso del Módulo

### 1. Registrar un Nuevo Certificado

1. Ir a **Personal → Certificados Médicos**
2. Click en "Nuevo Certificado"
3. Ingresar el DNI de la persona y buscar
4. Completar los datos del certificado:
   - Subir archivo (PDF, JPG o PNG)
   - Fecha de emisión
   - Fecha de expiración
   - Observaciones (opcional)
5. Guardar

### 2. Ver Certificados

- Listado completo con información resumida
- Indicador visual del estado (vigente/próximo a vencer/vencido)
- Días restantes hasta la expiración
- Botón para descargar el archivo

### 3. Filtrar Certificados

- **Por búsqueda**: DNI, nombre o apellido
- **Por estado**:
  - Vigentes: Más de 30 días de validez
  - Próximos a vencer: 30 días o menos
  - Vencidos: Fecha de expiración pasada

### 4. Editar Certificado

1. Click en el botón "Editar"
2. Modificar los datos necesarios
3. Opcionalmente subir un nuevo archivo
4. Guardar cambios

### 5. Descargar Archivo

- Desde el listado: Click en "Descargar"
- Desde la vista de detalle: Click en "Descargar Archivo"
- El archivo se descarga con el nombre: `certificado_{DNI}.{extensión}`

## Notificaciones

### Configuración de Notificaciones

El sistema registra en logs todos los certificados próximos a vencer. Para implementar notificaciones adicionales:

#### Email

Editar `app\Console\Commands\VerificarCertificadosVencimiento.php` líneas 76-81:

```php
if ($persona->correo) {
    try {
        Mail::to($persona->correo)->send(new CertificadoProximoVencer($certificado));
    } catch (\Exception $e) {
        Log::error('Error al enviar email de certificado: ' . $e->getMessage());
    }
}
```

#### SMS

Para SMS, integrar con un servicio como Twilio (líneas 83-88):

```php
if ($persona->celular) {
    try {
        // Configurar Twilio
        SMS::send($persona->celular, "Su certificado médico vence en {$diasRestantes} días");
    } catch (\Exception $e) {
        Log::error('Error al enviar SMS de certificado: ' . $e->getMessage());
    }
}
```

### Logs de Notificaciones

Las notificaciones se registran en:
- `storage/logs/laravel.log`

Información registrada:
- ID del certificado
- Nombre completo de la persona
- DNI
- Días restantes
- Fecha de expiración
- Celular y correo (si existen)

## Relaciones con Otros Módulos

### Modelo Persona

El módulo se relaciona con el modelo `Persona`:

```php
// En Persona.php
public function certificadosMedicos()
{
    return $this->hasMany(CertificadoMedico::class);
}

public function certificadoMedicoActivo()
{
    return $this->hasOne(CertificadoMedico::class)
        ->whereDate('fecha_expiracion', '>=', now())
        ->latest('fecha_expiracion');
}
```

### Uso en Otros Módulos

Para obtener el certificado activo de una persona:

```php
$persona = Persona::find($id);
$certificadoActivo = $persona->certificadoMedicoActivo;

if ($certificadoActivo && !$certificadoActivo->estaVencido()) {
    // Persona tiene certificado vigente
}
```

## Permisos

El módulo requiere el permiso `ver-inventario` para acceder a todas las funcionalidades.

## Rutas

```
GET    /certificados-medicos                    → Listado
GET    /certificados-medicos/create             → Formulario de creación
POST   /certificados-medicos                    → Guardar nuevo certificado
GET    /certificados-medicos/{id}               → Ver detalle
GET    /certificados-medicos/{id}/edit          → Formulario de edición
PUT    /certificados-medicos/{id}               → Actualizar certificado
DELETE /certificados-medicos/{id}               → Eliminar certificado
GET    /certificados-medicos/{id}/descargar     → Descargar archivo
POST   /certificados-medicos/buscar-persona     → API búsqueda por DNI
```

## Consideraciones de Seguridad

- Los archivos se almacenan en `storage/app/public/certificados_medicos`
- Solo se permiten archivos PDF, JPG, JPEG y PNG
- Tamaño máximo: 5MB
- Los archivos se eliminan automáticamente al borrar el certificado
- Acceso restringido por permisos de usuario

## Mantenimiento

### Limpiar Certificados Antiguos

Para eliminar certificados de personas que ya no están en el sistema:

```bash
php artisan tinker
CertificadoMedico::whereDoesntHave('persona')->delete();
```

### Verificar Integridad

Para verificar certificados sin archivo:

```bash
php artisan tinker
CertificadoMedico::whereNull('archivo_certificado')->get();
```

## Soporte

Para reportar problemas o sugerencias, contactar al equipo de desarrollo.
