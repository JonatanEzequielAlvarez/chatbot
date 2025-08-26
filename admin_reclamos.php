<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Reclamos Vecinales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato|Questrial|Roboto+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #f8f9fa;
        }
        .header {
            background: linear-gradient(135deg, #237548 0%, #1a5a3a 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .category-filter {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .reclamo-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 5px solid #237548;
        }
        .categoria-badge {
            background: #237548;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        .status-valid {
            background: #28a745;
            color: white;
        }
        .status-invalid {
            background: #dc3545;
            color: white;
        }
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: 10px;
            margin-top: 1rem;
        }
        .btn-filter {
            background: #237548;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            margin: 0.2rem;
            transition: all 0.3s ease;
        }
        .btn-filter:hover {
            background: #1a5a3a;
            color: white;
            transform: scale(1.05);
        }
        .btn-filter.active {
            background: #1a5a3a;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .search-box {
            border-radius: 25px;
            border: 2px solid #e9ecef;
            padding: 0.5rem 1rem;
        }
        .search-box:focus {
            border-color: #237548;
            box-shadow: 0 0 0 0.2rem rgba(35, 117, 72, 0.25);
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="material-icons">admin_panel_settings</i> Panel de Administración</h1>
                    <p class="mb-0">Gestión de Reclamos Vecinales</p>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-light" onclick="exportarDatos()">
                        <i class="material-icons">download</i> Exportar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Estadísticas -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <h3 id="totalReclamos">0</h3>
                    <p class="text-muted">Total Reclamos</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <h3 id="reclamosValidos">0</h3>
                    <p class="text-muted">Reclamos Válidos</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <h3 id="reclamosInvalidos">0</h3>
                    <p class="text-muted">Reclamos Inválidos</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <h3 id="categoriasActivas">0</h3>
                    <p class="text-muted">Categorías Activas</p>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="category-filter">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="material-icons">filter_list</i> Filtros</h5>
                    <div class="mb-3">
                        <input type="text" class="form-control search-box" id="searchInput" placeholder="Buscar en reclamos...">
                    </div>
                </div>
                <div class="col-md-6">
                    <h5><i class="material-icons">category</i> Categorías</h5>
                    <div id="categoryButtons">
                        <!-- Los botones se generarán dinámicamente -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Reclamos -->
        <div id="reclamosContainer">
            <!-- Los reclamos se cargarán aquí -->
        </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-center mt-4">
            <nav>
                <ul class="pagination" id="pagination">
                    <!-- La paginación se generará dinámicamente -->
                </ul>
            </nav>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentPage = 1;
        let itemsPerPage = 10;
        let currentFilter = 'todos';
        let currentSearch = '';
        let allReclamos = [];
        let filteredReclamos = [];

        // Cargar datos al iniciar
        $(document).ready(function() {
            cargarReclamos();
            
            // Evento de búsqueda
            $('#searchInput').on('input', function() {
                currentSearch = $(this).val();
                filtrarReclamos();
            });
        });

        function cargarReclamos() {
            $.ajax({
                url: 'get_reclamos.php',
                method: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        allReclamos = response.data;
                        actualizarEstadisticas();
                        generarBotonesCategoria();
                        filtrarReclamos();
                    } else {
                        console.error('Error al cargar reclamos:', response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la petición:', error);
                }
            });
        }

        function actualizarEstadisticas() {
            const total = allReclamos.length;
            const validos = allReclamos.filter(r => r.enabled == 1).length;
            const invalidos = allReclamos.filter(r => r.enabled == 0).length;
            const categorias = [...new Set(allReclamos.map(r => r.categoria))].length;

            $('#totalReclamos').text(total);
            $('#reclamosValidos').text(validos);
            $('#reclamosInvalidos').text(invalidos);
            $('#categoriasActivas').text(categorias);
        }

        function generarBotonesCategoria() {
            const categorias = [...new Set(allReclamos.map(r => r.categoria))];
            let buttonsHtml = '<button class="btn btn-filter active" onclick="filtrarPorCategoria(\'todos\')">Todos</button>';
            
            categorias.forEach(categoria => {
                buttonsHtml += `<button class="btn btn-filter" onclick="filtrarPorCategoria('${categoria}')">${categoria}</button>`;
            });
            
            $('#categoryButtons').html(buttonsHtml);
        }

        function filtrarPorCategoria(categoria) {
            currentFilter = categoria;
            currentPage = 1;
            
            // Actualizar botones activos
            $('.btn-filter').removeClass('active');
            $(`.btn-filter:contains('${categoria === 'todos' ? 'Todos' : categoria}')`).addClass('active');
            
            filtrarReclamos();
        }

        function filtrarReclamos() {
            filteredReclamos = allReclamos.filter(reclamo => {
                const cumpleCategoria = currentFilter === 'todos' || reclamo.categoria === currentFilter;
                const cumpleBusqueda = currentSearch === '' || 
                    reclamo.user_message.toLowerCase().includes(currentSearch.toLowerCase()) ||
                    reclamo.message.toLowerCase().includes(currentSearch.toLowerCase()) ||
                    reclamo.categoria.toLowerCase().includes(currentSearch.toLowerCase());
                
                return cumpleCategoria && cumpleBusqueda;
            });
            
            mostrarReclamos();
        }

        function mostrarReclamos() {
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const reclamosPaginados = filteredReclamos.slice(startIndex, endIndex);
            
            let html = '';
            
            if (reclamosPaginados.length === 0) {
                html = `
                    <div class="text-center py-5">
                        <i class="material-icons" style="font-size: 4rem; color: #ccc;">search_off</i>
                        <h4 class="text-muted mt-3">No se encontraron reclamos</h4>
                        <p class="text-muted">Intenta ajustar los filtros de búsqueda</p>
                    </div>
                `;
            } else {
                reclamosPaginados.forEach(reclamo => {
                    const fecha = new Date(reclamo.created_at).toLocaleString('es-ES');
                    const statusClass = reclamo.enabled == 1 ? 'status-valid' : 'status-invalid';
                    const statusText = reclamo.enabled == 1 ? 'Válido' : 'Inválido';
                    
                    html += `
                        <div class="reclamo-card">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="categoria-badge">${reclamo.categoria}</span>
                                        <span class="status-badge ${statusClass}">${statusText}</span>
                                    </div>
                                    <h6><strong>Reclamo del usuario:</strong></h6>
                                    <p class="mb-2">${reclamo.user_message}</p>
                                    <h6><strong>Respuesta del sistema:</strong></h6>
                                    <p class="mb-2">${reclamo.message}</p>
                                    <small class="text-muted">
                                        <i class="material-icons" style="font-size: 1rem;">schedule</i> ${fecha}
                                    </small>
                                </div>
                                <div class="col-md-4">
                                    ${reclamo.image_path ? `
                                        <div class="text-center">
                                            <img src="${reclamo.image_path}" class="image-preview" alt="Imagen del reclamo">
                                        </div>
                                    ` : '<p class="text-muted text-center">Sin imagen</p>'}
                                </div>
                            </div>
                        </div>
                    `;
                });
            }
            
            $('#reclamosContainer').html(html);
            generarPaginacion();
        }

        function generarPaginacion() {
            const totalPages = Math.ceil(filteredReclamos.length / itemsPerPage);
            let paginationHtml = '';
            
            if (totalPages > 1) {
                // Botón anterior
                paginationHtml += `
                    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" onclick="cambiarPagina(${currentPage - 1})">Anterior</a>
                    </li>
                `;
                
                // Números de página
                for (let i = 1; i <= totalPages; i++) {
                    if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                        paginationHtml += `
                            <li class="page-item ${i === currentPage ? 'active' : ''}">
                                <a class="page-link" href="#" onclick="cambiarPagina(${i})">${i}</a>
                            </li>
                        `;
                    } else if (i === currentPage - 3 || i === currentPage + 3) {
                        paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                }
                
                // Botón siguiente
                paginationHtml += `
                    <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="#" onclick="cambiarPagina(${currentPage + 1})">Siguiente</a>
                    </li>
                `;
            }
            
            $('#pagination').html(paginationHtml);
        }

        function cambiarPagina(pagina) {
            if (pagina >= 1 && pagina <= Math.ceil(filteredReclamos.length / itemsPerPage)) {
                currentPage = pagina;
                mostrarReclamos();
            }
        }

        function exportarDatos() {
            const csvContent = generarCSV();
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', `reclamos_vecinales_${new Date().toISOString().split('T')[0]}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        function generarCSV() {
            const headers = ['ID', 'Categoría', 'Estado', 'Reclamo del Usuario', 'Respuesta del Sistema', 'Imagen', 'Fecha'];
            const rows = filteredReclamos.map(r => [
                r.id,
                r.categoria,
                r.enabled == 1 ? 'Válido' : 'Inválido',
                `"${r.user_message.replace(/"/g, '""')}"`,
                `"${r.message.replace(/"/g, '""')}"`,
                r.image_path || 'Sin imagen',
                r.created_at
            ]);
            
            return [headers, ...rows].map(row => row.join(',')).join('\n');
        }
    </script>
</body>
</html> 