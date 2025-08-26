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
    
    // Obtener todos los reclamos ordenados por fecha de creación (más recientes primero)
    $query = "SELECT id, message, user_message, enabled, image_path, categoria, created_at 
              FROM reclamos_vecinales 
              ORDER BY created_at DESC";
    
    $statement = $connect->prepare($query);
    $statement->execute();
    
    $reclamos = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    // Formatear las fechas para mejor legibilidad
    foreach ($reclamos as &$reclamo) {
        $reclamo['created_at'] = date('Y-m-d H:i:s', strtotime($reclamo['created_at']));
    }
    
    echo json_encode([
        'status' => 'success',
        'data' => $reclamos,
        'total' => count($reclamos)
    ]);
    
} catch(PDOException $e) {
    echo json_encode([
        'status' => 'error', 
        'error' => 'Error al obtener reclamos: ' . $e->getMessage()
    ]);
}
?> 