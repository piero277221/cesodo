@echo off
chcp 65001 >nul
color 0A
cls

echo.
echo ═══════════════════════════════════════════════════════════════════════════════
echo    🍽️ SISTEMA CESODO - INSTALADOR AUTOMÁTICO
echo ═══════════════════════════════════════════════════════════════════════════════
echo.

REM Verificar si existe composer
where composer >nul 2>nul
if %errorlevel% neq 0 (
    echo ❌ ERROR: Composer no está instalado
    echo.
    echo Por favor instala Composer desde: https://getcomposer.org/download/
    echo.
    pause
    exit /b 1
)

REM Verificar si existe php
where php >nul 2>nul
if %errorlevel% neq 0 (
    echo ❌ ERROR: PHP no está instalado o no está en el PATH
    echo.
    echo Por favor instala PHP o agrega la ruta de PHP a las variables de entorno
    echo.
    pause
    exit /b 1
)

REM Verificar si existe npm
where npm >nul 2>nul
if %errorlevel% neq 0 (
    echo ❌ ERROR: Node.js/npm no está instalado
    echo.
    echo Por favor instala Node.js desde: https://nodejs.org/
    echo.
    pause
    exit /b 1
)

echo ✅ Requisitos verificados correctamente
echo.
echo ═══════════════════════════════════════════════════════════════════════════════
echo    PASO 1: Instalando dependencias PHP...
echo ═══════════════════════════════════════════════════════════════════════════════
echo.

composer install --no-interaction

if %errorlevel% neq 0 (
    echo.
    echo ❌ ERROR: Falló la instalación de dependencias PHP
    pause
    exit /b 1
)

echo.
echo ✅ Dependencias PHP instaladas correctamente
echo.
echo ═══════════════════════════════════════════════════════════════════════════════
echo    PASO 2: Configurando archivo .env...
echo ═══════════════════════════════════════════════════════════════════════════════
echo.

if not exist .env (
    if exist .env.example (
        copy .env.example .env >nul
        echo ✅ Archivo .env creado desde .env.example
    ) else (
        echo ❌ ERROR: No se encuentra el archivo .env.example
        pause
        exit /b 1
    )
) else (
    echo ⚠️  El archivo .env ya existe, no se sobrescribirá
)

echo.
echo ═══════════════════════════════════════════════════════════════════════════════
echo    PASO 3: Generando clave de aplicación...
echo ═══════════════════════════════════════════════════════════════════════════════
echo.

php artisan key:generate --force

if %errorlevel% neq 0 (
    echo.
    echo ❌ ERROR: No se pudo generar la clave de aplicación
    pause
    exit /b 1
)

echo.
echo ✅ Clave de aplicación generada
echo.
echo ═══════════════════════════════════════════════════════════════════════════════
echo    PASO 4: Configuración de Base de Datos
echo ═══════════════════════════════════════════════════════════════════════════════
echo.
echo ⚠️  IMPORTANTE: Antes de continuar, asegúrate de:
echo.
echo    1. MySQL/MariaDB está corriendo (inicia XAMPP si lo usas)
echo    2. Has creado la base de datos "cesodo_db" en phpMyAdmin
echo    3. Has configurado las credenciales en el archivo .env
echo.
echo Archivo .env ubicado en: %CD%\.env
echo.
echo Configuración por defecto:
echo    DB_DATABASE=cesodo_db
echo    DB_USERNAME=root
echo    DB_PASSWORD=
echo.
set /p continuar="¿Deseas continuar con las migraciones? (S/N): "

if /i "%continuar%" neq "S" (
    echo.
    echo ⚠️  Instalación pausada
    echo.
    echo Para continuar manualmente:
    echo    1. Configura el archivo .env
    echo    2. Ejecuta: php artisan migrate
    echo    3. Ejecuta: php artisan db:seed (opcional)
    echo    4. Ejecuta: npm install
    echo    5. Ejecuta: npm run dev
    echo    6. Ejecuta: php artisan storage:link
    echo.
    pause
    exit /b 0
)

echo.
echo ═══════════════════════════════════════════════════════════════════════════════
echo    PASO 5: Ejecutando migraciones de base de datos...
echo ═══════════════════════════════════════════════════════════════════════════════
echo.

php artisan migrate --force

if %errorlevel% neq 0 (
    echo.
    echo ❌ ERROR: Falló la ejecución de migraciones
    echo.
    echo Posibles causas:
    echo    - MySQL/MariaDB no está corriendo
    echo    - La base de datos no existe
    echo    - Credenciales incorrectas en .env
    echo.
    pause
    exit /b 1
)

echo.
echo ✅ Migraciones ejecutadas correctamente
echo.
echo ═══════════════════════════════════════════════════════════════════════════════
echo    PASO 6: ¿Cargar datos de ejemplo?
echo ═══════════════════════════════════════════════════════════════════════════════
echo.
echo Los datos de ejemplo incluyen:
echo    - Usuario administrador (admin@cesodo.com / password)
echo    - Usuario normal (user@cesodo.com / password)
echo    - Categorías, productos y proveedores de muestra
echo.
set /p seed="¿Deseas cargar datos de ejemplo? (S/N): "

if /i "%seed%"=="S" (
    echo.
    echo Cargando datos de ejemplo...
    php artisan db:seed --force

    if %errorlevel% neq 0 (
        echo ⚠️  Advertencia: Hubo problemas al cargar los datos de ejemplo
    ) else (
        echo ✅ Datos de ejemplo cargados correctamente
    )
)

echo.
echo ═══════════════════════════════════════════════════════════════════════════════
echo    PASO 7: Instalando dependencias frontend...
echo ═══════════════════════════════════════════════════════════════════════════════
echo.

npm install

if %errorlevel% neq 0 (
    echo.
    echo ❌ ERROR: Falló la instalación de dependencias npm
    pause
    exit /b 1
)

echo.
echo ✅ Dependencias frontend instaladas
echo.
echo ═══════════════════════════════════════════════════════════════════════════════
echo    PASO 8: Compilando assets...
echo ═══════════════════════════════════════════════════════════════════════════════
echo.

npm run build

if %errorlevel% neq 0 (
    echo ⚠️  Advertencia: Falló la compilación de assets, pero puedes continuar
)

echo.
echo ═══════════════════════════════════════════════════════════════════════════════
echo    PASO 9: Creando enlace de storage...
echo ═══════════════════════════════════════════════════════════════════════════════
echo.

php artisan storage:link

if %errorlevel% neq 0 (
    echo ⚠️  Advertencia: No se pudo crear el enlace de storage
)

echo.
echo ═══════════════════════════════════════════════════════════════════════════════
echo    PASO 10: Limpiando caché...
echo ═══════════════════════════════════════════════════════════════════════════════
echo.

php artisan optimize:clear >nul 2>nul

echo ✅ Caché limpiado
echo.
echo ═══════════════════════════════════════════════════════════════════════════════
echo    🎉 ¡INSTALACIÓN COMPLETADA!
echo ═══════════════════════════════════════════════════════════════════════════════
echo.
echo El sistema ha sido instalado correctamente.
echo.
echo Para iniciar el servidor de desarrollo, ejecuta:
echo    php artisan serve
echo.
echo Luego accede en tu navegador a:
echo    http://localhost:8000
echo.

if /i "%seed%"=="S" (
    echo Credenciales de acceso:
    echo    Admin: admin@cesodo.com / password
    echo    User:  user@cesodo.com / password
    echo.
)

echo ═══════════════════════════════════════════════════════════════════════════════
echo.
set /p iniciar="¿Deseas iniciar el servidor ahora? (S/N): "

if /i "%iniciar%"=="S" (
    echo.
    echo Iniciando servidor en http://localhost:8000...
    echo.
    echo Presiona Ctrl+C para detener el servidor
    echo.
    php artisan serve
) else (
    echo.
    echo Para iniciar el servidor manualmente, ejecuta:
    echo    php artisan serve
    echo.
)

pause
