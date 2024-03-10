<?php


require_once 'productos.php';

 function listadoproductosPrueba()
{
    $productos = Producto::listarProductoPrueba();

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
    <div class="Producto">
    <a href="caracteristicasProducto.php?id_producto={$producto->getIdProducto()}">
       
    <img src="../../../{$producto->getImagen()}" alt="{$producto->getNombre()}" class="producto_imagen">
        <div class="producto_nombre">{$producto->getNombre()}</div>
    </a>
    <div class="producto_precio"><strong>Precio:</strong> {$producto->getPrecio()} €</div>
    
    </div>


    EOF;

    return $html;
}
?>