<?php

require_once 'includes/config.php'; 

use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use es\ucm\fdi\aw\src\BD;

function visualizaMensajes($idEmisor, $idReceptor, $viewPoint)
{
    $mensajes = Mensaje::GetMensajesInPrivateChat($idEmisor, $idReceptor);
    $mensaje_class = '';
    $usuario = Usuario::buscaUsuario($_SESSION['correo']);
    if ($usuario) {
        $nombreUsuario = $usuario->getNombre();
        $imagenUsuario = $usuario->getAvatar();
    }
    
    $idEmisor = $usuario->getId();
    $idReceptor = $_POST['id'];
    $receptor = Usuario::buscaPorId($idReceptor);
    $autor = $receptor->getNombre();
    $imagenPath = $receptor->getAvatar() ? RUTA_IMGS . $receptor->getAvatar() : RUTA_IMGS . 'images/avatarPorDefecto.png'; 
    $rutaNew = resuelve('includes/src/Mensajes/put_mensaje.php');
    $rutaGetter = resuelve('includes/src/Mensajes/get_mensaje.php');

    $mensaje_class .= <<<HTML
    <div class="conv-mensaje ">
        
    </div>
    <div class="wrapper">
        <section class="chat-area">
            <header class="custom-header">          
                <a href="javascript:history.back()" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="{$imagenPath}" alt="Avatar de {$usuario->getNombre()}" class="avatar_usuario">               
                <div class="details">
                    <span>$autor</span>
                    
                    </div>
            </header>
            <div class="chat-box">
HTML;

    // Obtener mensajes del chat
    
    
        $mensaje_class .= <<<HTML
                </div>
                <form action="#" class="typing-area">
                    <input type="hidden" name="idEmisor" value="$idEmisor">
                    <input type="hidden" name="idDestinatario" value="$idReceptor">
                    <input type="text" name="message" class="input-field" placeholder="Escribe un mensaje aquí ..." autocomplete="off">
                    <div id="enviarMensaje" class="enviar-mensaje" onclick="enviarMensaje()">
                        <button><i class="fab fa-telegram-plane"></i></button>
                    </div>


                </form>

            </section>
        </div>
        

    HTML;

    return $mensaje_class;
}

?>

<?php

$id_usuario_receptor = $_POST['id'];

$usuario_receptor = Usuario::buscaPorId($id_usuario_receptor);

$usuario_emisor = Usuario::buscaUsuario($_SESSION['correo']);
$id_usuario_emisor = $usuario_emisor->getId();
$mensajesView = visualizaMensajes($id_usuario_emisor, $id_usuario_receptor, $id_usuario_emisor);

$tituloPagina = 'Chat Usuario';
$contenidoPrincipal = <<<HTML
    <h1>Chat en linea</h1>
    $mensajesView
HTML;

$scripts = [
    'js/chatView.js'
];

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Chat en línea', 'scripts' => $scripts];
$app->generaVista('/plantillas/plantilla.php', $params);
?>


<script>

    let idUsuarioEmisor = "<?php echo $id_usuario_emisor; ?>";
    let idUsuarioReceptor = "<?php echo $id_usuario_receptor; ?>";

</script>
