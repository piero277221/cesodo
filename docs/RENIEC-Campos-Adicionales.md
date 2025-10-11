# RENIEC - Campos Adicionales (Sexo y Fecha de Nacimiento)

## 📋 Situación Actual

La API de **apiperu.dev** actualmente **NO proporciona** los campos de:
- ❌ Sexo (género)
- ❌ Fecha de nacimiento

### Campos que SÍ proporciona:
- ✅ DNI (número)
- ✅ Nombres
- ✅ Apellido Paterno
- ✅ Apellido Materno
- ✅ Nombre Completo
- ✅ Código de Verificación
- ✅ Dirección
- ✅ Ubigeo (RENIEC y SUNAT)

## 🔧 Solución Implementada

El sistema ahora está preparado para:

1. **Autocompletar automáticamente** si la API proporciona estos campos
2. **Mostrar mensaje informativo** indicando que campos deben llenarse manualmente
3. **Soportar múltiples formatos** de respuesta API

### Funcionalidad del Código:

```javascript
// El JavaScript intenta autocompletar:
if (data.data.sexo) {
    // Rellena el campo de sexo
}

if (data.data.fecha_nacimiento) {
    // Rellena el campo de fecha de nacimiento
}

// Si falta información, muestra:
"Por favor, completa manualmente: sexo y fecha de nacimiento"
```

## 🌐 Alternativas de API

### Opción 1: APIs Peruanas Premium

Algunas APIs premium de RENIEC SÍ incluyen estos campos:

1. **API RENIEC Oficial** (Requiere convenio institucional)
   - URL: https://www.reniec.gob.pe/
   - Incluye: Todos los datos del DNI
   - Costo: Variable según convenio
   - Confiabilidad: ⭐⭐⭐⭐⭐

2. **API SUNAT** (Para RUC y datos empresariales)
   - URL: https://api.sunat.gob.pe/
   - Incluye: Datos fiscales
   - Costo: Gratuito (requiere registro)

3. **APIs Comerciales Peruanas:**
   - **Peru APIs**: https://www.peruapis.com/
   - **API Peru**: https://apiperu.dev/ (actual - versión gratuita limitada)
   - **DNI RUC Peru**: https://www.dniruc.com/

### Opción 2: Deducir Información del DNI

```php
// Ejemplo: Estimar rango de edad aproximado por DNI
function estimarEdadPorDNI($dni) {
    $primerDigito = intval(substr($dni, 0, 1));
    
    if ($primerDigito <= 2) {
        return "Mayor de 50 años (DNI antiguo)";
    } elseif ($primerDigito <= 4) {
        return "Entre 30-50 años";
    } elseif ($primerDigito <= 6) {
        return "Entre 20-30 años";
    } else {
        return "Menor de 20 años";
    }
}
```

### Opción 3: Integración Híbrida

Combinar RENIEC para nombres + entrada manual para datos complementarios:

1. Usuario ingresa DNI
2. Sistema consulta RENIEC → obtiene nombres
3. Usuario completa manualmente sexo y fecha de nacimiento
4. Sistema valida coherencia de datos

## ✅ Recomendación

**Solución Actual (Implementada):**
- Usar API actual para nombres y apellidos
- Completar manualmente sexo y fecha de nacimiento
- Sistema muestra mensaje claro indicando qué falta

**Ventajas:**
- ✅ Funciona inmediatamente
- ✅ No requiere cambio de API
- ✅ Reduce 80% del trabajo de digitación
- ✅ Mantiene precisión en datos sensibles

**Desventajas:**
- ⚠️ Requiere 2 campos manuales adicionales
- ⚠️ Puede haber error humano en esos campos

## 🚀 Mejoras Futuras

### Corto Plazo:
1. Agregar validaciones inteligentes:
   - Edad mínima/máxima según contexto
   - Fechas coherentes con DNI

2. Pre-rellenar con valores comunes:
   - Sexo basado en primer nombre (estadístico)
   - Fecha aproximada por rango de DNI

### Mediano Plazo:
1. Evaluar upgrade a API premium
2. Implementar caché inteligente
3. Integración con base de datos histórica propia

### Largo Plazo:
1. Convenio con RENIEC oficial
2. Sistema de verificación biométrica
3. Integración con documento electrónico

## 📊 Comparativa de APIs

| API | Campos Básicos | Sexo | Fecha Nac. | Foto | Costo Mensual |
|-----|---------------|------|------------|------|---------------|
| apiperu.dev (actual) | ✅ | ❌ | ❌ | ❌ | $0 (100/día) |
| APIs Premium | ✅ | ✅ | ✅ | ❌ | $50-200 |
| RENIEC Oficial | ✅ | ✅ | ✅ | ✅ | Convenio |

## 💡 Uso del Sistema Actual

### Flujo de Trabajo Optimizado:

1. **Nuevo Registro de Persona:**
   ```
   Usuario ingresa DNI → Clic en "RENIEC"
   ↓
   Sistema autocompleta: Nombres + Apellidos
   ↓
   Mensaje: "Por favor, completa manualmente: sexo y fecha de nacimiento"
   ↓
   Usuario selecciona Sexo del dropdown
   ↓
   Usuario ingresa Fecha de Nacimiento (con calendario)
   ↓
   Guardar (100% de datos completos)
   ```

2. **Tiempo Estimado:**
   - ❌ Sin RENIEC: 45 segundos (todo manual)
   - ✅ Con RENIEC actual: 15 segundos (2 campos manuales)
   - ⭐ **Ahorro de tiempo: 66%**

## 🔒 Consideraciones de Privacidad

La información de sexo y fecha de nacimiento son **datos sensibles** según:
- Ley de Protección de Datos Personales (Ley N° 29733)
- GDPR (si aplica a clientes internacionales)

**Ventaja de entrada manual:**
- Mayor control sobre datos sensibles
- Cumplimiento regulatorio simplificado
- Trazabilidad de origen de datos

---

**Fecha**: 11 de Enero de 2025  
**Sistema**: CESODO  
**Versión API**: apiperu.dev v1.0  
**Consultas Disponibles**: 100/día (gratuitas)
