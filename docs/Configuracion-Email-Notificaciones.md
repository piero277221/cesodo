# 📧 Configuración de Email para Notificaciones

## Guía Completa para Configurar el Envío de Correos Electrónicos

### 📋 Requisitos Previos
- Tener una cuenta de Gmail (o cualquier otro proveedor SMTP)
- Acceso al archivo `.env` del proyecto
- Permisos de administrador en el sistema

---

## 🔧 Configuración Paso a Paso

### **Opción 1: Usar Gmail (Recomendado para pruebas)**

#### Paso 1: Crear una Contraseña de Aplicación en Gmail

1. Ve a tu cuenta de Google: https://myaccount.google.com/
2. En el menú izquierdo, selecciona **"Seguridad"**
3. Busca **"Verificación en dos pasos"** y actívala si no está activada
4. Una vez activada la verificación en 2 pasos, busca **"Contraseñas de aplicaciones"**
5. Selecciona:
   - **Aplicación:** Correo
   - **Dispositivo:** Otro (nombre personalizado) → Escribe "Laravel CESODO"
6. Haz clic en **"Generar"**
7. Copia la contraseña de 16 caracteres que aparece (sin espacios)

#### Paso 2: Editar el archivo `.env`

Abre el archivo `.env` en la raíz del proyecto y modifica estas líneas:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=xxxx-xxxx-xxxx-xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="tu-email@gmail.com"
MAIL_FROM_NAME="Sistema CESODO"
```

**Reemplaza:**
- `tu-email@gmail.com` → Tu dirección de Gmail
- `xxxx-xxxx-xxxx-xxxx` → La contraseña de aplicación generada en el Paso 1

---

### **Opción 2: Usar Outlook/Hotmail**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.office365.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@outlook.com
MAIL_PASSWORD=tu-contraseña
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="tu-email@outlook.com"
MAIL_FROM_NAME="Sistema CESODO"
```

---

### **Opción 3: Usar Servidor SMTP Personalizado**

Si tienes tu propio servidor SMTP (por ejemplo, cPanel):

```env
MAIL_MAILER=smtp
MAIL_HOST=mail.tudominio.com
MAIL_PORT=465
MAIL_USERNAME=notificaciones@tudominio.com
MAIL_PASSWORD=tu-contraseña-segura
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="notificaciones@tudominio.com"
MAIL_FROM_NAME="Sistema CESODO"
```

**Nota:** Consulta con tu proveedor de hosting para obtener los datos correctos.

---

## 🚀 Probar la Configuración

### Paso 3: Limpiar la Caché

Después de editar el `.env`, ejecuta estos comandos en PowerShell:

```powershell
cd c:\xampp\htdocs\cesodo4
php artisan config:clear
php artisan cache:clear
```

### Paso 4: Probar el Envío de Email

Crea un archivo de prueba: `c:\xampp\htdocs\cesodo4\test-email.php`

```php
<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('Este es un email de prueba desde Laravel CESODO', function ($message) {
        $message->to('destinatario@ejemplo.com') // Cambia esto por tu email
                ->subject('Prueba de Email - Sistema CESODO');
    });
    
    echo "✅ Email enviado correctamente!\n";
    echo "Revisa tu bandeja de entrada (y spam).\n";
} catch (Exception $e) {
    echo "❌ Error al enviar email:\n";
    echo $e->getMessage() . "\n";
}
?>
```

**Ejecutar el script:**
```powershell
php test-email.php
```

---

## ⚙️ Configurar en el Módulo de Configuraciones

Una vez que el email funcione, ve al módulo de **Configuraciones → Notificaciones** y:

1. **Activa las notificaciones por email:**
   - ✅ Stock Bajo
   - ✅ Productos Vencidos
   - ✅ Nuevos Pedidos
   - ✅ Certificados Médicos

2. **Configura el email de destino:**
   - Ingresa el email donde quieres recibir las notificaciones

3. **Configura el servidor SMTP:**
   - Servidor SMTP: `smtp.gmail.com`
   - Puerto SMTP: `587`
   - Usuario SMTP: `tu-email@gmail.com`
   - Contraseña SMTP: Tu contraseña de aplicación
   - Encriptación: `TLS`
   - Nombre del Remitente: `Sistema CESODO`

4. Haz clic en **"Guardar Configuraciones"**

---

## 🔍 Solución de Problemas Comunes

### Error: "Connection could not be established with host smtp.gmail.com"

**Solución:**
- Verifica que la verificación en 2 pasos esté activada en Gmail
- Asegúrate de usar una contraseña de aplicación, NO tu contraseña normal
- Verifica que el puerto sea 587 y la encriptación TLS

### Error: "Expected response code 250 but got code 535"

**Solución:**
- La contraseña o usuario son incorrectos
- Regenera la contraseña de aplicación en Gmail

### Email no llega

**Solución:**
- Revisa la carpeta de SPAM
- Verifica que el email de destino esté correcto
- Revisa los logs de Laravel: `storage/logs/laravel.log`

### Error: "SMTP connect() failed"

**Solución:**
- Tu servidor puede estar bloqueando el puerto 587
- Intenta usar el puerto 465 con SSL en lugar de 587 con TLS
- Consulta con tu proveedor de hosting si bloquean SMTP saliente

---

## 📊 Verificar Logs de Email

Para ver si los emails se están enviando correctamente:

```powershell
# Ver los últimos logs
Get-Content storage\logs\laravel.log -Tail 50
```

O puedes revisar el archivo manualmente en:
`c:\xampp\htdocs\cesodo4\storage\logs\laravel.log`

---

## 🔐 Seguridad

**IMPORTANTE:** 
- ⚠️ NUNCA subas el archivo `.env` a Git
- ⚠️ Mantén las contraseñas de aplicación seguras
- ⚠️ No compartas tus credenciales SMTP

El archivo `.env` está en `.gitignore` por defecto, así que no se subirá al repositorio.

---

## 📝 Ejemplo de Configuración Completa

```env
# Configuración de Email SMTP
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=sistema.cesodo@gmail.com
MAIL_PASSWORD=abcd-efgh-ijkl-mnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="sistema.cesodo@gmail.com"
MAIL_FROM_NAME="Sistema CESODO"
```

---

## 🎯 Próximos Pasos

1. ✅ Configurar el `.env` con tus datos SMTP
2. ✅ Limpiar la caché con `php artisan config:clear`
3. ✅ Probar el envío con el script de prueba
4. ✅ Configurar las notificaciones en el módulo de Configuraciones
5. ✅ Verificar que las notificaciones lleguen correctamente

---

## 📚 Recursos Adicionales

- [Documentación de Laravel Mail](https://laravel.com/docs/10.x/mail)
- [Crear Contraseña de Aplicación en Gmail](https://support.google.com/accounts/answer/185833)
- [Configuración SMTP de Gmail](https://support.google.com/mail/answer/7126229)

---

## 🆘 Soporte

Si tienes problemas con la configuración:
1. Revisa los logs en `storage/logs/laravel.log`
2. Verifica que el archivo `.env` esté correctamente configurado
3. Asegúrate de que tu servidor permita conexiones SMTP salientes
4. Contacta a tu proveedor de hosting si el problema persiste

---

**Última actualización:** Octubre 12, 2025
