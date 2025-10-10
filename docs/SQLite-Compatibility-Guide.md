# Guía de Compatibilidad SQLite - Laravel

## Problema Original
El sistema utilizaba funciones específicas de MySQL (`YEAR()`, `MONTH()`) que no están disponibles en SQLite, causando errores como:
```
SQLSTATE[HY000]: General error: 1 no such function: YEAR
```

## Solución Implementada

### 1. Helper DatabaseHelper
Se creó `app/Helpers/DatabaseHelper.php` que proporciona métodos compatibles con ambas bases de datos:

```php
// Uso:
DatabaseHelper::yearExpression('fecha_consumo')  // Retorna la expresión SQL correcta
DatabaseHelper::whereYear($query, 'created_at', 2024)  // Filtro compatible
```

### 2. Correspondencia de Funciones

| MySQL | SQLite | Método Helper |
|-------|--------|---------------|
| `YEAR(column)` | `strftime('%Y', column)` | `yearExpression()` |
| `MONTH(column)` | `strftime('%m', column)` | `monthExpression()` |
| `DAY(column)` | `strftime('%d', column)` | `dayExpression()` |
| `DATE(column)` | `date(column)` | `dateExpression()` |

### 3. Archivos Modificados

#### Controladores:
- `ReporteController.php` - Consulta principal de reportes
- `MenuController.php` - Estadísticas de menús
- `PedidoController.php` - Estadísticas de pedidos  
- `CompraController.php` - Estadísticas de compras

#### Modelos:
- `Pedido.php` - Generación de números de pedido
- `Compra.php` - Generación de números de compra
- `Cliente.php` - Cálculo de ventas por mes

### 4. Patrón de Migración

**Antes:**
```php
$query->whereYear('created_at', 2024);
```

**Después:**
```php
DatabaseHelper::whereYear($query, 'created_at', 2024);
```

**Antes:**
```php
DB::raw('YEAR(fecha) as año')
```

**Después:**  
```php
DB::raw(DatabaseHelper::yearExpression('fecha') . ' as año')
```

## Uso Recomendado

### Para Consultas SELECT con Funciones de Fecha:
```php
use App\Helpers\DatabaseHelper;

$result = Model::select(
    DB::raw(DatabaseHelper::yearExpression('created_at') . ' as year'),
    DB::raw(DatabaseHelper::monthExpression('created_at') . ' as month'),
    DB::raw('COUNT(*) as total')
)
->groupBy('year', 'month')
->get();
```

### Para Filtros WHERE:
```php
use App\Helpers\DatabaseHelper;

$query = Model::query();
DatabaseHelper::whereYear($query, 'created_at', 2024);
DatabaseHelper::whereMonth($query, 'created_at', 10);
$results = $query->get();
```

## Comando de Prueba
Se creó el comando `test:sqlite-compatibility` para verificar que las funciones trabajen correctamente:

```bash
php artisan test:sqlite-compatibility
```

## Beneficios
- ✅ Compatibilidad completa con SQLite y MySQL
- ✅ Código limpio y mantenible
- ✅ Detección automática del driver de base de datos
- ✅ Sin cambios en la lógica de negocio
- ✅ Fácil migración de código existente

## Notas Importantes
- SQLite usa `strftime()` para extraer partes de fechas
- Los meses en SQLite se retornan con ceros a la izquierda ('01', '02', etc.)
- El helper detecta automáticamente el driver y usa la sintaxis apropiada
- Compatible con Laravel 11 y versiones anteriores
