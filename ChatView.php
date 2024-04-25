<?php

require_once 'includes/config.php'; 


echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/imagenes.css">';

use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use es\ucm\fdi\aw\src\BD;
?>


<?php
$id_usuario_receptor = $_POST['id'];

$usuario_receptor = Usuario::buscaPorId($id_usuario_receptor);

$receptorView = visualizaUsuario($usuario_receptor);

$usuario_emisor = Usuario::buscaUsuario($_SESSION['correo']);
$id_usuario_emisor = $usuario_emisor->getId();
$mensajesView = visualizaMensajes($id_usuario_emisor, $id_usuario_receptor, $id_usuario_emisor);

$rutaChat = resuelve('/ChatView.php');
$form = new es\ucm\fdi\aw\src\Mensajes\FormularioMensajePrivado("$rutaChat?id=$id_usuario_receptor");

$form->idEmisor = $id_usuario_emisor;
$form->idDestinatario = $id_usuario_receptor;

$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Chat Usuario';
$contenidoPrincipal=<<<EOF
  	<h1>Chat en linea</h1>
    $receptorView
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
    <div class="tarjeta_usuario">
        <img src="{$imagenPath}" alt="Avatar de {$Usuario->getNombre()}" class="avatar_usuario">
        <div class="info_usuario">
            <div class="texto"><strong>Nombre:</strong> {$Usuario->getNombre()}</div>
            <div class="texto"><strong>Correo:</strong> {$Usuario->getCorreo()}</div>
            <div class="texto"><strong>Rol:</strong> {$Usuario->getRolString()}</div>
        </div>
    </div>
    EOF;
    return $html;
  }


  ?>
