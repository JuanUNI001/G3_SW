<?php

require_once '../../config.php';
require_once '../../../includes/src/Eventos/eventos.php';

$tituloPagina = 'Características Evento';
$contenidoPrincipal ='';
// Verifica si se ha proporcionado un ID de evento

    $idEvento = $_GET['id'];

    // Busca el evento por su ID
    $evento = Evento::buscaPorId($idEvento);

    // Verifica si se encontró el evento
    if ($evento) {
        // Construye el HTML para mostrar los detalles del evento
        $inscritos = $evento->getInscritos();
        $cat = $evento->getCategoria();
        $numJ = $evento->getNumJugadores();
        $nom = $evento->getEvento();
        $des = $evento->getDescripcion();
        $fec = $evento->getFecha();
        $lug = $evento->getLugar();
        $est = $evento->getEstado();
        $prem = $evento->getPremio();
        $gan = $evento->getGanador();
        $ins = $evento->getTasaInscripcion();

   

        $contenidoPrincipal .= <<<EOF
            <div class="evento">
                <h2>{$nom}</h2>
            </div>
        EOF;

        //inscripcion
        if ($evento->getInscritos() < $evento->getNumJugadores()) {
        }

        if ($evento->getEstado() == 'Terminado') {
            $contenidoPrincipal .= "<p class='terminado'>Evento finalizado</p>";
        } else {
            $contenidoPrincipal .= "<p class='abierto'>Evento en curso...</p>";
        }

           
        
        $contenidoPrincipal .= <<<EOF
            <div class="Evento caracteristicas">
                <p><strong>Descripción: </strong>{$des}</p>
                <p><strong>Categoría:</strong> {$cat}</p>
                <p><strong>Número de jugadores:</strong> {$numJ}</p>
                <p><strong>Fecha:</strong> {$fec}</p>
                <p><strong>Lugar:</strong> {$lug}</p>
                <p><strong>Premio:</strong> {$prem}</p>
                <p><strong>Tasa de inscripción:</strong> {$ins}€</p>
            </div>
        EOF;

        if ($evento->getGanador()) {
            $contenidoPrincipal .= "<h2><strong>GANADOR:</strong> {$evento->getGanador()}</h2>";
        }


        if (isset($_SESSION["login"]) && ($_SESSION["login"] === true)) {
            $contenidoPrincipal .= <<<EOF
                <div class="Inscribirse">
                    <a href="/G3_SW/EditorProductoView.php?id_producto={$evento->getEvento()}"></a>   
                </div>
            EOF;
        }

        if(isset($_SESSION["rol"]) && $_SESSION["rol"] === "admin") {
            $contenidoPrincipal .= <<<EOF
                <div class="editarEvento">
                    <a href="/G3_SW/EditorProductoView.php?id_producto={$evento->getId()}"></a>   
                </div>
            EOF;
        }

    } else {
        $contenidoPrincipal .= 'Evento no encontrado.';
    }  


require_once '../comun/layout.php';
?>
