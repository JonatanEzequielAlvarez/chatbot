<?php
require_once 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $connect = getDatabaseConnection();
} catch(PDOException $e) {
    echo json_encode(['status' => '500', 'error' => 'Error de conexión: ' . $e->getMessage()]);
    exit;
}

date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha_actual = date("Y-m-d H:i:s");

if(isset($_POST["message"])) {
    $message = $_POST['message']; 
    $enabled = $_POST['enabled'] === 'true' ? 1 : 0; // Convertir a entero
    $user_message = $_POST['user_message'];
    $image_path = isset($_POST['image_path']) ? $_POST['image_path'] : null;

    // Debug: mostrar qué datos estamos recibiendo
    error_log("Datos recibidos: message=" . $message . ", enabled=" . $enabled . ", user_message=" . $user_message . ", image_path=" . $image_path);

    // Función para categorizar automáticamente el reclamo
    function categorizarReclamo($user_message) {
        $user_message = strtolower($user_message);
        
        // Definir categorías y palabras clave
        $categorias = [
            'Baches y Pavimento' => ['bache', 'baches', 'pavimento', 'asfalto', 'calle rota', 'camino roto', 'pavimento roto', 'asfalto roto'],
            'Alumbrado Público' => ['luz', 'luzes', 'alumbrado', 'poste', 'postes', 'farol', 'faroles', 'iluminación', 'lámpara', 'lámparas'],
            'Semáforos' => ['semáforo', 'semáforos', 'semaforo', 'semaforos', 'traffic light', 'luz de tránsito'],
            'Contenedores de Basura' => ['contenedor', 'contenedores', 'basura', 'tacho', 'tachos', 'residuos', 'basurero'],
            'Limpieza Urbana' => ['limpieza', 'sucio', 'basura', 'papel', 'desechos', 'barrido', 'limpiar'],
            'Aceras y Veredas' => ['acera', 'aceras', 'vereda', 'veredas', 'banqueta', 'banquetas', 'peatonal'],
            'Alcantarillas y Desagües' => ['alcantarilla', 'alcantarillas', 'desagüe', 'desagües', 'cloaca', 'cloacas', 'drenaje'],
            'Parques y Espacios Verdes' => ['parque', 'parques', 'plaza', 'plazas', 'jardín', 'jardines', 'área verde', 'espacio verde'],
            'Transporte Público' => ['colectivo', 'colectivos', 'bus', 'buses', 'parada', 'paradas', 'transporte'],
            'Señales de Tránsito' => ['señal', 'señales', 'cartel', 'carteles', 'señalización', 'stop', 'ceda el paso'],
            'Otros Servicios' => ['agua', 'gas', 'electricidad', 'internet', 'wifi', 'servicio']
        ];
        
        // Buscar coincidencias
        foreach ($categorias as $categoria => $palabras_clave) {
            foreach ($palabras_clave as $palabra) {
                if (strpos($user_message, $palabra) !== false) {
                    return $categoria;
                }
            }
        }
        
        // Si no encuentra coincidencia específica, intentar categorizar por contexto
        if (strpos($user_message, 'calle') !== false || strpos($user_message, 'avenida') !== false) {
            return 'Baches y Pavimento';
        }
        if (strpos($user_message, 'luz') !== false || strpos($user_message, 'oscuro') !== false) {
            return 'Alumbrado Público';
        }
        if (strpos($user_message, 'tránsito') !== false || strpos($user_message, 'cruce') !== false) {
            return 'Semáforos';
        }
        
        return 'Otros Servicios'; // Categoría por defecto
    }

    // Categorizar el reclamo
    $categoria = categorizarReclamo($user_message);

    // Crear tabla si no existe (con campo de categoría)
    try {
        $createTable = "CREATE TABLE IF NOT EXISTS reclamos_vecinales (
            id INT AUTO_INCREMENT PRIMARY KEY,
            message TEXT NOT NULL,
            user_message TEXT NOT NULL,
            enabled TINYINT(1) NOT NULL,
            image_path VARCHAR(255) NULL,
            categoria VARCHAR(100) DEFAULT 'Otros Servicios',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $connect->exec($createTable);
        
        // Agregar columna categoria si no existe
        try {
            $connect->exec("ALTER TABLE reclamos_vecinales ADD COLUMN categoria VARCHAR(100) DEFAULT 'Otros Servicios'");
        } catch(PDOException $e) {
            // La columna ya existe, ignorar error
        }
        
        error_log("Tabla creada/verificada correctamente");
    } catch(PDOException $e) {
        error_log("Error al crear tabla: " . $e->getMessage());
        echo json_encode(['status' => '500', 'error' => 'Error al crear tabla: ' . $e->getMessage()]);
        exit;
    }

    // Insertar los datos en la base de datos
    $query = "INSERT INTO reclamos_vecinales (message, user_message, enabled, image_path, categoria, created_at) VALUES (:message, :user_message, :enabled, :image_path, :categoria, :created_at)";
    
    try {
        $statement = $connect->prepare($query);

        // Enlazar los parámetros con tipos específicos
        $statement->bindParam(':message', $message, PDO::PARAM_STR);
        $statement->bindParam(':user_message', $user_message, PDO::PARAM_STR);
        $statement->bindParam(':enabled', $enabled, PDO::PARAM_INT);
        $statement->bindParam(':image_path', $image_path, PDO::PARAM_STR);
        $statement->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        $statement->bindParam(':created_at', $fecha_actual, PDO::PARAM_STR);

        // Ejecutar la consulta
        if ($statement->execute()) {
            $lastId = $connect->lastInsertId();
            error_log("Reclamo guardado correctamente con ID: " . $lastId . " y categoría: " . $categoria);
            $data = array('status' => "200", 'message' => "Reclamo guardado correctamente", 'id' => $lastId, 'categoria' => $categoria);
        } else {
            $errorInfo = $statement->errorInfo();
            error_log("Error al ejecutar consulta: " . print_r($errorInfo, true));
            $data = array('status' => "500", 'error' => $errorInfo);
        }
    } catch(PDOException $e) {
        error_log("Excepción PDO: " . $e->getMessage());
        $data = array('status' => "500", 'error' => $e->getMessage());
    }
} else {
    error_log("Faltan parámetros POST. Datos recibidos: " . print_r($_POST, true));
    $data = array('status' => "401", 'error' => "Faltan parámetros");
}

echo json_encode($data);
?> 