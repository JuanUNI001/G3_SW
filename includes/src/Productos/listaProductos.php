<?php
    use \es\ucm\fdi\aw\src\Productos\Producto;
    require_once __DIR__.'/../../config.php';
    require_once __DIR__.'/caracteristicaProducto.php';
    $tituloPagina = 'Características Producto';
    echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/imagenes.css">';
   
?>
<?php

function listaproductos()
{
    $productos = Producto::listarProducto();
    $numProductos = count($productos);
    $grupoInicio = 0;
    $html = ""; // Inicializa la variable HTML

    while ($grupoInicio < $numProductos) {
        $grupoProductos = array_slice($productos, $grupoInicio, 4);
        $html_grupo = ""; // Reinicia la variable HTML en cada iteración del bucle

        foreach ($grupoProductos as $producto) {
            $html_grupo .= visualizaProducto($producto);
        }

        $html .= "<div class='grupo-productos'>" . $html_grupo . "</div>";
        $grupoInicio += 4;
    }

    return $html;
}






function visualizaProducto($producto, $tipo = null)
{
    $imagenPath = RUTA_IMGS . $producto->getImagen(); // Ruta completa de la imagen
    $rutaCaract = resuelve('/includes/src/Productos/caracteristicaProducto.php'); 
    
    $html = '<div class="producto">';
    $html .= '<a href="'.$rutaCaract.'?id_producto='.$producto->getIdProducto().'" class="producto_enlace">';
    $html .= '<div class="producto_precio">' . $producto->getPrecio() . ' €</div>';

    

    
    $html .= '<img src="' . $imagenPath . '" alt="' . $producto->getNombre() . '" class="producto_imagen" >';
    $html .= '<div class="producto_nombre">' . $producto->getNombre() . '</div>';
    $html .= '</a>';
    $html .= '</div>';

    return $html;
}

function visualizaProductoOculto($producto, $tipo = null)
{
    $imagenPath = RUTA_IMGS . $producto->getImagen(); // Ruta completa de la imagen
    $rutaCaract = resuelve('/includes/src/Productos/caracteristicaProducto.php'); 
    
    $html = '<div class="producto_oculto">';
    $html .= '<a href="'.$rutaCaract.'?id_producto='.$producto->getIdProducto().'" class="producto_enlace_oculto">';
    $html .= '<div class="producto_precio">' . $producto->getPrecio() . ' €</div>';

    

    
    $html .= '<img src="' . $imagenPath . '" alt="' . $producto->getNombre() . '" class="producto_imagen" >';
    $html .= '<div class="producto_nombre">' . $producto->getNombre() . '</div>';
    $html .= '</a>';
    $html .= '</div>';

    return $html;
}

function listaproductosBusqueda($buscar, $buscaPrecioDesde, $buscaPrecioHasta, $orden)
{
    $productos = Producto::buscarProductosConFiltros($buscar, $buscaPrecioDesde, $buscaPrecioHasta, $orden);

    $numProductos = count($productos);
    $grupoInicio = 0;
    $html = ""; // Inicializa la variable HTML
    while ($grupoInicio < $numProductos) {
        $grupoProductos = array_slice($productos, $grupoInicio, 4);
        $html_grupo = ""; // Reinicia la variable HTML en cada iteración del bucle

        foreach ($grupoProductos as $producto) {
            $html_grupo .= visualizaProducto($producto);
        }



        $html .= "<div class='grupo-productos'>". $html_grupo."</div>";
        $grupoInicio += 4;
    }
    if (isset($_SESSION["rolUser"]) && $_SESSION["rolUser"] == "admin") { 
        $productos = Producto::buscarProductosConFiltrosArchivado($buscar, $buscaPrecioDesde, $buscaPrecioHasta, $orden);
        $numProductos = count($productos);
        $grupoInicio = 0;
        while ($grupoInicio < $numProductos) {
            $grupoProductos = array_slice($productos, $grupoInicio, 4);
            $html_grupo = ""; 

            foreach ($grupoProductos as $producto) {
                $html_grupo .= visualizaProductoOculto($producto);
            }



            $html .= "<div class='grupo-productos'>". $html_grupo."</div>";
            $grupoInicio += 4;
        }
    }

    return $html;
}


?>


<?php
 $contenidoPrincipal = listaproductos();
?>