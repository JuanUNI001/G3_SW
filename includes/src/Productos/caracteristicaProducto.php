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
            <div class="producto_caracteristica">
                <div class="producto_info">
                    <img src="$imagenPath" alt="{$producto->getNombre()}" class="detalle_imagen">
                    <div class="info_texto">
                        <h2>{$producto->getNombre()}</h2>
                        <p>{$producto->getDescripcion()}</p>
                    </div>
                </div>
                <p><strong>Precio:</strong> {$producto->getPrecio()} €</p>
                <!-- Resto de tu contenido -->
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
            
            $app = BD::getInstance();

            if ($app->usuarioLogueado())  {
                $direccion = resuelve("/includes/agregar_al_carrito.php");
                $contenidoPrincipal .= <<<HTML
                    <form action='$direccion' method='post'>
                    <div class="producto_detalle">
                    <div style="display: flex; align-items: center;">
                        <span style="margin-right: 10px;">Cantidad:</span>
                        <input type='number'  name='cantidad' value= '1' min='1' style='width: 40px; margin-right: 10px;'>
                    </div>                   
                        <p style="margin-top: 15px;">
                            <input type='hidden' name='id_producto' value='$id_producto'> 
                            <input type='submit' class="botonCaracteristica" value='Agregar al carrito'>
                        </p>
                        </div>
                    </form>
                HTML;
            }


            //if(isset($_SESSION["rol"]) === "admin"){
                $contenidoPrincipal .=<<<EOF
                <div class="editar_Producto">
                    <a href="/G3_SW/EditorProductoView.php?id_producto={$producto->getIdProducto()}">
                        <img src="/G3_SW/images/editar_producto.png" alt="Editor Producto" width="50" height="50">
                    </a>   
                </div>
                EOF; 
            //}
            $contenidoPrincipal .= "</div>";

        } else {
            $contenidoPrincipal = 'Producto no encontrado.';
        }
        $params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
        $app->generaVista('/plantillas/plantilla.php', $params);
    }

?>


