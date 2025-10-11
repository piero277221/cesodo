# Integración API RENIEC Perú - Sistema CESODO

## 📋 Descripción

Sistema completo de integración con la API de RENIEC (Registro Nacional de Identificación y Estado Civil) de Perú para consultas de DNI.

## 🚀 Características Implementadas

### 1. **Consulta de DNI en Tiempo Real**
- Botón de consulta integrado en el formulario de creación de personas
- Validación automática de formato de DNI (8 dígitos)
- Autocompletado de campos: nombres y apellidos
- Respuesta en tiempo real con feedback visual

### 2. **Sistema de Contador de Consultas**
- **Límite diario**: 100 consultas gratuitas por día
- **Visualización en tiempo real**: Contador actualizado automáticamente
- **Códigos de color**:
  - 🟢 Verde: Más de 30 consultas disponibles
  - 🟡 Amarillo: 11-30 consultas disponibles
  - 🔴 Rojo: 10 o menos consultas disponibles

### 3. **Historial de Consultas**
- Registro completo de todas las consultas realizadas
- Información almacenada:
  - DNI consultado
  - Nombre completo obtenido
  - Estado de la consulta (exitosa/fallida/error)
  - Tipo de consulta (gratuita/premium)
  - Usuario que realizó la consulta
  - IP de origen
  - Fecha y hora
- Vista paginada del historial
- Filtros y búsqueda avanzada

### 4. **Estadísticas Detalladas**
- Dashboard con tarjetas visuales:
  - Consultas realizadas hoy
  - Consultas disponibles restantes
  - Total de consultas del mes
  - Consultas exitosas totales
- Actualización automática cada 30 segundos
- Gráficos estadísticos

## 🔧 Componentes Técnicos

### Backend

#### 1. **Migración**: `2025_10_11_192422_create_reniec_consultas_table.php`
```php
- id
- dni (8 caracteres)
- nombres
- apellido_paterno
- apellido_materno
- nombre_completo
- tipo_consulta (gratuita/premium)
- estado (exitosa/fallida/error)
- respuesta_api (JSON)
- ip_consulta
- user_id (foreign key)
- timestamps
- indices
```

#### 2. **Modelo**: `App\Models\ReniecConsulta`
Métodos principales:
- `consultasGratuitasHoy()`: Retorna consultas disponibles hoy
- `totalConsultasHoy()`: Total de consultas del día
- `estadisticas()`: Array con todas las estadísticas

#### 3. **Servicio**: `App\Services\ReniecService`
- Consumo de API de RENIEC
- Validación de DNI peruano
- Registro automático de consultas
- Manejo de errores y límites
- API utilizada: `https://api.apis.net.pe/v2/reniec/dni`

#### 4. **Controlador**: `App\Http\Controllers\ReniecController`
Endpoints:
- `POST /reniec/consultar-dni`: Consultar DNI
- `GET /reniec/estadisticas`: Obtener estadísticas
- `GET /reniec/consultas-disponibles`: Ver disponibilidad
- `GET /reniec/historial`: Historial completo

### Frontend

#### 1. **Vista de Formulario**: `resources/views/personas/create.blade.php`
- Botón "RENIEC" integrado con el campo de documento
- Contador de consultas disponibles
- Alertas de resultado (success/warning/danger)
- JavaScript para consultas AJAX
- Autocompletado de campos

#### 2. **Vista de Historial**: `resources/views/reniec/historial.blade.php`
- Dashboard con 4 tarjetas estadísticas
- Tabla con historial completo
- Paginación
- Actualización en tiempo real
- Badges de estado con colores

### Configuración

#### `config/services.php`
```php
'reniec' => [
    'api_url' => env('RENIEC_API_URL', 'https://api.apis.net.pe/v2/reniec/dni'),
    'api_token' => env('RENIEC_API_TOKEN', 'apis-token-10359...'),
    'limite_gratuito' => env('RENIEC_LIMITE_GRATUITO', 100),
]
```

## 📍 Rutas Disponibles

| Método | Ruta | Nombre | Descripción |
|--------|------|--------|-------------|
| POST | `/reniec/consultar-dni` | reniec.consultar | Consultar DNI |
| GET | `/reniec/estadisticas` | reniec.estadisticas | Ver estadísticas |
| GET | `/reniec/consultas-disponibles` | reniec.disponibles | Consultas disponibles |
| GET | `/reniec/historial` | reniec.historial | Ver historial |

## 💻 Uso

### 1. Consultar DNI desde el Formulario

1. Ir a **Personas > Nueva Persona**
2. Seleccionar "DNI" en tipo de documento
3. Ingresar los 8 dígitos del DNI
4. Hacer clic en el botón **"RENIEC"**
5. Los campos de nombres y apellidos se rellenan automáticamente

### 2. Ver Historial de Consultas

Acceder a: `/reniec/historial`

### 3. Integración Programática

```javascript
// Consultar DNI
fetch('/reniec/consultar-dni', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
        dni: '12345678'
    })
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        console.log('Nombre:', data.data.nombre_completo);
        console.log('Consultas disponibles:', data.consultas_disponibles);
    }
});
```

## 🎨 Diseño CESODO

Todos los componentes utilizan la paleta de colores oficial:
- **Negro**: `#1a1a1a`
- **Rojo**: `#dc2626`
- **Blanco**: `#ffffff`

## 📊 Límites y Restricciones

- **Consultas gratuitas**: 100 por día
- **Reset diario**: A las 00:00 horas
- **Validación**: Solo DNI peruano (8 dígitos)
- **Timeout**: 10 segundos por consulta
- **Registro**: Todas las consultas se almacenan

## 🔐 Seguridad

- Token CSRF obligatorio
- Validación de entrada (DNI formato correcto)
- Registro de IP de origen
- Autenticación de usuario
- Rate limiting por IP

## 📈 Estadísticas Disponibles

- Consultas del día actual
- Consultas del mes actual
- Total histórico
- Consultas exitosas vs fallidas
- Consultas disponibles restantes

## 🎯 Próximas Mejoras

- [ ] Integración con RUC (empresas)
- [ ] Cache de resultados (evitar consultas duplicadas)
- [ ] Exportación de historial a Excel/PDF
- [ ] Notificaciones cuando quedan pocas consultas
- [ ] Dashboard de analíticas avanzadas
- [ ] API premium para consultas ilimitadas

## ✅ Estado del Proyecto

**COMPLETAMENTE FUNCIONAL** ✅

Todos los componentes están implementados, probados y listos para producción.

---

**Fecha de implementación**: 11 de Octubre de 2025  
**Versión**: 1.0.0  
**Sistema**: CESODO - Centro de Estudios y Servicios
