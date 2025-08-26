<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas - Reclamos Vecinales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato|Questrial|Roboto+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .chart-container {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .metric-card {
            background: linear-gradient(135deg, #237548 0%, #1a5a3a 100%);
            color: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        .metric-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .metric-label {
            font-size: 1rem;
            opacity: 0.9;
        }
        .progress-custom {
            height: 25px;
            border-radius: 15px;
            background-color: #e9ecef;
        }
        .progress-custom .progress-bar {
            border-radius: 15px;
            background: linear-gradient(90deg, #237548 0%, #1a5a3a 100%);
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="material-icons">analytics</i> Estadísticas de Reclamos</h1>
                    <p class="mb-0">Análisis detallado de reclamos vecinales por categoría</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="admin_reclamos.php" class="btn btn-light">
                        <i class="material-icons">list</i> Ver Todos los Reclamos
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Métricas principales -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="metric-card">
                    <div class="metric-number" id="totalReclamos">0</div>
                    <div class="metric-label">Total Reclamos</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card">
                    <div class="metric-number" id="reclamosValidos">0</div>
                    <div class="metric-label">Reclamos Válidos</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card">
                    <div class="metric-number" id="reclamosInvalidos">0</div>
                    <div class="metric-label">Reclamos Inválidos</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card">
                    <div class="metric-number" id="categoriasActivas">0</div>
                    <div class="metric-label">Categorías Activas</div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <h5><i class="material-icons">pie_chart</i> Distribución por Categoría</h5>
                    <canvas id="categoriaChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <h5><i class="material-icons">bar_chart</i> Reclamos Válidos vs Inválidos</h5>
                    <canvas id="validacionChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Detalles por categoría -->
        <div class="row">
            <div class="col-12">
                <div class="chart-container">
                    <h5><i class="material-icons">category</i> Detalles por Categoría</h5>
                    <div id="categoriaDetails">
                        <!-- Los detalles se cargarán dinámicamente -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico temporal -->
        <div class="row">
            <div class="col-12">
                <div class="chart-container">
                    <h5><i class="material-icons">timeline</i> Evolución Temporal (Últimos 30 días)</h5>
                    <canvas id="temporalChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let chartData = {};

        $(document).ready(function() {
            cargarEstadisticas();
        });

        function cargarEstadisticas() {
            $.ajax({
                url: 'get_estadisticas.php',
                method: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        chartData = response.data;
                        actualizarMetricas();
                        crearGraficos();
                        mostrarDetallesCategoria();
                    } else {
                        console.error('Error al cargar estadísticas:', response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la petición:', error);
                }
            });
        }

        function actualizarMetricas() {
            $('#totalReclamos').text(chartData.total || 0);
            $('#reclamosValidos').text(chartData.validos || 0);
            $('#reclamosInvalidos').text(chartData.invalidos || 0);
            $('#categoriasActivas').text(chartData.categorias || 0);
        }

        function crearGraficos() {
            // Gráfico de distribución por categoría
            const categoriaCtx = document.getElementById('categoriaChart').getContext('2d');
            new Chart(categoriaCtx, {
                type: 'doughnut',
                data: {
                    labels: chartData.categoriaLabels || [],
                    datasets: [{
                        data: chartData.categoriaData || [],
                        backgroundColor: [
                            '#237548', '#28a745', '#17a2b8', '#ffc107', '#dc3545',
                            '#6f42c1', '#fd7e14', '#20c997', '#e83e8c', '#6c757d'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Gráfico de validación
            const validacionCtx = document.getElementById('validacionChart').getContext('2d');
            new Chart(validacionCtx, {
                type: 'bar',
                data: {
                    labels: ['Válidos', 'Inválidos'],
                    datasets: [{
                        label: 'Cantidad de Reclamos',
                        data: [chartData.validos || 0, chartData.invalidos || 0],
                        backgroundColor: ['#28a745', '#dc3545'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Gráfico temporal
            if (chartData.temporalData) {
                const temporalCtx = document.getElementById('temporalChart').getContext('2d');
                new Chart(temporalCtx, {
                    type: 'line',
                    data: {
                        labels: chartData.temporalLabels || [],
                        datasets: [{
                            label: 'Reclamos por Día',
                            data: chartData.temporalData || [],
                            borderColor: '#237548',
                            backgroundColor: 'rgba(35, 117, 72, 0.1)',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }

        function mostrarDetallesCategoria() {
            if (!chartData.categoriaDetails) return;

            let html = '<div class="row">';
            
            chartData.categoriaDetails.forEach(categoria => {
                const porcentaje = chartData.total > 0 ? ((categoria.total / chartData.total) * 100).toFixed(1) : 0;
                
                html += `
                    <div class="col-md-6 mb-3">
                        <div class="stats-card">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">${categoria.nombre}</h6>
                                <span class="badge bg-primary">${categoria.total}</span>
                            </div>
                            <div class="progress progress-custom mb-2">
                                <div class="progress-bar" style="width: ${porcentaje}%"></div>
                            </div>
                            <small class="text-muted">
                                ${porcentaje}% del total • 
                                ${categoria.validos} válidos • 
                                ${categoria.invalidos} inválidos
                            </small>
                        </div>
                    </div>
                `;
            });
            
            html += '</div>';
            $('#categoriaDetails').html(html);
        }
    </script>
</body>
</html> 