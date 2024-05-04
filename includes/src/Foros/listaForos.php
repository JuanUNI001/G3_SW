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

    $rutaForo = resuelve('ForoView.php');
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
            
    EOF;
   
    
    if ($usuarioLogueado) {
        $html .= <<<EOF
            <form action="{$rutaForo}" method="post">
                <input type="hidden" name="id" value="{$idForo}">
                <button type="submit" class="button-foro">Acceder</button>
            </form>
        EOF;    
    }
    if (isset($_SESSION["rolUser"]) && $_SESSION["rolUser"] == "admin") {
        
        $eliminarForo = resuelve('includes/src/Foros/eliminarForo.php');

        $html .=<<<EOF
        <form class="eliminar-foro" action="$eliminarForo" method="post" style="float: right;">
            <input type="hidden" name="id_foro" value="$idForo">
            
            <button type="submit" style="background:none; border:none; padding:0; font-size:inherit; cursor:pointer;">
                🗑️
            </button>
        </form>
        EOF;
    }
    
    $html .= '</div></div>'; // Cierre de las etiquetas div de foro_info y foro
    
    return $html;
}

?>
