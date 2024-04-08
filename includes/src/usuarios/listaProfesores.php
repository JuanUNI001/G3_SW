<?php
    use \es\ucm\fdi\aw\src\usuarios\Profesor;
    require_once __DIR__.'/../../config.php';
    $tituloPagina = 'Lista de Profesores';
    echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/imagenes.css">';
    $contenidoPrincipal = listaProfesores();
?>
<?php
function listaProfesores()
{
    $profesores = Profesor::listarProfesores();

    $html = "<div class='profesores'>";

    foreach ($profesores as $profesor) {
        $html .= visualizaProfesor($profesor);
    }

    $html .= "</div>";
    return $html;
}

function visualizaProfesor($profesor) {
        $imagenPath = $profesor->getAvatar() ? RUTA_IMGS . $profesor->getAvatar() : RUTA_IMGS . 'images/avatarPorDefecto.png'; 
        $precio = $profesor->getPrecio();
        $valoracion = $profesor->getValoracion();
        
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

        $html = <<<EOF
        <div class="profesor">
            <img src="{$imagenPath}" alt="Avatar de {$profesor->getNombre()}" class="profesor_avatar">
            <div class="profesor_info">
                <div class="profesor_nombre"><strong>Nombre:</strong> {$profesor->getNombre()}</div>
                <div class="profesor_precio"><strong>Precio:</strong> {$precioTexto}</div>
                <div class="profesor_valoracion"><strong>Valoracion:</strong> {$valoracionTexto}</div>
                <div class="profesor_correo"><strong>Correo:</strong> {$profesor->getCorreo()}</div>
                <div>
                    <button onclick="contactarProfesor('{$profesor->getCorreo()}')">Contactar</button>
                </div>
            </div>
        </div>
    EOF;

    return $html;
}


?>
