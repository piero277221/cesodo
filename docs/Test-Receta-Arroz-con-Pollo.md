# Test de Creación de Receta: Arroz con Pollo

## Datos de la Receta

### Información Básica
- **Nombre**: Arroz con Pollo Peruano
- **Tipo de Plato**: Plato Principal
- **Dificultad**: Intermedio
- **Tiempo de Preparación**: 80 minutos
- **Porciones**: 5

### Descripción
```
4 Piernas de Pollo
2 Tazas de Arroz Blanco
3 Tazas de Agua
1 Cubo MAGGI® Sabor Gallina
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

### Instrucciones Generales
```
Receta tradicional peruana de Arroz con Pollo, plato clásico de la gastronomía nacional.
Ideal para almuerzos familiares y celebraciones.
```

### Pasos de Preparación

**Paso 1**: Sazonar las piernas de pollo con sal y ajo molido. Dorar en aceite caliente hasta que estén doradas por todos los lados.

**Paso 2**: En la misma olla, sofreír la cebolla picada hasta que esté transparente. Agregar el ají amarillo molido y el ajo, cocinar por 2 minutos.

**Paso 3**: Añadir el tomate picado y cocinar hasta que se forme un aderezo homogéneo. Sazonar con sal al gusto.

**Paso 4**: Agregar el arroz y mezclar bien con el aderezo. Añadir el agua, el cubo de caldo MAGGI y las verduras (arvejas, choclo, zanahoria en cubos).

**Paso 5**: Cocinar a fuego medio-alto hasta que el arroz absorba el líquido. Reducir el fuego, tapar y cocinar por 15 minutos más.

**Paso 6**: Incorporar el culantro picado, mezclar suavemente. Dejar reposar 5 minutos tapado.

**Paso 7**: Servir caliente acompañado de limón al lado. Opcional: agregar papa a la huancaína o salsa criolla.

### Ingredientes del Sistema

Los ingredientes se detectarán automáticamente desde la descripción usando el botón "Analizar ingredientes desde descripción".

#### Ingredientes Esperados:
1. Pollo Entero (CARN-002) - 1.5 kg
2. Arroz Superior (CER-001) - 400g
3. Cubo MAGGI Sabor Gallina (COND-007) - 1 unidad
4. Cebolla Roja (VERD-001) - 3 unidades
5. Tomate (VERD-002) - 1 unidad
6. Zanahoria (VERD-010) - 1 unidad
7. Arvejas (VERD-011) - 100g
8. Choclo (VERD-009) - 100g
9. Culantro (VERD-007) - 1 taza
10. Sal (ABAR-003) - al gusto
11. Limón (FRUT-001) - 2 unidades
12. Ajo Molido (COND-006) - 1 cucharadita
13. Ají Amarillo Molido (COND-008) - 4 cucharadas
14. Aceite Vegetal (ACEI-001) - 4 cucharadas

### Costo Estimado
**Costo Total**: S/ 27.93 (para 5 porciones)
**Costo por Porción**: S/ 5.59

### Estado
Activo

---

## Instrucciones de Prueba

### 1. Acceder al Módulo de Recetas
```
URL: http://localhost/cesodo4/public/recetas/create
```

### 2. Completar el Formulario
1. ✅ Copiar el nombre: "Arroz con Pollo Peruano"
2. ✅ Seleccionar "Plato Principal"
3. ✅ Seleccionar "Intermedio" (valor corregido)
4. ✅ Tiempo: 80 minutos
5. ✅ Porciones: 5
6. ✅ Copiar la descripción con los ingredientes
7. ✅ Hacer clic en "Analizar ingredientes desde descripción"
8. ✅ Verificar que se detecten los 14 ingredientes
9. ✅ Copiar las instrucciones generales
10. ✅ Agregar los 7 pasos de preparación
11. ✅ Verificar que el costo se calcule automáticamente
12. ✅ Seleccionar estado "Activo"
13. ✅ Hacer clic en "Guardar Receta"

### 3. Verificación Exitosa
✅ La receta se debe guardar sin errores
✅ Debe aparecer en el listado de recetas
✅ Debe mostrar el costo calculado
✅ Todos los ingredientes deben estar asociados

---

## Valores de Dificultad Corregidos

### Antes (INCORRECTO)
- facil
- media ❌
- dificil

### Después (CORRECTO)
- facil ✅
- intermedio ✅
- dificil ✅
- muy_dificil ✅

---

**Fecha**: 12 de Octubre de 2025
**Sistema**: CESODO
**Módulo**: Recetas
**Tipo**: Bug Fix + Test Case
**Estado**: ✅ Corregido y Listo para Prueba
