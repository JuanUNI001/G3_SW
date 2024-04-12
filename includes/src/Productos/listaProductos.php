<?php
    use \es\ucm\fdi\aw\src\Productos\Producto;
    require_once __DIR__.'/../../config.php';
    require_once __DIR__.'/caracteristicaProducto.php';
    $tituloPagina = 'Características Producto';
    echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/imagenes.css">';
    $contenidoPrincipal = listaproductos();
?>
<?php

function listaproductos()
{
    $productos = Producto::listarProducto();

    $html = ""; // Elimina el contenedor de productos aquí

    // Agrupa los productos en grupos de tres
    $numProductos = count($productos);
    $grupoInicio = 0;
    $grupoFin = 3;

    while ($grupoInicio < $numProductos) {
        $grupoProductos = array_slice($productos, $grupoInicio, $grupoFin);
        $html .= "<div class='grupo-productos'>";
        foreach ($grupoProductos as $producto) {
            $html .= visualizaProducto($producto);
        }
        $html .= "</div>";
        $grupoInicio += 3;
        $grupoFin = min($grupoInicio + 3, $numProductos);
    }

    return $html;
}




function visualizaProducto($producto, $tipo = null)
{
    $imagenPath = RUTA_IMGS . $producto->getImagen(); // Ruta completa de la imagen
    $rutaCaract = resuelve('/includes/src/Productos/caracteristicaProducto.php'); 
    $html = '<div class="producto">';
    $html .= '<a href="'.$rutaCaract.'?id_producto='.$producto->getIdProducto().'">';
    $html .= '<img src="' . $imagenPath . '" alt="' . $producto->getNombre() . '" class="producto_imagen" >';
    $html .= '<div class="producto_nombre">' . $producto->getNombre() . '</div>';
    $html .= '</a>';
    $html .= '<div class="producto_precio"><strong>Precio:</strong> ' . $producto->getPrecio() . ' €</div>';
    $html .= '</div>';

    return $html;
}
?>


