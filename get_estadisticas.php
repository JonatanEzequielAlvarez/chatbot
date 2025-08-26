<?php
require_once 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

try {
    $connect = getDatabaseConnection();
} catch(PDOException $e) {
    echo json_encode(['status' => 'error', 'error' => 'Error de conexión: ' . $e->getMessage()]);
    exit;
}

try {
    // Verificar si la tabla existe
    $checkTable = "SHOW TABLES LIKE 'reclamos_vecinales'";
    $result = $connect->query($checkTable);
    
    if ($result->rowCount() == 0) {
        echo json_encode(['status' => 'success', 'data' => []]);
        exit;
    }

    // Estadísticas generales
    $statsQuery = "SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN enabled = 1 THEN 1 ELSE 0 END) as validos,
        SUM(CASE WHEN enabled = 0 THEN 1 ELSE 0 END) as invalidos,
        COUNT(DISTINCT categoria) as categorias
        FROM reclamos_vecinales";
    
    $statsStmt = $connect->prepare($statsQuery);
    $statsStmt->execute();
    $stats = $statsStmt->fetch(PDO::FETCH_ASSOC);

    // Estadísticas por categoría
    $categoriaQuery = "SELECT 
        categoria,
        COUNT(*) as total,
        SUM(CASE WHEN enabled = 1 THEN 1 ELSE 0 END) as validos,
        SUM(CASE WHEN enabled = 0 THEN 1 ELSE 0 END) as invalidos
        FROM reclamos_vecinales 
        GROUP BY categoria 
        ORDER BY total DESC";
    
    $categoriaStmt = $connect->prepare($categoriaQuery);
    $categoriaStmt->execute();
    $categorias = $categoriaStmt->fetchAll(PDO::FETCH_ASSOC);

    // Datos para gráficos
    $categoriaLabels = [];
    $categoriaData = [];
    $categoriaDetails = [];

    foreach ($categorias as $cat) {
        $categoriaLabels[] = $cat['categoria'];
        $categoriaData[] = (int)$cat['total'];
        $categoriaDetails[] = [
            'nombre' => $cat['categoria'],
            'total' => (int)$cat['total'],
            'validos' => (int)$cat['validos'],
            'invalidos' => (int)$cat['invalidos']
        ];
    }

    // Datos temporales (últimos 30 días)
    $temporalQuery = "SELECT 
        DATE(created_at) as fecha,
        COUNT(*) as cantidad
        FROM reclamos_vecinales 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
        GROUP BY DATE(created_at)
        ORDER BY fecha";
    
    $temporalStmt = $connect->prepare($temporalQuery);
    $temporalStmt->execute();
    $temporalData = $temporalStmt->fetchAll(PDO::FETCH_ASSOC);

    $temporalLabels = [];
    $temporalValues = [];

    // Generar array completo de 30 días
    $fechas = [];
    for ($i = 29; $i >= 0; $i--) {
        $fecha = date('Y-m-d', strtotime("-$i days"));
        $fechas[$fecha] = 0;
    }

    // Llenar con datos reales
    foreach ($temporalData as $data) {
        $fechas[$data['fecha']] = (int)$data['cantidad'];
    }

    foreach ($fechas as $fecha => $cantidad) {
        $temporalLabels[] = date('d/m', strtotime($fecha));
        $temporalValues[] = $cantidad;
    }

    // Top categorías más problemáticas
    $topCategoriasQuery = "SELECT 
        categoria,
        COUNT(*) as total
        FROM reclamos_vecinales 
        WHERE enabled = 1
        GROUP BY categoria 
        ORDER BY total DESC 
        LIMIT 5";
    
    $topStmt = $connect->prepare($topCategoriasQuery);
    $topStmt->execute();
    $topCategorias = $topStmt->fetchAll(PDO::FETCH_ASSOC);

    // Tasa de éxito por categoría
    $exitoQuery = "SELECT 
        categoria,
        COUNT(*) as total,
        SUM(CASE WHEN enabled = 1 THEN 1 ELSE 0 END) as validos,
        ROUND((SUM(CASE WHEN enabled = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 1) as tasa_exito
        FROM reclamos_vecinales 
        GROUP BY categoria 
        HAVING total > 0
        ORDER BY tasa_exito DESC";
    
    $exitoStmt = $connect->prepare($exitoQuery);
    $exitoStmt->execute();
    $tasasExito = $exitoStmt->fetchAll(PDO::FETCH_ASSOC);

    $response = [
        'status' => 'success',
        'data' => [
            'total' => (int)$stats['total'],
            'validos' => (int)$stats['validos'],
            'invalidos' => (int)$stats['invalidos'],
            'categorias' => (int)$stats['categorias'],
            'categoriaLabels' => $categoriaLabels,
            'categoriaData' => $categoriaData,
            'categoriaDetails' => $categoriaDetails,
            'temporalLabels' => $temporalLabels,
            'temporalData' => $temporalValues,
            'topCategorias' => $topCategorias,
            'tasasExito' => $tasasExito
        ]
    ];

    echo json_encode($response);

} catch(PDOException $e) {
    echo json_encode([
        'status' => 'error', 
        'error' => 'Error al obtener estadísticas: ' . $e->getMessage()
    ]);
}
?> 