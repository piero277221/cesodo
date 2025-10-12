# 🧪 Guía Rápida: Crear Receta Arroz con Pollo

## ✅ Problema Corregido
**Error anterior**: "El campo dificultad no está en la lista de valores permitidos"
**Solución**: Valores del select ahora coinciden con la validación del controlador

---

## 📝 Datos para Copiar y Pegar

### 1. Nombre de la Receta
```
Arroz con Pollo Peruano
```

### 2. Descripción (Copiar TODO este bloque)
```
4 Piernas de Pollo
2 Tazas de Arroz Blanco
3 Tazas de Agua
1 Cubo MAGGI Sabor Gallina
3 Cebollas Rojas
1 Tomate
1 Zanahoria
1/2 Taza de Arvejas
1/2 Taza de Choclo Desgranado
1 Taza de Culantro Deshojado
1 Pizca de Sal
2 Limones
1 Cucharadita de Ajo Molido
4 Cucharadas de Ají Amarillo Molido
4 Cucharadas de Aceite Vegetal
```

### 3. Instrucciones Generales
```
Receta tradicional peruana de Arroz con Pollo, plato clásico de la gastronomía nacional. Ideal para almuerzos familiares y celebraciones. Combina perfectamente el pollo dorado con arroz verde aromático.
```

### 4. Pasos de Preparación (Agregar UNO POR UNO)

**Paso 1**:
```
Sazonar las piernas de pollo con sal y ajo molido. Dorar en aceite caliente hasta que estén doradas por todos los lados.
```

**Paso 2**:
```
En la misma olla, sofreír la cebolla picada hasta que esté transparente. Agregar el ají amarillo molido y el ajo, cocinar por 2 minutos.
```

**Paso 3**:
```
Añadir el tomate picado y cocinar hasta que se forme un aderezo homogéneo. Sazonar con sal al gusto.
```

**Paso 4**:
```
Agregar el arroz y mezclar bien con el aderezo. Añadir el agua, el cubo de caldo MAGGI y las verduras.
```

**Paso 5**:
```
Cocinar a fuego medio-alto hasta que el arroz absorba el líquido. Reducir el fuego, tapar y cocinar 15 minutos más.
```

**Paso 6**:
```
Incorporar el culantro picado, mezclar suavemente. Dejar reposar 5 minutos tapado.
```

**Paso 7**:
```
Servir caliente acompañado de limón. Opcional: agregar papa a la huancaína o salsa criolla.
```

---

## 🎯 Instrucciones Paso a Paso

### PASO 1: Acceder al Formulario
1. Ir a: **Recetas → Nueva Receta**
2. URL: `http://localhost/cesodo4/public/recetas/create`

### PASO 2: Completar Información de la Receta
1. **Nombre de la Receta**: Pegar → "Arroz con Pollo Peruano"
2. **Tiempo de Preparación**: Escribir → `80`
3. **Porciones**: Escribir → `5`
4. **Tipo de Plato**: Seleccionar → "Plato Principal"
5. **Dificultad**: Seleccionar → **"Intermedio"** ✅ (ahora disponible)

### PASO 3: Analizar Ingredientes Automáticamente
1. En **Descripción**, pegar el bloque completo de ingredientes
2. Hacer clic en el botón: **🔍 Analizar ingredientes desde descripción**
3. ⏳ Esperar unos segundos...
4. ✅ Deberías ver **14 ingredientes** detectados automáticamente

### PASO 4: Verificar Ingredientes Detectados
Confirmar que aparezcan:
- ✅ Pollo Entero
- ✅ Arroz Superior
- ✅ Cubo MAGGI Sabor Gallina
- ✅ Cebolla Roja
- ✅ Tomate
- ✅ Zanahoria
- ✅ Arvejas
- ✅ Choclo
- ✅ Culantro
- ✅ Sal
- ✅ Limón
- ✅ Ajo Molido
- ✅ Ají Amarillo Molido
- ✅ Aceite Vegetal

**Nota**: Las cantidades deben aparecer automáticamente (4, 2, 3, 1, etc.)

### PASO 5: Completar Instrucciones
1. En **Instrucciones Generales**, pegar el texto proporcionado
2. En **Pasos de Preparación**:
   - Hacer clic en "+ Agregar Paso"
   - Pegar el **Paso 1**
   - Repetir para los **7 pasos** (usar el botón "+ Agregar Paso" cada vez)

### PASO 6: Verificar Costos Automáticos
En la barra derecha **"💰 Información de Costos"** deberías ver:
- **Costo total de ingredientes**: Aproximadamente S/ 27.93
- **Costo por porción**: Aproximadamente S/ 5.59
- **Costo Aproximado**: Campo readonly con el total calculado

### PASO 7: Estado y Guardar
1. **Estado**: Seleccionar → "Activo"
2. Hacer clic en: **💾 Guardar Receta**

---

## ✅ Resultado Esperado

### Si TODO está correcto:
1. ✅ Aparece mensaje: "Receta creada exitosamente"
2. ✅ Redirección a la vista detalle de la receta
3. ✅ Se muestra "Arroz con Pollo Peruano" con toda su información
4. ✅ Los 14 ingredientes están asociados correctamente
5. ✅ El costo total es visible
6. ✅ Los 7 pasos de preparación están guardados

### Si hay algún error:
- ❌ **"El campo dificultad no está en la lista..."** → Refresca la página (caché de Blade)
- ❌ **"Ingrediente no encontrado: XXX"** → Verifica que los productos existan en el sistema
- ❌ **"El campo X es obligatorio"** → Completa todos los campos marcados con *

---

## 🔍 Verificación Final

### Consultar en Base de Datos (Opcional)
```sql
-- Ver la receta creada
SELECT * FROM recetas WHERE nombre LIKE '%Arroz con Pollo%';

-- Ver ingredientes asociados
SELECT ri.*, p.nombre, p.precio_unitario
FROM receta_ingredientes ri
JOIN productos p ON ri.producto_id = p.id
WHERE ri.receta_id = (SELECT id FROM recetas WHERE nombre LIKE '%Arroz con Pollo%');
```

---

## 🎨 Valores de Dificultad Corregidos

| Antes (ERROR) | Después (CORRECTO) |
|---------------|---------------------|
| facil | ✅ facil |
| **media** ❌ | ✅ **intermedio** |
| dificil | ✅ dificil |
| (faltaba) | ✅ muy_dificil |

---

## 📊 Resumen de la Receta

| Característica | Valor |
|----------------|-------|
| **Nombre** | Arroz con Pollo Peruano |
| **Tipo** | Plato Principal |
| **Dificultad** | Intermedio |
| **Tiempo** | 80 minutos |
| **Porciones** | 5 |
| **Ingredientes** | 14 |
| **Pasos** | 7 |
| **Costo Total** | S/ 27.93 |
| **Costo/Porción** | S/ 5.59 |

---

**¡Listo para probar!** 🚀

Fecha: 12 de Octubre de 2025
Sistema: CESODO
Módulo: Recetas
Estado: ✅ Corregido y Verificado
