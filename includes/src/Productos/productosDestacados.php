<?php
use \es\ucm\fdi\aw\src\Productos\Producto;
function productosDestacados()
{
    $productosDestacados = Producto::listarProductoDestacado(); // Obtener todos los productos
    

    // Crear el HTML para mostrar los productos destacados
    
    $html = '<div class="productos-destacados">';
    $html .= '<h1>Productos destacados</h1>';
    $html .= '<div class="contenedor-productos">';
    
   
    foreach ($productosDestacados as $producto) {
        $imagenPath = RUTA_IMGS . $producto->getImagen(); // Ruta completa de la imagen
        $nombre = $producto->getNombre();
        $precio = $producto->getPrecio();
        $rutaCaract = resuelve('/includes/src/Productos/caracteristicaProducto.php'); 
        // HTML de cada producto
        $html .= <<<HTML
        <div class="producto-destacado">
            <a href="{$rutaCaract}?id_producto={$producto->getIdProducto()}" class="enlace_destacado">
                <img src="{$imagenPath}" alt="{$nombre}">
                <div class="nombre-precio">
                    <div class="nombre">{$nombre}</div>
                    <div>{$precio} €</div> <!-- Precio debajo del nombre con estilo -->
                </div>
            </a>
        </div>
HTML;
    }
    
    $html .= '<div class="flecha-izquierda-producto">&#10094;</div>';
    $html .= '<div class="flecha-derecha-producto">&#10095;</div>';
    
    $html .= '</div>'; // Cierre de div "contenedor-productos"
    $html .= '</div>'; // Cierre de div "productos-destacados"
    $rutaJs = resuelve('js/productosDestacados.js');
    $html .= "<script src='$rutaJs'></script>";
    return $html;
}

?>
