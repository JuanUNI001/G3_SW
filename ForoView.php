<?php

require_once 'includes/config.php'; 


use es\ucm\fdi\aw\src\Mensajes\Mensaje;
use es\ucm\fdi\aw\src\Foros\Foro;
use es\ucm\fdi\aw\src\BD;
use es\ucm\fdi\aw\src\Usuarios\Usuario;
?>
<?php
function visualizaMensajes($idEmisor, $idReceptor, $viewPoint)
{

    $mensaje_class = '';
    $usuario = Usuario::buscaUsuario($_SESSION['correo']);
    if ($usuario) {
        $nombreUsuario = $usuario->getNombre();
        $imagenUsuario = $usuario->getAvatar();
    }
    
    $idEmisor = $usuario->getId();
    $idForo = $_POST['id'];
    $idReceptor = $idForo;
    $receptor = Usuario::buscaPorId($idEmisor);
    $autor = $receptor->getNombre();
    $imagenPath = $receptor->getAvatar() ? RUTA_IMGS . $receptor->getAvatar() : RUTA_IMGS . 'images/avatarPorDefecto.png'; 
   
    $mensaje_class .= <<<HTML
    <div class="conv-mensaje ">
        
    </div>
    <div class="wrapper-foro">
        <section class="foro-area">
HTML;

//cabecera
$foroView = visualizaForo($idForo);

$mensaje_class .= <<<HTML
            <header class="custom-header-foro">          
                <a href="javascript:history.back()" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <h1>Discusión en el Foro</h1>
                $foroView
            </header>
            <div class="foro-box">
HTML;

    // Obtener mensajes del chat
    
    
        $mensaje_class .= <<<HTML
                </div>
                <form action="#" class="typing-area">
                    <input type="hidden" name="idEmisor" value="$idEmisor">
                    <input type="hidden" name="idDestinatario" value="$idReceptor">
                    <textarea name="message" class="input-field-foro" placeholder="Escribe un mensaje aquí ..." autocomplete="off"></textarea>
                    <div id="enviarMensaje" class="enviar-mensaje" onclick="enviarMensaje()">
                        <button><i class="fab fa-telegram-plane"></i></button>
                    </div>


                </form>

            </section>
        </div>
        

    HTML;

    return $mensaje_class;
}

function visualizaForo($idForo) {
    
    $foro = Foro::buscaForo($idForo);

    $autor_id = $foro->getAutor();
    $autor = \es\ucm\fdi\aw\src\Usuarios\Usuario::buscaPorId($autor_id);
    $nombreAutor = $autor ? $autor->getNombre() : "Desconocido";
    $html = <<<HTML
   

    <div class="foro">
        <div class="foro_info">

                <div class="foro_autor">
                    <strong> $nombreAutor</strong>
                </div>
                <div class="foro_titulo">
                    <strong>{$foro->getTitulo()}</strong> 
                </div>
            </a>
           
        </div>
    </div>
    HTML;
    
    return $html;
    
  }



?>

<?php
 $contenidoPrincipal='';
 $tituloPagina = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idForo = $_POST['id'];


    $usuario_emisor = Usuario::buscaUsuario($_SESSION['correo']);
    $id_usuario_emisor = $usuario_emisor->getId();

    $mensajesView = visualizaMensajes($id_usuario_emisor, $idForo, $id_usuario_emisor);

    $tituloPagina = 'Chat Usuario';
    $contenidoPrincipal = <<<HTML
        $mensajesView
    HTML;
}
$scripts = [
    'js/Foro.js'
];

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Discusión en el Foro', 'scripts' => $scripts];
$app->generaVista('/plantillas/plantilla.php', $params);
?>

<script>

    //Pasamos la informacion a js
    let idUsuarioEmisor = "<?php echo $id_usuario_emisor; ?>";
    let idUsuarioReceptor = "<?php echo $idForo; ?>";
    let idForo = <?php echo $idForo; ?>;

</script>
