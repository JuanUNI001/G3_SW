<?php

require_once __DIR__.'/../../src/Foros/forosDestacados.php';
require_once __DIR__.'/../../src/Profesores/profesoresDestacados.php';
$contenidoPrincipal  = '';

$contenidoPrincipal = '<div class="custom-foros-destacados">';
$contenidoPrincipal .= '<div>'.forosDestacados().'</div>';
$contenidoPrincipal .= '<div>'.profesoresDestacados().'</div>';
$contenidoPrincipal .= '</div>';
?>

<aside id="sidebarDer">

<?php echo $contenidoPrincipal; ?>

   
</aside>
