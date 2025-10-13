@echo off
chcp 65001 >nul
color 0E
cls

echo.
echo ═══════════════════════════════════════════════════════════════════════════════
echo    🍽️ SISTEMA CESODO - INICIAR SERVIDOR
echo ═══════════════════════════════════════════════════════════════════════════════
echo.

REM Verificar si existe php
where php >nul 2>nul
if %errorlevel% neq 0 (
    echo ❌ ERROR: PHP no está instalado o no está en el PATH
    echo.
    pause
    exit /b 1
)

REM Verificar si el archivo .env existe
if not exist .env (
    echo ❌ ERROR: El archivo .env no existe
    echo.
    echo Por favor ejecuta primero: install.bat
    echo O copia manualmente: copy .env.example .env
    echo.
    pause
    exit /b 1
)

echo ✅ Verificaciones completadas
echo.
echo ═══════════════════════════════════════════════════════════════════════════════
echo.
echo El servidor se iniciará en:
echo.
echo    🌐 http://localhost:8000
echo.
echo Presiona Ctrl+C para detener el servidor
echo.
echo ═══════════════════════════════════════════════════════════════════════════════
echo.

REM Esperar 3 segundos
timeout /t 3 /nobreak >nul

REM Iniciar el servidor
php artisan serve

pause
