<?php

require_once __DIR__.'/../../config.php';




use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Foros\Foro;
use es\ucm\fdi\aw\src\BD;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
?>
<?php
function visualizaMensajes($idEmisor,$idForo, $viewPoint)
{
    $mensajes = Mensaje::GetMensajesInForoChat($idForo);
    $html = "<div class ='foro-container'>";
    $html .= "<div class='chatPrivado'>";
    if($mensajes != null){
        foreach ($mensajes as $mensaje) {
            $html .= visualizaMensaje($mensaje, $viewPoint);
        }
    }
    
    $html .= "</div>";
    $html .= "</div>";
    return $html;
}


function visualizaMensaje($mensaje, $viewPoint)
{
    $usuario = Usuario::buscaPorId($mensaje->getIdEmisor());
    $autor = $usuario->getNombre();
    $nombreAutor = $autor ? $autor : "Desconocido";
    // Determinar la clase CSS del mensaje según el viewPoint
    if ($viewPoint == $mensaje->getIdEmisor()) {
        $mensaje_class = 'conv-mensaje_emisor';
    } else {
        $mensaje_class = 'conv-mensaje_receptor';
    }
    //$fechaHora = $mensaje->getFechaYHora();
    $html = '<div class="conv-mensaje ' . $mensaje_class . '">';
    //$html .= '<div class="fecha_hora">' . $fechaHora . '</div>';
    $html .= '<div class="autor_mensaje">' . $nombreAutor . '</div>';
    $html .= '<div class="texto_mensaje">' . $mensaje->getTexto() . '</div>';
    $html .= '</div>';
    
    return $html;
    
}


function visualizaForo($foro) {
    
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
$id_foro = $_GET['id_foro'];

$foro = Foro::buscaForo($id_foro);

$foroView = visualizaForo($foro);
$app = BD::getInstance();

if ($app->usuarioLogueado())  {
    $usuario = Usuario::buscaUsuario($_SESSION['correo']);
    $idEmisor = $usuario->getId();
    $mensajesView = visualizaMensajes($idEmisor, $id_foro, $idEmisor);

    $rutaChat =resuelve('/includes/vistas/helpers/ForoView.php');
    $form = new es\ucm\fdi\aw\src\Mensajes\FormularioMensajeForo("$rutaChat?id_foro=$id_foro",$id_foro);

    $form->idEmisor = $usuario->getId();
    //$form->idForo = $_POST['id_foro'];

    $htmlFormLogin = $form->gestiona();

    $tituloPagina = 'Conversacion Foro';
    $contenidoPrincipal=<<<EOF
        <h1>Conversacion Foro</h1>
        $foroView
        $mensajesView
        $htmlFormLogin
    EOF;
}
    $params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Conversacion en Foro'];
    $app->generaVista('/plantillas/plantilla.php', $params);


?>
