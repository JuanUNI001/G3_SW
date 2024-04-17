<?php

require_once 'includes/config.php'; 
use \es\ucm\fdi\aw\src\Productos\Producto;

function generarHTML() {
    
    $form = new es\ucm\fdi\aw\src\Productos\FormularioBusquedaProducto();
    $form->productos = listaproductos();
    
    $htmlFormLogin = $form->gestiona();

    $tituloPagina = 'Búsqueda Producto';
    $contenidoPrincipal = <<<EOF
  	
    $htmlFormLogin
EOF;
    return $contenidoPrincipal;
    
}

// Generar HTML
$html = generarHTML();

// Convertir el array de parámetros en HTML
return $html;

?>
