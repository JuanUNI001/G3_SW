<?php

require_once 'Productos.php';
require_once '../includes/vistas/helpers/autorizacion.php';
require_once __DIR__ . '/../../config.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu título de página</title>
    <link rel="stylesheet" type="text/css" href="<?php echo RUTA_CSS ?>/imagenes.css">

</head>
<body>
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
function visualizaProducto($producto, $tipo=null)
{
    $imagenPath = RUTA_IMGS . $producto->getImagen(); // Ruta completa de la imagen
    $html = <<<EOF
    <div >
        <a href="/G3_SW/includes/src/Productos/caracteristicasProducto.php?id_producto={$producto->getIdProducto()}">
            <img src="{$imagenPath}" alt="{$producto->getNombre()}" class="producto_imagen">
            <div class="producto_nombre">{$producto->getNombre()}</div>
        </a>
        <div class="producto_precio"><strong>Precio:</strong> {$producto->getPrecio()} €</div>
    </div>
    <div class="eliminador_Producto">
        <img src="/G3_SW/images/eliminar_producto.png" alt="Eliminar Producto" onclick="eliminarProducto()">
    </div>


    EOF;

    return $html;
}
?>