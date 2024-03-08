<?php
namespace includes\src\Productos;


require_once __DIR__ . '\productos.php'; // Ruta relativa al directorio actual
echo __DIR__ . '\productos.php'; // Ruta relativa al directorio actual
function listaproductos()
{
   
    
    $productos = Producto::listarProducto();



   foreach($productos as $producto) {
      
        $html .= visualizaProducto($producto);
      
   }
    
   $html .= "</table>";
    return $html;
}
function visualizaProducto($producto, $tipo=null) {
    
        $html = <<<EOF
        <div class="producto">
            <a href="caracteristicasProducto.php?id_producto={$producto->getIdProducto()}">
                <img src="{$producto->getImagen()}" alt="{$producto->getNombre()}" class="producto_imagen">
                <div class="producto_nombre">{$producto->getNombre()}</div>
            </a>
            <div class="producto_precio"><strong>Precio:</strong> {$producto->getPrecio()} €</div>
        </div>
        EOF;
    
        EOF;
     
    return $html;
}

?>