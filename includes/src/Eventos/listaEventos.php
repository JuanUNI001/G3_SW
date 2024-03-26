
<?php


function listaeventos()
{
    $eventos = Evento::listarEventos();

    $html = "<div class='eventos'>";

    foreach ($eventos as $evento) {
        $html .= visualizaEvento($evento);
    }

    $html .= "</div>";
    return $html;
}

function visualizaEvento($evento)
{
    // Comenzar la estructura HTML
    $html = '<div class="Evento">';

    $estado = $evento->getEstado();
    $html .= '<div>';
    $html .= '<a href="/G3_SW/includes/vistas/helpers/caracteristicasEvento.php?id=' . $evento->getId() . '">';
    // Mostrar los detalles del evento dentro de un fieldset
    $html .= '<fieldset>';
    $html .= '<legend>' . $evento->getEvento() . '</legend>';
    //switch($estado){
      //  case 'Abierto':
        //    $html .= '<span class="abierto">'.'En curso'.'</span>';
          //  break; // Agregar break para evitar la ejecución continua
       // case 'Terminado':
      //      $html .= '<span class="terminado">'.'En curso'.'</span>';
        //    break; // Agregar break para evitar la ejecución continua
    //}
    $html .= '<p>' . $evento->getEstado() . '</p>';
    $html .= '<ul>';
    $html .= '<li>' . $evento->getCategoria() . '</li>';
    // Agrega más detalles según sea necesario
    $html .= '</ul>';
    $html .= '</fieldset>';

    // Cerrar la sección del evento
    $html .= '</div>';

    // Cerrar la estructura HTML
    $html .= '</div>';

    // Retornar el HTML generado
    return $html;
}



?>
<?php


    require_once __DIR__.'/eventos.php';
    require_once __DIR__.'/../../config.php';
   

    $tituloPagina = 'Eventos';
    $contenidoPrincipal = listaEventos();

?> 


