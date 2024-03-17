<?php
    // Incluye los archivos necesarios
    require_once 'includes/config.php';
    require_once 'includes/src/Productos/Producto.php';

    // Define el título de la página
    $tituloPagina = 'Características Producto';

    // Incluye el CSS necesario
    echo '<link rel="stylesheet" type="text/css" href="css/imagenes.css">';

    // Verifica si se ha proporcionado un ID de producto
    if(isset($_GET['id_producto'])) {
        $id_producto = $_GET['id_producto'];

        // Busca el producto por su ID
        $producto = Producto::buscaPorId($id_producto);

        // Verifica si se encontró el producto
        if ($producto) {
            // Construye el HTML para mostrar los detalles del producto
            $imagenPath = RUTA_IMGS . $producto->getImagen();
            $valoracion = $producto->getValoracion();
            $valoracion_rounded = round($valoracion * 2) / 2;

            $contenidoPrincipal = <<<EOF
                <div class="producto_detalles">
                    <img src="$imagenPath" alt="{$producto->getNombre()}" class="detalle_imagen">
                    <h2>{$producto->getNombre()}</h2>
                    <p>{$producto->getDescripcion()}</p>
                    <p><strong>Precio:</strong> {$producto->getPrecio()} €</p>
                    <p><strong>Valoración:</strong> ";
                EOF;
            for ($i = 1; $i <= 5; $i++) {
                $contenidoPrincipal .= ($valoracion_rounded >= $i) ? '<span class="star">&#9733;</span>' : '<span class="star">&#9734;</span>';
            }
            $contenidoPrincipal .= " / {$producto->getNumValoraciones()} valoraciones</p>
                    <form action='agregar_al_carrito.php' method='post'>
                        <p>Cantidad: <input type='number' id='cantidad' name='cantidad' value='1' min='1' style='width: 50px;'>
                        <input type='hidden' name='id_producto' value='$id_producto'> <input type='submit' value='Agregar al carrito'></p>
                    </form>
                </div>";
            
            $contenidoPrincipal .=<<<EOF
                <div class="editar_Producto">
                <a href="/G3_SW/EditorProductoView.php">
                <img src="/G3_SW/images/editar_producto.png" alt="Editor Producto" width="50" height="50">
                </a>   
                </div>
                EOF; 


                    
        } else {
            $contenidoPrincipal = 'Producto no encontrado.';
        }
        require_once 'includes/vistas/comun/layout.php';
    }

?>
