<?php
    // Incluye los archivos necesarios
    require_once __DIR__.'/../../config.php';
    use \es\ucm\fdi\aw\src\Productos\Producto;
    use \es\ucm\fdi\aw\src\BD;
    // Define el título de la página
    $tituloPagina = 'Características Producto';

    // Incluye el CSS necesario
    $rutaCSS = resuelve('/css/imagenes.css');

// Imprimir la etiqueta link con la ruta al archivo CSS
    echo '<link rel="stylesheet" type="text/css" href="' . $rutaCSS . '">';

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
                <p><strong>Valoración: {$producto->getValoracion()}   </strong>
            EOF;
            for ($i = 1; $i <= 5; $i++) {
                $contenidoPrincipal .= ($valoracion_rounded >= $i) ? '<span class="star">&#9733;</span>' : '<span class="star">&#9734;</span>';
            }
            $contenidoPrincipal .= " / {$producto->getNumValoraciones()} valoraciones</p>";

            // Verifica si hay stock del producto
            if ($producto->getCantidad() > 0) {
                $contenidoPrincipal .= "<p class='stock verde'>En stock     ({$producto->getCantidad()} unidades)</p>";
            } else {
                $contenidoPrincipal .= "<p class='stock rojo'>Sin stock     ({$producto->getCantidad()} unidades) </p>";
            }
            
           
            if (isset($_SESSION["login"]) ) {
                $direccion = resuelve("/includes/agregar_al_carrito.php");
                $contenidoPrincipal .= <<<HTML
                    <form action='$direccion' method='post'>
                        <p>Cantidad: <input type='number' id='cantidad' name='cantidad' value='1' min='1' style='width: 50px;'>
                        <input type='hidden' name='id_producto' value='$id_producto'> <input type='submit' value='Agregar al carrito'></p>
                    </form>
                HTML;
            }


            if(isset($_SESSION["rolUser"]) && $_SESSION["rolUser"] == "admin"){
                $editarProductoRuta=resuelve('EditorProductoView.php');
                $imagenRuta=resuelve('/images/editar_producto.png');

                $contenidoPrincipal .=<<<EOF
                <div class="editar_Producto">
                    <a href="$editarProductoRuta?id_producto={$producto->getIdProducto()}">
                        <img src="$imagenRuta" alt="Editor Producto" width="50" height="50">
                    </a>   
                </div>
                EOF; 
            }
            $contenidoPrincipal .= "</div>";

        } else {
            $contenidoPrincipal = 'Producto no encontrado.';
        }
        $params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
        $app->generaVista('/plantillas/plantilla.php', $params);
    }

?>


