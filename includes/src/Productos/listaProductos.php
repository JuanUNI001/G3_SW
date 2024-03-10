<?php
require_once __DIR__.'/productos.php';
require_once __DIR__.'/../../config.php';
require_once __DIR__.'/caracteristicaProducto.php';
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
    <a href="/G3_SW/caracteristicaProducto.php?id_producto=' . $producto->IdProducto() . '">
            <img src="{$imagenPath}" alt="{$producto->getNombre()}" class="producto_imagen">
            <div class="producto_nombre">{$producto->getNombre()}</div>
        </a>
        <div class="producto_precio"><strong>Precio:</strong> {$producto->getPrecio()} €</div>
    </div>
        <div class="editar_Producto">
        <a href="/G3_SW/EditorProductoView.php">
        <img src="/G3_SW/images/editar_producto.png" alt="Editor Producto"">
        </a>   
    </div>


    EOF;

    return $html;
}

?>

</body>
</html>
