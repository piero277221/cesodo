# Consulta RENIEC - Sistema CESODO

## ✅ Estado: API REAL ACTIVA

El sistema está configurado con **API REAL de RENIEC** a través de **apiperu.dev**.

### 🎯 Ahora Puedes Consultar Cualquier DNI Real

Ya no es necesario usar DNIs de prueba. El sistema puede consultar **cualquier DNI peruano válido** de 8 dígitos.

### 🔍 Ejemplo de Consulta Real

**DNI**: `43216789`  
**Resultado**:
- Nombres: JACK LENNYN
- Apellido Paterno: ARIAS
- Apellido Materno: NOLAZCO
- Nombre Completo: JACK LENNYN ARIAS NOLAZCO

### 📊 Límites de API

- **Consultas diarias**: 100 (gratuitas)
- **Reset**: Diario a las 00:00 hrs
- **Proveedor**: apiperu.dev
- **Token**: Configurado en el sistema

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
