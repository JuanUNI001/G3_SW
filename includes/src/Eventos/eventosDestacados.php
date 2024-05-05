<?php
use \es\ucm\fdi\aw\src\Eventos\Evento;

function eventossDestacados()
{
    $eventos = Evento::listarEventos(); // Obtener todos los productos
    

    // Crear el HTML para mostrar los productos destacados
    
    $html = '<div class="productos-destacados">';
    $html .= '<h1>Eventos destacados</h1>';
    $html .= '<div class="contenedor-productos">';
    $html .= '<div class="flechas">';
    $html .= '<div class="flecha-izquierda">&#10094;</div>';
    $html .= '<div class="flecha-derecha">&#10095;</div>';
    $html .= '</div>'; // Cierre de div "flechas"
   
    foreach ($eventos as $evento) {
     
        $nombre = $evento->getEvento();
        $ganador = $evento->getGanador();
        $rutaCaract = resuelve('/includes/src/Eventos/caracteristicasEvento.php'); 
        // HTML de cada producto
        $html .= <<<HTML
        <div class="producto-destacado">
            <a href="{$rutaCaract}?id={$evento->getId()}" class="enlace-destacado">
   
                <div class="nombre-precio">
                    <div class="nombre">{$nombre}</div>
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
