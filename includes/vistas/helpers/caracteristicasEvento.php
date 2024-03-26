<?php
// Incluye los archivos necesarios
require_once '../../config.php';
//use \es\ucm\fdi\aw\src\Eventos\eventos;
require_once '../../Eventos/eventos.php';


// Define el título de la página
$tituloPagina = 'Evento';

// Verifica si se ha proporcionado un ID de evento
if(isset($_GET['id'])) {
    $idEvento = $_GET['id'];

    // Busca el evento por su ID
    $evento = Evento::buscaPorId($idEvento);

    // Verifica si se encontró el evento
    if ($evento) {
        // Construye el contenido principal
        $contenidoPrincipal = '<div class="evento_detalles">';
        $contenidoPrincipal .= '<h2>' . htmlspecialchars($evento->getNombre()) . '</h2>';
        $contenidoPrincipal .= '<p>' . htmlspecialchars($evento->getDescripcion()) . '</p>';
        $contenidoPrincipal .= '<ul>';
        $contenidoPrincipal .= '<li><strong>Categoría:</strong> ' . htmlspecialchars($evento->getCategoria()) . '</li>';
        $contenidoPrincipal .= '<li><strong>Fecha:</strong> ' . htmlspecialchars($evento->getFecha()) . '</li>';
        $contenidoPrincipal .= '<li><strong>Lugar:</strong> ' . htmlspecialchars($evento->getLugar()) . '</li>';
        $contenidoPrincipal .= '<li><strong>Estado:</strong> ';
        
        // Determina el color del estado
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

// Requiere el layout común
require_once 'includes/vistas/comun/layout.php';
?>
