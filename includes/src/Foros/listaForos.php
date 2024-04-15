<?php
    use \es\ucm\fdi\aw\src\Foros\Foro;
    require_once __DIR__.'/../../config.php';
    $tituloPagina = 'Chatea aprende y diviertete en los foros';
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

    $rutaForo = resuelve('/ForoView.php');
    $idForo = $foro->getId();
    $html = <<<HTML
    <div class="foro">
        <div class="foro_info">
            <a href="$rutaForo?id_foro=$idForo">
                <div class="foro_autor">
                    <strong> {$foro->getAutor()}</strong>
                </div>
                <div class="foro_titulo">
                    <strong>{$foro->getTitulo()}</strong> 
                </div>
            </a>
            <div class="foro_contenido">
                Contenido del foro aquí...
            </div>
            <div>
                <a href="$rutaForo?id_foro=$idForo" class="button-like-link">Ver</a>
            </div>
        </div>
    </div>
    HTML;
    
    return $html;
    
}




?>
