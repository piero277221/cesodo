<?php
// Archivo principal del módulo de pedidos
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo de Pedidos - SCM CESODO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2d3436 0%, #636e72 100%);
            min-height: 100vh;
            color: #fff;
        }
        .navbar {
            background: #2d3436 !important;
            border-bottom: 3px solid #fd7900;
        }
        .card {
            background: rgba(255,255,255,0.95);
            color: #2d3436;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .btn-primary {
            background: #fd7900;
            border-color: #fd7900;
        }
        .btn-primary:hover {
            background: #e56b00;
            border-color: #e56b00;
        }
        .table-striped > tbody > tr:nth-of-type(odd) > td {
            background-color: rgba(253, 121, 0, 0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/scm-cesodo/public/"><i class="fas fa-boxes"></i> SCM CESODO</a>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: #fd7900; color: white;">
                        <h4 class="mb-0"><i class="fas fa-shopping-cart"></i> Gestión de Pedidos</h4>
                        <a href="/scm-cesodo/public/pedidos/create" class="btn btn-light"><i class="fas fa-plus"></i> Nuevo Pedido</a>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label>Proveedor</label>
                                <select class="form-select" id="filtro-proveedor">
                                    <option value="">Todos los proveedores</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Estado</label>
                                <select class="form-select" id="filtro-estado">
                                    <option value="">Todos los estados</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="confirmado">Confirmado</option>
                                    <option value="entregado">Entregado</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Desde</label>
                                <input type="date" class="form-control" id="fecha-desde">
                            </div>
                            <div class="col-md-3">
                                <label>Hasta</label>
                                <input type="date" class="form-control" id="fecha-hasta">
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead style="background: #2d3436; color: white;">
                                    <tr>
                                        <th>ID</th>
                                        <th>Número</th>
                                        <th>Proveedor</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="pedidos-tabla">
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Cargando...</span>
                                            </div>
                                            <p>Cargando pedidos...</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            cargarPedidos();
            cargarProveedores();
        });

        function cargarPedidos() {
            fetch('/scm-cesodo/public/api/pedidos.php')
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        mostrarPedidos(data);
                    } else {
                        mostrarMensajeVacio();
                    }
                })
                .catch(error => {
                    console.error('Error al cargar pedidos:', error);
                    mostrarError();
                });
        }

        function cargarProveedores() {
            fetch('/scm-cesodo/public/api/proveedores.php')
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('filtro-proveedor');
                    data.forEach(proveedor => {
                        const option = document.createElement('option');
                        option.value = proveedor.id;
                        option.textContent = proveedor.nombre;
                        select.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error al cargar proveedores:', error);
                });
        }

        function mostrarPedidos(pedidos) {
            const tabla = document.getElementById('pedidos-tabla');
            let html = '';

            pedidos.forEach(pedido => {
                html += `
                    <tr>
                        <td>${pedido.id}</td>
                        <td>${pedido.numero_pedido}</td>
                        <td>${pedido.proveedor}</td>
                        <td>${pedido.fecha_pedido}</td>
                        <td><span class="badge bg-${getEstadoColor(pedido.estado.toLowerCase())}">${pedido.estado}</span></td>
                        <td>$${pedido.total}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="verPedido(${pedido.id})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-warning" onclick="editarPedido(${pedido.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="eliminarPedido(${pedido.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });

            tabla.innerHTML = html;
        }

        function mostrarMensajeVacio() {
            const tabla = document.getElementById('pedidos-tabla');
            tabla.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            No hay pedidos registrados en el sistema.
                            <br><br>
                            <a href="/scm-cesodo/public/pedidos/create" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Crear primer pedido
                            </a>
                        </div>
                    </td>
                </tr>
            `;
        }

        function mostrarError() {
            const tabla = document.getElementById('pedidos-tabla');
            tabla.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            Error al cargar los pedidos. Por favor, intenta nuevamente.
                            <br><br>
                            <button class="btn btn-primary" onclick="cargarPedidos()">
                                <i class="fas fa-refresh"></i> Reintentar
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }

        function getEstadoColor(estado) {
            switch(estado) {
                case 'pendiente': return 'warning';
                case 'confirmado': return 'info';
                case 'entregado': return 'success';
                default: return 'secondary';
            }
        }

        function verPedido(id) {
            window.location.href = `/scm-cesodo/public/pedidos/show?id=${id}`;
        }

        function editarPedido(id) {
            window.location.href = `/scm-cesodo/public/pedidos/edit?id=${id}`;
        }

        function eliminarPedido(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este pedido?')) {
                // Implementar eliminación
                alert('Función de eliminación por implementar');
            }
        }
    </script>
</body>
</html>
