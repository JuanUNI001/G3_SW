
<?php
function listaproductos()
{
    $productos = Producto::listarProductoPrueba();

    $html = "<div class='productos'>";

    foreach ($productos as $producto) {
        $html .= visualizaProducto($producto);
    }

    $html .= "</div>";
    return $html;
}

function visualizaProducto($producto, $tipo = null)
{
    $imagenPath = RUTA_IMGS . $producto->getImagen(); // Ruta completa de la imagen
    $html = '<div class="producto">';
    $html .= '<a href="/G3_SW/caracteristicaProducto.php?id_producto=' . $producto->getIdProducto() . '">';
    $html .= '<img src="' . $imagenPath . '" alt="' . $producto->getNombre() . '" class="producto_imagen">';
    $html .= '<div class="producto_nombre">' . $producto->getNombre() . '</div>';
    $html .= '</a>';
    $html .= '<div class="producto_precio"><strong>Precio:</strong> ' . $producto->getPrecio() . ' €</div>';
    $html .= '</div>';

    return $html;
}
?>
<?php


    require_once __DIR__.'/Producto.php';
    require_once __DIR__.'/../../config.php';
    require_once __DIR__.'../../../../caracteristicaProducto.php';

    $tituloPagina = 'Características Producto';
    echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/imagenes.css">';
    $contenidoPrincipal = listaproductos();

?> 


