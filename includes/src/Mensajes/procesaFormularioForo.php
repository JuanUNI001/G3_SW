<?php
// Incluir el archivo de configuración y las clases necesarias
require_once __DIR__.'/../../config.php';
use \es\ucm\fdi\aw\src\Mensajes\Mensaje;

// Comprobar si se reciben datos del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["mensaje"])) {
    // Obtener el mensaje enviado desde el formulario
    $mensaje = $_POST["mensaje"];
    
    // Obtener el ID del emisor y del foro
    $idEmisor = $_SESSION["id_usuario"]; // Ajusta esto según cómo estés manejando las sesiones de usuario
    $idForo = $_GET["id_foro"]; // Ajusta esto según cómo estés enviando el ID del foro

    // Validar el mensaje (puedes agregar más validaciones si es necesario)
    $mensaje = trim($mensaje);
    if (empty($mensaje)) {
        $response = ["success" => false, "error" => "El mensaje no puede estar vacío"];
    } else {
        // Guardar el mensaje en la base de datos
        $hora_actual = date("H:i:s");
        $mensajeObj = Mensaje::Crea(null, $idEmisor, -1, $idForo, $mensaje, $hora_actual);
        $mensajeObj->guarda();
        $response = ["success" => true];
    }

    // Enviar la respuesta como JSON
    header("Content-Type: application/json");
    echo json_encode($response);
} else {
    // Si no se reciben datos del formulario, mostrar un mensaje de error
    $response = ["success" => false, "error" => "No se recibieron datos del formulario"];
    header("Content-Type: application/json");
    echo json_encode($response);
}
?>
