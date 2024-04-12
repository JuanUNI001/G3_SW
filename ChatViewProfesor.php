<?php

require_once 'includes/config.php'; 


echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/imagenes.css">';

use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Profesores\Profesor;
use es\ucm\fdi\aw\src\BD;

?>


<?php
$id_profesor = $_GET['id_profesor'];

$profesor = Profesor::buscaPorId($id_profesor);

$profView = visualizaProfesor($profesor);


$form = new es\ucm\fdi\aw\src\Mensajes\FormularioMensajePrivado();

$form->idEmisor;
$form->idDestinatario = $id_profesor;
$form->es_privado = true;

$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Chat profesor';
$contenidoPrincipal=<<<EOF
  	<h1>Chat en linea</h1>
    $profView
    $htmlFormLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Char en línea'];
$app->generaVista('/plantillas/plantilla.php', $params);



function listaMensajes()
{
    $mensajes = Mensaje::listarMensajes($idEmisor, $idDestinatario, "privado");

    $html = "<div class='mensajes'>";
    if($mensajes != null){
        foreach ($mensajes as $mensaje) {
            $html .= visualizaMensaje($mensaje);
        }
    
    }
    
    $html .= "</div>";
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
  ?>
