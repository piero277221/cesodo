═══════════════════════════════════════════════════════════════════════════════
   🔧 SOLUCIÓN AL ERROR 404 EN RUTAS DEL SISTEMA
═══════════════════════════════════════════════════════════════════════════════

❌ PROBLEMA:
Al acceder a http://localhost/cesodo4/public/contratos sale "404 Not Found"

✅ CAUSA:
Apache no está redirigiendo las URLs correctamente a través del index.php de Laravel.

═══════════════════════════════════════════════════════════════════════════════
   SOLUCIÓN RÁPIDA (Si tienes prisa)
═══════════════════════════════════════════════════════════════════════════════

1. NO escribas /contratos directamente en la URL
2. Accede primero a: http://localhost/cesodo4/public
3. Desde el dashboard, haz clic en el módulo "Contratos"
4. Laravel generará la URL correcta automáticamente

═══════════════════════════════════════════════════════════════════════════════
   SOLUCIÓN PERMANENTE: Configurar Virtual Host
═══════════════════════════════════════════════════════════════════════════════

Con esto podrás acceder como: http://cesodo.local (sin /public)

┌─────────────────────────────────────────────────────────────────────────────┐
│ PASO 1: Habilitar Virtual Hosts en Apache                                  │
└─────────────────────────────────────────────────────────────────────────────┘

1. Abre el archivo: C:\xampp\apache\conf\httpd.conf

2. Busca esta línea (Ctrl+F):
   #Include conf/extra/httpd-vhosts.conf

3. Quítale el símbolo # para que quede así:
   Include conf/extra/httpd-vhosts.conf

4. Guarda el archivo

┌─────────────────────────────────────────────────────────────────────────────┐
│ PASO 2: Agregar configuración del Virtual Host                             │
└─────────────────────────────────────────────────────────────────────────────┘

1. Abre el archivo: C:\xampp\apache\conf\extra\httpd-vhosts.conf

2. Al FINAL del archivo, pega esto (copia del archivo apache-config.conf):

─────────────────────────────────────────────────────────────────────────────
<VirtualHost *:80>
    ServerName cesodo.local
    DocumentRoot "C:/xampp/htdocs/cesodo4/public"
    
    <Directory "C:/xampp/htdocs/cesodo4/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
        DirectoryIndex index.php
        
        <IfModule mod_rewrite.c>
            RewriteEngine On
        </IfModule>
    </Directory>
    
    ErrorLog "C:/xampp/htdocs/cesodo4/storage/logs/apache_error.log"
    CustomLog "C:/xampp/htdocs/cesodo4/storage/logs/apache_access.log" combined
</VirtualHost>
─────────────────────────────────────────────────────────────────────────────

3. Guarda el archivo

┌─────────────────────────────────────────────────────────────────────────────┐
│ PASO 3: Modificar el archivo hosts de Windows                              │
└─────────────────────────────────────────────────────────────────────────────┘

⚠️ IMPORTANTE: Necesitas permisos de Administrador

1. Abre el Bloc de notas COMO ADMINISTRADOR:
   - Clic derecho en "Bloc de notas"
   - "Ejecutar como administrador"

2. Desde el Bloc de notas, abre el archivo:
   C:\Windows\System32\drivers\etc\hosts

3. Al FINAL del archivo, agrega esta línea:
   127.0.0.1    cesodo.local

4. Guarda el archivo (Ctrl+S)

┌─────────────────────────────────────────────────────────────────────────────┐
│ PASO 4: Reiniciar Apache                                                   │
└─────────────────────────────────────────────────────────────────────────────┘

1. Abre el Panel de Control de XAMPP
2. Detén Apache (botón "Stop")
3. Espera 2 segundos
4. Inicia Apache (botón "Start")

┌─────────────────────────────────────────────────────────────────────────────┐
│ PASO 5: Probar la nueva URL                                                │
└─────────────────────────────────────────────────────────────────────────────┘

1. Abre tu navegador
2. Accede a: http://cesodo.local
3. Deberías ver el login del sistema
4. Ahora puedes acceder a: http://cesodo.local/contratos

═══════════════════════════════════════════════════════════════════════════════
   VERIFICAR QUE TODO FUNCIONA
═══════════════════════════════════════════════════════════════════════════════

Prueba estas URLs después de configurar:

✅ http://cesodo.local              → Debería mostrar login/dashboard
✅ http://cesodo.local/contratos    → Debería mostrar módulo de contratos
✅ http://cesodo.local/productos    → Debería mostrar módulo de productos
✅ http://cesodo.local/menus        → Debería mostrar módulo de menús

═══════════════════════════════════════════════════════════════════════════════
   SOLUCIÓN ALTERNATIVA: Usar servidor de Laravel
═══════════════════════════════════════════════════════════════════════════════

Si no quieres configurar Virtual Host, puedes usar el servidor de Laravel:

1. Abre una terminal en la carpeta del proyecto
2. Ejecuta: php artisan serve
3. Accede a: http://localhost:8000
4. Todas las rutas funcionarán perfectamente:
   - http://localhost:8000/contratos
   - http://localhost:8000/productos
   - http://localhost:8000/menus
   - etc.

═══════════════════════════════════════════════════════════════════════════════
   PROBLEMAS COMUNES
═══════════════════════════════════════════════════════════════════════════════

❌ "403 Forbidden" después de configurar
   └─ Solución: Verifica que la ruta en httpd-vhosts.conf sea correcta
   └─ Debe ser: C:/xampp/htdocs/cesodo4/public (con / no \)

❌ "Apache no inicia" después de cambios
   └─ Solución: Hay un error de sintaxis en httpd-vhosts.conf
   └─ Revisa que hayas copiado correctamente el <VirtualHost>
   └─ Verifica las comillas y los < >

❌ "cesodo.local no carga"
   └─ Solución 1: Limpia el caché DNS
      └─ Ejecuta en CMD: ipconfig /flushdns
   └─ Solución 2: Verifica el archivo hosts
      └─ Debe tener: 127.0.0.1    cesodo.local
   └─ Solución 3: Reinicia el navegador

❌ "404 Not Found" aún después de configurar
   └─ Solución: Verifica que mod_rewrite esté habilitado
   └─ En httpd.conf debe estar sin # esta línea:
      LoadModule rewrite_module modules/mod_rewrite.so

═══════════════════════════════════════════════════════════════════════════════
   RESUMEN DE ARCHIVOS A MODIFICAR
═══════════════════════════════════════════════════════════════════════════════

1. C:\xampp\apache\conf\httpd.conf
   └─ Descomentar: Include conf/extra/httpd-vhosts.conf

2. C:\xampp\apache\conf\extra\httpd-vhosts.conf
   └─ Agregar el bloque <VirtualHost> al final

3. C:\Windows\System32\drivers\etc\hosts
   └─ Agregar: 127.0.0.1    cesodo.local

4. Reiniciar Apache desde panel XAMPP

═══════════════════════════════════════════════════════════════════════════════
   ¿CUÁL MÉTODO USAR?
═══════════════════════════════════════════════════════════════════════════════

📌 Para DESARROLLO (recomendado):
   └─ php artisan serve
   └─ Más fácil, no requiere configuración
   └─ http://localhost:8000

📌 Para PRODUCCIÓN LOCAL (profesional):
   └─ Virtual Host (cesodo.local)
   └─ Simula un entorno real
   └─ Requiere configuración inicial

📌 Para PRUEBAS RÁPIDAS:
   └─ http://localhost/cesodo4/public
   └─ Usar menú para navegar
   └─ No escribir URLs manualmente

═══════════════════════════════════════════════════════════════════════════════

🎯 RECOMENDACIÓN: Usa "php artisan serve" para desarrollo diario
                  Es más simple y todas las rutas funcionarán sin problemas

═══════════════════════════════════════════════════════════════════════════════
