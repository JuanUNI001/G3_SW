<?php
require_once 'includes/src/Productos/Producto.php'; // Ajusta la ruta según sea necesario
require_once 'includes/config.php'; // Ajusta la ruta según sea necesario

// Verifica si se ha recibido el ID del producto
if(isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];

    // Realiza la lógica para obtener la información del producto con el ID proporcionado
    $producto = Producto::buscarPorId($id_producto); // Ajusta el método según tu implementación

    if ($producto) {
        // Si el producto se encontró, muestra sus características
        $html = '<div class="producto">';
        $html .= '<h2>' . $producto->getNombre() . '</h2>';
        $html .= '<p><strong>Precio:</strong> ' . $producto->getPrecio() . ' €</p>';
        $html .= '<p><strong>Descripción:</strong> ' . $producto->getDescripcion() . '</p>';
        $html .= '<p><strong>Imagen:</strong> <img src="' . $producto->getImagen() . '" alt="' . $producto->getNombre() . '"></p>';
        $html .= '<p><strong>Valoración:</strong> ' . $producto->getValoracion() . '</p>';
        $html .= '<p><strong>Número de valoraciones:</strong> ' . $producto->getNumValoraciones() . '</p>';
        // Puedes agregar más detalles del producto según sea necesario
        $html .= '</div>';

        echo $html;
    } else {
        // Si no se encontró el producto, muestra un mensaje de error
        echo "Producto no encontrado.";
    }
} else {
    // Si no se proporcionó un ID de producto, muestra un mensaje de error
    echo "ID del producto no especificado.";
}
?>
