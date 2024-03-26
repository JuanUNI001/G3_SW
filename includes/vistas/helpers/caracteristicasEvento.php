<?php

require_once '../../config.php';

require_once '../../Eventos/eventos.php';



$tituloPagina = 'Evento';


if(isset($_GET['id'])) {
    $idEvento = $_GET['id'];

    $evento = Evento::buscaPorId($idEvento);


    if ($evento) {

        $contenidoPrincipal = '<div class="evento_detalles">';
        $contenidoPrincipal .= '<h2>' . htmlspecialchars($evento->getNombre()) . '</h2>';
        $contenidoPrincipal .= '<p>' . htmlspecialchars($evento->getDescripcion()) . '</p>';
        $contenidoPrincipal .= '<ul>';
        $contenidoPrincipal .= '<li><strong>Categoría:</strong> ' . htmlspecialchars($evento->getCategoria()) . '</li>';
        $contenidoPrincipal .= '<li><strong>Fecha:</strong> ' . htmlspecialchars($evento->getFecha()) . '</li>';
        $contenidoPrincipal .= '<li><strong>Lugar:</strong> ' . htmlspecialchars($evento->getLugar()) . '</li>';
        $contenidoPrincipal .= '<li><strong>Estado:</strong> ';
 
        switch($evento->getEstado()) {
            case 'Abierto':
                $colorEstado = 'green';
                break;
            case 'Terminado':
                $colorEstado = 'red';
                break;
            case 'Pendiente':
            default:
                $colorEstado = 'orange';
                break;
        }
        
        $contenidoPrincipal .= '<span style="color: ' . $colorEstado . ';">' . htmlspecialchars($evento->getEstado()) . '</span>';
        $contenidoPrincipal .= '</li>';
        $contenidoPrincipal .= '</ul>';
        $contenidoPrincipal .= '</div>';
    } else {
        $contenidoPrincipal = 'Evento no encontrado.';
    }
}


require_once 'includes/vistas/comun/layout.php';
?>
