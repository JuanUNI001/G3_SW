<?php

require_once 'includes/config.php'; 


echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/imagenes.css">';

use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use es\ucm\fdi\aw\src\BD;
?>


<?php
$id_Usuario = $_GET['id'];

$Usuario = getUsuario($id_Usuario);

$profView = visualizaUsuario($Usuario);

$idReceptor = $id_Usuario;
$usuario = Usuario::buscaUsuario($_SESSION['correo']);
$idEmisor = $usuario->getId();
$mensajesView = visualizaMensajes($idEmisor, $idReceptor, $idEmisor);

$rutaChat = resuelve('/ChatViewUsuario.php');
$form = new es\ucm\fdi\aw\src\Mensajes\FormularioMensajePrivado("$rutaChat?id_Usuario=$id_Usuario");

$form->idEmisor = $usuario->getId();
$form->idDestinatario = $id_Usuario;

$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Chat Usuario';
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


function visualizaUsuario($Usuario) {
    $imagenPath = $Usuario->getAvatar() ? RUTA_IMGS . $Usuario->getAvatar() : RUTA_IMGS . 'images/avatarPorDefecto.png'; 
    $id =  $Usuario->getId();
    
    $app = BD::getInstance();
    
    $html = <<<EOF
    <div class="Usuario">
        <img src="{$imagenPath}" alt="Avatar de {$Usuario->getNombre()}" class="Usuario_avatar">
        <div class="Usuario_info">
            <div class="Usuario_nombre"><strong>Nombre:</strong> {$Usuario->getNombre()}</div>
            <div class="Usuario_correo"><strong>Correo:</strong> {$Usuario->getCorreo()}</div>
            <div class="texto"><strong>Rol:</strong> {$Usuario->getRolString()}</div>
        </div>
    </div>
    EOF;

    



    return $html;
  }

function getUsuario($idUsuario)
{
    $Usuarios = Usuario::listarUsuarios();

    foreach ($Usuarios as $Usuario) {
        if($idUsuario == $Usuario->getId())
        {
            return $Usuario;
        }
    }
    return null;
}


  ?>
