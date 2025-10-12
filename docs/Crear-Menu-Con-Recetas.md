# Guía: Crear Menú con Recetas para Consumos

## 📋 Resumen del Sistema

El sistema funciona en 3 pasos:
1. **Recetas** → Plantillas de platos (✅ Ya creaste "Arroz con Pollo")
2. **Menús** → Programación semanal con recetas asignadas
3. **Consumos** → Registro de platos consumidos

## ⚠️ Problema Identificado

Si ves **"0 platos disponibles"** en Consumos, es porque:
- No has creado ningún **Menú** aún
- Las recetas solas NO crean platos disponibles
- Necesitas crear un Menú y asignarle recetas

## 📝 Paso a Paso: Crear tu Primer Menú

### 1. Ir al Módulo de Menús
```
Dashboard → Menús → Nuevo Menú
```

### 2. Completar Información Básica

**Nombre del Menú:**
```
Menú Semanal - Semana 42 Octubre 2025
```

**Fechas:**
- Fecha de Inicio: `2025-10-13` (mañana)
- Fecha de Fin: `2025-10-19` (7 días después)

**Tipo de Menú:**
- Selecciona: `Menú Semanal`

**Descripción:**
```
Menú de la semana con platos peruanos variados
```

### 3. Configurar Días y Comidas

**Días a Incluir:**
- ✅ Lunes
- ✅ Martes
- ✅ Miércoles
- ✅ Jueves
- ✅ Viernes
- ⬜ Sábado (opcional)
- ⬜ Domingo (opcional)

**Tipos de Comida:**
- ✅ Desayuno
- ✅ Almuerzo
- ✅ Cena

### 4. Configurar Porciones

**Número de Personas:** `10`
- Esto define cuántas personas comerán del menú

**Porciones por Persona:** `1`
- Cada persona consume 1 plato por comida

**Total de Platos Disponibles:**
```
10 personas × 5 días × 3 comidas = 150 platos disponibles
```

### 5. Asignar Recetas a los Días

En la tabla que aparece, para cada día y tipo de comida, selecciona una receta:

**Ejemplo:**

| Día | Desayuno | Almuerzo | Cena |
|-----|----------|----------|------|
| Lunes | (ninguno) | **Arroz con Pollo** | (ninguno) |
| Martes | (ninguno) | **Arroz con Pollo** | (ninguno) |
| Miércoles | (ninguno) | **Arroz con Pollo** | (ninguno) |
| Jueves | (ninguno) | **Arroz con Pollo** | (ninguno) |
| Viernes | (ninguno) | **Arroz con Pollo** | (ninguno) |

> **Nota:** Por ahora solo tienes "Arroz con Pollo", así que repítela. Luego puedes crear más recetas.

### 6. Guardar el Menú

Click en **"Crear Menú"**

El sistema:
- ✅ Verificará que hay stock de ingredientes
- ✅ Descontará los ingredientes del inventario
- ✅ Creará el menú con 50 platos disponibles (10 personas × 5 días × 1 almuerzo)
- ✅ Estado: `Activo`

## 🍽️ Registrar Consumos

Una vez creado el menú:

### Opción 1: Desde el Módulo de Consumos
```
Dashboard → Consumos → Nuevo Consumo
```

Ahora SÍ verás:
```
✅ Platos disponibles: 50
```

### Opción 2: Desde el Menú Directamente
```
Dashboard → Menús → Ver menú → Registrar Consumo
```

## 📊 Cálculo de Platos Disponibles

```
Platos Totales = Número de Personas × Días del Menú × Comidas por Día

Ejemplo con tu configuración:
- 10 personas
- 5 días (Lunes a Viernes)
- 1 comida asignada (Almuerzo)
= 10 × 5 × 1 = 50 platos disponibles
```

Si quisieras todas las comidas:
```
10 personas × 5 días × 3 comidas = 150 platos disponibles
```

## ❌ Errores Comunes

### Error: "No hay platos disponibles"
**Causa:** No has creado ningún menú activo
**Solución:** Crea un menú como se explicó arriba

### Error: "Stock insuficiente para el producto..."
**Causa:** No hay suficientes ingredientes en inventario
**Solución:** 
1. Ve a Inventario
2. Ajusta el stock de los productos faltantes
3. Intenta crear el menú nuevamente

### Error: "El menú debe tener al menos un plato"
**Causa:** No asignaste ninguna receta en la tabla
**Solución:** Selecciona al menos una receta para un día/comida

## 🔄 Flujo Completo del Sistema

```
1. PRODUCTOS (en Inventario)
   ↓
2. RECETAS (Arroz con Pollo) ← YA HICISTE ESTO ✅
   ↓
3. MENÚS (Asignar recetas a días) ← HACER AHORA 📍
   ↓
4. CONSUMOS (Registrar que se comieron platos) ← DESPUÉS DE 3
```

## 🎯 Siguiente Paso Inmediato

**Ve al módulo de Menús y crea tu primer menú siguiendo esta guía.**

Después podrás:
- Registrar consumos
- Ver platos disponibles
- Trackear quién comió qué
- Generar reportes

## 💡 Tips

1. **Empieza simple**: Crea un menú de 1 semana con solo almuerzos
2. **Pocas personas**: Usa 5-10 personas para probar
3. **Una receta**: Usa solo "Arroz con Pollo" para todas las comidas inicialmente
4. **Verifica stock**: Antes de crear el menú, confirma que tienes ingredientes

## ✅ Checklist Rápido

- [ ] Ir a Dashboard → Menús → Nuevo Menú
- [ ] Nombre: "Menú Prueba Semana 1"
- [ ] Fecha: 7 días desde mañana
- [ ] Días: Lunes a Viernes
- [ ] Comidas: Solo Almuerzo (para empezar)
- [ ] Personas: 10
- [ ] Porciones: 1
- [ ] Asignar "Arroz con Pollo" a todos los almuerzos
- [ ] Guardar
- [ ] Ir a Consumos y verificar que aparecen los platos disponibles

---

**Última actualización:** 12 de Octubre 2025
**Sistema:** CESODO - Control de Consumos
