<!DOCTYPE html>
<html>
<head>
    <title>Detalles del Producto</title>
    <link rel="stylesheet" type="text/css" href="/G3_SW/includes/views/estilo.css" />
    <link rel="stylesheet" type="text/css" href="imagenes.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        /* Puedes agregar estilos adicionales si es necesario */
    </style>
</head>
<body>
    <?php 
      
    if(isset($_GET['id_producto'])) {
        $id_producto = $_GET['id_producto'];

        $producto = Producto::buscarPorId($idProducto);

    // Verificar si se encontró el producto
    if ($producto) {
        // Obtener la ruta completa de la imagen
        $imagenPath = RUTA_IMGS . $producto->getImagen();

        // Construir el HTML para mostrar los detalles del producto
        $html = '<div class="producto_detalles">';
        $html .= '<img src="' . $imagenPath . '" alt="' . $producto->getNombre() . '" class="detalle_imagen">';
        $html .= '<h2>' . $producto->getNombre() . '</h2>';
        $html .= '<p>' . $producto->getDescripcion() . '</p>';
        $html .= '<p><strong>Precio:</strong> ' . $producto->getPrecio() . ' €</p>';
        $html .= '</div>';

        // Imprimir los detalles del producto
        echo $html;
    } else {
        // Si no se encuentra el producto, mostrar un mensaje de error
        echo "Producto no encontrado.";
    }
} 
    ?>
</body>
</html>