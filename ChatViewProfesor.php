<?php

require_once 'includes/config.php'; 


echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/imagenes.css">';

use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Profesores\Profesor;
use es\ucm\fdi\aw\src\BD;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
?>


<?php
$id_profesor = $_GET['id_profesor'];

$profesor = getProfesor($id_profesor);

$profView = visualizaProfesor($profesor);

$idReceptor = $id_profesor;
$usuario = Usuario::buscaUsuario($_SESSION['correo']);
$idEmisor = $usuario->getId();
$mensajesView = visualizaMensajes($idEmisor, $idReceptor, $idEmisor);

$rutaChat = resuelve('/ChatViewProfesor.php');
$form = new es\ucm\fdi\aw\src\Mensajes\FormularioMensajePrivado("$rutaChat?id_profesor=$id_profesor");

$form->idEmisor = $usuario->getId();
$form->idDestinatario = $id_profesor;

$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Chat profesor';
$contenidoPrincipal=<<<EOF
  	<h1>Chat en linea</h1>
    $profView
    $mensajesView
    $htmlFormLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Chat en línea'];
$app->generaVista('/plantillas/plantilla.php', $params);



function visualizaMensajes($idEmisor, $idReceptor, $viewPoint)
{
    $mensajes = Mensaje::GetMensajesInPrivateChat($idEmisor, $idReceptor);

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


function visualizaProfesor($profesor) {
    $imagenPath = $profesor->getAvatar() ? RUTA_IMGS . $profesor->getAvatar() : RUTA_IMGS . 'images/avatarPorDefecto.png'; 
    $precio = $profesor->getPrecio();
    $valoracion = $profesor->getValoracion();
    $id =  $profesor->getId();
    if ($precio === null) {
        $precioTexto = '-';
    } else {
        $precioTexto = $precio . ' €';
    }

    if ($valoracion === null) {
        $valoracionTexto = '-';
    } else {
        $valoracionTexto = $valoracion;
    }
    $app = BD::getInstance();
    
    $html = <<<EOF
    <div class="profesor">
        <img src="{$imagenPath}" alt="Avatar de {$profesor->getNombre()}" class="profesor_avatar">
        <div class="profesor_info">
            <div class="profesor_nombre"><strong>Nombre:</strong> {$profesor->getNombre()}</div>
            <div class="profesor_precio"><strong>Precio:</strong> {$precioTexto}</div>
            <div class="profesor_valoracion"><strong>Valoracion:</strong> {$valoracionTexto}</div>
            <div class="profesor_correo"><strong>Correo:</strong> {$profesor->getCorreo()}</div>
        </div>
    </div>
    EOF;

    



    return $html;
  }

function getProfesor($idProfesor)
{
    $profesores = Profesor::listarProfesores();

    foreach ($profesores as $profesor) {
        if($idProfesor == $profesor->getId())
        {
            return $profesor;
        }
    }
    return null;
}


  ?>
