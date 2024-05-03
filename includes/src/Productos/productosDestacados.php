<?php
use \es\ucm\fdi\aw\src\Productos\Producto;
function productosDestacados()
{
    $productosDestacados = Producto::listarProductoDestacado(); // Obtener todos los productos
    

    // Crear el HTML para mostrar los productos destacados
    
    $html = '<div class="productos-destacados">';
    $html .= '<h1>Productos destacados</h1>';
    $html .= '<div class="contenedor-productos">';
    $html .= '<div class="flecha-izquierda">&#10094;</div>';
    $html .= '<div class="flecha-derecha">&#10095;</div>';
   
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
    $html .= <<<HTML
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const flechaIzquierda = document.querySelector('.flecha-izquierda');
        const flechaDerecha = document.querySelector('.flecha-derecha');
        const contenedorProductos = document.querySelector('.contenedor-productos');

        flechaDerecha.addEventListener('click', function() {
            contenedorProductos.scrollBy({
                left: 200,
                behavior: 'smooth'
            });
        });

        flechaIzquierda.addEventListener('click', function() {
            contenedorProductos.scrollBy({
                left: -200,
                behavior: 'smooth'
            });
        });
    });
    </script>
HTML;
    $html .= '</div>'; // Cierre de div "contenedor-productos"
    $html .= '</div>'; // Cierre de div "productos-destacados"
    
    return $html;
}

?>
