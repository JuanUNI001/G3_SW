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
        $titulo = $foro->getTitulo();
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

        //if(isset($_SESSION["rol"]) === "admin"){
            $html .=<<<EOF
            <div class="editar_Profesor">
                <a href="/G3_SW/EditorProfesorView.php?id_profesor={$profesor->getId()}">
                    <img src="/G3_SW/images/editar_producto.png" alt="Editor Producto" width="50" height="50">
                </a>   
            </div>
            EOF; 
        //}

    return $html;
}


?>
