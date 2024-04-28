<?php
    use \es\ucm\fdi\aw\src\Foros\Foro;
    require_once 'includes/config.php';
    $tituloPagina = 'Chatea aprende y diviertete en los foros';
    use es\ucm\fdi\aw\src\BD;
?>
<?php
function listaForos()
{
    $foros = Foro::listarForos();

    $html = "<div>";

    foreach ($foros as $foro) {
        $html .= visualizaForo($foro);
    }

    $html .= "</div>";
    return $html;
}
function listarForosBusqueda($autor, $nombre,$orden)
{
    $foros = Foro::listarForosBusqueda($autor, $nombre,$orden);

    $html = "<div>";

    foreach ($foros as $foro) {
        $html .= visualizaForo($foro);
    }

    $html .= "</div>";
    return $html;
}
function visualizaForo($foro) {

    $app = BD::getInstance();
    $usuarioLogueado = $app->usuarioLogueado();

    $rutaForo = resuelve('/ForoView.php');
    $idForo = $foro->getId();
   
    $rutaForo = resuelve('/ForoView.php');
    $idForo = $foro->getId();
    $html = <<<EOF
    <div class="foro">
        <div class="foro_info">
            <div class="foro_autor">
                <strong>{$foro->getAutor()}</strong>
            </div>
            <div class="foro_titulo">
            <strong>{$foro->getTitulo()}</strong> 
            </div>
            <div class="foro_contenido">
                Contenido del foro aquí...
            </div>
            <div>
    EOF;
    
    // Display the "Ver" link only if the user is logged in
    if ($usuarioLogueado) {
        $html .= '<a href="' . $rutaForo . '?id_foro=' . $idForo . '" class="button-like-link">Ver</a>';
    }
    
    $html .= <<<'EOF'
            </div>
        </div>
    </div>
    EOF;
    
    return $html;
    
}




?>