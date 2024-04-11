<?php
    // Incluye los archivos necesarios
    require_once __DIR__.'/../../config.php';
    require_once __DIR__.'/includes/src/Mensajes\listaMensajes.php';

    use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
    use \es\ucm\fdi\aw\src\usuarios\Usuario;
    use \es\ucm\fdi\aw\src\Mensajes\FormularioEnviarMensaje;
    use \es\ucm\fdi\aw\src\BD;
    // Define el título de la página
    $tituloPagina = 'Chat';

    // Incluye el CSS necesario
    $rutaCSS = resuelve('/css/imagenes.css');

    // Imprimir la etiqueta link con la ruta al archivo CSS
    echo '<link rel="stylesheet" type="text/css" href="' . $rutaCSS . '">';

    // Verifica si se ha proporcionado un ID de producto
    if(isset($_GET['id_destinatario'])) {
   
        $id_destinatario = $_GET['id_destinatario'];

        $correo = $_SESSION['correo'];
        $usuario = Usuario::buscaUsuario($correo);  
        $contenidoPrincipal = listaMensajes($usuario->getId(), $id_destinatario);

        $formEnviarMensaje = new \es\ucm\fdi\aw\src\Mensajes\FormularioEnviarMensaje($id_destinatario, null);
        $formEnviarMensaje = $formEnviarMensaje->gestiona();

        $contenidoPrincipal.= $formEnviarMensaje;
        } else {
            $contenidoPrincipal = 'No se ha podio cargar la conversacion.';
        }
        $params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
        $app->generaVista('/plantillas/plantilla.php', $params);
?>


