<?php

require_once __DIR__.'/includes/config.php';


echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/imagenes.css">';

use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Foros\Foro;
use es\ucm\fdi\aw\src\BD;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
?>


<?php
$id_foro = $_GET['id_foro'];

$foro = getForo($id_foro);

$foroView = visualizaForo($foro);

$usuario = Usuario::buscaUsuario($_SESSION['correo']);
$idEmisor = $usuario->getId();
$mensajesView = visualizaMensajes($idEmisor, $id_foro, $idEmisor);

$rutaChat = resuelve('/ForoView.php');
$form = new es\ucm\fdi\aw\src\Mensajes\FormularioMensajeForo("$rutaChat?id_foro=$id_foro",$id_foro);

$form->idEmisor = $usuario->getId();
//$form->idForo = $_GET['id_foro'];

$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Conversacion Foro';
$contenidoPrincipal=<<<EOF
  	<h1>Conversacion Foro</h1>
    $foroView
    $mensajesView
    $htmlFormLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Conversacion en Foro'];
$app->generaVista('/plantillas/plantilla.php', $params);



function visualizaMensajes($idEmisor,$idForo, $viewPoint)
{
    $mensajes = Mensaje::GetMensajesInForoChat($idForo);

    $html = "<div class='chatPrivado'>";
    if($mensajes != null){
        foreach ($mensajes as $mensaje) {
            $html .= visualizaMensaje($mensaje, $viewPoint);
        }
    }
    
    $html .= "</div>";
    return $html;
}


function visualizaMensaje($mensaje, $viewPoint)
{
    $usuario = Usuario::buscaPorId($mensaje->getIdEmisor());
    $autor = $usuario->getNombre();
    
    // Determinar la clase CSS del mensaje según el viewPoint
    if ($viewPoint == $mensaje->getIdEmisor()) {
        $mensaje_class = 'conv-mensaje_emisor';
    } else {
        $mensaje_class = 'conv-mensaje_receptor';
    }
    
    $html = '<div class="conv-mensaje ' . $mensaje_class . '">';
    $html .= '<div class="autor_mensaje">' . $autor . '</div>';
    $html .= '<div class="texto_mensaje">' . $mensaje->getTexto() . '</div>';
    $html .= '</div>';
    
    return $html;
    
}


function visualizaForo($foro) {

    $html = <<<HTML
    <div class="foro">
        <div class="foro_info">

                <div class="foro_autor">
                    <strong> {$foro->getAutor()}</strong>
                </div>
                <div class="foro_titulo">
                    <strong>{$foro->getTitulo()}</strong> 
                </div>
            </a>
            <div class="foro_contenido">
                Contenido del foro aquí...
            </div>
        </div>
    </div>
    HTML;
    
    return $html;
    
  }

function getForo($idForo)
{
    $foros = Foro::listarForos();

    foreach ($foros as $foro) {
        if($idForo == $foro->getId())
        {
            return $foro;
        }
    }
    return null;
}


  ?>
