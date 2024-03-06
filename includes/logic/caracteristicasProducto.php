<!DOCTYPE html>
<html>
<head>
    <title>Detalles del Producto</title>
    <link rel="stylesheet" type="text/css" href="/G3_SW/includes/views/estilo.css" />
    <link rel="stylesheet" type="text/css" href="imagenes.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        /* Puedes agregar estilos adicionales si es necesario */
    </style>
</head>
<body>
    <?php 
    include("conexionBBDD.php");

    // Verifica si se ha recibido el ID del producto
    if(isset($_GET['id_producto'])) {
        $id_producto = $_GET['id_producto'];

        // Consulta SQL para obtener la información del producto seleccionado
        $sql = "SELECT id, nombre, descripción, precio, imagen, valoración, num_valoraciones FROM productos WHERE id = $id_producto";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            $producto = $result->fetch_assoc(); // Obtiene los datos del producto
            ?>
            <div id="contenedor">
                <?php require('/G3_SW/includes/views/cabecera.php'); ?>
                <?php require('/G3_SW/includes/views/sidebarIzq.php'); ?>

                <main>
                    <article>
                        <div class="producto_detalle">
                            <img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>" class="detalle_imagen">
                            <h2><?php echo $producto['nombre']; ?></h2>
                            <p><?php echo $producto['descripción']; ?></p>
                            <p><strong>Precio:</strong> $<?php echo $producto['precio']; ?></p>
                            
                            <p><strong>Valoración:</strong> 
                                    <?php
                                    $valoracion = $producto['valoración'];
                                    $valoracion_rounded = round($valoracion * 2) / 2; //redondeamos la valoracion pq no podemos hacer mitades
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($valoracion_rounded >= $i) {
                                            echo '<span class="star">&#9733;</span>'; // Spawnea una estrella llena
                                        } else {
                                            echo '<span class="star">&#9734;</span>'; // Spawnea una estrella vacía
                                        }
                                    }
                                    ?>
                                
                            / <?php echo $producto['num_valoraciones']; ?>valoraciones</p>
                            <form action="agregar_al_carrito.php" method="post">
                            <p>Cantidad:
                                <input type="number" id="cantidad" name="cantidad" value="1" min="1" style="width: 50px;">
                                <input type="hidden" name="id_producto" value="<?php echo $producto['id']; ?>">
                                <input type="submit" value="Agregar al carrito">
                            </p>
                            </form>
                        </div>
                    </article>
                </main>

                <?php include('/G3_SW/includes/views/sidebarDer.php'); ?>
                <?php include('/G3_SW/includes/views/pie.php'); ?>
            </div>
            <?php
        } else {
            echo "Producto no encontrado.";
        }
    } else {
        echo "ID del producto no especificado.";
    }
    ?>
</body>
</html>
