# 🎯 GUÍA RÁPIDA PARA STARUML - SISTEMA CESODO

## 📋 RESUMEN EJECUTIVO

**Sistema:** CESODO - Sistema de Gestión para Comedores  
**Total Casos de Uso:** 57  
**Total Actores:** 7  
**Total Módulos:** 12  

---

## 👥 ACTORES

### Actor Principal
```
🔴 Administrador
   - Tipo: Usuario Interno
   - Rol: Gestión completa del sistema
   - Acceso: Todos los módulos
```

### Actores Secundarios
```
🟡 Almacenero
   - Tipo: Usuario Interno
   - Rol: Gestión de inventarios y compras
   - Acceso: Productos, Inventario, Compras, Proveedores

🟡 Supervisor
   - Tipo: Usuario Interno
   - Rol: Supervisión operativa
   - Acceso: Menús, Recetas, Consumos, Reportes

🟡 Personal de RR.HH.
   - Tipo: Usuario Interno
   - Rol: Gestión de personal
   - Acceso: Trabajadores, Contratos, Certificados

🟢 Personal de Atención
   - Tipo: Usuario Interno
   - Rol: Registro de consumos
   - Acceso: Solo módulo de consumos

🔵 Sistema RENIEC
   - Tipo: Sistema Externo
   - Rol: Validación de identidad
   - Interfaz: API REST

🔵 Sistema (Automatizado)
   - Tipo: Sistema Interno
   - Rol: Tareas programadas
   - Funciones: Alertas, verificaciones, notificaciones
```

---

## 📦 PAQUETES DE CASOS DE USO

### Paquete 1: Autenticación y Seguridad
```
[Autenticación y Seguridad]
│
├── CU-01: Iniciar Sesión
│   Actores: Todos los usuarios
│   Complejidad: Baja
│   Prioridad: Alta
│
├── CU-02: Cerrar Sesión
│   Actores: Todos los usuarios
│   Complejidad: Baja
│   Prioridad: Alta
│
├── CU-03: Recuperar Contraseña
│   Actores: Todos los usuarios
│   Complejidad: Media
│   Prioridad: Alta
│
└── CU-04: Cambiar Contraseña
    Actores: Todos los usuarios
    Complejidad: Baja
    Prioridad: Media
```

### Paquete 2: Gestión de Usuarios y Roles
```
[Gestión de Usuarios]
│
├── CU-05: Crear Usuario
│   Actores: Administrador
│   Complejidad: Media
│   Prioridad: Alta
│   Include: Validar Email, Generar Contraseña
│
├── CU-06: Editar Usuario
│   Actores: Administrador
│   Complejidad: Media
│   Prioridad: Alta
│
├── CU-07: Eliminar Usuario
│   Actores: Administrador
│   Complejidad: Baja
│   Prioridad: Media
│
├── CU-08: Gestionar Roles
│   Actores: Administrador
│   Complejidad: Alta
│   Prioridad: Alta
│
├── CU-09: Crear Rol Personalizado
│   Actores: Administrador
│   Complejidad: Media
│   Prioridad: Media
│
└── CU-10: Clonar Rol
    Actores: Administrador
    Complejidad: Baja
    Prioridad: Baja
```

### Paquete 3: Gestión de Productos e Inventario
```
[Gestión de Inventario]
│
├── CU-11: Registrar Producto
│   Actores: Administrador, Almacenero
│   Complejidad: Media
│   Prioridad: Alta
│
├── CU-12: Editar Producto
│   Actores: Administrador, Almacenero
│   Complejidad: Media
│   Prioridad: Alta
│
├── CU-13: Eliminar Producto
│   Actores: Administrador
│   Complejidad: Alta
│   Prioridad: Media
│   Extend: Verificar Dependencias
│
├── CU-14: Registrar Entrada de Inventario
│   Actores: Almacenero
│   Complejidad: Alta
│   Prioridad: Alta
│   Include: Actualizar Stock, Generar Kardex
│
├── CU-15: Registrar Salida de Inventario
│   Actores: Almacenero
│   Complejidad: Alta
│   Prioridad: Alta
│   Include: Validar Stock, Actualizar Stock, Generar Kardex
│   Extend: Generar Alerta Stock Mínimo
│
├── CU-16: Consultar Kardex
│   Actores: Administrador, Almacenero, Supervisor
│   Complejidad: Media
│   Prioridad: Alta
│
├── CU-17: Ajustar Inventario
│   Actores: Administrador, Supervisor
│   Complejidad: Alta
│   Prioridad: Alta
│   Include: Registrar Auditoría
│
└── CU-18: Generar Alerta de Stock Mínimo
    Actores: Sistema
    Complejidad: Media
    Prioridad: Alta
    Tipo: Automatizado
```

### Paquete 4: Gestión de Compras y Proveedores
```
[Gestión de Compras]
│
├── CU-19: Registrar Proveedor
│   Actores: Administrador, Almacenero
│   Complejidad: Media
│   Prioridad: Alta
│   Extend: Consultar SUNAT
│
├── CU-20: Crear Orden de Compra
│   Actores: Almacenero
│   Complejidad: Alta
│   Prioridad: Alta
│   Include: Calcular Totales
│
├── CU-21: Recepcionar Orden de Compra
│   Actores: Almacenero
│   Complejidad: Alta
│   Prioridad: Alta
│   Include: Registrar Entrada Inventario
│
└── CU-22: Anular Orden de Compra
    Actores: Administrador
    Complejidad: Media
    Prioridad: Media
    Include: Registrar Auditoría
```

### Paquete 5: Gestión de Menús y Recetas
```
[Gestión de Menús]
│
├── CU-23: Crear Receta
│   Actores: Administrador, Supervisor
│   Complejidad: Alta
│   Prioridad: Alta
│   Include: Calcular Costo
│
├── CU-24: Editar Receta
│   Actores: Administrador, Supervisor
│   Complejidad: Alta
│   Prioridad: Alta
│   Include: Recalcular Costo
│
├── CU-25: Crear Menú Diario
│   Actores: Administrador, Supervisor
│   Complejidad: Alta
│   Prioridad: Alta
│   Include: Verificar Disponibilidad
│
├── CU-26: Activar/Desactivar Menú
│   Actores: Administrador, Supervisor
│   Complejidad: Media
│   Prioridad: Alta
│   Include: Reservar Ingredientes
│
└── CU-27: Verificar Disponibilidad de Menú
    Actores: Sistema, Usuarios
    Complejidad: Alta
    Prioridad: Alta
    Tipo: Automatizado/Manual
```

### Paquete 6: Registro de Consumos
```
[Registro de Consumos]
│
├── CU-28: Registrar Consumo Individual
│   Actores: Personal de Atención, Supervisor
│   Complejidad: Alta
│   Prioridad: Crítica
│   Include: Buscar Trabajador, Actualizar Stock
│   Extend: Validar con RENIEC
│
├── CU-29: Registrar Consumo Masivo
│   Actores: Supervisor, Administrador
│   Complejidad: Alta
│   Prioridad: Alta
│   Generalización de: CU-28
│
├── CU-30: Consultar Historial de Consumos
│   Actores: Supervisor, Administrador, RR.HH.
│   Complejidad: Media
│   Prioridad: Alta
│
└── CU-31: Anular Consumo
    Actores: Supervisor, Administrador
    Complejidad: Media
    Prioridad: Alta
    Include: Revertir Stock
```

### Paquete 7: Gestión de Personal
```
[Gestión de Personal]
│
├── CU-32: Registrar Trabajador
│   Actores: Personal de RR.HH., Administrador
│   Complejidad: Alta
│   Prioridad: Alta
│   Include: Consultar RENIEC, Generar Código
│
├── CU-33: Editar Trabajador
│   Actores: Personal de RR.HH., Administrador
│   Complejidad: Media
│   Prioridad: Alta
│
├── CU-34: Desactivar Trabajador
│   Actores: Personal de RR.HH., Administrador
│   Complejidad: Media
│   Prioridad: Alta
│   Include: Finalizar Contrato
│
└── CU-35: Consultar Datos de Trabajador
    Actores: Personal de RR.HH., Supervisor, Administrador
    Complejidad: Baja
    Prioridad: Media
```

### Paquete 8: Gestión de Contratos Laborales
```
[Gestión de Contratos]
│
├── CU-36: Crear Contrato Laboral
│   Actores: Personal de RR.HH., Administrador
│   Complejidad: Alta
│   Prioridad: Alta
│   Include: Seleccionar Plantilla, Generar PDF
│
├── CU-37: Generar PDF de Contrato
│   Actores: Personal de RR.HH.
│   Complejidad: Media
│   Prioridad: Alta
│   Include: Reemplazar Variables
│
├── CU-38: Subir Contrato Firmado
│   Actores: Personal de RR.HH.
│   Complejidad: Baja
│   Prioridad: Alta
│
├── CU-39: Activar Contrato
│   Actores: Personal de RR.HH., Administrador
│   Complejidad: Media
│   Prioridad: Alta
│   Include: Validar Estado Trabajador
│
├── CU-40: Finalizar Contrato
│   Actores: Personal de RR.HH., Administrador
│   Complejidad: Media
│   Prioridad: Alta
│
├── CU-41: Crear Plantilla de Contrato
│   Actores: Administrador
│   Complejidad: Alta
│   Prioridad: Media
│
└── CU-42: Consultar Contratos por Vencer
    Actores: Personal de RR.HH., Administrador
    Complejidad: Media
    Prioridad: Alta
    Tipo: Consulta + Automatizado
```

### Paquete 9: Certificados Médicos
```
[Certificados Médicos]
│
├── CU-43: Registrar Certificado Médico
│   Actores: Personal de RR.HH., Supervisor
│   Complejidad: Media
│   Prioridad: Alta
│   Extend: Generar Alerta No Apto
│
├── CU-44: Consultar Certificados por Vencer
│   Actores: Personal de RR.HH.
│   Complejidad: Baja
│   Prioridad: Alta
│
└── CU-45: Renovar Certificado Médico
    Actores: Personal de RR.HH.
    Complejidad: Media
    Prioridad: Alta
```

### Paquete 10: Reportes y Estadísticas
```
[Reportes]
│
├── CU-46: Generar Reporte de Consumos
│   Actores: Supervisor, Administrador
│   Complejidad: Alta
│   Prioridad: Alta
│   Include: Procesar Datos, Generar Gráficos
│
├── CU-47: Generar Reporte de Inventario
│   Actores: Almacenero, Administrador
│   Complejidad: Alta
│   Prioridad: Alta
│   Include: Calcular Valorización
│
├── CU-48: Generar Reporte de Compras
│   Actores: Almacenero, Administrador
│   Complejidad: Alta
│   Prioridad: Alta
│
└── CU-49: Ver Dashboard de Estadísticas
    Actores: Todos los usuarios
    Complejidad: Alta
    Prioridad: Alta
    Include: Cargar Widgets según Rol
```

### Paquete 11: Configuraciones del Sistema
```
[Configuraciones]
│
├── CU-50: Configurar Datos de Empresa
│   Actores: Administrador
│   Complejidad: Media
│   Prioridad: Alta
│   Include: Actualizar Plantillas
│
├── CU-51: Configurar Parámetros del Sistema
│   Actores: Administrador
│   Complejidad: Media
│   Prioridad: Alta
│
├── CU-52: Configurar Notificaciones
│   Actores: Administrador
│   Complejidad: Alta
│   Prioridad: Media
│   Include: Programar Tareas
│
├── CU-53: Gestionar Permisos Personalizados
│   Actores: Administrador
│   Complejidad: Alta
│   Prioridad: Alta
│   Include: Aplicar a Usuarios
│
├── CU-54: Limpiar Caché del Sistema
│   Actores: Administrador
│   Complejidad: Baja
│   Prioridad: Baja
│
└── CU-55: Optimizar Sistema
    Actores: Administrador
    Complejidad: Media
    Prioridad: Baja
```

### Paquete 12: Auditoría y Logs
```
[Auditoría]
│
├── CU-56: Consultar Log de Actividades
│   Actores: Administrador
│   Complejidad: Media
│   Prioridad: Alta
│
└── CU-57: Ver Historial de Cambios
    Actores: Administrador, Supervisor
    Complejidad: Media
    Prioridad: Media
```

---

## 🔗 RELACIONES PRINCIPALES

### Relaciones INCLUDE (<<include>>)
```
CU-28 (Registrar Consumo) INCLUDE Buscar Trabajador
CU-28 (Registrar Consumo) INCLUDE Actualizar Stock
CU-14 (Entrada Inventario) INCLUDE Generar Kardex
CU-15 (Salida Inventario) INCLUDE Generar Kardex
CU-15 (Salida Inventario) INCLUDE Validar Stock
CU-20 (Crear Orden Compra) INCLUDE Calcular Totales
CU-21 (Recepcionar Orden) INCLUDE Registrar Entrada Inventario
CU-23 (Crear Receta) INCLUDE Calcular Costo
CU-25 (Crear Menú) INCLUDE Verificar Disponibilidad
CU-26 (Activar Menú) INCLUDE Reservar Ingredientes
CU-32 (Registrar Trabajador) INCLUDE Consultar RENIEC
CU-32 (Registrar Trabajador) INCLUDE Generar Código
CU-36 (Crear Contrato) INCLUDE Seleccionar Plantilla
CU-36 (Crear Contrato) INCLUDE Generar PDF
CU-37 (Generar PDF) INCLUDE Reemplazar Variables
CU-39 (Activar Contrato) INCLUDE Validar Estado Trabajador
CU-46 (Reporte Consumos) INCLUDE Procesar Datos
CU-46 (Reporte Consumos) INCLUDE Generar Gráficos
CU-50 (Config Empresa) INCLUDE Actualizar Plantillas
CU-52 (Config Notificaciones) INCLUDE Programar Tareas
CU-53 (Gestionar Permisos) INCLUDE Aplicar a Usuarios
```

### Relaciones EXTEND (<<extend>>)
```
Validar con RENIEC EXTEND CU-28 (Registrar Consumo)
Consultar SUNAT EXTEND CU-19 (Registrar Proveedor)
Verificar Dependencias EXTEND CU-13 (Eliminar Producto)
Generar Alerta Stock Mínimo EXTEND CU-15 (Salida Inventario)
Generar Alerta No Apto EXTEND CU-43 (Registrar Certificado)
Sugerir Recetas Alternativas EXTEND CU-25 (Crear Menú)
```

### Relaciones de GENERALIZACIÓN
```
Usuario (Actor Genérico)
  ├── Administrador
  ├── Almacenero
  ├── Supervisor
  ├── Personal de Atención
  └── Personal de RR.HH.

Registrar Consumo (CU Base)
  └── Registrar Consumo Masivo (CU-29)
```

---

## 🎨 PASOS PARA CREAR EN STARUML

### Paso 1: Configurar Proyecto
```
1. Crear nuevo proyecto UML
2. Nombre: "Sistema CESODO - Casos de Uso"
3. Tipo: Use Case Diagram
```

### Paso 2: Crear Actores
```
1. Agregar Actor "Usuario" (abstracto)
2. Agregar 5 actores heredando de Usuario:
   - Administrador (Stick Figure)
   - Almacenero (Stick Figure)
   - Supervisor (Stick Figure)
   - Personal de Atención (Stick Figure)
   - Personal de RR.HH. (Stick Figure)

3. Agregar 2 actores externos:
   - Sistema RENIEC (Robot/External)
   - Sistema (Robot/Internal)

4. Conectar herencias con líneas de generalización
```

### Paso 3: Crear Paquetes
```
Crear 12 paquetes (uno por módulo):
1. Package: "Autenticación y Seguridad"
2. Package: "Gestión de Usuarios"
3. Package: "Gestión de Inventario"
4. Package: "Gestión de Compras"
5. Package: "Gestión de Menús"
6. Package: "Registro de Consumos"
7. Package: "Gestión de Personal"
8. Package: "Gestión de Contratos"
9. Package: "Certificados Médicos"
10. Package: "Reportes"
11. Package: "Configuraciones"
12. Package: "Auditoría"
```

### Paso 4: Agregar Casos de Uso
```
Dentro de cada paquete, agregar los casos de uso:
- Usar forma elíptica
- Nombrar con formato: "CU-XX: Nombre del Caso"
- Agregar estereotipos donde corresponda:
  * <<automatizado>> para casos del sistema
  * <<crítico>> para casos de alta prioridad
```

### Paso 5: Conectar Relaciones
```
1. Asociaciones Actor-CU (línea simple)
   - Conectar cada actor con sus casos de uso

2. Include (línea punteada con flecha abierta)
   - Etiqueta: <<include>>
   - Dirección: Del CU base al CU incluido

3. Extend (línea punteada con flecha abierta)
   - Etiqueta: <<extend>>
   - Dirección: Del CU extensor al CU base

4. Generalizaciones (línea continua con triángulo)
   - Entre actores
   - Entre casos de uso relacionados
```

### Paso 6: Organizar Diagrama
```
Distribución sugerida:
- Actores en los laterales (izquierda y derecha)
- Paquetes en el centro, organizados por importancia
- Casos de uso críticos más visibles
- Usar colores para diferenciar módulos
```

---

## 🎨 SUGERENCIAS DE DISEÑO

### Código de Colores por Módulo
```
🔴 Autenticación: Rojo (#FF0000)
🟠 Gestión Usuarios: Naranja (#FF9900)
🟡 Inventario: Amarillo (#FFCC00)
🟢 Compras: Verde (#00CC00)
🔵 Menús: Azul (#0066CC)
🟣 Consumos: Morado (#9933CC)
🟤 Personal: Marrón (#996633)
⚫ Contratos: Negro (#333333)
🔴 Certificados: Rosa (#FF6699)
🟦 Reportes: Azul Claro (#6699FF)
⚙️ Configuraciones: Gris (#999999)
📋 Auditoría: Gris Oscuro (#666666)
```

### Prioridades Visuales
```
Crítico: Borde grueso (3px)
Alto: Borde medio (2px)
Medio: Borde normal (1px)
Bajo: Borde fino (0.5px)
```

---

## 📊 MÉTRICAS DEL SISTEMA

```
Total de Casos de Uso: 57
├── Críticos: 5 (9%)
├── Prioridad Alta: 38 (67%)
├── Prioridad Media: 11 (19%)
└── Prioridad Baja: 3 (5%)

Casos de Uso por Actor:
├── Administrador: 42 casos (74%)
├── Almacenero: 15 casos (26%)
├── Supervisor: 18 casos (32%)
├── Personal Atención: 2 casos (4%)
├── Personal RR.HH.: 13 casos (23%)
├── Sistema RENIEC: 2 integraciones
└── Sistema: 3 casos automatizados

Complejidad:
├── Alta: 25 casos (44%)
├── Media: 24 casos (42%)
└── Baja: 8 casos (14%)

Relaciones:
├── Include: 20 relaciones
├── Extend: 6 relaciones
└── Generalización: 7 relaciones
```

---

## ✅ CHECKLIST DE VALIDACIÓN

### Antes de finalizar el diagrama, verificar:

- [ ] Todos los actores están definidos
- [ ] Todos los casos de uso están nombrados correctamente
- [ ] Las relaciones include están correctamente direccionadas
- [ ] Las relaciones extend están correctamente direccionadas
- [ ] Las generalizaciones de actores son correctas
- [ ] Los casos críticos están destacados
- [ ] Los paquetes están organizados lógicamente
- [ ] Las integraciones externas están identificadas
- [ ] Los casos automatizados tienen estereotipo
- [ ] El diagrama es legible y no está sobrecargado

---

**Archivo generado para:** StarUML  
**Versión del Sistema:** CESODO v1.0  
**Fecha de Creación:** Octubre 2025  
**Estado:** Listo para implementación en StarUML

