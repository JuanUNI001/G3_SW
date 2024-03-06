<!DOCTYPE html>
<html>
<head>
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" type="text/css" href="/G3_SW/includes/views/estilo.css" />
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
    require('/G3_SW/includes/views/cabecera.php');
    require('/G3_SW/includes/views/sidebarIzq.php');
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
                    echo '<img src="' . $row["imagen"] . '" alt="' . $row["nombre"] . '" class="producto_imagen">';
                    echo '<div class="producto_nombre">' . $row["nombre"] . '</div>';
                    echo '</a>';
                    echo '<div class="producto_precio"><strong>Precio:</strong> ' . $row["precio"] . ' €</div>';                    
                    echo '</div>';
                }
            } else {
                echo "No se encontraron productos.";
            }
            ?>
        </article>
    </main>

    <?php
    include('/G3_SW/includes/views/sidebarDer.php');
    include('/G3_SW/includes/views/pie.php');
    ?>
</div>

</body>
</html>
