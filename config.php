<?php
/**
 * Archivo de configuración para cargar variables de entorno
 */

// Función para cargar variables de entorno desde archivo .env
function loadEnv($path) {
    if (!file_exists($path)) {
        return false;
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            // Remover comillas si existen
            if (preg_match('/^(["\'])(.*)\1$/', $value, $matches)) {
                $value = $matches[2];
            }
            
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
    return true;
}

// Cargar variables de entorno
loadEnv(__DIR__ . '/.env');

// Función para obtener variables de entorno con valor por defecto
function env($key, $default = null) {
    $value = $_ENV[$key] ?? getenv($key);
    return $value !== false ? $value : $default;
}

// Función para obtener la conexión a la base de datos
function getDatabaseConnection() {
    try {
        $host = env('DB_HOST', 'localhost');
        $dbname = env('DB_NAME', 'chatbot');
        $user = env('DB_USER', 'root');
        $password = env('DB_PASSWORD', '');
        
        $connect = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connect;
    } catch(PDOException $e) {
        error_log("Error de conexión a la base de datos: " . $e->getMessage());
        throw $e;
    }
}

// Función para obtener la API key de OpenAI
function getOpenAIKey() {
    return env('OPENAI_API_KEY', '');
}
?> 