

<!DOCTYPE html>
<html>
<?php
require_once '../config.php';
?>
<head>
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/estilo.css" />
    <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/imagenes.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Catalogo</title>
</head>
<body>
<?php 
include ("conexionBBDD.php"); 
?>
<div id="contenedor">
    <?php
    require(RUTA_VISTAS . '/cabecera.php');
    require(RUTA_VISTAS . '/sidebarIzq.php');
    ?>

    <main>
        <article>
            <h1>Catálogo de Productos</h1>
            
           
        </article>
    </main>

    <?php
    include(RUTA_VISTAS . '/sidebarDer.php');
    include(RUTA_VISTAS . '/pie.php');
    ?>
</div>

</body>
</html>
