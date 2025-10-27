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

6. **Sistema RENIEC** (Actor Externo)
   - Validación de DNI
   - Consulta de datos personales

---

## 🎯 CASOS DE USO POR MÓDULO

---

## 1️⃣ MÓDULO: AUTENTICACIÓN Y SEGURIDAD

### CU-01: Iniciar Sesión
**Actor:** Todos los usuarios  
**Precondición:** Usuario debe estar registrado en el sistema  
**Flujo Principal:**
1. Usuario accede a la página de login
2. Sistema muestra formulario de autenticación
3. Usuario ingresa email y contraseña
4. Sistema valida credenciales
5. Sistema verifica estado del usuario (activo/inactivo)
6. Sistema registra fecha de último acceso
7. Sistema redirige al dashboard según rol

**Flujo Alternativo:**
- 4a. Credenciales incorrectas: Sistema muestra mensaje de error
- 5a. Usuario inactivo: Sistema deniega acceso
- 4b. Múltiples intentos fallidos: Sistema bloquea cuenta temporalmente

**Postcondición:** Usuario autenticado y sesión iniciada

---

### CU-02: Cerrar Sesión
**Actor:** Todos los usuarios  
**Precondición:** Usuario debe estar autenticado  
**Flujo Principal:**
1. Usuario hace clic en "Cerrar Sesión"
2. Sistema invalida sesión
3. Sistema limpia tokens de autenticación
4. Sistema redirige a página de login

**Postcondición:** Sesión cerrada correctamente

---

### CU-03: Recuperar Contraseña
**Actor:** Todos los usuarios  
**Precondición:** Usuario registrado con email válido  
**Flujo Principal:**
1. Usuario hace clic en "¿Olvidaste tu contraseña?"
2. Sistema muestra formulario de recuperación
3. Usuario ingresa su email
4. Sistema valida existencia del email
5. Sistema genera token de recuperación
6. Sistema envía email con enlace de recuperación
7. Usuario hace clic en enlace del email
8. Sistema valida token y expiraci

ón
9. Usuario ingresa nueva contraseña
10. Sistema actualiza contraseña
11. Sistema envía confirmación por email

**Flujo Alternativo:**
- 4a. Email no existe: Sistema muestra mensaje genérico de seguridad
- 8a. Token expirado: Sistema solicita nueva recuperación

**Postcondición:** Contraseña actualizada correctamente

---

### CU-04: Cambiar Contraseña
**Actor:** Todos los usuarios  
**Precondición:** Usuario autenticado  
**Flujo Principal:**
1. Usuario accede a su perfil
2. Usuario hace clic en "Cambiar Contraseña"
3. Sistema muestra formulario
4. Usuario ingresa contraseña actual
5. Usuario ingresa nueva contraseña (2 veces)
6. Sistema valida contraseña actual
7. Sistema valida formato de nueva contraseña
8. Sistema actualiza contraseña
9. Sistema muestra mensaje de confirmación

**Flujo Alternativo:**
- 6a. Contraseña actual incorrecta: Sistema muestra error
- 7a. Nueva contraseña no cumple requisitos: Sistema muestra reglas

**Postcondición:** Contraseña actualizada

---

## 2️⃣ MÓDULO: GESTIÓN DE USUARIOS Y ROLES

### CU-05: Crear Usuario
**Actor:** Administrador  
**Precondición:** Administrador autenticado con permisos  
**Flujo Principal:**
1. Administrador accede a módulo de usuarios
2. Sistema muestra lista de usuarios
3. Administrador hace clic en "Crear Usuario"
4. Sistema muestra formulario de registro
5. Administrador ingresa datos del usuario:
   - Nombre completo
   - Email (único)
   - DNI (opcional)
   - Teléfono
   - Persona asociada (opcional)
   - Trabajador asociado (opcional)
   - Roles a asignar
6. Sistema valida datos ingresados
7. Sistema genera contraseña temporal
8. Sistema crea usuario
9. Sistema asigna roles seleccionados
10. Sistema muestra contraseña generada
11. Sistema envía email de bienvenida (opcional)

**Flujo Alternativo:**
- 6a. Email ya existe: Sistema muestra error
- 6b. DNI ya registrado: Sistema muestra advertencia

**Postcondición:** Usuario creado y roles asignados

---

### CU-06: Editar Usuario
**Actor:** Administrador  
**Precondición:** Usuario a editar debe existir  
**Flujo Principal:**
1. Administrador accede a lista de usuarios
2. Administrador busca/filtra usuario
3. Administrador hace clic en "Editar"
4. Sistema muestra formulario con datos actuales
5. Administrador modifica datos:
   - Nombre
   - Email
   - Teléfono
   - Estado (activo/inactivo)
   - Roles
6. Sistema valida cambios
7. Sistema actualiza información
8. Sistema sincroniza permisos según nuevos roles

**Flujo Alternativo:**
- 6a. Email duplicado: Sistema muestra error
- 5a. Cambio de estado a inactivo: Sistema cierra sesiones activas

**Postcondición:** Usuario actualizado

---

### CU-07: Eliminar Usuario
**Actor:** Administrador  
**Precondición:** Usuario no debe ser el mismo administrador  
**Flujo Principal:**
1. Administrador selecciona usuario a eliminar
2. Administrador hace clic en "Eliminar"
3. Sistema muestra confirmación
4. Administrador confirma eliminación
5. Sistema verifica que no sea auto-eliminación
6. Sistema realiza soft delete
7. Sistema invalida sesiones activas del usuario
8. Sistema muestra confirmación

**Flujo Alternativo:**
- 5a. Intento de auto-eliminación: Sistema deniega operación

**Postcondición:** Usuario desactivado

---

### CU-08: Gestionar Roles
**Actor:** Administrador  
**Precondición:** Administrador con permisos de configuración  
**Flujo Principal:**
1. Administrador accede a "Gestión de Roles"
2. Sistema muestra lista de roles existentes:
   - Administrador
   - Almacenero
   - Supervisor
   - Personal de Atención
3. Administrador selecciona rol a configurar
4. Sistema muestra matriz de permisos por módulo
5. Administrador activa/desactiva permisos
6. Sistema guarda configuración
7. Sistema aplica cambios a usuarios con ese rol

**Postcondición:** Permisos de rol actualizados

---

### CU-09: Crear Rol Personalizado
**Actor:** Administrador  
**Flujo Principal:**
1. Administrador hace clic en "Crear Rol"
2. Sistema muestra formulario
3. Administrador ingresa:
   - Nombre del rol
   - Descripción
   - Permisos por módulo
4. Sistema valida nombre único
5. Sistema crea rol
6. Sistema asocia permisos seleccionados

**Postcondición:** Nuevo rol disponible

---

### CU-10: Clonar Rol
**Actor:** Administrador  
**Flujo Principal:**
1. Administrador selecciona rol a clonar
2. Administrador hace clic en "Clonar"
3. Sistema solicita nuevo nombre
4. Sistema duplica permisos del rol original
5. Sistema crea nuevo rol

**Postcondición:** Rol clonado creado

---

## 3️⃣ MÓDULO: GESTIÓN DE PRODUCTOS E INVENTARIO

### CU-11: Registrar Producto
**Actor:** Almacenero, Administrador  
**Precondición:** Usuario con permiso "crear-productos"  
**Flujo Principal:**
1. Usuario accede a módulo de productos
2. Usuario hace clic en "Nuevo Producto"
3. Sistema muestra formulario
4. Usuario ingresa información:
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
5. Sistema valida datos
6. Sistema guarda producto
7. Sistema genera entrada en kardex

**Flujo Alternativo:**
- 5a. Código duplicado: Sistema genera nuevo código
- 5b. Nombre duplicado: Sistema solicita confirmación

**Postcondición:** Producto registrado en sistema

---

### CU-12: Editar Producto
**Actor:** Almacenero, Administrador  
**Precondición:** Producto debe existir  
**Flujo Principal:**
1. Usuario busca producto
2. Usuario hace clic en "Editar"
3. Sistema muestra formulario con datos actuales
4. Usuario modifica información
5. Sistema valida cambios
6. Sistema actualiza producto
7. Si cambió precio: Sistema registra en historial

**Postcondición:** Producto actualizado

---

### CU-13: Eliminar Producto
**Actor:** Administrador  
**Precondición:** Producto no debe tener movimientos recientes  
**Flujo Principal:**
1. Administrador selecciona producto
2. Administrador hace clic en "Eliminar"
3. Sistema verifica dependencias:
   - Movimientos de inventario
   - Recetas que lo incluyen
   - Órdenes de compra pendientes
4. Sistema muestra advertencia
5. Administrador confirma eliminación
6. Sistema realiza soft delete
7. Sistema registra en auditoría

**Flujo Alternativo:**
- 3a. Producto con dependencias activas: Sistema no permite eliminación

**Postcondición:** Producto eliminado/desactivado

---

### CU-14: Registrar Entrada de Inventario
**Actor:** Almacenero  
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
7. Sistema registra movimiento
8. Sistema actualiza inventario
9. Sistema genera entrada en kardex
10. Sistema verifica alertas de stock

**Flujo Alternativo:**
- 6a. Stock supera máximo: Sistema muestra advertencia pero permite continuar

**Postcondición:** Inventario actualizado, kardex registrado

---

### CU-15: Registrar Salida de Inventario
**Actor:** Almacenero  
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
6. Sistema calcula nuevo stock
7. Sistema verifica stock mínimo
8. Sistema registra salida
9. Sistema actualiza inventario
10. Sistema genera entrada en kardex
11. Si stock < mínimo: Sistema genera alerta

**Flujo Alternativo:**
- 5a. Stock insuficiente: Sistema muestra error y no permite continuar

**Postcondición:** Inventario actualizado, alerta generada si necesario

---

### CU-16: Consultar Kardex
**Actor:** Almacenero, Supervisor, Administrador  
**Precondición:** Debe existir movimientos registrados  
**Flujo Principal:**
1. Usuario accede a "Kardex"
2. Sistema muestra opciones de filtro:
   - Producto
   - Rango de fechas
   - Tipo de movimiento
   - Usuario que registró
3. Usuario aplica filtros
4. Sistema muestra tabla con:
   - Fecha y hora
   - Tipo de movimiento
   - Cantidad (entrada/salida)
   - Stock anterior
   - Stock nuevo
   - Usuario responsable
   - Documento relacionado
   - Observaciones
5. Usuario puede exportar a Excel/PDF

**Postcondición:** Información consultada

---

### CU-17: Ajustar Inventario
**Actor:** Administrador, Supervisor  
**Precondición:** Permiso "gestionar-inventario"  
**Flujo Principal:**
1. Usuario accede a producto
2. Usuario hace clic en "Ajustar Stock"
3. Sistema muestra:
   - Stock actual en sistema
   - Stock físico contado
4. Usuario ingresa stock físico real
5. Sistema calcula diferencia
6. Sistema solicita motivo del ajuste
7. Usuario ingresa justificación
8. Sistema registra ajuste
9. Sistema actualiza inventario
10. Sistema notifica a administrador (si diferencia > 10%)

**Flujo Alternativo:**
- 5a. Diferencia significativa: Sistema requiere aprobación de supervisor

**Postcondición:** Inventario ajustado y registrado

---

### CU-18: Generar Alerta de Stock Mínimo
**Actor:** Sistema (Automatizado)  
**Precondición:** Productos con stock mínimo configurado  
**Flujo Principal:**
1. Sistema ejecuta tarea programada (diaria)
2. Sistema consulta productos
3. Para cada producto:
   - Compara stock actual con stock mínimo
   - Si stock actual ≤ stock mínimo:
     * Sistema crea notificación
     * Sistema envía email a almacenero
     * Sistema marca producto en dashboard
4. Sistema genera reporte de productos críticos

**Postcondición:** Alertas generadas y enviadas

---

## 4️⃣ MÓDULO: GESTIÓN DE COMPRAS Y PROVEEDORES

### CU-19: Registrar Proveedor
**Actor:** Almacenero, Administrador  
**Precondición:** Permiso "crear-proveedores"  
**Flujo Principal:**
1. Usuario accede a módulo de proveedores
2. Usuario hace clic en "Nuevo Proveedor"
3. Sistema muestra formulario
4. Usuario ingresa datos:
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
5. Sistema valida RUC único
6. Sistema consulta SUNAT (opcional)
7. Sistema guarda proveedor

**Flujo Alternativo:**
- 5a. RUC duplicado: Sistema muestra error
- 6a. RUC no encontrado en SUNAT: Sistema permite continuar

**Postcondición:** Proveedor registrado

---

### CU-20: Crear Orden de Compra
**Actor:** Almacenero  
**Precondición:** Proveedor y productos deben existir  
**Flujo Principal:**
1. Almacenero accede a "Compras"
2. Almacenero hace clic en "Nueva Compra"
3. Sistema muestra formulario
4. Almacenero selecciona:
   - Tipo de compra (productos, insumos, equipos, servicios)
   - Proveedor
   - Fecha de compra
   - Fecha de entrega esperada
5. Almacenero agrega productos:
   - Selecciona producto
   - Ingresa cantidad
   - Ingresa precio unitario
   - Sistema calcula subtotal
6. Almacenero puede agregar múltiples productos
7. Sistema calcula:
   - Subtotal
   - IGV (18%)
   - Total
8. Almacenero ingresa descuento (opcional)
9. Sistema recalcula total
10. Almacenero guarda orden
11. Sistema genera número de orden
12. Sistema cambia estado a "Pendiente"

**Flujo Alternativo:**
- 5a. Producto no disponible: Sistema permite buscarlo o crearlo

**Postcondición:** Orden de compra creada con estado "Pendiente"

---

### CU-21: Recepcionar Orden de Compra
**Actor:** Almacenero  
**Precondición:** Orden debe estar en estado "Pendiente"  
**Flujo Principal:**
1. Almacenero accede a orden de compra
2. Almacenero hace clic en "Recepcionar"
3. Sistema muestra productos ordenados
4. Para cada producto:
   - Almacenero verifica cantidad recibida
   - Almacenero verifica calidad
   - Almacenero puede ajustar cantidad si hay diferencia
   - Almacenero ingresa fecha de vencimiento (si aplica)
5. Sistema solicita confirmación
6. Almacenero confirma recepción
7. Sistema actualiza estado a "Recibida"
8. Sistema genera movimientos de inventario (entradas)
9. Sistema actualiza stock de productos
10. Sistema genera entradas en kardex

**Flujo Alternativo:**
- 4a. Cantidad recibida < cantidad ordenada: Sistema marca diferencia
- 4b. Producto en mal estado: Almacenero puede rechazar parcialmente

**Postcondición:** Orden recepcionada, inventario actualizado

---

### CU-22: Anular Orden de Compra
**Actor:** Administrador  
**Precondición:** Orden no debe estar recepcionada  
**Flujo Principal:**
1. Administrador accede a orden
2. Administrador hace clic en "Anular"
3. Sistema solicita motivo
4. Administrador ingresa justificación
5. Sistema verifica que no esté recepcionada
6. Sistema cambia estado a "Anulada"
7. Sistema registra en auditoría

**Flujo Alternativo:**
- 5a. Orden ya recepcionada: Sistema no permite anulación

**Postcondición:** Orden anulada

---

## 5️⃣ MÓDULO: GESTIÓN DE MENÚS Y RECETAS

### CU-23: Crear Receta
**Actor:** Supervisor, Administrador  
**Precondición:** Productos/insumos deben existir  
**Flujo Principal:**
1. Usuario accede a "Recetas"
2. Usuario hace clic en "Nueva Receta"
3. Sistema muestra formulario
4. Usuario ingresa:
   - Nombre de la receta
   - Descripción
   - Categoría (entrada, plato principal, postre, bebida)
   - Tiempo de preparación
   - Porciones que rinde
   - Imagen (opcional)
   - Instrucciones de preparación
5. Usuario agrega ingredientes:
   - Selecciona producto/insumo
   - Ingresa cantidad necesaria
   - Sistema muestra unidad de medida
   - Sistema muestra stock disponible
6. Usuario puede agregar múltiples ingredientes
7. Sistema calcula:
   - Costo total de la receta
   - Costo por porción
   - Disponibilidad según stock actual
8. Usuario guarda receta
9. Sistema valida que tenga al menos 1 ingrediente

**Flujo Alternativo:**
- 5a. Stock insuficiente: Sistema muestra advertencia

**Postcondición:** Receta creada y disponible para menús

---

### CU-24: Editar Receta
**Actor:** Supervisor, Administrador  
**Precondición:** Receta debe existir  
**Flujo Principal:**
1. Usuario busca receta
2. Usuario hace clic en "Editar"
3. Sistema muestra formulario con datos actuales
4. Usuario modifica información
5. Usuario puede agregar/quitar/modificar ingredientes
6. Sistema recalcula costos
7. Sistema valida cambios
8. Sistema actualiza receta
9. Si receta está en menús activos: Sistema notifica cambios

**Postcondición:** Receta actualizada

---

### CU-25: Crear Menú Diario
**Actor:** Supervisor, Administrador  
**Precondición:** Recetas deben existir  
**Flujo Principal:**
1. Usuario accede a "Menús"
2. Usuario hace clic en "Crear Menú"
3. Sistema muestra formulario
4. Usuario ingresa:
   - Fecha del menú
   - Tipo de menú (desayuno, almuerzo, cena)
   - Nombre/descripción
5. Usuario agrega platos/recetas:
   - Entrada (opcional)
   - Plato principal
   - Guarniciones
   - Postre (opcional)
   - Bebida (opcional)
6. Para cada receta seleccionada:
   - Sistema verifica disponibilidad de ingredientes
   - Sistema muestra alertas si stock insuficiente
   - Sistema calcula porciones disponibles
7. Usuario define:
   - Cantidad estimada de comensales
   - Precio (si aplica)
   - Estado (activo/inactivo)
8. Sistema calcula:
   - Costo total del menú
   - Costo por porción
   - Ingredientes totales necesarios
9. Usuario guarda menú
10. Sistema reserva ingredientes (opcional)

**Flujo Alternativo:**
- 6a. Stock insuficiente para algún ingrediente: Sistema sugiere recetas alternativas
- 3a. Ya existe menú para esa fecha/tipo: Sistema solicita confirmación

**Postcondición:** Menú creado y disponible

---

### CU-26: Activar/Desactivar Menú
**Actor:** Supervisor, Administrador  
**Precondición:** Menú debe existir  
**Flujo Principal:**
1. Usuario accede a lista de menús
2. Usuario selecciona menú
3. Usuario hace clic en "Cambiar Estado"
4. Sistema verifica:
   - Fecha del menú (no debe ser pasada)
   - Disponibilidad de ingredientes
5. Sistema cambia estado
6. Si se activa: Sistema reserva ingredientes
7. Si se desactiva: Sistema libera ingredientes reservados

**Flujo Alternativo:**
- 4a. Ingredientes insuficientes: Sistema no permite activación

**Postcondición:** Estado del menú actualizado

---

### CU-27: Verificar Disponibilidad de Menú
**Actor:** Sistema (Automatizado), Usuarios  
**Precondición:** Menú debe estar activo  
**Flujo Principal:**
1. Sistema ejecuta verificación:
   - Automáticamente cada hora
   - Manualmente cuando usuario consulta
2. Para cada receta del menú:
   - Sistema verifica stock de cada ingrediente
   - Sistema compara con cantidad necesaria
   - Sistema calcula porciones disponibles
3. Sistema determina estado:
   - "Disponible" si todos los ingredientes están
   - "Disponible Parcialmente" si faltan algunos
   - "No Disponible" si faltan ingredientes críticos
4. Sistema actualiza estado del menú
5. Si cambia a "No Disponible": Sistema notifica supervisor

**Postcondición:** Disponibilidad actualizada

---

## 6️⃣ MÓDULO: REGISTRO DE CONSUMOS

### CU-28: Registrar Consumo Individual
**Actor:** Personal de Atención, Supervisor  
**Precondición:** Menú activo y trabajador registrado  
**Flujo Principal:**
1. Usuario accede a "Registrar Consumo"
2. Sistema muestra menús activos del día
3. Usuario selecciona tipo de menú (desayuno/almuerzo/cena)
4. Sistema muestra información del menú
5. Usuario busca trabajador:
   - Por DNI
   - Por nombre
   - Escaneando código (QR/barras)
6. Sistema valida trabajador:
   - Existe en sistema
   - Está activo
   - No ha consumido ese menú hoy
7. Sistema muestra datos del trabajador
8. Usuario confirma consumo
9. Sistema registra:
   - Trabajador
   - Menú consumido
   - Fecha y hora
   - Usuario que registró
   - Ubicación (opcional)
10. Sistema descuenta ingredientes del stock
11. Sistema muestra confirmación

**Flujo Alternativo:**
- 6a. Trabajador no encontrado: Sistema permite registrar datos básicos
- 6b. Trabajador ya consumió: Sistema muestra alerta y no permite duplicado
- 5a. DNI inválido: Sistema integra con RENIEC para validar

**Postcondición:** Consumo registrado, stock actualizado

---

### CU-29: Registrar Consumo Masivo
**Actor:** Supervisor, Administrador  
**Precondición:** Menú activo y lista de trabajadores  
**Flujo Principal:**
1. Usuario accede a "Consumo Masivo"
2. Sistema muestra menús activos
3. Usuario selecciona menú
4. Usuario carga archivo Excel con DNIs o:
   - Usuario selecciona área/departamento
   - Sistema lista trabajadores
5. Usuario revisa lista de trabajadores
6. Usuario puede agregar/quitar trabajadores
7. Usuario confirma consumo masivo
8. Sistema procesa cada registro:
   - Valida trabajador
   - Verifica que no haya consumido
   - Registra consumo
9. Sistema muestra resumen:
   - Consumos exitosos
   - Errores (duplicados, no encontrados)
10. Sistema descuenta ingredientes proporcionalmente
11. Sistema genera reporte

**Flujo Alternativo:**
- 8a. Algunos trabajadores ya consumieron: Sistema los omite y continúa

**Postcondición:** Consumos masivos registrados

---

### CU-30: Consultar Historial de Consumos
**Actor:** Supervisor, Administrador, Personal de RR.HH.  
**Precondición:** Debe haber consumos registrados  
**Flujo Principal:**
1. Usuario accede a "Consumos"
2. Sistema muestra filtros:
   - Rango de fechas
   - Trabajador específico
   - Tipo de menú
   - Área/departamento
3. Usuario aplica filtros
4. Sistema muestra tabla con:
   - Fecha y hora
   - Trabajador
   - Menú consumido
   - Usuario que registró
5. Usuario puede:
   - Ver detalles del consumo
   - Exportar a Excel/PDF
   - Generar estadísticas

**Postcondición:** Información consultada

---

### CU-31: Anular Consumo
**Actor:** Supervisor, Administrador  
**Precondición:** Consumo debe existir y ser del día actual  
**Flujo Principal:**
1. Usuario busca consumo a anular
2. Usuario hace clic en "Anular"
3. Sistema verifica que sea del día actual
4. Sistema solicita motivo
5. Usuario ingresa justificación
6. Sistema confirma anulación
7. Sistema revierte descuento de ingredientes
8. Sistema marca consumo como anulado
9. Sistema registra en auditoría

**Flujo Alternativo:**
- 3a. Consumo de días anteriores: Sistema no permite anulación directa

**Postcondición:** Consumo anulado, stock devuelto

---

## 7️⃣ MÓDULO: GESTIÓN DE PERSONAL

### CU-32: Registrar Trabajador
**Actor:** Personal de RR.HH., Administrador  
**Precondición:** Permiso "crear-trabajadores"  
**Flujo Principal:**
1. Usuario accede a "Personal"
2. Usuario hace clic en "Nuevo Trabajador"
3. Sistema muestra formulario
4. Usuario ingresa DNI
5. Sistema integra con RENIEC:
   - Consulta datos del DNI
   - Obtiene nombre completo, fecha de nacimiento
6. Sistema auto-completa datos personales
7. Usuario completa/corrige información:
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
8. Sistema valida DNI único
9. Sistema guarda trabajador
10. Sistema genera código de empleado

**Flujo Alternativo:**
- 5a. DNI no encontrado en RENIEC: Usuario ingresa datos manualmente
- 8a. DNI duplicado: Sistema muestra error

**Postcondición:** Trabajador registrado

---

### CU-33: Editar Trabajador
**Actor:** Personal de RR.HH., Administrador  
**Precondición:** Trabajador debe existir  
**Flujo Principal:**
1. Usuario busca trabajador
2. Usuario hace clic en "Editar"
3. Sistema muestra formulario con datos actuales
4. Usuario modifica información
5. Sistema valida cambios
6. Sistema actualiza trabajador
7. Si cambió área/cargo: Sistema notifica a supervisor

**Postcondición:** Trabajador actualizado

---

### CU-34: Desactivar Trabajador
**Actor:** Personal de RR.HH., Administrador  
**Precondición:** Trabajador activo  
**Flujo Principal:**
1. Usuario accede a ficha de trabajador
2. Usuario hace clic en "Desactivar"
3. Sistema solicita:
   - Fecha de cese
   - Motivo
4. Usuario ingresa información
5. Sistema confirma desactivación
6. Sistema cambia estado a "Inactivo"
7. Sistema finaliza contrato activo (si existe)
8. Si trabajador tiene usuario: Sistema desactiva cuenta

**Postcondición:** Trabajador desactivado

---

### CU-35: Consultar Datos de Trabajador
**Actor:** Personal de RR.HH., Supervisor, Administrador  
**Precondición:** Trabajador registrado  
**Flujo Principal:**
1. Usuario busca trabajador por:
   - DNI
   - Nombre
   - Código de empleado
   - Área
2. Sistema muestra resultados
3. Usuario selecciona trabajador
4. Sistema muestra ficha completa:
   - Datos personales
   - Datos laborales
   - Contratos (histórico)
   - Certificados médicos
   - Historial de consumos
   - Usuario del sistema (si tiene)
5. Usuario puede imprimir ficha

**Postcondición:** Información consultada

---

## 8️⃣ MÓDULO: GESTIÓN DE CONTRATOS LABORALES

### CU-36: Crear Contrato Laboral
**Actor:** Personal de RR.HH., Administrador  
**Precondición:** Trabajador debe existir y plantilla de contrato disponible  
**Flujo Principal:**
1. Usuario accede a trabajador
2. Usuario hace clic en "Nuevo Contrato"
3. Sistema muestra formulario
4. Usuario ingresa:
   - Tipo de contrato (plazo fijo, indefinido, por obra)
   - Fecha de inicio
   - Fecha de fin (si es temporal)
   - Cargo específico
   - Salario mensual
   - Beneficios
   - Horario de trabajo
   - Condiciones especiales
5. Usuario selecciona plantilla de contrato
6. Sistema genera vista previa del contrato con datos
7. Usuario revisa y confirma
8. Sistema genera documento PDF
9. Sistema guarda contrato con estado "Pendiente de Firma"
10. Sistema puede enviar por email al trabajador

**Flujo Alternativo:**
- 5a. No hay plantillas: Usuario debe crear una primero

**Postcondición:** Contrato creado en estado "Pendiente"

---

### CU-37: Generar PDF de Contrato
**Actor:** Personal de RR.HH.  
**Precondición:** Contrato debe existir con plantilla  
**Flujo Principal:**
1. Usuario accede a contrato
2. Usuario hace clic en "Generar PDF"
3. Sistema carga plantilla seleccionada
4. Sistema reemplaza variables:
   - {nombre_trabajador}
   - {dni}
   - {fecha_inicio}
   - {fecha_fin}
   - {cargo}
   - {salario}
   - {fecha_actual}
   - etc.
5. Sistema genera documento PDF
6. Sistema muestra vista previa
7. Usuario puede:
   - Descargar
   - Imprimir
   - Enviar por email

**Postcondición:** PDF generado

---

### CU-38: Subir Contrato Firmado
**Actor:** Personal de RR.HH.  
**Precondición:** Contrato generado previamente  
**Flujo Principal:**
1. Usuario accede a contrato
2. Usuario hace clic en "Subir Contrato Firmado"
3. Sistema muestra formulario de carga
4. Usuario selecciona archivo PDF escaneado
5. Sistema valida formato (PDF, tamaño máximo)
6. Usuario sube archivo
7. Sistema guarda documento
8. Sistema cambia estado a "Firmado"
9. Sistema registra fecha de firma

**Postcondición:** Contrato firmado registrado

---

### CU-39: Activar Contrato
**Actor:** Personal de RR.HH., Administrador  
**Precondición:** Contrato en estado "Firmado"  
**Flujo Principal:**
1. Usuario accede a contrato
2. Usuario hace clic en "Activar Contrato"
3. Sistema verifica:
   - Contrato firmado
   - Fecha de inicio (hoy o futura)
   - No hay contratos activos del mismo trabajador
4. Sistema cambia estado a "Activo"
5. Sistema registra fecha de activación
6. Si trabajador estaba inactivo: Sistema reactiva

**Flujo Alternativo:**
- 3a. Ya existe contrato activo: Sistema sugiere finalizar el anterior

**Postcondición:** Contrato activo y vigente

---

### CU-40: Finalizar Contrato
**Actor:** Personal de RR.HH., Administrador  
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
6. Sistema cambia estado a "Finalizado"
7. Sistema registra fecha de finalización
8. Sistema puede generar liquidación (futuro)

**Postcondición:** Contrato finalizado

---

### CU-41: Crear Plantilla de Contrato
**Actor:** Administrador  
**Precondición:** Permiso de configuración  
**Flujo Principal:**
1. Administrador accede a "Plantillas de Contrato"
2. Administrador hace clic en "Nueva Plantilla"
3. Sistema muestra editor
4. Administrador ingresa:
   - Nombre de la plantilla
   - Tipo de contrato (plazo fijo, indefinido, etc.)
   - Descripción
5. Administrador escribe contenido del contrato usando variables:
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
6. Sistema muestra lista de variables disponibles
7. Administrador puede formatear texto (negrita, cursiva, etc.)
8. Administrador guarda plantilla
9. Sistema valida sintaxis de variables

**Postcondición:** Plantilla creada y disponible

---

### CU-42: Consultar Contratos por Vencer
**Actor:** Personal de RR.HH., Administrador  
**Precondición:** Contratos activos existentes  
**Flujo Principal:**
1. Usuario accede a "Contratos por Vencer"
2. Sistema filtra contratos:
   - Estado: Activo
   - Fecha fin <= (hoy + 30 días)
3. Sistema muestra lista con:
   - Trabajador
   - Tipo de contrato
   - Fecha de inicio
   - Fecha de fin
   - Días restantes
4. Sistema marca con colores:
   - Rojo: Vence en menos de 7 días
   - Amarillo: Vence en 7-15 días
   - Verde: Vence en 16-30 días
5. Usuario puede:
   - Ver detalle del contrato
   - Renovar contrato
   - Exportar lista

**Postcondición:** Lista consultada

---

## 9️⃣ MÓDULO: CERTIFICADOS MÉDICOS

### CU-43: Registrar Certificado Médico
**Actor:** Personal de RR.HH., Supervisor  
**Precondición:** Trabajador debe existir  
**Flujo Principal:**
1. Usuario accede a trabajador
2. Usuario hace clic en "Nuevo Certificado Médico"
3. Sistema muestra formulario
4. Usuario ingresa:
   - Tipo de examen (pre-ocupacional, anual, por cambio de puesto)
   - Fecha del examen
   - Institución/clínica
   - Médico evaluador
   - Resultado (apto, no apto, apto con restricciones)
   - Restricciones (si aplica)
   - Fecha de vencimiento
   - Observaciones
5. Usuario sube documento PDF (opcional)
6. Sistema valida fechas
7. Sistema guarda certificado
8. Si resultado es "No Apto": Sistema genera alerta

**Flujo Alternativo:**
- 8a. Resultado "No Apto": Sistema sugiere desactivar trabajador

**Postcondición:** Certificado registrado

---

### CU-44: Consultar Certificados por Vencer
**Actor:** Personal de RR.HH.  
**Precondición:** Certificados registrados  
**Flujo Principal:**
1. Usuario accede a "Certificados por Vencer"
2. Sistema filtra certificados:
   - Fecha vencimiento <= (hoy + 30 días)
   - Trabajador activo
3. Sistema muestra lista
4. Sistema marca con colores según días restantes
5. Usuario puede:
   - Ver detalle
   - Renovar certificado
   - Notificar a trabajador

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
**Total de Casos de Uso:** 57  
**Total de Actores:** 7 (5 humanos + 2 de sistema)

