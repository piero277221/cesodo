# Datos de Prueba - Base de Datos CESODO

## Resumen de Datos Agregados

Se han poblado las tablas principales del sistema con datos de prueba realistas para simular un entorno de cocina peruana profesional.

### 📦 Categorías de Productos (12 categorías)
1. Carnes
2. Pescados y Mariscos
3. Verduras
4. Frutas
5. Lácteos
6. Abarrotes
7. Condimentos
8. Bebidas
9. Cereales y Granos
10. Aceites y Grasas
11. Tubérculos
12. Harinas

### 🥘 Productos e Ingredientes (53 productos)

#### Carnes (5 productos)
- Lomo de Res - S/ 32.00/kg
- Pollo Entero - S/ 12.50/kg
- Carne Molida - S/ 18.00/kg
- Chancho (Cerdo) - S/ 22.00/kg
- Pato - S/ 28.00/kg

#### Pescados y Mariscos (6 productos)
- Corvina - S/ 35.00/kg
- Lenguado - S/ 45.00/kg
- Conchas Negras - S/ 120.00/kg
- Langostinos - S/ 85.00/kg
- Pulpo - S/ 65.00/kg
- Calamar - S/ 28.00/kg

#### Verduras (10 productos)
- Cebolla Roja - S/ 3.50/kg
- Tomate - S/ 4.00/kg
- Ají Amarillo - S/ 12.00/kg
- Ají Limo - S/ 15.00/kg
- Ají Panca - S/ 18.00/kg
- Pimiento - S/ 5.50/kg
- Culantro - S/ 1.50/atado
- Huacatay - S/ 2.00/atado
- Choclo - S/ 6.00/kg
- Zanahoria - S/ 2.80/kg

#### Frutas (3 productos)
- Limón - S/ 4.50/kg
- Rocoto - S/ 8.00/kg
- Aguaymanto - S/ 12.00/kg

#### Lácteos (4 productos)
- Leche Evaporada Gloria - S/ 4.20/lata
- Queso Fresco - S/ 18.00/kg
- Mantequilla - S/ 22.00/kg
- Crema de Leche - S/ 15.00/lt

#### Abarrotes (5 productos)
- Fideos Spaghetti - S/ 6.50/kg
- Azúcar Blanca - S/ 3.80/kg
- Sal - S/ 1.50/kg
- Vinagre Blanco - S/ 3.20/lt
- Salsa de Soya (Sillao) - S/ 8.50/lt

#### Condimentos (6 productos)
- Comino Molido - S/ 25.00/kg
- Pimienta Negra - S/ 35.00/kg
- Orégano - S/ 18.00/kg
- Palillo (Cúrcuma) - S/ 22.00/kg
- Laurel - S/ 20.00/kg
- Ajo Molido - S/ 12.00/kg

#### Bebidas (4 productos)
- Chicha Morada - S/ 3.50/lt
- Inca Kola - S/ 4.50/botella
- Pisco Quebranta - S/ 45.00/botella
- Cerveza Cusqueña - S/ 6.50/botella

#### Cereales y Granos (4 productos)
- Arroz Superior Costeño - S/ 4.20/kg
- Quinua - S/ 15.00/kg
- Lentejas - S/ 8.50/kg
- Frijol Canario - S/ 9.00/kg

#### Aceites y Grasas (3 productos)
- Aceite Vegetal Primor - S/ 8.50/lt
- Aceite de Oliva - S/ 35.00/lt
- Manteca Vegetal - S/ 12.00/kg

#### Tubérculos (4 productos)
- Papa Blanca (Huayro) - S/ 2.50/kg
- Papa Amarilla (Tumbay) - S/ 4.00/kg
- Camote - S/ 3.20/kg
- Yuca - S/ 2.80/kg

#### Harinas (3 productos)
- Harina de Trigo Nicolini - S/ 3.50/kg
- Harina de Maíz - S/ 5.00/kg
- Harina de Quinua - S/ 18.00/kg

### 🏢 Proveedores (10 empresas)
1. **Distribuidora de Carnes La Granja SAC** - RUC: 20512345671
2. **Pescados y Mariscos del Pacífico EIRL** - RUC: 20512345672
3. **Mercado Central de Verduras SAC (Verde Perú)** - RUC: 20512345673
4. **Abarrotes Mayoristas Unidos SA (AMU)** - RUC: 20512345674
5. **Gloria SA** - RUC: 20512345675
6. **Condimentos del Perú SAC** - RUC: 20512345676
7. **Alicorp SAA** - RUC: 20512345677
8. **Bebidas del Perú SA (Arca Continental)** - RUC: 20512345678
9. **Cereales y Granos Andinos EIRL** - RUC: 20512345679
10. **Distribuidora de Licores Premium SAC** - RUC: 20512345680

### 👥 Clientes (8 registros)
- **Empresas (5):**
  - Restaurante El Señorío SAC
  - Comedor Popular San Juan EIRL
  - Hotel Costa del Sol SAC
  - Cevichería La Mar SAC
  - Municipalidad Distrital de Ate
  
- **Personas Naturales (3):**
  - García Pérez, Ana - DNI: 72345678
  - Rodríguez Sánchez, Carlos - DNI: 72345679
  - Torres López, María - DNI: 72345680

### 👤 Personas (15 registros)
Personas registradas con datos completos:
- Juan Carlos Rodríguez García - DNI: 45678901
- María Elena Torres Vega - DNI: 45678902
- Carlos Alberto Mendoza Silva - DNI: 45678903
- Ana Patricia Gutiérrez López - DNI: 45678904
- Luis Fernando Castro Pérez - DNI: 45678905
- Rosa María Flores Quispe - DNI: 45678906
- Pedro José Vargas Huamán - DNI: 45678907
- Carmen Rosa Sánchez García - DNI: 45678908
- José Luis Ramírez Torres - DNI: 45678909
- Lucía Isabel Martínez Díaz - DNI: 45678910
- Roberto Carlos Chávez Rojas - DNI: 45678911
- Diana Carolina Reyes Paredes - DNI: 45678912
- Miguel Ángel Fernández Cruz - DNI: 45678913
- Patricia Sofía Herrera Morales - DNI: 45678914
- Jorge Luis Palacios Ríos - DNI: 45678915

## Comandos Ejecutados

```bash
# Ejecutar seeders individuales
php artisan db:seed --class=CategoriasSeeder
php artisan db:seed --class=ProductosPeruanosSeeder
php artisan db:seed --class=ProveedoresSeeder
php artisan db:seed --class=ClientesSeeder
php artisan db:seed --class=PersonasSeeder

# O ejecutar todos los seeders
php artisan db:seed
```

## Archivos Creados

1. `database/seeders/CategoriasSeeder.php` - Categorías de productos
2. `database/seeders/ProductosPeruanosSeeder.php` - 53 productos e ingredientes
3. `database/seeders/ProveedoresSeeder.php` - 10 proveedores
4. `database/seeders/ClientesSeeder.php` - 8 clientes
5. `database/seeders/PersonasSeeder.php` - 15 personas
6. `database/seeders/DatabaseSeeder.php` - Actualizado para ejecutar todos

## Características de los Datos

✅ **Realistas**: Productos típicos de la cocina peruana
✅ **Completos**: Todos los campos necesarios poblados
✅ **Precios reales**: Precios aproximados del mercado peruano 2025
✅ **RUCs válidos**: Formato correcto de 11 dígitos
✅ **DNIs únicos**: Documentos de identidad sin duplicados
✅ **Direcciones peruanas**: Direcciones reales de Lima y provincias

## Próximos Pasos

Con estos datos puedes:
1. ✅ Probar el módulo de inventario
2. ✅ Crear menús con productos reales
3. ✅ Registrar pedidos y consumos
4. ✅ Generar compras a proveedores
5. ✅ Emitir ventas a clientes
6. ✅ Gestionar contratos con personas
