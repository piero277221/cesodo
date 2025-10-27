# 🎯 CASO DE USO GENERAL - SISTEMA CESODO
## Gestión Integral de Servicio de Alimentación Institucional

---

## 📊 INFORMACIÓN GENERAL

**Código:** CU-GENERAL-001  
**Nombre:** Gestión Completa del Servicio de Comedor Institucional  
**Nivel:** Estratégico  
**Complejidad:** Alta  
**Prioridad:** Crítica  

---

## 👥 ACTORES

**Principales:** Fábrica Contratante, Gerente General, Encargado de Cocina, Encargado de Almacén, Encargado de Compras, Personal del Comedor  
**Secundarios:** Trabajadores, Sistema CESODO, Base de Datos

---

## 🎯 OBJETIVO

Gestionar el ciclo completo del servicio de alimentación institucional: planificación de menús, compras, preparación, registro de consumos y facturación.


---

## ✅ PRECONDICIONES

- Contrato vigente con la fábrica contratante
- Sistema operativo
- Stock base inicial en almacén
- Personal capacitado

---

## 📋 FLUJO PRINCIPAL (RESUMIDO)

### **FASE 1: PLANIFICACIÓN (Lunes)**

**1.** Fábrica Contratante envía información semanal (trabajadores, cantidad menús, restricciones)  
**2.** Gerente General recibe y distribuye información a Cocina y Almacén  
**3.** Encargado de Cocina elabora menú semanal y calcula ingredientes  
**4.** Sistema genera lista de insumos necesarios

---

### **FASE 2: COMPRAS (Lunes-Martes)**

**5.** Encargado de Almacén verifica stock disponible  
**6.** Sistema identifica productos faltantes  

**¿Stock suficiente?**
- **SÍ:** Notifica a Cocina → Ir a Fase 3
- **NO:** Continuar ↓

**7.** Encargado de Compras registra productos faltantes  
**8.** Realiza compras y entrega al almacén  
**9.** Sistema actualiza stock y notifica a Cocina

---

### **FASE 3: PREPARACIÓN (Martes-Viernes)**

**10.** Encargado de Cocina solicita ingredientes del almacén  
**11.** Sistema registra salida de stock  
**12.** Encargado de Cocina prepara menús (generales y especiales)  
**13.** Notifica al Personal del Comedor

---

### **FASE 4: ATENCIÓN Y REGISTRO (Diario: 12:00 - 14:00)**

**14.** Personal del Comedor recibe trabajadores  
**15.** Trabajador registra en hoja física: Nombre, DNI, Firma  
**16.** Personal entrega menú (general o especial según restricción)  

**¿Todos atendidos?**
- **NO:** Continuar atendiendo (volver a paso 14)
- **SÍ:** Continuar ↓

**17.** Personal recolecta hojas de consumo y las entrega al Gerente General

---

### **FASE 5: CONSOLIDACIÓN (Viernes)**

**18.** Gerente General digitaliza consumos en el sistema  
**19.** Sistema genera reporte semanal y calcula costos  
**20.** Gerente General entrega registros y factura a Fábrica Contratante

---

### **FASE 6: FACTURACIÓN Y PAGO (Siguiente Semana)**

**21.** Fábrica Contratante verifica registros  

**¿Conforme?**
- **NO:** Solicita corrección → Volver a paso 19
- **SÍ:** Continuar ↓

**22.** Fábrica realiza pago semanal  
**23.** Sistema registra pago y confirma al Gerente General  
**24.** Sistema genera reportes de cierre semanal

**🏁 FIN** - Sistema listo para nueva semana

---

## 🔀 FLUJOS ALTERNATIVOS

**FA-1: Stock Insuficiente No Resuelto**  
→ Gerente ajusta menú o busca proveedor alternativo

**FA-2: Exceso de Demanda**  
→ Cocina prepara porciones adicionales si hay ingredientes

**FA-3: Trabajador No Registrado**  
→ Personal registra con observación, Gerente valida con cliente

**FA-4: Fábrica No Paga a Tiempo**  
→ Sistema genera alerta de mora, Gerente negocia fecha o suspende servicio

**FA-5: Falla del Sistema**  
→ Activar modo manual con hojas físicas, sincronizar al restaurar

---

## 🔴 FLUJOS DE EXCEPCIÓN

**EX-1: Emergencia Sanitaria**  
→ Suspender servicio, notificar autoridades, activar plan de contingencia

**EX-2: Ausencia Personal Clave**  
→ Asignar suplente o reducir servicio

---

## ✅ POSTCONDICIONES

**Éxito:**
- ✅ Trabajadores alimentados
- ✅ Consumos registrados (físico + digital)
- ✅ Stock actualizado
- ✅ Pago recibido
- ✅ Sistema listo para nuevo ciclo

**Fallo:**
- ❌ Registros incompletos (recuperables de hojas físicas)
- ❌ Pago pendiente
- ❌ Stock desactualizado

---

## 📏 REGLAS DE NEGOCIO PRINCIPALES

**RN-01:** Menú semanal con 48h anticipación  
**RN-02:** Stock mínimo para 3 días  
**RN-03:** Registro obligatorio: Nombre + DNI + Firma  
**RN-04:** 1 menú por trabajador por día  
**RN-05:** Facturación semanal, pago en 7 días  
**RN-06:** Hojas físicas = documento legal primario

---

## 📈 INDICADORES CLAVE (KPIs)

- ⏱️ Tiempo atención: < 3 min/trabajador
- 🎯 Satisfacción: > 90%
- 📦 Disponibilidad stock: > 95%
- 💰 Cobro a tiempo: > 98%
- 🍽️ Desperdicio: < 10%

---

## 🎨 DIAGRAMA DE SECUENCIA

```
Fábrica ──[Info]──> Gerente ──[Req]──> Cocina ──[Lista]──> Almacén
                       │                  │                   │
                       │                  │              ¿Stock?
                       │                  │                   │
                       │                  │          NO──> Compras
                       │                  │                   │
                       │                  │<───[Insumos]──────┘
                       │                  │
                       │                  └─[Menús]──> Comedor
                       │                                   │
                       │<──────[Hojas Consumo]─────────────┘
                       │
Fábrica <─[Factura]────┤
   │                   │
   └─[Pago]───────────>│
                       │
                   [Confirma]
                       │
                    FIN ✓
```

---

## 🎯 PARA STARUML

### **Relaciones Include:**
```
CU-GENERAL-001 <<include>> CU-25: Crear Menú Diario
CU-GENERAL-001 <<include>> CU-28: Registrar Consumo Individual
CU-GENERAL-001 <<include>> CU-20: Crear Orden de Compra
CU-GENERAL-001 <<include>> CU-14: Registrar Entrada de Inventario
CU-GENERAL-001 <<include>> CU-15: Registrar Salida de Inventario
CU-GENERAL-001 <<include>> CU-46: Generar Reporte de Consumos
```

### **Relaciones Extend:**
```
CU-GENERAL-001 <<extend>> "Gestionar Stock Insuficiente"
CU-GENERAL-001 <<extend>> "Atender Demanda Excedente"
CU-GENERAL-001 <<extend>> "Gestionar Mora de Pago"
```

### **Actores Conectados:**
```
Fábrica Contratante ────┐
Gerente General ────────┤
Encargado de Cocina ────┼──── CU-GENERAL-001
Encargado de Almacén ───┤
Encargado de Compras ───┤
Personal del Comedor ───┘

Sistema CESODO ─────────── (Actor Técnico)
Base de Datos ──────────── (Actor Técnico)
```

---

**Sistema:** CESODO v1.0  
**Fecha:** Octubre 2025  
**Versión:** 2.0 (Resumida)  
**Ciclo:** Semanal (Lunes - Viernes)

