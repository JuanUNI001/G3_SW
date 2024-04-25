<?php

use \es\ucm\fdi\aw\src\BD;
use es\ucm\fdi\aw\src\Eventos\Evento;

require_once '../../config.php';


$tituloPagina = 'Características Evento';

$contenidoPrincipal ='';

    $idEvento = $_POST['id'];

    $evento = Evento::buscaPorId($idEvento);

    if ($evento) {
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
                <p><strong>Fecha:</strong> {$fec}</p>
                <p><strong>Lugar:</strong> {$lug}</p>
                <p><strong>Premio:</strong> {$prem}</p>
                <p><strong>Tasa de inscripción:</strong> {$ins}€</p>
                <p><strong>Inscritos:</strong> {$inscritos} personas</p>
                <p><strong>Aforo:</strong> {$numJ} </p>
            </div>
        EOF;

        if ($evento->getGanador()) {
            $contenidoPrincipal .= "<h2><strong>GANADOR:</strong> {$evento->getGanador()}</h2>";
        }


       if (isset($_SESSION["login"])) {
    

            $direccion = resuelve("inscribirseEventoView.php");
            $contenidoPrincipal .= <<<EOF
                <div class="inscripcion">
                    <a href="{$direccion}?id={$evento->getId()}">
                    <button type="submit" name="inscribir" class="sideBarDerButton">Inscribirse</button>
                    </a>
                </div>
            EOF;

    
        }

        if(isset($_SESSION["rolUser"]) && $_SESSION["rolUser"] == "admin"){

            $direccionEditor = resuelve("editorEventoView.php");
            $imagenRuta=resuelve('/images/editar_producto.png');
            $contenidoPrincipal .=<<<EOF
            <div class="editar_Evento">
                <a href="{$direccionEditor}?id={$evento->getId()}">
                    <img src=" $imagenRuta" alt="Editor Producto" width="50" height="50">
                </a>   
            </div>
            EOF; 
        }

    } else {
        $contenidoPrincipal .= 'Evento no encontrado.';
    } 
    
    $params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
    $app->generaVista('/plantillas/plantilla.php', $params);

?>