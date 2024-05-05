
<?php

    use es\ucm\fdi\aw\src\Profesores\Profesor;
    use es\ucm\fdi\aw\src\Usuarios\Usuario;
    use es\ucm\fdi\aw\src\BD;
    require_once __DIR__.'/../../config.php';
    require_once __DIR__.'/visualizaProfesor.php';
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
function listaProfesoresFiltrada($buscar,$correo, $buscaPrecioDesde, $buscaPrecioHasta, $orden)
{
    $profesores = Profesor::listarProfesoresBusqueda($buscar,$correo, $buscaPrecioDesde, $buscaPrecioHasta, $orden);

    $html = "<div class='profesores'>";

    foreach ($profesores as $profesor) {
        $html .= visualizaProfesor($profesor);
    }

    $html .= "</div>";
    return $html;
}

?>
