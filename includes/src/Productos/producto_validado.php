<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/G3_SW/includes/views/estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Validación de Producto</title>
</head>
<body>

<div id="contenedor">

<?php
    require('/G3_SW/includes/views/cabecera.php');
    require('/G3_SW/includes/views/sidebarIzq.php');
?>

<main>
    <article>
        <h1>Resultado de la validación del Producto</h1>

        <?php
        // Verificar si se han enviado los datos del formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Verificar si se han recibido los datos esperados
            if (isset($_POST['prod_name']) && isset($_POST['prod_ID']) && isset($_POST['prod_precio'])) {
                // Recuperar los datos del formulario
                $prod_name = $_POST['prod_name'];
                $prod_ID = $_POST['prod_ID'];
                $prod_precio = $_POST['prod_precio'];
                echo "El artículo \"$prod_name\" con ID \"$prod_ID\" y precio \"$prod_precio\" ha sido añadido correctamente.";
                
            } else {
                // Mostrar un mensaje de error si faltan datos
                echo "Error: Faltan datos del formulario.";
            }
        } else {
            // Mostrar un mensaje de error si no se reciben datos POST
            echo "Error: No se han recibido datos del formulario.";
        }
        ?>

    </article>
</main>

<?php
    require('/G3_SW/includes/views/sidebarDer.php');
    require('/G3_SW/includes/views/pie.php');
?>
</div>

</body>
</html>
