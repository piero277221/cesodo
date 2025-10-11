# DNIs de Prueba - Sistema RENIEC

## 📋 Modo Demostración Activo

El sistema actualmente funciona en **MODO DEMOSTRACIÓN** con datos de prueba.

### 🔑 DNIs de Prueba Disponibles

Puedes usar cualquiera de estos DNIs para probar la funcionalidad:

| DNI | Nombres | Apellido Paterno | Apellido Materno | Nombre Completo |
|-----|---------|------------------|------------------|-----------------|
| `71981207` | JUAN CARLOS | RODRIGUEZ | GARCIA | JUAN CARLOS RODRIGUEZ GARCIA |
| `41821256` | MARIA ELENA | LOPEZ | FERNANDEZ | MARIA ELENA LOPEZ FERNANDEZ |
| `12345678` | PEDRO LUIS | MARTINEZ | SANCHEZ | PEDRO LUIS MARTINEZ SANCHEZ |
| `87654321` | ANA SOFIA | TORRES | RAMIREZ | ANA SOFIA TORRES RAMIREZ |
| `45678901` | CARLOS ALBERTO | GONZALEZ | DIAZ | CARLOS ALBERTO GONZALEZ DIAZ |

### ✅ Cómo Usar

1. Ve a **Personas > Nueva Persona**
2. Selecciona "DNI" en tipo de documento
3. Ingresa uno de los DNIs de prueba (por ejemplo: `71981207`)
4. Haz clic en el botón **"RENIEC"**
5. Los datos se rellenarán automáticamente

### 🔄 Migrar a API Real

Para usar una API real de RENIEC, necesitas:

1. **Obtener un Token de API:**
   - Opción 1: [https://apis.net.pe/](https://apis.net.pe/) - Registra y obtén tu token gratuito
   - Opción 2: [https://apiperu.dev/](https://apiperu.dev/) - API con plan gratuito
   - Opción 3: [https://api.perudevs.com/](https://api.perudevs.com/) - API peruana

2. **Configurar el archivo `.env`:**
   ```env
   RENIEC_API_URL=https://api.apis.net.pe/v2/reniec/dni
   RENIEC_API_TOKEN=tu-token-aqui
   RENIEC_LIMITE_GRATUITO=100
   ```

3. **Modificar el servicio:**
   - Editar `app/Services/ReniecService.php`
   - Cambiar el método `consultarDni()` para usar `consultarApiReal()`
   - Eliminar la llamada a `obtenerDatosPrueba()`

### 📊 Características Actuales

- ✅ Validación de formato DNI (8 dígitos)
- ✅ Contador de consultas disponibles
- ✅ Registro de todas las consultas en base de datos
- ✅ Autocompletado de nombres y apellidos
- ✅ Alertas visuales de resultado
- ✅ Historial completo de consultas
- ✅ Estadísticas en tiempo real

### 🎯 Beneficios del Modo Demostración

- Sin necesidad de registro en APIs externas
- Sin límites de rate limiting
- Respuestas instantáneas
- Perfecto para pruebas y desarrollo
- Sin costos de API

### ⚠️ Limitaciones

- Solo funcionan los 5 DNIs predefinidos
- No se puede consultar DNIs reales
- Datos ficticios (solo para demostración)

### 🚀 Próximos Pasos

1. Registrarse en una API de RENIEC
2. Obtener token de autenticación
3. Configurar en `.env`
4. Activar API real en el código
5. ¡Consultar DNIs reales!

---

**Fecha**: 11 de Octubre de 2025  
**Sistema**: CESODO  
**Versión**: 1.0.0 (Modo Demostración)
