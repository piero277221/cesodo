# 🍽️ Sistema CESODO

**Sistema de Gestión para Comedores y Servicios de Alimentación**

Sistema completo desarrollado en Laravel 11 para la gestión integral de comedores, servicios de alimentación, inventarios, compras, personal y menús.

---

## 📋 Requisitos del Sistema

Antes de instalar, asegúrate de tener:

- ✅ **PHP 8.1 o superior** (recomendado 8.2)
- ✅ **Composer** (https://getcomposer.org/)
- ✅ **MySQL 8.0+** o **MariaDB 10.3+**
- ✅ **Node.js 16+** y **npm** (https://nodejs.org/)

### Extensiones PHP necesarias:
```
BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, PDO_MySQL, Tokenizer, XML, GD, Zip
```

---

## 🚀 Instalación Rápida (5 pasos)

### 1️⃣ Instalar Dependencias PHP
```bash
composer install
```

### 2️⃣ Configurar Variables de Entorno
```bash
# Copiar archivo de configuración
copy .env.example .env

# Editar .env y configurar tu base de datos:
DB_DATABASE=cesodo_db
DB_USERNAME=root
DB_PASSWORD=

# Generar clave de aplicación
php artisan key:generate
```

### 3️⃣ Crear y Configurar Base de Datos
```sql
-- En MySQL/phpMyAdmin:
CREATE DATABASE cesodo_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

```bash
# Ejecutar migraciones
php artisan migrate

# (Opcional) Cargar datos de ejemplo
php artisan db:seed
```

### 4️⃣ Instalar Assets Frontend
```bash
npm install
npm run dev
```

### 5️⃣ Crear Enlace de Storage
```bash
php artisan storage:link
```

---

## ▶️ Iniciar el Sistema

```bash
# Opción 1: Servidor de desarrollo Laravel
php artisan serve

# Acceder en: http://localhost:8000
```

```bash
# Opción 2: Usando XAMPP/WAMP
# Colocar en C:\xampp\htdocs\cesodo4
# Acceder en: http://localhost/cesodo4/public
```

---

## 👤 Credenciales de Acceso

Si ejecutaste los seeders (`php artisan db:seed`):

**Administrador:**
- Email: `admin@cesodo.com`
- Password: `password`

**Usuario:**
- Email: `user@cesodo.com`
- Password: `password`

> ⚠️ **Cambia estas contraseñas en producción**

---

## 🎯 Módulos del Sistema

El sistema incluye los siguientes módulos:

### 📦 Gestión de Inventario
- Control de productos e insumos
- Categorías y unidades de medida
- Alertas de stock mínimo
- Kardex de movimientos
- Fechas de vencimiento

### 🛒 Compras
- Órdenes de compra a proveedores
- Gestión de proveedores
- Recepción de mercadería
- Cálculo automático de IGV incluido
- Historial de compras

### 🍽️ Menús
- Creación de menús diarios
- Recetas con ingredientes
- Control de disponibilidad
- Registro de consumos por trabajador
- Estadísticas de consumo

### 👥 Personal
- Registro de trabajadores
- Gestión de contratos laborales
- Certificados médicos
- Control de documentos
- Historial laboral

### ⚙️ Configuraciones
- Información de empresa y logo
- Configuración del sistema
- Roles y permisos (Spatie Permission)
- Notificaciones y alertas
- Personalización de interfaz

---

## 🔧 Comandos Útiles

### Limpiar Caché
```bash
php artisan optimize:clear    # Limpia todo el caché
php artisan cache:clear       # Caché de aplicación
php artisan config:clear      # Caché de configuración
php artisan view:clear        # Caché de vistas
php artisan route:clear       # Caché de rutas
```

### Base de Datos
```bash
php artisan migrate           # Ejecutar migraciones
php artisan migrate:fresh     # Reiniciar BD (borra datos)
php artisan migrate:fresh --seed  # Reiniciar con datos ejemplo
php artisan db:seed          # Solo cargar datos ejemplo
```

### Optimización (Producción)
```bash
php artisan optimize          # Optimizar aplicación
php artisan config:cache      # Cachear configuración
php artisan route:cache       # Cachear rutas
php artisan view:cache        # Cachear vistas
npm run build                 # Compilar assets para producción
```

---

## 📁 Estructura del Proyecto

```
cesodo4/
├── app/                    # Lógica de la aplicación
│   ├── Http/Controllers/   # Controladores
│   ├── Models/            # Modelos Eloquent
│   └── Services/          # Servicios
├── config/                # Configuraciones
├── database/
│   ├── migrations/        # Migraciones de BD
│   └── seeders/          # Datos iniciales
├── public/               # Punto de entrada (index.php)
├── resources/
│   ├── views/            # Vistas Blade
│   ├── css/              # Estilos
│   └── js/               # JavaScript
├── routes/               # Rutas de la aplicación
├── storage/              # Archivos generados
│   ├── app/              # Archivos de aplicación
│   └── logs/             # Logs del sistema
├── .env                  # Variables de entorno
├── artisan               # CLI de Laravel
└── composer.json         # Dependencias PHP
```

---

## 🎨 Características Destacadas

✨ **Interfaz Moderna:** Diseño con paleta de colores negro, rojo y blanco  
🔐 **Control de Acceso:** Sistema de roles y permisos con Spatie  
📊 **Reportes:** Exportación a Excel y PDF  
🔔 **Notificaciones:** Sistema de alertas en tiempo real  
📱 **Responsive:** Adaptado para móviles y tablets  
🌍 **Multiidioma:** Preparado para español  
⚡ **Performance:** Optimizado con caché y lazy loading  

---

## 🐛 Solución de Problemas

### Error: "Class 'PDO' not found"
```bash
# Habilitar en php.ini:
extension=pdo_mysql
```

### Error: "No application encryption key"
```bash
php artisan key:generate
```

### Error 500 al acceder
```bash
# Ver logs
tail -f storage/logs/laravel.log

# O en Windows:
Get-Content storage\logs\laravel.log -Wait
```

### Permisos en Windows (XAMPP)
```bash
# Si hay problemas de escritura:
icacls storage /grant Everyone:(OI)(CI)F /T
icacls bootstrap\cache /grant Everyone:(OI)(CI)F /T
```

---

## 📖 Documentación Completa

Para instrucciones detalladas de instalación, configuración avanzada y troubleshooting, consulta:

**📄 [INSTALACION.md](INSTALACION.md)** - Tutorial completo de instalación paso a paso

---

## 🛠️ Stack Tecnológico

- **Backend:** Laravel 11, PHP 8.2
- **Frontend:** Bootstrap 5, JavaScript ES6
- **Base de Datos:** MySQL 8.0
- **Autenticación:** Laravel UI
- **Permisos:** Spatie Laravel Permission
- **Excel/PDF:** Maatwebsite Excel, DomPDF
- **Build Tools:** Vite, npm

---

## 📞 Soporte

- 📖 Documentación Laravel: https://laravel.com/docs/11.x
- 🐛 Reportar errores: Crear issue en el repositorio
- 📧 Contacto: piero277221@github

---

## ✅ Checklist de Instalación

- [ ] PHP 8.1+ instalado
- [ ] Composer instalado
- [ ] MySQL corriendo
- [ ] Node.js y npm instalados
- [ ] `composer install` ejecutado
- [ ] Archivo `.env` configurado
- [ ] `php artisan key:generate` ejecutado
- [ ] Base de datos creada
- [ ] `php artisan migrate` ejecutado
- [ ] `npm install && npm run dev` ejecutado
- [ ] `php artisan storage:link` ejecutado
- [ ] Sistema accesible en navegador ✨

---

**Desarrollado con ❤️ usando Laravel 11**

*Versión: 1.0 | Última actualización: Octubre 2025*

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
