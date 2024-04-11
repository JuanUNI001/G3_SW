<?php
    use \es\ucm\fdi\aw\src\Foros\Foro;
    require_once __DIR__.'/../../config.php';
    $tituloPagina = 'Lista de Foros';
    echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/imagenes.css">';
    $contenidoPrincipal = listaForos();
?>
<?php
function listaForos()
{
    $foros = Foro::listarForos();

    $html = "<div class='foro'>";

    foreach ($foros as $foro) {
        $html .= visualizaForo($foro);
    }

    $html .= "</div>";
    return $html;
}

function visualizaForo($foro) {

    $rutaVerForo = resuelve('/includes/src/Foros/verForo.php'); 
    $html = '<div class="foro">';
    $html .= '<a href="'.$rutaVerForo.'?idForo='.$foro->getId().'">';

    $html .= '<div class="foro_titulo">' . $foro->getTitulo() . '</div>';
    $html .= '<div class="foro_autor">' . $foro->getAutor() . '</div>';
    
    $html .= '</a>';
    $html .= '</div>';

    return $html;
}


?>
