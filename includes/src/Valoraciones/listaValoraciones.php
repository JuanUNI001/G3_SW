<?php
use \es\ucm\fdi\aw\src\Valoraciones\Valoracion;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
function listarValoraciones($id_producto)
{
    $valoraciones = Valoracion::listarValoracion($id_producto);
    $htmlValoraciones = '<div class="valoraciones-container">';
    // Inicializar variable para almacenar el HTML de todas las valoraciones
    $htmlValoraciones .= '<div class="producto_val">';
    $htmlValoraciones .= '<h2>Valoraciones</h2>';
    // Generar HTML para cada valoración y agregarlo al contenedor
    foreach ($valoraciones as $valoracion) {
        // Obtener el nombre del usuario asociado a la valoración
        $idUsuario = $valoracion->getIdUsuario();
        $usuario = Usuario::buscaPorId($idUsuario);
        $nombreUsuario = $usuario->getNombre();

        // Generar las estrellas de la valoración
        $valoracionEstrellas = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $valoracion->getValoracion()) {
                $valoracionEstrellas .= '&#9733;'; // Estrella llena
            } else {
                $valoracionEstrellas .= '&#9734;'; // Estrella vacía
            }
        }

        // Generar HTML para la valoración actual
        $htmlValoracion = <<<HTML
        
            <div class="valoracion">
                <div class="autor_val">
                    <p><strong>Autor:</strong> {$nombreUsuario}</p>                                  
                    <div class="estrellas-val">
                        {$valoracionEstrellas}
                    </div>
                </div>
                <div class="contenido_val">
                    <p><strong>Comentario:</strong> {$valoracion->getComentario()}</p>
                </div>
            </div>
        
        HTML;

        // Agregar HTML de la valoración al contenedor de valoraciones
        $htmlValoraciones .= $htmlValoracion;
    }

    // Devolver el HTML completo con todas las valoraciones
    return $htmlValoraciones;
}

?>
