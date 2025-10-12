# Módulo de Configuraciones - Guía Completa

## 📋 Descripción General

El módulo de Configuraciones permite a los administradores personalizar completamente el sistema CESODO sin necesidad de conocimientos técnicos. Está organizado en 5 pestañas principales.

## 🏢 1. Empresa

Configura la información corporativa del sistema:

### Información Básica
- **Nombre de la Empresa**: Nombre que aparecerá en todo el sistema
- **RUC/NIF**: Número de identificación fiscal
- **Dirección**: Ubicación física de la empresa
- **Teléfono y Email**: Datos de contacto

### Identidad Visual
- **Logo Principal**: Imagen principal (recomendado: 200x60px, PNG con fondo transparente)
- **Icono/Favicon**: Icono pequeño para navegador (recomendado: 32x32px)
- **Descripción**: Breve descripción de la empresa

### Mejores Prácticas
- Usa imágenes en formato PNG con fondo transparente
- El logo debe ser legible en tamaños pequeños
- Mantén la descripción concisa (máximo 200 caracteres)

---

## ⚙️ 2. Sistema

Configuración técnica y operativa del sistema:

### Configuración General
- **Zona Horaria**: Ajusta la hora del sistema (Ej: America/Lima)
- **Idioma**: Español por defecto
- **Formato de Fecha**: DD/MM/YYYY (estándar peruano)
- **Moneda**: S/ (Soles peruanos)
- **Modo Mantenimiento**: Desactiva temporalmente el acceso público

### Límites y Restricciones
- **Timeout de Sesión**: Tiempo de inactividad antes de cerrar sesión (30 min por defecto)
- **Intentos de Login**: Máximo de intentos fallidos permitidos (5 por defecto)
- **Duración de Bloqueo**: Minutos que dura el bloqueo (15 min por defecto)
- **Tamaño Máximo de Archivos**: Límite para uploads (10 MB por defecto)
- **Registros por Página**: Cantidad de filas en tablas (15 por defecto)

### Seguridad y Privacidad
- **Requerir Contraseña Fuerte**: Exige contraseñas con mayúsculas, números y símbolos
- **Autenticación de Dos Factores**: Capa adicional de seguridad (requiere configuración adicional)
- **Registro de Actividad**: Guarda logs de acciones importantes
- **Expiración de Contraseña**: Días hasta requerir cambio (90 días por defecto)

### Backup y Mantenimiento
- **Backup Automático**: Activa respaldos automáticos de la base de datos
- **Frecuencia de Backup**: Diario, Semanal o Mensual
- **Retención de Backups**: Días que se guardan los respaldos (30 días por defecto)
- **Limpieza Automática de Logs**: Elimina logs antiguos automáticamente
- **Retención de Logs**: Días que se guardan los logs (90 días por defecto)

### Acciones Rápidas
- **Limpiar Caché**: Elimina archivos temporales (usar si hay problemas de visualización)
- **Optimizar Sistema**: Reconstruye cachés para mejor rendimiento

---

## 🔐 3. Permisos

Gestión de roles y permisos de usuario:

### Roles del Sistema
1. **Super Admin**: Acceso completo al sistema
2. **Admin**: Administración general excepto configuraciones críticas
3. **Encargado**: Gestión de inventario y pedidos
4. **Vendedor**: Registro de ventas y consulta de stock

### Categorías de Permisos
- **Productos**: Ver, crear, editar, eliminar productos
- **Stock**: Gestión de inventario y movimientos
- **Personas**: Administración de clientes y proveedores
- **Pedidos**: Manejo del sistema de pedidos
- **Menú**: Creación y gestión de menús
- **Recetas**: Administración de recetas
- **Reportes**: Acceso a reportes y estadísticas
- **Configuraciones**: Cambio de ajustes del sistema
- **Usuarios**: Gestión de cuentas de usuario
- **Certificados**: Manejo de certificados médicos

### Cómo Asignar Permisos
1. Selecciona un rol
2. Marca/desmarca los permisos deseados
3. Haz clic en "Actualizar Permisos"
4. Los cambios se aplican inmediatamente a todos los usuarios con ese rol

### Recomendaciones de Seguridad
- No des permisos de "Eliminar" a roles básicos
- Limita el acceso a "Configuraciones" solo a Super Admin
- Revisa periódicamente los permisos asignados
- Usa el principio de mínimo privilegio

---

## 🔔 4. Notificaciones

Sistema de alertas y notificaciones automáticas:

### Notificaciones por Email

#### Configuración SMTP
Para enviar emails, necesitas configurar un servidor SMTP:

**Gmail (Recomendado)**
1. Servidor: `smtp.gmail.com`
2. Puerto: `587`
3. Encriptación: `TLS`
4. Usuario: Tu email de Gmail
5. Contraseña: Contraseña de aplicación (NO tu contraseña normal)

**Cómo obtener contraseña de aplicación de Gmail:**
1. Ve a https://myaccount.google.com/security
2. Activa "Verificación en 2 pasos"
3. Ve a "Contraseñas de aplicaciones"
4. Genera una nueva contraseña para "Mail"
5. Copia la contraseña de 16 caracteres (sin espacios)
6. Pégala en el campo "Contraseña SMTP"

**Outlook/Hotmail**
- Servidor: `smtp-mail.outlook.com`
- Puerto: `587`
- Encriptación: `TLS`
- Usuario: Tu email de Outlook
- Contraseña: Tu contraseña de Outlook

#### Tipos de Notificaciones por Email
- **Stock Bajo**: Alerta cuando productos están por agotarse
- **Productos Vencidos**: Aviso de productos próximos a vencer
- **Nuevos Pedidos**: Notificación de pedidos recibidos
- **Certificados Médicos**: Alertas de certificados por vencer

### Notificaciones del Sistema
Alertas visuales dentro de la aplicación:
- **Alertas de Stock**: Banner en dashboard con productos bajos
- **Productos por Vencer**: Lista de productos próximos a vencer
- **Pedidos Pendientes**: Contador de pedidos sin procesar
- **Sonido de Notificaciones**: Reproduce alerta sonora (opcional)
- **Duración**: Tiempo que permanece visible (5 segundos por defecto)

### Recordatorios Automáticos
- **Aviso de Vencimiento**: Días de anticipación para alertar productos (7 días por defecto)
- **Stock Mínimo**: Cantidad que activa alerta de stock bajo (10 unidades por defecto)
- **Certificados**: Días de anticipación para certificados médicos (5 días por defecto)

### Prueba de Configuración
Después de configurar SMTP, puedes probar el envío usando:
```bash
php test-email-auto.php
```

---

## 🎨 5. Interfaz

Personalización de la apariencia del sistema:

### Tema Visual
- **Tema del Sistema**: Claro, Oscuro o Automático (según preferencia del navegador)
- **Color Primario**: Color principal del sistema (Rojo CESODO: #dc2626 por defecto)
- **Color Secundario**: Color secundario (Negro CESODO: #1a1a1a por defecto)
- **Bordes Redondeados**: Sin redondeo, Pequeño, Medio o Grande
- **Tamaño de Fuente**: Pequeña, Media o Grande
- **Densidad de Interfaz**: Compacta, Normal o Cómoda

### Navegación
- **Tipo de Menú Lateral**: 
  - Fijo: Siempre visible
  - Plegable: Se oculta/muestra con botón
  - Mini: Solo muestra iconos
- **Posición del Logo**: Izquierda, Centro o Derecha
- **Mostrar Breadcrumbs**: Ruta de navegación superior
- **Iconos en Menú**: Mostrar/ocultar iconos junto a opciones
- **Animaciones**: Transiciones y efectos visuales

### Tablas y Listados
- **Filas Alternas**: Colores alternados para mejor lectura
- **Bordes en Tablas**: Líneas divisoras entre celdas
- **Hover en Filas**: Resalta fila al pasar el mouse
- **Tamaño de Tablas**: Compacta, Normal o Grande
- **Posición de Acciones**: Primera o última columna

### Dashboard
- **Estilo de Cards**: Plano, Con Sombra o Con Bordes
- **Distribución**: 2, 3 o 4 columnas de widgets
- **Gráficos Animados**: Animación al cargar gráficos
- **Actualización Automática**: Refrescar datos cada 5 minutos
- **Widgets Compactos**: Vista reducida de widgets

### Accesibilidad
- **Alto Contraste**: Mejora visibilidad para usuarios con problemas visuales
- **Texto Grande**: Aumenta tamaño general de fuente
- **Reducir Movimiento**: Desactiva todas las animaciones

### Restaurar Valores
Usa el botón "Restaurar Valores por Defecto" para volver a la configuración original de CESODO.

---

## 🛠️ Solución de Problemas Comunes

### No se guardan los cambios
- Verifica que tengas permisos de Super Admin
- Comprueba que no haya errores en los campos obligatorios
- Revisa que el servidor web tenga permisos de escritura

### Emails no se envían
- Verifica la configuración SMTP
- Comprueba que usas contraseña de aplicación (Gmail)
- Revisa que el puerto y encriptación sean correctos
- Ejecuta `php test-email-auto.php` para diagnóstico

### Imágenes no se cargan
- Verifica que las imágenes sean PNG o JPG
- Comprueba el tamaño (máximo 10MB por defecto)
- Revisa permisos de carpeta `storage/app/public`

### Caché desactualizado
- Ve a Sistema → Limpiar Caché
- Si persiste: `php artisan cache:clear` en terminal
- Luego: Optimizar Sistema

---

## 📞 Soporte

Para soporte adicional:
- **Email**: skeen6265@gmail.com
- **Sistema**: Sistema CESODO v1.0
- **Documentación completa**: `/docs` en el repositorio

---

## 🔄 Historial de Cambios

### v1.0 (Octubre 2025)
- ✅ Tab Empresa implementado
- ✅ Tab Sistema implementado
- ✅ Tab Permisos implementado
- ✅ Tab Notificaciones implementado
- ✅ Tab Interfaz implementado
- ✅ Sistema de notificaciones por email con SMTP
- ✅ Configuración completa persistente en base de datos
- ✅ Scripts de prueba de email
- ✅ Documentación completa

---

*Este documento fue generado automáticamente por el sistema CESODO*
