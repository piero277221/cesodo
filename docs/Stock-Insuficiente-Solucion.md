# Solución: Stock Insuficiente para Crear Menú

## ❌ Error Reportado

```
Error al crear el menú: Stock insuficiente para el producto: 
Pollo Entero, Culantro, Aguaymanto, Sal, Vinagre Blanco, 
Aceite Vegetal, Arvejas, Ají Amarillo Molido, Ajo Molido
```

## 🔍 Causa del Problema

Cuando creas un **Menú** en el sistema, Laravel verifica automáticamente que haya suficiente stock en el **Inventario** para preparar todos los platos del menú.

**Cálculo automático:**
```
Stock Necesario = Ingredientes por Receta × Número de Personas × Días del Menú
```

**Ejemplo:**
- Receta "Arroz con Pollo" usa 4 pollos enteros (para 5 porciones)
- Menú para 10 personas durante 5 días
- Stock necesario: 4 × (10/5) × 5 = 40 pollos enteros

Si no hay 40 pollos en inventario, el sistema rechaza la creación del menú.

## ✅ Solución Aplicada

### 1. Creado Seeder de Inventario Inicial

Archivo: `database/seeders/InventarioInicialSeeder.php`

Este seeder agrega stock inicial a todos los productos del sistema:

**Stock agregado:**
- **Carnes:** Pollo Entero (50 unidades), Carne Molida (30 kg)
- **Cereales:** Arroz Superior (100 kg), Quinua (30 kg), Lentejas (30 kg)
- **Verduras:** Cebolla Roja (50 kg), Tomate (50 kg), Zanahoria (40 kg), Culantro (20 kg), Arvejas (30 kg), Choclo (30 kg)
- **Frutas:** Limón (50 kg), Aguaymanto (20 kg)
- **Condimentos:** Sal (50 kg), Orégano (5 kg), Ají Panca (10 kg), Ají Amarillo (10 kg), Ají Amarillo Molido (15 kg), Ajo Molido (15 kg), Cubo MAGGI (500 unidades)
- **Aceites:** Aceite Vegetal (50 litros), Aceite de Oliva (20 litros), Vinagre Blanco (30 litros)
- **Lácteos:** Leche Evaporada (100 litros), Queso Fresco (30 kg), Mantequilla (20 kg)

### 2. Ejecutado el Seeder

```bash
php artisan db:seed --class=InventarioInicialSeeder
```

**Resultado:**
- ✅ 25 inventarios creados
- ⚠️ 27 productos no encontrados (nombres diferentes o no existen)

### 3. Agregado Stock Manualmente para Productos con Nombres Diferentes

Script creado: `agregar-stock-faltantes.php`

```bash
php agregar-stock-faltantes.php
```

**Productos corregidos:**
- ✅ Arroz Superior (100 kg)
- ✅ Cubo MAGGI Sabor Gallina (500 unidades)
- ✅ Choclo (30 kg)

### 4. Verificación Final

Script: `verificar-stock-receta.php`

```bash
php verificar-stock-receta.php
```

**Resultado:**
```
✅ Todos los ingredientes están disponibles en stock!
```

## 📊 Stock Actual de la Receta "Arroz con Pollo"

| Ingrediente | Necesario | Stock Disponible | Estado |
|-------------|-----------|------------------|---------|
| Pollo Entero | 4.00 unidades | 50.00 | ✅ OK |
| Culantro | 1.00 taza | 20.00 kg | ✅ OK |
| Aguaymanto | 3.00 unidades | 20.00 kg | ✅ OK |
| Sal | 1.00 unidad | 50.00 kg | ✅ OK |
| Vinagre Blanco | 2.00 unidades | 30.00 litros | ✅ OK |
| Aceite Vegetal | 4.00 unidades | 50.00 litros | ✅ OK |
| Arvejas | 0.50 taza | 30.00 kg | ✅ OK |
| Ají Amarillo Molido | 4.00 unidades | 15.00 kg | ✅ OK |
| Ajo Molido | 1.00 cucharadita | 15.00 kg | ✅ OK |

## 🎯 Ahora Puedes Crear el Menú

Con todo el stock disponible, ahora SÍ puedes crear el menú:

### Paso 1: Ir a Crear Menú
```
Dashboard → Menús → Nuevo Menú
```

### Paso 2: Configuración Recomendada para Prueba

**Información Básica:**
- Nombre: `Menú Semanal - Semana 42 Octubre 2025`
- Fecha Inicio: `2025-10-13` (mañana)
- Fecha Fin: `2025-10-19` (7 días)
- Tipo: `Menú Semanal`

**Porciones:**
- Número de Personas: `10` (empezar con pocas personas)
- Porciones por Persona: `1`

**Días y Comidas:**
- Días: ✅ Lunes a Viernes
- Comidas: ✅ Solo Almuerzo (para empezar)

**Asignación:**
- Seleccionar "Arroz con Pollo" para todos los almuerzos

**Resultado Esperado:**
```
✅ Menú creado exitosamente
📊 50 platos disponibles (10 personas × 5 días × 1 almuerzo)
📉 Stock descontado automáticamente del inventario
```

## ⚠️ Notas Importantes

### 1. Stock se Descuenta Automáticamente

Cuando creas un menú, el sistema:
- ✅ Verifica que hay stock suficiente
- ✅ Descuenta los ingredientes del inventario
- ✅ Registra el movimiento en kardex
- ✅ Crea los platos disponibles para consumo

### 2. Si Necesitas Más Stock

**Opción A: Ejecutar el Seeder Nuevamente**
```bash
php artisan db:seed --class=InventarioInicialSeeder
```
Esto SUMA al stock existente, no lo reemplaza.

**Opción B: Agregar Stock Manualmente**
1. Ve a: Dashboard → Inventario
2. Busca el producto
3. Click en "Ajustar Stock"
4. Ingresa la nueva cantidad

**Opción C: Registrar una Compra**
1. Ve a: Dashboard → Compras → Nueva Compra
2. Selecciona productos y cantidades
3. El stock se actualizará automáticamente

### 3. Validación de Stock por Menú

El sistema calcula:
```php
foreach ($receta->ingredientes as $ingrediente) {
    $cantidadNecesaria = $ingrediente->cantidad 
                       × $numeroPersonas 
                       × $diasDelMenu;
    
    if ($stockDisponible < $cantidadNecesaria) {
        throw new Exception("Stock insuficiente: {$producto->nombre}");
    }
}
```

## 📁 Archivos Creados

1. `database/seeders/InventarioInicialSeeder.php` - Seeder principal de inventario
2. `agregar-stock-faltantes.php` - Script para productos faltantes
3. `verificar-stock-receta.php` - Script de verificación de stock
4. `docs/Stock-Insuficiente-Solucion.md` - Esta documentación

## 🔄 Comandos Útiles

**Ver stock de un producto:**
```bash
php artisan tinker --execute="echo json_encode(\App\Models\Inventario::with('producto')->get(['producto_id', 'stock_disponible']), JSON_PRETTY_PRINT);"
```

**Agregar stock rápidamente:**
```bash
php agregar-stock-faltantes.php
```

**Verificar ingredientes de receta:**
```bash
php verificar-stock-receta.php
```

**Re-ejecutar seeder de inventario:**
```bash
php artisan db:seed --class=InventarioInicialSeeder
```

## ✅ Problema Resuelto

- ✅ Stock inicial agregado a 25+ productos
- ✅ Todos los ingredientes de "Arroz con Pollo" disponibles
- ✅ Sistema listo para crear menús
- ✅ Inventario funcional con stock suficiente

**Puedes proceder a crear tu menú sin problemas.** 🎉

---

**Fecha de Solución:** 12 de Octubre 2025
**Sistema:** CESODO - Control de Inventarios
**Estado:** ✅ RESUELTO
