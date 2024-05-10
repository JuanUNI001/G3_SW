
<?php
require_once __DIR__.'/../../config.php';

use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Foros\Foro;
use \es\ucm\fdi\aw\src\Profesores\Profesor;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use \es\ucm\fdi\aw\src\BD;
function valoracionConEstrellas($valoracion)
{
    $html = '<div class="custom-valoracion">';
    $html .= 'Valoración: ';
    $html .= '<span style="color: purple;">';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $valoracion) {
            $html .= '★';
        } else {
            $html .= '☆'; 
        }
    }
    $html .= '</span>';
    $html .= '</div>';

    return $html;
}
function profesoresDestacados()
{
    $profesores = Profesor::obtenerProfesoresDestacados();   
    $html = '<h2>Profesores Destacados</h2>';
    $html .='<div class="profesores-container">';  
    foreach ($profesores as $profesor) {
        $html .= profesorDestacadoVisualizado($profesor);
    }
    return $html;
}

function profesorDestacadoVisualizado($profesor)
{ 
    $html = '<div class="custom-profesor-destacado">';
    
    $app = BD::getInstance();
    $usuarioLogueado = $app->usuarioLogueado();  
    $nombre = $profesor->getNombre();
    $valoracion = $profesor->getValoracion();
    $avatar = $profesor->getAvatar();
    $rutaImagen = resuelve('/');
    $idProfesor = $profesor->getId();
    $rutaChat = resuelve('/ChatView.php');
    $avatarImagen = RUTA_IMGS . $avatar;
            
    $html .= '<div class="custom-profesor-info">';        
    $html .= '<div class="custom-avatar"><img src="' .  $avatarImagen . '" alt="Avatar"></div>';
       
    $html .= '<div class="custom-info-text">';
    $html .= '<p class="custom-nombre">' . $nombre . '</p>';
    $html .= valoracionConEstrellas($valoracion); 
    if($usuarioLogueado){
        
        $html .= '<form action="' . $rutaChat . '" method="post">'; // Formulario oculto
        $html .= '<input type="hidden" name="id" value="' . $profesor->getId()  . '">';
        $html .= '<button type="submit" class="custom-boton-profesor">Contactar</button>';
        $html .= '</form>';
    }
    $html .= '</div>';
    $html .= '</div>'; 
   

    // Agregar el formulario con el botón para enviar mensaje
    
    $html .= '</div>';

    return $html;
}
?>