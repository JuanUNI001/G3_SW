<?php
    // Incluye los archivos necesarios
    require_once 'includes/config.php';
    require_once 'includes/src/Eventos/eventos.php';

    // Define el título de la página
    $tituloPagina = 'Evento';

    // Verifica si se ha proporcionado un ID de producto
    if(isset($_GET['idTorneo'])) {
        $idTorneo = $_GET['idTorneo'];

        // Busca el producto por su ID
        $evento = Evento::buscaPorId($idTorneo);

        $name = $evento->nombreTorneo;
        // Verifica si se encontró el producto
        if ($evento) {
            $contenidoPrincipal = <<<EOF
            <div class="producto_detalles">
                <h2>{$name}</h2>
                <p>{$evento->getDescripcion()}</p>
            EOF;
            $contenidoPrincipal .= "</div>";

            
        } else {
            $contenidoPrincipal = 'Producto no encontrado.';
        }
        require_once 'includes/vistas/comun/layout.php';
    }

?>
