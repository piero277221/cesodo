# 📋 CASOS DE USO - SISTEMA CESODO
## Sistema de Gestión para Comedores y Servicios de Alimentación

---

## 📊 DIAGRAMA DE ACTORES

### 👥 Actores del Sistema

1. **Administrador** (Actor Principal)
   - Control total del sistema
   - Gestión de usuarios y roles
   - Configuraciones del sistema
   - Acceso a todos los módulos

2. **Almacenero** (Actor Secundario)
   - Gestión de inventarios
   - Control de productos
   - Registro de compras
   - Gestión de proveedores

3. **Supervisor** (Actor Secundario)
   - Registro de consumos
   - Gestión de menús
   - Supervisión de personal
   - Visualización de reportes

4. **Personal de Atención** (Actor Terciario)
   - Registro de consumos diarios
   - Consulta de menús disponibles

5. **Personal de RR.HH.** (Actor Secundario)
   - Gestión de trabajadores
   - Gestión de contratos laborales
   - Control de certificados médicos

6. **Sistema** (Actor Técnico - SIEMPRE PRESENTE)
   - Procesa lógica de negocio
   - Valida datos
   - Ejecuta operaciones
   - Genera cálculos y reportes

7. **Base de Datos** (Actor Técnico - SIEMPRE PRESENTE)
   - Almacena información
   - Consulta datos
   - Actualiza registros
   - Mantiene integridad referencial

8. **Sistema RENIEC** (Actor Externo)
   - Validación de DNI
   - Consulta de datos personales

---

## 🎯 CASOS DE USO POR MÓDULO

---

## 1️⃣ MÓDULO: AUTENTICACIÓN Y SEGURIDAD

### CU-01: Iniciar Sesión
**Actores:** Usuario (cualquier rol), Sistema, Base de Datos  
**Precondición:** Usuario debe estar registrado en el sistema  
**Flujo Principal:**
1. Usuario accede a la página de login
2. Sistema muestra formulario de autenticación
3. Usuario ingresa email y contraseña
4. Sistema valida credenciales
5. Base de Datos consulta información del usuario
6. Sistema verifica estado del usuario (activo/inactivo)
7. Base de Datos registra fecha de último acceso
8. Sistema redirige al dashboard según rol

**Flujo Alternativo:**
- 4a. Credenciales incorrectas: Sistema muestra mensaje de error
- 6a. Usuario inactivo: Sistema deniega acceso
- 4b. Múltiples intentos fallidos: Sistema bloquea cuenta temporalmente

**Postcondición:** Usuario autenticado y sesión iniciada

---

### CU-02: Cerrar Sesión
**Actores:** Usuario (cualquier rol), Sistema, Base de Datos  
**Precondición:** Usuario debe estar autenticado  
**Flujo Principal:**
1. Usuario hace clic en "Cerrar Sesión"
2. Sistema invalida sesión
3. Base de Datos actualiza registro de sesión
4. Sistema limpia tokens de autenticación
5. Sistema redirige a página de login

**Postcondición:** Sesión cerrada correctamente

---

### CU-03: Recuperar Contraseña
**Actores:** Usuario (cualquier rol), Sistema, Base de Datos  
**Precondición:** Usuario registrado con email válido  
**Flujo Principal:**
1. Usuario hace clic en "¿Olvidaste tu contraseña?"
2. Sistema muestra formulario de recuperación
3. Usuario ingresa su email
4. Sistema valida existencia del email
5. Base de Datos consulta información del usuario
6. Sistema genera token de recuperación
7. Base de Datos almacena token temporal
8. Sistema envía email con enlace de recuperación
9. Usuario hace clic en enlace del email
10. Sistema valida token y expiración
11. Usuario ingresa nueva contraseña
12. Sistema actualiza contraseña
13. Base de Datos guarda nueva contraseña encriptada
14. Sistema envía confirmación por email

**Flujo Alternativo:**
- 4a. Email no existe: Sistema muestra mensaje genérico de seguridad
- 10a. Token expirado: Sistema solicita nueva recuperación

**Postcondición:** Contraseña actualizada correctamente

---

### CU-04: Cambiar Contraseña
**Actores:** Usuario (cualquier rol), Sistema, Base de Datos  
**Precondición:** Usuario autenticado  
**Flujo Principal:**
1. Usuario accede a su perfil
2. Usuario hace clic en "Cambiar Contraseña"
3. Sistema muestra formulario
4. Usuario ingresa contraseña actual
5. Usuario ingresa nueva contraseña (2 veces)
6. Sistema valida contraseña actual
7. Base de Datos consulta contraseña encriptada actual
8. Sistema valida formato de nueva contraseña
9. Sistema actualiza contraseña
10. Base de Datos guarda nueva contraseña encriptada
11. Sistema muestra mensaje de confirmación

**Flujo Alternativo:**
- 6a. Contraseña actual incorrecta: Sistema muestra error
- 8a. Nueva contraseña no cumple requisitos: Sistema muestra reglas

**Postcondición:** Contraseña actualizada

---

## 2️⃣ MÓDULO: GESTIÓN DE USUARIOS Y ROLES

### CU-05: Crear Usuario
**Actores:** Administrador, Sistema, Base de Datos  
**Precondición:** Administrador autenticado con permisos  
**Flujo Principal:**
1. Administrador accede a módulo de usuarios
2. Sistema muestra lista de usuarios
3. Base de Datos consulta usuarios existentes
4. Administrador hace clic en "Crear Usuario"
5. Sistema muestra formulario de registro
6. Administrador ingresa datos del usuario:
   - Nombre completo
   - Email (único)
   - DNI (opcional)
   - Teléfono
   - Persona asociada (opcional)
   - Trabajador asociado (opcional)
   - Roles a asignar
7. Sistema valida datos ingresados
8. Base de Datos verifica unicidad de email
9. Sistema genera contraseña temporal
10. Base de Datos crea usuario
11. Base de Datos asigna roles seleccionados
12. Sistema muestra contraseña generada
13. Sistema envía email de bienvenida (opcional)

**Flujo Alternativo:**
- 8a. Email ya existe: Sistema muestra error
- 8b. DNI ya registrado: Sistema muestra advertencia

**Postcondición:** Usuario creado y roles asignados

---

### CU-06: Editar Usuario
**Actores:** Administrador, Sistema, Base de Datos  
**Precondición:** Usuario a editar debe existir  
**Flujo Principal:**
1. Administrador accede a lista de usuarios
2. Sistema muestra lista de usuarios
3. Administrador busca/filtra usuario
4. Administrador hace clic en "Editar"
5. Sistema muestra formulario con datos actuales
6. Base de Datos consulta información del usuario
7. Administrador modifica datos:
   - Nombre
   - Email
   - Teléfono
   - Estado (activo/inactivo)
   - Roles
8. Sistema valida cambios
9. Base de Datos verifica email duplicado
10. Base de Datos actualiza información
11. Sistema sincroniza permisos según nuevos roles

**Flujo Alternativo:**
- 9a. Email duplicado: Sistema muestra error
- 7a. Cambio de estado a inactivo: Sistema cierra sesiones activas

**Postcondición:** Usuario actualizado

---

### CU-07: Eliminar Usuario
**Actores:** Administrador, Sistema, Base de Datos  
**Precondición:** Usuario no debe ser el mismo administrador  
**Flujo Principal:**
1. Administrador selecciona usuario a eliminar
2. Administrador hace clic en "Eliminar"
3. Sistema muestra confirmación
4. Administrador confirma eliminación
5. Sistema verifica que no sea auto-eliminación
6. Base de Datos realiza soft delete
7. Sistema invalida sesiones activas del usuario
8. Sistema muestra confirmación

**Flujo Alternativo:**
- 5a. Intento de auto-eliminación: Sistema deniega operación

**Postcondición:** Usuario desactivado

---

### CU-08: Gestionar Roles
**Actores:** Administrador, Sistema, Base de Datos  
**Precondición:** Administrador con permisos de configuración  
**Flujo Principal:**
1. Administrador accede a "Gestión de Roles"
2. Sistema muestra lista de roles existentes
3. Base de Datos consulta roles y permisos:
   - Administrador
   - Almacenero
   - Supervisor
   - Personal de Atención
4. Administrador selecciona rol a configurar
5. Sistema muestra matriz de permisos por módulo
6. Administrador activa/desactiva permisos
7. Sistema valida configuración
8. Base de Datos guarda configuración
9. Sistema aplica cambios a usuarios con ese rol

**Postcondición:** Permisos de rol actualizados

---

### CU-09: Crear Rol Personalizado
**Actores:** Administrador, Sistema, Base de Datos  
**Flujo Principal:**
1. Administrador hace clic en "Crear Rol"
2. Sistema muestra formulario
3. Administrador ingresa:
   - Nombre del rol
   - Descripción
   - Permisos por módulo
4. Sistema valida nombre único
5. Base de Datos verifica nombre único
6. Base de Datos crea rol
7. Base de Datos asocia permisos seleccionados

**Postcondición:** Nuevo rol disponible

---

### CU-10: Clonar Rol
**Actores:** Administrador, Sistema, Base de Datos  
**Flujo Principal:**
1. Administrador selecciona rol a clonar
2. Administrador hace clic en "Clonar"
3. Sistema solicita nuevo nombre
4. Base de Datos consulta permisos del rol original
5. Sistema duplica permisos del rol original
6. Base de Datos crea nuevo rol

**Postcondición:** Rol clonado creado

---

## 3️⃣ MÓDULO: GESTIÓN DE PRODUCTOS E INVENTARIO

### CU-11: Registrar Producto
**Actores:** Almacenero, Administrador, Sistema, Base de Datos  
**Precondición:** Usuario con permiso "crear-productos"  
**Flujo Principal:**
1. Usuario accede a módulo de productos
2. Sistema muestra lista de productos
3. Usuario hace clic en "Nuevo Producto"
4. Sistema muestra formulario
5. Usuario ingresa información:
   - Código (opcional, auto-generado)
   - Nombre del producto
   - Categoría
   - Unidad de medida
   - Precio unitario
   - Stock mínimo
   - Stock máximo
   - Fecha de vencimiento (opcional)
   - Proveedor preferido
   - Imagen (opcional)
6. Sistema valida datos
7. Base de Datos verifica unicidad de código
8. Base de Datos guarda producto
9. Base de Datos genera entrada en kardex

**Flujo Alternativo:**
- 7a. Código duplicado: Sistema genera nuevo código
- 7b. Nombre duplicado: Sistema solicita confirmación

**Postcondición:** Producto registrado en sistema

---

### CU-12: Editar Producto
**Actores:** Almacenero, Administrador, Sistema, Base de Datos  
**Precondición:** Producto debe existir  
**Flujo Principal:**
1. Usuario busca producto
2. Sistema muestra resultados
3. Usuario hace clic en "Editar"
4. Sistema muestra formulario con datos actuales
5. Base de Datos consulta información del producto
6. Usuario modifica información
7. Sistema valida cambios
8. Base de Datos actualiza producto
9. Base de Datos registra cambio en historial (si cambió precio)

**Postcondición:** Producto actualizado

---

### CU-13: Eliminar Producto
**Actores:** Administrador, Sistema, Base de Datos  
**Precondición:** Producto no debe tener movimientos recientes  
**Flujo Principal:**
1. Administrador selecciona producto
2. Administrador hace clic en "Eliminar"
3. Sistema verifica dependencias
4. Base de Datos consulta:
   - Movimientos de inventario
   - Recetas que lo incluyen
   - Órdenes de compra pendientes
5. Sistema muestra advertencia
6. Administrador confirma eliminación
7. Base de Datos realiza soft delete
8. Base de Datos registra en auditoría

**Flujo Alternativo:**
- 4a. Producto con dependencias activas: Sistema no permite eliminación

**Postcondición:** Producto eliminado/desactivado

---

### CU-14: Registrar Entrada de Inventario
**Actores:** Almacenero, Sistema, Base de Datos  
**Precondición:** Producto debe existir  
**Flujo Principal:**
1. Almacenero accede a "Movimientos de Inventario"
2. Almacenero selecciona "Entrada"
3. Sistema muestra formulario
4. Almacenero ingresa:
   - Producto
   - Cantidad
   - Tipo de movimiento (compra, devolución, ajuste)
   - Proveedor (si es compra)
   - Número de documento
   - Fecha de vencimiento (si aplica)
   - Observaciones
5. Sistema calcula nuevo stock
6. Sistema valida stock máximo (advertencia)
7. Base de Datos registra movimiento
8. Base de Datos actualiza inventario
9. Base de Datos genera entrada en kardex
10. Sistema verifica alertas de stock

**Flujo Alternativo:**
- 6a. Stock supera máximo: Sistema muestra advertencia pero permite continuar

**Postcondición:** Inventario actualizado, kardex registrado

---

### CU-15: Registrar Salida de Inventario
**Actores:** Almacenero, Sistema, Base de Datos  
**Precondición:** Producto debe tener stock disponible  
**Flujo Principal:**
1. Almacenero accede a "Movimientos de Inventario"
2. Almacenero selecciona "Salida"
3. Sistema muestra formulario
4. Almacenero ingresa:
   - Producto
   - Cantidad
   - Tipo de movimiento (consumo, merma, venta)
   - Destino/motivo
   - Trabajador solicitante (opcional)
   - Observaciones
5. Sistema valida stock disponible
6. Base de Datos consulta stock actual
7. Sistema calcula nuevo stock
8. Sistema verifica stock mínimo
9. Base de Datos registra salida
10. Base de Datos actualiza inventario
11. Base de Datos genera entrada en kardex
12. Sistema genera alerta si stock < mínimo

**Flujo Alternativo:**
- 5a. Stock insuficiente: Sistema muestra error y no permite continuar

**Postcondición:** Inventario actualizado, alerta generada si necesario

---

### CU-16: Consultar Kardex
**Actores:** Almacenero, Supervisor, Administrador, Sistema, Base de Datos  
**Precondición:** Debe existir movimientos registrados  
**Flujo Principal:**
1. Usuario accede a "Kardex"
2. Sistema muestra opciones de filtro:
   - Producto
   - Rango de fechas
   - Tipo de movimiento
   - Usuario que registró
3. Usuario aplica filtros
4. Base de Datos consulta movimientos según filtros
5. Sistema muestra tabla con:
   - Fecha y hora
   - Tipo de movimiento
   - Cantidad (entrada/salida)
   - Stock anterior
   - Stock nuevo
   - Usuario responsable
   - Documento relacionado
   - Observaciones
6. Usuario puede exportar a Excel/PDF
7. Sistema genera archivo de exportación

**Postcondición:** Información consultada

---

### CU-17: Ajustar Inventario
**Actores:** Administrador, Supervisor, Sistema, Base de Datos  
**Precondición:** Permiso "gestionar-inventario"  
**Flujo Principal:**
1. Usuario accede a producto
2. Usuario hace clic en "Ajustar Stock"
3. Sistema muestra:
   - Stock actual en sistema
   - Stock físico contado
4. Base de Datos consulta stock actual
5. Usuario ingresa stock físico real
6. Sistema calcula diferencia
7. Sistema solicita motivo del ajuste
8. Usuario ingresa justificación
9. Base de Datos registra ajuste
10. Base de Datos actualiza inventario
11. Sistema notifica a administrador (si diferencia > 10%)

**Flujo Alternativo:**
- 6a. Diferencia significativa: Sistema requiere aprobación de supervisor

**Postcondición:** Inventario ajustado y registrado

---

### CU-18: Generar Alerta de Stock Mínimo
**Actores:** Sistema, Base de Datos  
**Precondición:** Productos con stock mínimo configurado  
**Flujo Principal:**
1. Sistema ejecuta tarea programada (diaria a las 6:00 AM)
2. Base de Datos consulta todos los productos activos
3. Para cada producto:
   - Sistema compara stock actual con stock mínimo
   - Si stock actual ≤ stock mínimo:
     * Sistema crea notificación
     * Base de Datos guarda notificación
     * Sistema envía email a almacenero
     * Sistema marca producto en dashboard
4. Sistema genera reporte de productos críticos

**Postcondición:** Alertas generadas y enviadas

---

## 4️⃣ MÓDULO: GESTIÓN DE COMPRAS Y PROVEEDORES

### CU-19: Registrar Proveedor
**Actores:** Almacenero, Administrador, Sistema, Base de Datos  
**Precondición:** Permiso "crear-proveedores"  
**Flujo Principal:**
1. Usuario accede a módulo de proveedores
2. Sistema muestra lista de proveedores
3. Usuario hace clic en "Nuevo Proveedor"
4. Sistema muestra formulario
5. Usuario ingresa datos:
   - Razón social
   - RUC
   - Nombre comercial
   - Dirección
   - Teléfono
   - Email
   - Contacto principal
   - Tipo de productos que provee
   - Días de crédito (opcional)
   - Observaciones
6. Sistema valida RUC único
7. Base de Datos verifica unicidad de RUC
8. Sistema consulta SUNAT (opcional)
9. Base de Datos guarda proveedor

**Flujo Alternativo:**
- 7a. RUC duplicado: Sistema muestra error
- 8a. RUC no encontrado en SUNAT: Sistema permite continuar

**Postcondición:** Proveedor registrado

---

### CU-20: Crear Orden de Compra
**Actores:** Almacenero, Sistema, Base de Datos  
**Precondición:** Proveedor y productos deben existir  
**Flujo Principal:**
1. Almacenero accede a "Compras"
2. Sistema muestra lista de órdenes
3. Almacenero hace clic en "Nueva Compra"
4. Sistema muestra formulario
5. Base de Datos consulta proveedores y productos disponibles
6. Almacenero selecciona:
   - Tipo de compra (productos, insumos, equipos, servicios)
   - Proveedor
   - Fecha de compra
   - Fecha de entrega esperada
7. Almacenero agrega productos:
   - Selecciona producto
   - Ingresa cantidad
   - Ingresa precio unitario
   - Sistema calcula subtotal
8. Almacenero puede agregar múltiples productos
9. Sistema calcula:
   - Subtotal
   - IGV (18%)
   - Total
10. Almacenero ingresa descuento (opcional)
11. Sistema recalcula total
12. Almacenero guarda orden
13. Sistema genera número de orden
14. Base de Datos guarda orden con estado "Pendiente"

**Flujo Alternativo:**
- 7a. Producto no disponible: Sistema permite buscarlo o crearlo

**Postcondición:** Orden de compra creada con estado "Pendiente"

---

### CU-21: Recepcionar Orden de Compra
**Actores:** Almacenero, Sistema, Base de Datos  
**Precondición:** Orden debe estar en estado "Pendiente"  
**Flujo Principal:**
1. Almacenero accede a orden de compra
2. Base de Datos consulta detalles de la orden
3. Almacenero hace clic en "Recepcionar"
4. Sistema muestra productos ordenados
5. Para cada producto:
   - Almacenero verifica cantidad recibida
   - Almacenero verifica calidad
   - Almacenero puede ajustar cantidad si hay diferencia
   - Almacenero ingresa fecha de vencimiento (si aplica)
6. Sistema solicita confirmación
7. Almacenero confirma recepción
8. Base de Datos actualiza estado a "Recibida"
9. Base de Datos genera movimientos de inventario (entradas)
10. Base de Datos actualiza stock de productos
11. Base de Datos genera entradas en kardex

**Flujo Alternativo:**
- 5a. Cantidad recibida < cantidad ordenada: Sistema marca diferencia
- 5b. Producto en mal estado: Almacenero puede rechazar parcialmente

**Postcondición:** Orden recepcionada, inventario actualizado

---

### CU-22: Anular Orden de Compra
**Actores:** Administrador, Sistema, Base de Datos  
**Precondición:** Orden no debe estar recepcionada  
**Flujo Principal:**
1. Administrador accede a orden
2. Base de Datos consulta estado de la orden
3. Administrador hace clic en "Anular"
4. Sistema solicita motivo
5. Administrador ingresa justificación
6. Sistema verifica que no esté recepcionada
7. Base de Datos cambia estado a "Anulada"
8. Base de Datos registra en auditoría

**Flujo Alternativo:**
- 6a. Orden ya recepcionada: Sistema no permite anulación

**Postcondición:** Orden anulada

---

## 5️⃣ MÓDULO: GESTIÓN DE MENÚS Y RECETAS

### CU-23: Crear Receta
**Actores:** Supervisor, Administrador, Sistema, Base de Datos  
**Precondición:** Productos/insumos deben existir  
**Flujo Principal:**
1. Usuario accede a "Recetas"
2. Sistema muestra lista de recetas
3. Usuario hace clic en "Nueva Receta"
4. Sistema muestra formulario
5. Usuario ingresa:
   - Nombre de la receta
   - Descripción
   - Categoría (entrada, plato principal, postre, bebida)
   - Tiempo de preparación
   - Porciones que rinde
   - Imagen (opcional)
   - Instrucciones de preparación
6. Usuario agrega ingredientes:
   - Selecciona producto/insumo
   - Ingresa cantidad necesaria
   - Sistema muestra unidad de medida
   - Base de Datos consulta stock disponible
   - Sistema muestra stock disponible
7. Usuario puede agregar múltiples ingredientes
8. Sistema calcula:
   - Costo total de la receta
   - Costo por porción
   - Disponibilidad según stock actual
9. Usuario guarda receta
10. Sistema valida que tenga al menos 1 ingrediente
11. Base de Datos guarda receta e ingredientes

**Flujo Alternativo:**
- 6a. Stock insuficiente: Sistema muestra advertencia

**Postcondición:** Receta creada y disponible para menús

---

### CU-24: Editar Receta
**Actores:** Supervisor, Administrador, Sistema, Base de Datos  
**Precondición:** Receta debe existir  
**Flujo Principal:**
1. Usuario busca receta
2. Sistema muestra resultados
3. Usuario hace clic en "Editar"
4. Sistema muestra formulario con datos actuales
5. Base de Datos consulta información de la receta
6. Usuario modifica información
7. Usuario puede agregar/quitar/modificar ingredientes
8. Sistema recalcula costos
9. Sistema valida cambios
10. Base de Datos actualiza receta
11. Sistema notifica si receta está en menús activos

**Postcondición:** Receta actualizada

---

### CU-25: Crear Menú Diario
**Actores:** Supervisor, Administrador, Sistema, Base de Datos  
**Precondición:** Recetas deben existir  
**Flujo Principal:**
1. Usuario accede a "Menús"
2. Sistema muestra lista de menús
3. Usuario hace clic en "Crear Menú"
4. Sistema muestra formulario
5. Usuario ingresa:
   - Fecha del menú
   - Tipo de menú (desayuno, almuerzo, cena)
   - Nombre/descripción
6. Base de Datos consulta recetas disponibles
7. Usuario agrega platos/recetas:
   - Entrada (opcional)
   - Plato principal
   - Guarniciones
   - Postre (opcional)
   - Bebida (opcional)
8. Para cada receta seleccionada:
   - Sistema verifica disponibilidad de ingredientes
   - Base de Datos consulta stock de ingredientes
   - Sistema muestra alertas si stock insuficiente
   - Sistema calcula porciones disponibles
9. Usuario define:
   - Cantidad estimada de comensales
   - Precio (si aplica)
   - Estado (activo/inactivo)
10. Sistema calcula:
    - Costo total del menú
    - Costo por porción
    - Ingredientes totales necesarios
11. Usuario guarda menú
12. Base de Datos guarda menú
13. Sistema reserva ingredientes si está activo

**Flujo Alternativo:**
- 8a. Stock insuficiente para algún ingrediente: Sistema sugiere recetas alternativas
- 5a. Ya existe menú para esa fecha/tipo: Sistema solicita confirmación

**Postcondición:** Menú creado y disponible

---

### CU-26: Activar/Desactivar Menú
**Actores:** Supervisor, Administrador, Sistema, Base de Datos  
**Precondición:** Menú debe existir  
**Flujo Principal:**
1. Usuario accede a lista de menús
2. Sistema muestra menús
3. Usuario selecciona menú
4. Usuario hace clic en "Cambiar Estado"
5. Sistema verifica:
   - Fecha del menú (no debe ser pasada)
   - Disponibilidad de ingredientes
6. Base de Datos consulta stock de ingredientes
7. Base de Datos cambia estado
8. Sistema reserva/libera ingredientes según nuevo estado

**Flujo Alternativo:**
- 6a. Ingredientes insuficientes: Sistema no permite activación

**Postcondición:** Estado del menú actualizado

---

### CU-27: Verificar Disponibilidad de Menú
**Actores:** Sistema, Base de Datos  
**Precondición:** Menú debe estar activo  
**Flujo Principal:**
1. Sistema ejecuta verificación automática cada hora
2. Base de Datos consulta menús activos
3. Para cada receta del menú:
   - Base de Datos verifica stock de cada ingrediente
   - Sistema compara con cantidad necesaria
   - Sistema calcula porciones disponibles
4. Sistema determina estado:
   - "Disponible" si todos los ingredientes están
   - "Disponible Parcialmente" si faltan algunos
   - "No Disponible" si faltan ingredientes críticos
5. Base de Datos actualiza estado del menú
6. Sistema notifica supervisor si cambia a "No Disponible"

**Postcondición:** Disponibilidad actualizada

---

## 6️⃣ MÓDULO: REGISTRO DE CONSUMOS

### CU-28: Registrar Consumo Individual
**Actores:** Personal de Atención, Supervisor, Sistema, Base de Datos, RENIEC  
**Precondición:** Menú activo y trabajador registrado  
**Flujo Principal:**
1. Usuario accede a "Registrar Consumo"
2. Sistema muestra menús activos del día
3. Base de Datos consulta menús activos
4. Usuario selecciona tipo de menú (desayuno/almuerzo/cena)
5. Sistema muestra información del menú
6. Usuario busca trabajador:
   - Por DNI
   - Por nombre
   - Escaneando código (QR/barras)
7. Base de Datos busca trabajador
8. Sistema valida trabajador:
   - Existe en sistema
   - Está activo
   - No ha consumido ese menú hoy
9. Sistema muestra datos del trabajador
10. Usuario confirma consumo
11. Base de Datos registra:
    - Trabajador
    - Menú consumido
    - Fecha y hora
    - Usuario que registró
    - Ubicación (opcional)
12. Base de Datos descuenta ingredientes del stock
13. Base de Datos genera entrada en kardex
14. Sistema muestra confirmación

**Flujo Alternativo:**
- 7a. Trabajador no encontrado: RENIEC valida DNI y Sistema permite registrar datos básicos
- 8a. Trabajador ya consumió: Sistema muestra alerta y no permite duplicado

**Postcondición:** Consumo registrado, stock actualizado

---

### CU-29: Registrar Consumo Masivo
**Actores:** Supervisor, Administrador, Sistema, Base de Datos  
**Precondición:** Menú activo y lista de trabajadores  
**Flujo Principal:**
1. Usuario accede a "Consumo Masivo"
2. Sistema muestra menús activos
3. Base de Datos consulta menús activos
4. Usuario selecciona menú
5. Usuario carga archivo Excel con DNIs o:
   - Usuario selecciona área/departamento
   - Base de Datos lista trabajadores
   - Sistema muestra trabajadores
6. Usuario revisa lista de trabajadores
7. Usuario puede agregar/quitar trabajadores
8. Usuario confirma consumo masivo
9. Sistema procesa cada registro:
   - Valida trabajador
   - Verifica que no haya consumido
   - Base de Datos registra consumo
10. Sistema muestra resumen:
    - Consumos exitosos
    - Errores (duplicados, no encontrados)
11. Base de Datos descuenta ingredientes proporcionalmente
12. Sistema genera reporte

**Flujo Alternativo:**
- 9a. Algunos trabajadores ya consumieron: Sistema los omite y continúa

**Postcondición:** Consumos masivos registrados

---

### CU-30: Consultar Historial de Consumos
**Actores:** Supervisor, Administrador, Personal de RR.HH., Sistema, Base de Datos  
**Precondición:** Debe haber consumos registrados  
**Flujo Principal:**
1. Usuario accede a "Consumos"
2. Sistema muestra filtros:
   - Rango de fechas
   - Trabajador específico
   - Tipo de menú
   - Área/departamento
3. Usuario aplica filtros
4. Base de Datos consulta consumos según filtros
5. Sistema muestra tabla con:
   - Fecha y hora
   - Trabajador
   - Menú consumido
   - Usuario que registró
6. Usuario puede:
   - Ver detalles del consumo
   - Exportar a Excel/PDF
   - Sistema generar estadísticas

**Postcondición:** Información consultada

---

### CU-31: Anular Consumo
**Actores:** Supervisor, Administrador, Sistema, Base de Datos  
**Precondición:** Consumo debe existir y ser del día actual  
**Flujo Principal:**
1. Usuario busca consumo a anular
2. Base de Datos consulta consumo
3. Usuario hace clic en "Anular"
4. Sistema verifica que sea del día actual
5. Sistema solicita motivo
6. Usuario ingresa justificación
7. Sistema confirma anulación
8. Base de Datos revierte descuento de ingredientes
9. Base de Datos marca consumo como anulado
10. Base de Datos registra en auditoría

**Flujo Alternativo:**
- 4a. Consumo de días anteriores: Sistema no permite anulación directa

**Postcondición:** Consumo anulado, stock devuelto

---

## 7️⃣ MÓDULO: GESTIÓN DE PERSONAL

### CU-32: Registrar Trabajador
**Actores:** Personal de RR.HH., Administrador, Sistema, Base de Datos, RENIEC  
**Precondición:** Permiso "crear-trabajadores"  
**Flujo Principal:**
1. Usuario accede a "Personal"
2. Sistema muestra lista de trabajadores
3. Usuario hace clic en "Nuevo Trabajador"
4. Sistema muestra formulario
5. Usuario ingresa DNI
6. Sistema integra con RENIEC:
   - Consulta datos del DNI
   - RENIEC retorna nombre completo, fecha de nacimiento
7. Sistema auto-completa datos personales
8. Usuario completa/corrige información:
   - Datos personales (nombre, DNI, fecha nacimiento)
   - Dirección
   - Teléfono
   - Email
   - Cargo
   - Área/departamento
   - Fecha de ingreso
   - Tipo de contrato
   - Salario (opcional)
   - Contacto de emergencia
   - Foto (opcional)
9. Sistema valida DNI único
10. Base de Datos verifica unicidad de DNI
11. Base de Datos guarda trabajador
12. Sistema genera código de empleado

**Flujo Alternativo:**
- 6a. DNI no encontrado en RENIEC: Usuario ingresa datos manualmente
- 10a. DNI duplicado: Sistema muestra error

**Postcondición:** Trabajador registrado

---

### CU-33: Editar Trabajador
**Actores:** Personal de RR.HH., Administrador, Sistema, Base de Datos  
**Precondición:** Trabajador debe existir  
**Flujo Principal:**
1. Usuario busca trabajador
2. Sistema muestra resultados
3. Usuario hace clic en "Editar"
4. Sistema muestra formulario con datos actuales
5. Base de Datos consulta información del trabajador
6. Usuario modifica información
7. Sistema valida cambios
8. Base de Datos actualiza trabajador
9. Sistema notifica a supervisor si cambió área/cargo

**Postcondición:** Trabajador actualizado

---

### CU-34: Desactivar Trabajador
**Actores:** Personal de RR.HH., Administrador, Sistema, Base de Datos  
**Precondición:** Trabajador activo  
**Flujo Principal:**
1. Usuario accede a ficha de trabajador
2. Usuario hace clic en "Desactivar"
3. Sistema solicita:
   - Fecha de cese
   - Motivo
4. Usuario ingresa información
5. Sistema confirma desactivación
6. Base de Datos cambia estado a "Inactivo"
7. Base de Datos finaliza contrato activo (si existe)
8. Base de Datos desactiva cuenta de usuario (si existe)

**Postcondición:** Trabajador desactivado

---

### CU-35: Consultar Datos de Trabajador
**Actores:** Personal de RR.HH., Supervisor, Administrador, Sistema, Base de Datos  
**Precondición:** Trabajador registrado  
**Flujo Principal:**
1. Usuario busca trabajador por:
   - DNI
   - Nombre
   - Código de empleado
   - Área
2. Base de Datos consulta según criterio
3. Sistema muestra resultados
4. Usuario selecciona trabajador
5. Base de Datos consulta información completa
6. Sistema muestra ficha completa:
   - Datos personales
   - Datos laborales
   - Contratos (histórico)
   - Certificados médicos
   - Historial de consumos
   - Usuario del sistema (si tiene)
7. Usuario puede imprimir ficha
8. Sistema genera PDF

**Postcondición:** Información consultada

---

## 8️⃣ MÓDULO: GESTIÓN DE CONTRATOS LABORALES

### CU-36: Crear Contrato Laboral
**Actores:** Personal de RR.HH., Administrador, Sistema, Base de Datos  
**Precondición:** Trabajador debe existir y plantilla de contrato disponible  
**Flujo Principal:**
1. Usuario accede a trabajador
2. Base de Datos consulta información del trabajador
3. Usuario hace clic en "Nuevo Contrato"
4. Sistema muestra formulario
5. Usuario ingresa:
   - Tipo de contrato (plazo fijo, indefinido, por obra)
   - Fecha de inicio
   - Fecha de fin (si es temporal)
   - Cargo específico
   - Salario mensual
   - Beneficios
   - Horario de trabajo
   - Condiciones especiales
6. Base de Datos consulta plantillas disponibles
7. Usuario selecciona plantilla de contrato
8. Sistema genera vista previa del contrato con datos
9. Usuario revisa y confirma
10. Sistema genera documento PDF
11. Base de Datos guarda contrato con estado "Pendiente de Firma"
12. Sistema puede enviar por email al trabajador

**Flujo Alternativo:**
- 6a. No hay plantillas: Usuario debe crear una primero

**Postcondición:** Contrato creado en estado "Pendiente"

---

### CU-37: Generar PDF de Contrato
**Actores:** Personal de RR.HH., Sistema, Base de Datos  
**Precondición:** Contrato debe existir con plantilla  
**Flujo Principal:**
1. Usuario accede a contrato
2. Usuario hace clic en "Generar PDF"
3. Base de Datos consulta datos del contrato y trabajador
4. Sistema carga plantilla seleccionada
5. Sistema reemplaza variables:
   - {nombre_trabajador}
   - {dni}
   - {fecha_inicio}
   - {fecha_fin}
   - {cargo}
   - {salario}
   - {fecha_actual}
   - etc.
6. Sistema genera documento PDF
7. Sistema muestra vista previa
8. Usuario puede:
   - Descargar
   - Imprimir
   - Enviar por email

**Postcondición:** PDF generado

---

### CU-38: Subir Contrato Firmado
**Actores:** Personal de RR.HH., Sistema, Base de Datos  
**Precondición:** Contrato generado previamente  
**Flujo Principal:**
1. Usuario accede a contrato
2. Usuario hace clic en "Subir Contrato Firmado"
3. Sistema muestra formulario de carga
4. Usuario selecciona archivo PDF escaneado
5. Sistema valida formato (PDF, tamaño máximo)
6. Usuario sube archivo
7. Sistema guarda documento en storage
8. Base de Datos actualiza ruta del archivo
9. Base de Datos cambia estado a "Firmado"
10. Base de Datos registra fecha de firma

**Postcondición:** Contrato firmado registrado

---

### CU-39: Activar Contrato
**Actores:** Personal de RR.HH., Administrador, Sistema, Base de Datos  
**Precondición:** Contrato en estado "Firmado"  
**Flujo Principal:**
1. Usuario accede a contrato
2. Usuario hace clic en "Activar Contrato"
3. Sistema verifica:
   - Contrato firmado
   - Fecha de inicio (hoy o futura)
4. Base de Datos consulta contratos activos del trabajador
5. Sistema valida que no hay contratos activos
6. Base de Datos cambia estado a "Activo"
7. Base de Datos registra fecha de activación
8. Base de Datos reactiva trabajador si estaba inactivo

**Flujo Alternativo:**
- 5a. Ya existe contrato activo: Sistema sugiere finalizar el anterior

**Postcondición:** Contrato activo y vigente

---

### CU-40: Finalizar Contrato
**Actores:** Personal de RR.HH., Administrador, Sistema, Base de Datos  
**Precondición:** Contrato en estado "Activo"  
**Flujo Principal:**
1. Usuario accede a contrato
2. Usuario hace clic en "Finalizar Contrato"
3. Sistema solicita:
   - Fecha de finalización
   - Motivo (vencimiento, renuncia, despido, mutuo acuerdo)
   - Observaciones
4. Usuario ingresa datos
5. Sistema confirma finalización
6. Base de Datos cambia estado a "Finalizado"
7. Base de Datos registra fecha de finalización
8. Sistema puede generar liquidación (futuro)

**Postcondición:** Contrato finalizado

---

### CU-41: Crear Plantilla de Contrato
**Actores:** Administrador, Sistema, Base de Datos  
**Precondición:** Permiso de configuración  
**Flujo Principal:**
1. Administrador accede a "Plantillas de Contrato"
2. Sistema muestra lista de plantillas
3. Administrador hace clic en "Nueva Plantilla"
4. Sistema muestra editor
5. Administrador ingresa:
   - Nombre de la plantilla
   - Tipo de contrato (plazo fijo, indefinido, etc.)
   - Descripción
6. Administrador escribe contenido del contrato usando variables:
   - {nombre_trabajador}
   - {dni}
   - {direccion}
   - {cargo}
   - {salario}
   - {fecha_inicio}
   - {fecha_fin}
   - {fecha_actual}
   - {empresa_nombre}
   - {empresa_ruc}
   - {empresa_representante}
7. Sistema muestra lista de variables disponibles
8. Administrador puede formatear texto (negrita, cursiva, etc.)
9. Administrador guarda plantilla
10. Sistema valida sintaxis de variables
11. Base de Datos guarda plantilla

**Postcondición:** Plantilla creada y disponible

---

### CU-42: Consultar Contratos por Vencer
**Actores:** Personal de RR.HH., Administrador, Sistema, Base de Datos  
**Precondición:** Contratos activos existentes  
**Flujo Principal:**
1. Usuario accede a "Contratos por Vencer"
2. Base de Datos consulta contratos activos
3. Sistema filtra contratos:
   - Estado: Activo
   - Fecha fin <= (hoy + 30 días)
4. Sistema muestra lista con:
   - Trabajador
   - Tipo de contrato
   - Fecha de inicio
   - Fecha de fin
   - Días restantes
5. Sistema marca con colores:
   - Rojo: Vence en menos de 7 días
   - Amarillo: Vence en 7-15 días
   - Verde: Vence en 16-30 días
6. Usuario puede:
   - Ver detalle del contrato
   - Renovar contrato
   - Exportar lista
7. Sistema genera archivo de exportación

**Postcondición:** Lista consultada

---

## 9️⃣ MÓDULO: CERTIFICADOS MÉDICOS

### CU-43: Registrar Certificado Médico
**Actores:** Personal de RR.HH., Supervisor, Sistema, Base de Datos  
**Precondición:** Trabajador debe existir  
**Flujo Principal:**
1. Usuario accede a trabajador
2. Base de Datos consulta información del trabajador
3. Usuario hace clic en "Nuevo Certificado Médico"
4. Sistema muestra formulario
5. Usuario ingresa:
   - Tipo de examen (pre-ocupacional, anual, por cambio de puesto)
   - Fecha del examen
   - Institución/clínica
   - Médico evaluador
   - Resultado (apto, no apto, apto con restricciones)
   - Restricciones (si aplica)
   - Fecha de vencimiento
   - Observaciones
6. Usuario sube documento PDF (opcional)
7. Sistema valida fechas
8. Base de Datos guarda certificado
9. Sistema guarda archivo PDF en storage
10. Sistema genera alerta si resultado es "No Apto"

**Flujo Alternativo:**
- 10a. Resultado "No Apto": Sistema sugiere desactivar trabajador

**Postcondición:** Certificado registrado

---

### CU-44: Consultar Certificados por Vencer
**Actores:** Personal de RR.HH., Sistema, Base de Datos  
**Precondición:** Certificados registrados  
**Flujo Principal:**
1. Usuario accede a "Certificados por Vencer"
2. Base de Datos consulta certificados activos
3. Sistema filtra certificados:
   - Fecha vencimiento <= (hoy + 30 días)
   - Trabajador activo
4. Sistema muestra lista
5. Sistema marca con colores según días restantes
6. Usuario puede:
   - Ver detalle
   - Renovar certificado
   - Notificar a trabajador
7. Sistema envía notificación si se solicita

**Postcondición:** Lista consultada

---

### CU-45: Renovar Certificado Médico
**Actor:** Personal de RR.HH.  
**Precondición:** Certificado anterior debe existir  
**Flujo Principal:**
1. Usuario accede a certificado vencido/por vencer
2. Usuario hace clic en "Renovar"
3. Sistema copia datos del certificado anterior
4. Usuario actualiza información del nuevo examen
5. Sistema marca certificado anterior como "Renovado"
6. Sistema guarda nuevo certificado como "Vigente"

**Postcondición:** Certificado renovado

---

## 🔟 MÓDULO: REPORTES Y ESTADÍSTICAS

### CU-46: Generar Reporte de Consumos
**Actor:** Supervisor, Administrador  
**Precondición:** Datos de consumos existentes  
**Flujo Principal:**
1. Usuario accede a "Reportes"
2. Usuario selecciona "Reporte de Consumos"
3. Sistema muestra filtros:
   - Rango de fechas
   - Tipo de menú
   - Área/departamento
   - Trabajador específico
4. Usuario aplica filtros
5. Sistema procesa datos y muestra:
   - Total de consumos
   - Consumos por día
   - Consumos por tipo de menú
   - Consumos por área
   - Top 10 platos más consumidos
   - Gráficos de tendencia
6. Usuario puede exportar a:
   - Excel
   - PDF
   - Imprimir

**Postcondición:** Reporte generado

---

### CU-47: Generar Reporte de Inventario
**Actor:** Almacenero, Administrador  
**Precondición:** Movimientos de inventario registrados  
**Flujo Principal:**
1. Usuario accede a "Reportes"
2. Usuario selecciona "Reporte de Inventario"
3. Sistema muestra opciones:
   - Stock actual de todos los productos
   - Movimientos por período
   - Productos por vencer
   - Productos con stock mínimo
   - Valorización de inventario
4. Usuario selecciona tipo de reporte
5. Usuario define parámetros
6. Sistema genera reporte con:
   - Tablas detalladas
   - Gráficos
   - Resumen ejecutivo
7. Usuario exporta reporte

**Postcondición:** Reporte de inventario generado

---

### CU-48: Generar Reporte de Compras
**Actor:** Almacenero, Administrador  
**Precondición:** Órdenes de compra registradas  
**Flujo Principal:**
1. Usuario accede a "Reportes"
2. Usuario selecciona "Reporte de Compras"
3. Sistema muestra filtros:
   - Rango de fechas
   - Proveedor
   - Estado (pendiente, recibida, anulada)
   - Tipo de compra
4. Usuario aplica filtros
5. Sistema procesa y muestra:
   - Total comprado por período
   - Compras por proveedor
   - Productos más comprados
   - Promedio de precios
   - Tiempo de entrega promedio
6. Usuario exporta reporte

**Postcondición:** Reporte de compras generado

---

### CU-49: Ver Dashboard de Estadísticas
**Actor:** Todos los usuarios autenticados  
**Precondición:** Usuario con permisos correspondientes  
**Flujo Principal:**
1. Usuario inicia sesión
2. Sistema redirige a dashboard
3. Sistema muestra widgets según rol:
   
   **Administrador ve:**
   - Total de trabajadores activos
   - Consumos del día
   - Productos con stock crítico
   - Órdenes de compra pendientes
   - Contratos por vencer
   - Gráficos de tendencias
   
   **Almacenero ve:**
   - Stock actual resumido
   - Productos por vencer
   - Alertas de stock mínimo
   - Órdenes pendientes de recepcionar
   
   **Supervisor ve:**
   - Consumos del día
   - Menús activos
   - Disponibilidad de recetas
   - Estadísticas de área

4. Usuario puede hacer clic en widgets para ver detalles
5. Usuario puede personalizar dashboard (futuro)

**Postcondición:** Dashboard visualizado

---

## 1️⃣1️⃣ MÓDULO: CONFIGURACIONES DEL SISTEMA

### CU-50: Configurar Datos de Empresa
**Actor:** Administrador  
**Precondición:** Permiso "gestionar-configuraciones"  
**Flujo Principal:**
1. Administrador accede a "Configuraciones"
2. Administrador selecciona tab "Empresa"
3. Sistema muestra formulario con datos actuales
4. Administrador modifica:
   - Nombre de la empresa
   - RUC
   - Dirección
   - Teléfono
   - Email
   - Sitio web
   - Logo (imagen)
   - Representante legal
5. Sistema valida datos
6. Sistema guarda configuración
7. Sistema aplica cambios en todo el sistema
8. Sistema actualiza plantillas de documentos

**Postcondición:** Datos de empresa actualizados

---

### CU-51: Configurar Parámetros del Sistema
**Actor:** Administrador  
**Precondición:** Permiso "gestionar-configuraciones"  
**Flujo Principal:**
1. Administrador accede a tab "Sistema"
2. Sistema muestra configuraciones:
   - Zona horaria
   - Formato de fecha
   - Formato de moneda
   - Idioma del sistema
   - Items por página
   - Días para alertas de vencimiento
   - Porcentaje de stock mínimo para alertas
   - Habilitar modo mantenimiento
3. Administrador modifica valores
4. Sistema valida cambios
5. Sistema guarda configuración
6. Sistema aplica cambios inmediatamente

**Postcondición:** Sistema configurado

---

### CU-52: Configurar Notificaciones
**Actor:** Administrador  
**Precondición:** Permiso "gestionar-configuraciones"  
**Flujo Principal:**
1. Administrador accede a tab "Notificaciones"
2. Sistema muestra tipos de notificaciones:
   - Email de stock mínimo
   - Email de productos por vencer
   - Email de contratos por vencer
   - Email de certificados por vencer
   - Notificaciones en sistema
3. Para cada tipo, administrador configura:
   - Activar/Desactivar
   - Destinatarios
   - Frecuencia
   - Plantilla de mensaje
4. Sistema valida configuración
5. Sistema guarda cambios
6. Sistema programa tareas automáticas

**Postcondición:** Notificaciones configuradas

---

### CU-53: Gestionar Permisos Personalizados
**Actor:** Administrador  
**Precondición:** Sistema de roles/permisos activo  
**Flujo Principal:**
1. Administrador accede a tab "Permisos"
2. Sistema muestra matriz de permisos:
   - Filas: Roles
   - Columnas: Permisos por módulo
3. Administrador selecciona rol
4. Administrador activa/desactiva permisos:
   - Ver, Crear, Editar, Eliminar (por módulo)
5. Sistema muestra vista previa de cambios
6. Administrador confirma cambios
7. Sistema actualiza permisos
8. Sistema aplica a usuarios con ese rol
9. Usuarios afectados deben reiniciar sesión

**Postcondición:** Permisos actualizados

---

### CU-54: Limpiar Caché del Sistema
**Actor:** Administrador  
**Precondición:** Permiso de administración  
**Flujo Principal:**
1. Administrador accede a "Configuraciones"
2. Administrador hace clic en "Limpiar Caché"
3. Sistema muestra opciones:
   - Caché de aplicación
   - Caché de configuración
   - Caché de rutas
   - Caché de vistas
   - Todo el caché
4. Administrador selecciona tipo de caché
5. Administrador confirma acción
6. Sistema ejecuta limpieza
7. Sistema muestra resultado

**Postcondición:** Caché limpiado

---

### CU-55: Optimizar Sistema
**Actor:** Administrador  
**Precondición:** Permiso de administración  
**Flujo Principal:**
1. Administrador accede a "Configuraciones"
2. Administrador hace clic en "Optimizar Sistema"
3. Sistema ejecuta comandos de optimización:
   - Cachear configuración
   - Cachear rutas
   - Cachear vistas
   - Optimizar autoload
4. Sistema muestra progreso
5. Sistema muestra resultado de optimización

**Postcondición:** Sistema optimizado

---

## 1️⃣2️⃣ MÓDULO: AUDITORÍA Y LOGS

### CU-56: Consultar Log de Actividades
**Actor:** Administrador  
**Precondición:** Logs habilitados  
**Flujo Principal:**
1. Administrador accede a "Logs de Actividad"
2. Sistema muestra filtros:
   - Rango de fechas
   - Usuario
   - Módulo
   - Tipo de acción (crear, editar, eliminar)
3. Administrador aplica filtros
4. Sistema muestra tabla con:
   - Fecha y hora
   - Usuario
   - Acción realizada
   - Módulo afectado
   - IP de origen
   - Datos modificados (antes/después)
5. Administrador puede exportar logs

**Postcondición:** Logs consultados

---

### CU-57: Ver Historial de Cambios
**Actor:** Administrador, Supervisor  
**Precondición:** Auditoría habilitada  
**Flujo Principal:**
1. Usuario accede a registro específico (producto, trabajador, etc.)
2. Usuario hace clic en "Historial de Cambios"
3. Sistema muestra línea de tiempo con:
   - Fecha y hora de cada modificación
   - Usuario que hizo el cambio
   - Campos modificados
   - Valor anterior vs. valor nuevo
4. Usuario puede ver detalles de cada cambio

**Postcondición:** Historial consultado

---

## 📊 MATRIZ DE CASOS DE USO POR ACTOR

| Caso de Uso | Admin | Almacenero | Supervisor | Personal Atención | RR.HH. | Sistema |
|-------------|-------|------------|------------|-------------------|--------|---------|
| CU-01: Iniciar Sesión | ✅ | ✅ | ✅ | ✅ | ✅ | - |
| CU-02: Cerrar Sesión | ✅ | ✅ | ✅ | ✅ | ✅ | - |
| CU-03: Recuperar Contraseña | ✅ | ✅ | ✅ | ✅ | ✅ | - |
| CU-04: Cambiar Contraseña | ✅ | ✅ | ✅ | ✅ | ✅ | - |
| CU-05: Crear Usuario | ✅ | - | - | - | - | - |
| CU-06: Editar Usuario | ✅ | - | - | - | - | - |
| CU-07: Eliminar Usuario | ✅ | - | - | - | - | - |
| CU-08: Gestionar Roles | ✅ | - | - | - | - | - |
| CU-09: Crear Rol Personalizado | ✅ | - | - | - | - | - |
| CU-10: Clonar Rol | ✅ | - | - | - | - | - |
| CU-11: Registrar Producto | ✅ | ✅ | - | - | - | - |
| CU-12: Editar Producto | ✅ | ✅ | - | - | - | - |
| CU-13: Eliminar Producto | ✅ | - | - | - | - | - |
| CU-14: Registrar Entrada | ✅ | ✅ | - | - | - | - |
| CU-15: Registrar Salida | ✅ | ✅ | - | - | - | - |
| CU-16: Consultar Kardex | ✅ | ✅ | ✅ | - | - | - |
| CU-17: Ajustar Inventario | ✅ | - | ✅ | - | - | - |
| CU-18: Alerta Stock Mínimo | - | - | - | - | - | ✅ |
| CU-19: Registrar Proveedor | ✅ | ✅ | - | - | - | - |
| CU-20: Crear Orden Compra | ✅ | ✅ | - | - | - | - |
| CU-21: Recepcionar Orden | ✅ | ✅ | - | - | - | - |
| CU-22: Anular Orden | ✅ | - | - | - | - | - |
| CU-23: Crear Receta | ✅ | - | ✅ | - | - | - |
| CU-24: Editar Receta | ✅ | - | ✅ | - | - | - |
| CU-25: Crear Menú | ✅ | - | ✅ | - | - | - |
| CU-26: Activar/Desactivar Menú | ✅ | - | ✅ | - | - | - |
| CU-27: Verificar Disponibilidad | ✅ | - | ✅ | - | - | ✅ |
| CU-28: Registrar Consumo | ✅ | - | ✅ | ✅ | - | - |
| CU-29: Consumo Masivo | ✅ | - | ✅ | - | - | - |
| CU-30: Historial Consumos | ✅ | - | ✅ | - | ✅ | - |
| CU-31: Anular Consumo | ✅ | - | ✅ | - | - | - |
| CU-32: Registrar Trabajador | ✅ | - | - | - | ✅ | - |
| CU-33: Editar Trabajador | ✅ | - | - | - | ✅ | - |
| CU-34: Desactivar Trabajador | ✅ | - | - | - | ✅ | - |
| CU-35: Consultar Trabajador | ✅ | - | ✅ | - | ✅ | - |
| CU-36: Crear Contrato | ✅ | - | - | - | ✅ | - |
| CU-37: Generar PDF Contrato | ✅ | - | - | - | ✅ | - |
| CU-38: Subir Contrato Firmado | ✅ | - | - | - | ✅ | - |
| CU-39: Activar Contrato | ✅ | - | - | - | ✅ | - |
| CU-40: Finalizar Contrato | ✅ | - | - | - | ✅ | - |
| CU-41: Crear Plantilla | ✅ | - | - | - | - | - |
| CU-42: Contratos por Vencer | ✅ | - | - | - | ✅ | - |
| CU-43: Registrar Certificado | ✅ | - | ✅ | - | ✅ | - |
| CU-44: Certificados por Vencer | ✅ | - | - | - | ✅ | - |
| CU-45: Renovar Certificado | ✅ | - | - | - | ✅ | - |
| CU-46: Reporte Consumos | ✅ | - | ✅ | - | - | - |
| CU-47: Reporte Inventario | ✅ | ✅ | - | - | - | - |
| CU-48: Reporte Compras | ✅ | ✅ | - | - | - | - |
| CU-49: Dashboard | ✅ | ✅ | ✅ | ✅ | ✅ | - |
| CU-50: Config Empresa | ✅ | - | - | - | - | - |
| CU-51: Config Sistema | ✅ | - | - | - | - | - |
| CU-52: Config Notificaciones | ✅ | - | - | - | - | - |
| CU-53: Gestionar Permisos | ✅ | - | - | - | - | - |
| CU-54: Limpiar Caché | ✅ | - | - | - | - | - |
| CU-55: Optimizar Sistema | ✅ | - | - | - | - | - |
| CU-56: Consultar Logs | ✅ | - | - | - | - | - |
| CU-57: Historial Cambios | ✅ | - | ✅ | - | - | - |

---

## 🎨 INSTRUCCIONES PARA STARUML

### Pasos para crear el Diagrama de Casos de Uso:

1. **Crear Actores:**
   ```
   - Administrador (Hereda de Usuario)
   - Almacenero (Hereda de Usuario)
   - Supervisor (Hereda de Usuario)
   - Personal de Atención (Hereda de Usuario)
   - Personal de RR.HH. (Hereda de Usuario)
   - Sistema RENIEC (Actor externo)
   - Sistema (Actor del sistema)
   ```

2. **Agrupar Casos de Uso por Paquetes:**
   ```
   📦 Autenticación y Seguridad (CU-01 a CU-04)
   📦 Gestión de Usuarios (CU-05 a CU-10)
   📦 Gestión de Inventario (CU-11 a CU-18)
   📦 Gestión de Compras (CU-19 a CU-22)
   📦 Gestión de Menús (CU-23 a CU-27)
   📦 Registro de Consumos (CU-28 a CU-31)
   📦 Gestión de Personal (CU-32 a CU-35)
   📦 Gestión de Contratos (CU-36 a CU-42)
   📦 Certificados Médicos (CU-43 a CU-45)
   📦 Reportes (CU-46 a CU-49)
   📦 Configuraciones (CU-50 a CU-55)
   📦 Auditoría (CU-56 a CU-57)
   ```

3. **Relaciones importantes:**
   - **Include:** 
     - "Registrar Consumo" include "Buscar Trabajador"
     - "Crear Contrato" include "Generar PDF"
     - "Registrar Trabajador" include "Consultar RENIEC"
   
   - **Extend:**
     - "Registrar Consumo Individual" extend "Validar con RENIEC"
     - "Crear Orden Compra" extend "Consultar Stock Actual"

4. **Generalizaciones:**
   - Todos los actores humanos heredan de "Usuario"
   - "Consumo Masivo" es generalización de "Registrar Consumo"

---

## 📝 NOTAS ADICIONALES

### Actores del Sistema (OBLIGATORIOS EN TODOS LOS CU):
- **Sistema:** Actor técnico que procesa lógica de negocio, valida datos, ejecuta operaciones y genera cálculos. DEBE estar presente en TODOS los casos de uso.
- **Base de Datos:** Actor técnico que almacena información, consulta datos, actualiza registros y mantiene integridad referencial. DEBE estar presente en TODOS los casos de uso (excepto CU-54, CU-55 que solo interactúan con archivos de caché).

### Integraciones Externas:
- **RENIEC:** Para validación de DNI en CU-32, CU-28
- **SUNAT:** Para consulta de RUC en CU-19
- **Email:** Para notificaciones automáticas

### Procesos Automáticos del Sistema:
- CU-18: Generación diaria de alertas de stock
- CU-27: Verificación horaria de disponibilidad de menús
- Notificaciones programadas (contratos, certificados, productos por vencer)

### Seguridad:
- Todos los casos de uso requieren autenticación (excepto CU-01, CU-03)
- Validación de permisos por rol en cada operación
- Registro de auditoría en operaciones críticas (CU-56, CU-57)

---

**Documento generado para:** Sistema CESODO v1.0  
**Fecha:** Octubre 2025  
**Versión:** 2.0 (Actualizado con Sistema y Base de Datos como actores obligatorios)  
**Total de Casos de Uso:** 57  
**Total de Actores:** 8 (5 humanos + 2 técnicos obligatorios + 1 externo)

