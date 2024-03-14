<?php 
// Si INCLUSION_CHECK no está definido, significa que este script se está ejecutando directamente

    // Incluye los archivos necesarios
    require_once 'includes/config.php';
    require_once 'includes/src/Productos/productos.php';

    // Define el título de la página
    $tituloPagina = 'Características Producto';

    // Incluye el CSS necesario
    echo '<link rel="stylesheet" type="text/css" href="css/Imagenes.css">';

    // Inicializa la variable de contenido principal
    $contenidoPrincipal = '';

    // Verifica si se ha proporcionado un ID de producto
    if(isset($_GET['id_producto'])) {
        $id_producto = $_GET['id_producto'];

        // Busca el producto por su ID
        $producto = Producto::buscaPorId($id_producto);

        // Verifica si se encontró el producto
        if ($producto) {
            // Construye el HTML para mostrar los detalles del producto
            $imagenPath = RUTA_IMGS . $producto->getImagen();
            $html = '<div class="producto_detalles">';
            $html .= '<img src="' . $imagenPath . '" alt="' . $producto->getNombre() . '" class="detalle_imagen">';
            $html .= '<h2>' . $producto->getNombre() . '</h2>';
            $html .= '<p>' . $producto->descripcion() . '</p>';
            $html .= '<p><strong>Precio:</strong> ' . $producto->getPrecio() . ' €</p>';
            $html .= '<p><strong>Valoración:</strong> ';
            $valoracion = $producto->getValoracion();
            $valoracion_rounded = round($valoracion * 2) / 2;
            for ($i = 1; $i <= 5; $i++) {
                if ($valoracion_rounded >= $i) {
                    $html .= '<span class="star">&#9733;</span>'; // Estrella llena
                } else {
                    $html .= '<span class="star">&#9734;</span>'; // Estrella vacía
                }
            }
            $html .= ' / ' . $producto->getNumValoraciones() . ' valoraciones</p>';
            $html .= '<form action="agregar_al_carrito.php" method="post">';
            $html .= '<p>Cantidad: ';
            $html .= '<input type="number" id="cantidad" name="cantidad" value="1" min="1" style="width: 50px;">';
            $html .= '<input type="hidden" name="id_producto" value="' . $id_producto . '">';
            $html .= ' <input type="submit" value="Agregar al carrito">';
            $html .= '</p></form>';
            $html .= '</div>'; // Cierre del div producto_detalles

            // Guarda el HTML en la variable $contenidoPrincipal
            $contenidoPrincipal = $html;
        } else {
            // Si no se encuentra el producto, muestra un mensaje de error
            $contenidoPrincipal = 'Producto no encontrado.';
        }
    }

    // Incluye el layout para darle estructura a la página
    require 'includes/vistas/comun/layout.php';

?>