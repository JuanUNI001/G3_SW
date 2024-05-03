<?php
// Incluir las clases y archivos necesarios
require_once __DIR__.'/../../config.php';

use es\ucm\fdi\aw\Inscritos\Inscrito as InscritosInscrito;
use es\ucm\fdi\aw\src\Eventos\Evento;
use es\ucm\fdi\aw\src\Inscritos\Inscrito;
use es\ucm\fdi\aw\src\Usuarios\Usuario;

// Función para mostrar los eventos inscritos
function mostrarEventosInscritos()
{
    // Comprobar si el usuario está logueado
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
        $rutaLogin = resuelve('/login.php');
        header("Location: $rutaLogin");
        exit();
    }

    // Obtener el correo del usuario logueado
    $correo_usuario = $_SESSION['correo'];

    // Buscar el usuario por su correo
    $usuario = Usuario::buscaUsuario($correo_usuario);
    $id_usuario = $usuario->getId();

    // Verificar el tipo de contenido esperado
    $contentType = $_SERVER['CONTENT_TYPE'] ?? 'application/json';
    $contentType = strtolower(str_replace(' ', '', $contentType));

    // Verificar si el tipo de contenido es compatible
    $acceptedContentTypes = array('application/json;charset=utf-8', 'application/json');
    $found = false;
    foreach ($acceptedContentTypes as $acceptedContentType) {
        if ($contentType === $acceptedContentType) {
            $found = true;
            break;
        }
    }

    if (!$found) {
        http_response_code(400);
        echo 'Este servicio REST solo soporta el content-type application/json';
        die();
    }

    $result = null;

    // Manejar las diferentes peticiones HTTP
    switch ($_SERVER['REQUEST_METHOD']) {
        // Consulta de datos
        case 'GET':
            try {
                // Comprobamos si es una consulta de un evento concreto -> eventos.php?idEvento=XXXXX
                $idEvento = filter_input(INPUT_GET, 'idEvento', FILTER_VALIDATE_INT);
                if ($idEvento !== null && $idEvento !== false) {
                    $result = [];
                    $result[] = Inscrito::buscaPorId($idEvento);
                } else {
                    // Comprobamos si es una lista de eventos entre dos fechas -> eventos.php?start=XXXXX&end=YYYYY
                    // https://fullcalendar.io/docs/events-json-feed
                    $start = filter_input(INPUT_GET, 'start', FILTER_SANITIZE_SPECIAL_CHARS);
                    $end = filter_input(INPUT_GET, 'end', FILTER_SANITIZE_SPECIAL_CHARS);
                    if ($start !== null && $end !== null) {
                        $startDateTime = \DateTime::createFromFormat(\DateTime::ISO8601, $start);
                        $endDateTime = \DateTime::createFromFormat(\DateTime::ISO8601, $end);
                        if ($startDateTime !== false && $endDateTime !== false) {
                            $result = Inscrito::buscaEntreFechas($id_usuario, $startDateTime, $endDateTime);
                        } else {
                            http_response_code(400);
                            echo 'Formato de fecha inválido';
                            die();
                        }
                    } else {
                        http_response_code(400);
                        echo 'Parámetros start o end incorrectos';
                        die();
                    }
                }

                // Generamos un array de eventos en formato JSON
                $json = json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

                http_response_code(200); // 200 OK
                header('Content-Type: application/json; charset=utf-8');
                header('Content-Length: ' . mb_strlen($json));

                echo $json;
            } catch (Exception $e) {
                http_response_code(500);
                echo 'Error en la aplicación';
                error_log((string) $e);
                die();
            }
            break;

        default:
            http_response_code(400);
            echo $_SERVER['REQUEST_METHOD'] . ' no está soportado';
            break;
    }
}
?>
