<?php

    use es\ucm\fdi\aw\src\Eventos\Evento;
    require_once __DIR__.'/../../config.php';


    $tituloPagina = 'Eventos';
    $contenidoPrincipal = listaEventos();

?> 


<?php


function listaeventos()
{
    $eventos = Evento::listarEventos();

    $html = '<div class="eventos">';

    foreach ($eventos as $evento) {
        $html .= visualizaEvento($evento);
    }

    $html .= "</div>";
    return $html;
}
function listaeventosBusqueda($buscar, $buscaPrecioDesde, $buscaPrecioHasta, $fechaDesde, $fechaHasta, $orden, $categoria, $estado)
{
    $eventos = Evento::listaEventosBusqueda($buscar, $buscaPrecioDesde, $buscaPrecioHasta, $fechaDesde, $fechaHasta, $orden, $categoria, $estado);

    $html = '<div class="eventos">';

    foreach ($eventos as $evento) {
        $html .= visualizaEvento($evento);
    }

    $html .= "</div>";
    return $html;
}
function visualizaEvento($evento)
{
    $html = '<div class="Evento">'; // Se cambió la clase "evento" por "Evento" para que coincida con el CSS

    $estado = $evento->getEstado();
    $rutaCaract = resuelve('/includes/src/Eventos/caracteristicasEvento.php'); 
    $html .= '<a href="'.$rutaCaract.'?id=' . $evento->getId() . '">';

    $html .= '<legend>' . $evento->getEvento() . '</legend>';
    $html .= '<p>' . $evento->getEstado() . '</p>';
    $html .= '<ul>';
    $html .= '<li>' . $evento->getCategoria() . '</li>';
    // Puedes agregar más características aquí

    $html .= '</ul>';


    $html .= '</a>'; // Cierre del enlace

    $html .= '</div>';

    return $html;
}

?>



