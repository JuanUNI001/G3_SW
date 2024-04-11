<?php

require_once 'includes/config.php'; 


echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/imagenes.css">';

use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Profesores\Profesor;
use es\ucm\fdi\aw\src\BD;

?>
<?php  // a continuacion hay una ayuda para saber por donde poder seguir
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

function visualizaMensaje($mensaje) {
  $contenido = //algo como $mensaje->getContenido();
  $fecha_hora = // algo como $mensaje->getDate();

      $html = <<<EOF
      <div class="mensaje">
          <img src="{$imagenPath}" alt="Avatar de {$mensaje->getNombre()}" class="profesor_avatar">
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

<?php
$id_profesor = $_GET['id_profesor'];

$profesor = Profesor::buscaPorId($id_profesor);

$profView = visualizaProfesor($profesor);


$form = new es\ucm\fdi\aw\src\Mensajes\FormularioEnviarMensaje();

$form->id;
$form->idEmisor;
$form->idDestinatario = $id_profesor;
$form->es_privado = true;
$form->mensaje;

$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Chat profesor';
$contenidoPrincipal=<<<EOF
  	<h1>Chat en linea</h1>
    $profView
    $htmlFormLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Char en línea'];
$app->generaVista('/plantillas/plantilla.php', $params);



