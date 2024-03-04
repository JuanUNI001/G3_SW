<!DOCTYPE html>
<html>
<head>
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" type="text/css" href="estilo.css" />
    <link rel="stylesheet" type="text/css" href="imagenes.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Catalogo</title>
</head>
<body>
<?php 
include ("conexionBBDD.php"); 
?>
<div id="contenedor">
    <?php
    require('cabecera.php');
    require('sidebarIzq.php');
    ?>

    <main>
        <article>
            <h1>Catálogo de Productos</h1>
            
            <?php
            // Consulta SQL para obtener los productos
            $sql = "SELECT id, nombre, descripción, precio, imagen, valoración FROM productos";
            $result = $conexion->query($sql); // Aquí se cambia $conn por $conexion

            if ($result->num_rows > 0) {
                // Mostrar cada producto
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="producto">';
                    echo '<a href="caracteristicasProducto.php?id_producto=' . $row["id"] . '">';
                    echo '<img src="' . $row["imagen"] . '" alt="' . $row["nombre"] . '">';
                    echo '<div class="producto_nombre">' . $row["nombre"] . '</div>';
                    echo '</a>';
                    echo '<div class="producto_descripcion">' . $row["descripción"] . '</div>';
                    echo '<div class="producto_precio"><strong>Precio:</strong> $' . $row["precio"] . '</div>';
                    echo '<div class="producto_valoracion"><strong>Valoración:</strong> $: ' . $row["valoración"] . '</div>';
                    
                    echo '</div>';
                }
            } else {
                echo "No se encontraron productos.";
            }
            ?>
        </article>
    </main>

    <?php
    include('sidebarDer.php');
    include('pie.php');
    ?>
</div>

</body>
</html>
