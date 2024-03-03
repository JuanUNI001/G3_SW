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

<div id="contenedor">
    <?php
    require('cabecera.php');
    require('sidebarIzq.php');
    ?>

    
        

        <main>
            <article>
            <h1>Catálogo de Productos</h1>
            
                <?php
                //Aqui lo que vamos a hacer es recoger un array de los articulos
                $productos = array(
                    array("nombre" => "Preguntados", "imagen" => "images/preguntados.jpg"),
                    array("nombre" => "Parchís y oca, 2 en 1", "imagen" => "images/parchis_oca.jpg"),
                    array("nombre" => "Quien es quien", "imagen" => "images/quien.jpg"),
                    array("nombre" => "Érase una vez", "imagen" => "images/erase.jpg"),
                    array("nombre" => "Laberinto", "imagen" => "images/laberinto.jpg"),
                    array("nombre" => "Exploding Kittens", "imagen" => "images/explodingKittens.jpg"),
                    array("nombre" => "Cluedo", "imagen" => "images/cluedo.jpg"),

                );

                //los recorremos y motramos 
                //Hay q tener en cuenta que los articulos no estan en un array sino en una BBDD y hay que obtener su info desde ahi
                
                foreach ($productos as $producto) {
                    echo '<div class="producto">';
                    echo '<a href="caracteristicasProducto.php?id_producto=' ./* $producto["id"] .*/ '">';
                    echo '<img src="' . $producto["imagen"] . '" alt="' . $producto["nombre"] . '">';
                    echo '<div class="producto_nombre">' . $producto["nombre"] . '</div>';
                    echo '</a>';
                    echo '</div>';
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
