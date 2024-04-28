<?php
use \es\ucm\fdi\aw\src\Foros\Foro;
require_once 'includes/config.php';
$tituloPagina = 'Chatea aprende y diviértete en los foros';
use es\ucm\fdi\aw\src\BD;

?>
<?php
function listaForos()
{
    $foros = Foro::listarForos();

    $html = '<div class="foro-container">';

    foreach ($foros as $foro) {
        $html .= visualizaForo($foro);
    }

    $html .= "</div>";
    return $html;
}
function listarForosBusqueda($autor, $nombre,$orden)
{
    $foros = Foro::listarForosBusqueda($autor, $nombre,$orden);

    $html = '<div class="foro-container">';

    foreach ($foros as $foro) {
        $html .= visualizaForo($foro);
    }

    $html .= "</div>";
    return $html;
}
function visualizaForo($foro) {
    $app = BD::getInstance();
    $usuarioLogueado = $app->usuarioLogueado();

    $rutaForo = resuelve('/includes/vistas/helpers/ForoView.php');
    $idForo = $foro->getId();
    $autorId = $foro->getAutor(); // Obtener el ID del autor del foro

    // Obtener el nombre del autor a partir de su ID
    $autor = \es\ucm\fdi\aw\src\Usuarios\Usuario::buscaPorId($autorId);
    $nombreAutor = $autor ? $autor->getNombre() : "Desconocido";

    $html = <<<EOF
    
        <div class="foro">
            <div class="foro_info">
                <div class="foro_autor">
                    <strong>{$nombreAutor}</strong> <!-- Mostrar el nombre del autor -->
                </div>
                <div class="foro_titulo">
                    <strong>{$foro->getTitulo()}</strong> 
                </div>
                <div class="foro_descripcion">
                     <p>{$foro->getDescripcion()}</p>   
                </div>
                <div>
    EOF;
    
    // Mostrar el enlace "Ver" solo si el usuario está logueado
    if ($usuarioLogueado) {
        $html .= '<a href="' . $rutaForo . '?id_foro=' . $idForo . '" class="button-foro">Ver</a>';
    }
    
    $html .= <<<'EOF'
                </div>
            </div>
        </div>
    
    EOF;
    
    return $html;
}

?>
