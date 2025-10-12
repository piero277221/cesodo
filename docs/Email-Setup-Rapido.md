# 📧 Configuración Rápida de Email

## Pasos para Configurar Gmail (5 minutos)

### 1. Obtener Contraseña de Aplicación de Gmail

1. Ve a: https://myaccount.google.com/apppasswords
2. Si no está habilitada la verificación en 2 pasos, actívala primero
3. Genera una contraseña de aplicación:
   - Aplicación: Correo
   - Dispositivo: Otro (Laravel CESODO)
4. Copia la contraseña de 16 caracteres

### 2. Editar archivo `.env`

Abre `c:\xampp\htdocs\cesodo4\.env` y cambia estas líneas:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-contraseña-de-aplicacion-16-caracteres
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="tu-email@gmail.com"
MAIL_FROM_NAME="Sistema CESODO"
```

### 3. Limpiar Caché

```powershell
php artisan config:clear
php artisan cache:clear
```

### 4. Probar Email

```powershell
php test-email.php
```

Ingresa tu email y verifica que llegue el mensaje.

### 5. Configurar en el Sistema

1. Ve a: **Configuraciones → Notificaciones**
2. Activa las notificaciones que quieras
3. Configura los datos SMTP (mismos del .env)
4. Guarda los cambios

## ✅ ¡Listo!

Ahora el sistema enviará notificaciones por email cuando:
- Stock esté bajo
- Productos estén por vencer
- Lleguen nuevos pedidos
- Certificados médicos estén por vencer

---

## 🆘 Problemas?

Lee la documentación completa: `docs/Configuracion-Email-Notificaciones.md`
