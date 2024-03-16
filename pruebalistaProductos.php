<?php


require_once 'pruebaProductos.php';

 function listadoproductosPrueba()
{
    $productos = ProductoPr::listarProductoPrueba();

    $html = "<div class='productos'>";

    foreach ($productos as $producto) {
        $html .= visualizaProducto($producto);
    }

    $html .= "</div>";
    return $html;
}
function visualizaProducto($producto, $tipo=null)
{
    $html = <<<EOF
    <div class="producto">
        <a href="caracteristicasProducto.php?id_producto={$producto->getIdProducto()}">
            <img src="{$producto->getImagen()}" alt="{$producto->getNombre()}" class="producto_imagen">
            <div class="producto_nombre">{$producto->getNombre()}</div>
        </a>
        <div class="producto_precio"><strong>Precio:</strong> {$producto->getPrecio()} €</div>
    </div>
EOF;

    return $html;
}
?>
