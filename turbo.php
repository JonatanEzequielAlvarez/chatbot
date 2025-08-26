<?php
require_once 'config.php';

//$model_id = "gpt-3.5-turbo";
$model_id = "gpt-4.1";
$api_key = getOpenAIKey();
$question = $_POST['Question'];
$imagePath = isset($_POST['ImagePath']) ? $_POST['ImagePath'] : null;

// Log para debugging
error_log("Turbo.php - Question: " . $question);
error_log("Turbo.php - ImagePath: " . ($imagePath ? $imagePath : "null"));
// Establece el contenido de la solicitud
// $request_data = array(
//   "model" => $model_id,
//   "messages" => array(array (
//       "role" => "assistant",
//       "content" => $question
//       )),
//   "temperature" => 0.7

// );

$request_data = array(
  "model" => $model_id,
  "messages" => array(
    array(
      "role" => "system",
      "content" => "Eres un bot diseñado para validar reclamos vecinales y de servicios públicos. Tu función es validar que los reclamos cumplan con las siguientes condiciones:
      1. Deben ser reclamos legítimos relacionados con servicios públicos (baches, semáforos, alumbrado público, contenedores de basura, aceras rotas, alcantarillas, limpieza urbana, etc.).
      2. No deben contener lenguaje ofensivo, insultos, amenazas o contenido inapropiado.
      3. Deben ser descriptivos y constructivos, orientados a mejorar los servicios de la comunidad.
      4. No deben incluir ataques personales hacia funcionarios o vecinos.
      5. No deben promover el odio, la venganza o acciones ilegales.
      6. Deben ser reclamos específicos y verificables, incluyendo **ubicación exacta, dirección, intersección o referencia clara** para que el reclamo pueda ser atendido.
      
      IMPORTANTE: Si el usuario adjunta una imagen, considera que ya fue validada previamente como apropiada para reclamos vecinales.
      
      Si el reclamo NO incluye ubicación, dirección o referencia clara, responde: 'Reclamo no válido. El reclamo debe incluir la ubicación exacta, dirección o referencia clara para ser atendido.'
      
      Si el reclamo cumple con todas las condiciones, responde: 'Reclamo válido y registrado. Tu reclamo ha sido categorizado automáticamente para facilitar su procesamiento.'
      
      Si el reclamo no cumple con alguna de las condiciones, responde: 'Reclamo no válido' y explica brevemente por qué no cumple.
      
      Si el usuario escribe algo que no es un reclamo vecinal (por ejemplo, un saludo, pregunta personal, o tema no relacionado), responde: 'Soy un bot diseñado únicamente para validar reclamos vecinales y de servicios públicos. Por favor, describe tu reclamo sobre infraestructura o servicios de tu barrio.'"
    ),
    array(
      "role" => "user",
      "content" => $question . ($imagePath ? " [Se adjuntó una imagen validada previamente]" : "")
    )
  ),
  "temperature" => 0.3
);


$request_data_json = json_encode($request_data);

//https://api.openai.com/v1/edits
//https://api.openai.com/v1/completions
//https://api.deepseek.com

$ch = curl_init("https://api.openai.com/v1/chat/completions");
//$ch = curl_init("https://api.deepseek.com");

// Establece las opciones de la solicitud cURL
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $request_data_json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Content-Length: " . strlen($request_data_json),
  "Authorization: Bearer " . $api_key
));

// Ejecuta la solicitud cURL
$response = curl_exec($ch);

// Cierra la sesión cURL
curl_close($ch);

// Procesa la respuesta de la API
$response_data = json_decode($response, true);



$json[] = array(
      'request' => $request_data,
      'test' => $response_data,
      'response' => $response_data['choices'][0]['message']['content'],
      'id' => 0
      
    );
  
  $jsonstring = json_encode($json);
  echo $jsonstring;


