<?php
require_once 'config.php';

// Suprimir warnings para evitar problemas con JSON
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 0);

header('Content-Type: application/json');

$api_key = getOpenAIKey();

// Verificar si se subió una imagen
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'message' => 'No se subió ninguna imagen válida']);
    exit;
}

$uploadedFile = $_FILES['image'];
$allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

// Validar tipo de archivo
if (!in_array($uploadedFile['type'], $allowedTypes)) {
    echo json_encode(['status' => 'error', 'message' => 'Tipo de archivo no permitido. Solo se permiten JPG y PNG']);
    exit;
}

// Validar tamaño (máximo 5MB)
if ($uploadedFile['size'] > 5 * 1024 * 1024) {
    echo json_encode(['status' => 'error', 'message' => 'La imagen es demasiado grande. Máximo 5MB']);
    exit;
}

// Convertir imagen a base64 para enviar directamente
$imageData = file_get_contents($uploadedFile['tmp_name']);
$base64Image = base64_encode($imageData);
$mimeType = $uploadedFile['type'];

// Crear data URL para la imagen
$imageDataUrl = "data:$mimeType;base64,$base64Image";

// Usar el mismo formato que funciona en prueba-imagen.php pero con data URL
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.openai.com/v1/responses',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode([
        "model" => "gpt-4.1",
        "input" => [
            [
                "role" => "user",
                "content" => [
                    [
                        "type" => "input_text", 
                        "text" => "Analiza esta imagen y determina si muestra un problema vecinal o de servicios públicos que requiere ser reportado a las autoridades municipales.

VÁLIDO si la imagen muestra:
- Baches, calles en mal estado, veredas rotas
- Semáforos dañados o sin funcionar  
- Contenedores de basura rotos o desbordados
- Problemas de alumbrado público
- Pozos, alcantarillas destapadas
- Árboles caídos o dañados en vía pública
- Infraestructura urbana deteriorada

NO VÁLIDO si la imagen muestra:
- Personas en situaciones privadas o comprometedoras
- Contenido sexual, violento u ofensivo
- Interiores de casas o propiedades privadas
- Situaciones que no requieren intervención municipal
- Imágenes sin relación con servicios públicos

Responde ÚNICAMENTE con:
'VÁLIDA' si es apropiada para reclamos vecinales
'NO VÁLIDA: [razón específica]' si no es apropiada

Después explica brevemente qué se observa en la imagen."
                    ],
                    [
                        "type" => "input_image",
                        "image_url" => $imageDataUrl
                    ]
                ]
            ]
        ]
    ]),
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key,
        'Cookie: __cf_bm=RUPDtcE4aNMpCrwCb9k_jcMd5ufF9R.R1VfnRLUiUQM-1754348151-1.0.1.1-LNoo6UJWWwvlqQN.ETUHt_uiVXG.9oxuRnJgqmC1mDMgItat1RPyeqRRgKNBXrYxXW.aCk89RVA_UAqIAEBSMVQW17_CgE3CE0n2T9COqTM; _cfuvid=BvBXaR0Cotys5Fd6umPXGr0ztHwIOBIsyWICcF18BGo-1754348151230-0.0.1.1-604800000'
    ),
));

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

// Mejor manejo de errores
if ($response === false) {
    $error = curl_error($curl);
    curl_close($curl);
    echo json_encode(['status' => 'error', 'message' => 'Error de conexión: ' . $error]);
    exit;
}

curl_close($curl);

if ($httpCode !== 200) {
    $error_info = json_decode($response, true);
    echo json_encode([
        'status' => 'error', 
        'message' => 'Error API (' . $httpCode . ')',
        'api_error' => $error_info,
        'response' => $response
    ]);
    exit;
}

$response_data = json_decode($response, true);

if (!isset($response_data['output'][0]['content'][0]['text'])) {
    echo json_encode([
        'status' => 'error', 
        'message' => 'Error en la respuesta de validación de imagen',
        'debug_response' => $response_data,
        'raw_response' => $response
    ]);
    exit;
}

$aiAnalysis = trim($response_data['output'][0]['content'][0]['text']);

// Verificar si la imagen es válida según el análisis de IA
if (strpos($aiAnalysis, 'VÁLIDA') === 0) {
    // La imagen es válida, guardarla
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo crear el directorio de uploads']);
            exit;
        }
    }

    $fileName = uniqid() . '_' . time() . '.' . pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
    $filePath = $uploadDir . $fileName;

    if (@move_uploaded_file($uploadedFile['tmp_name'], $filePath)) {
        echo json_encode([
            'status' => 'success', 
            'message' => 'Imagen válida y guardada',
            'filename' => $fileName,
            'path' => $filePath,
            'validation' => $aiAnalysis,
            'ai_response' => $response_data // Respuesta completa de la API
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al guardar la imagen']);
    }
} else {
    // La imagen no es válida según el análisis de IA
    echo json_encode([
        'status' => 'invalid', 
        'message' => $aiAnalysis,
        'ai_response' => $response_data
    ]);
}
?> 