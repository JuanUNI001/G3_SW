<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/G3_SW/includes/views/estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Login</title>
<script>
function validarFormulario() {
    var nombre = document.forms["registroProducto"]["prod_name"].value;
    var id = document.forms["registroProducto"]["prod_ID"].value;
    var precio = document.forms["registroProducto"]["prod_precio"].value;
    var desc = document.forms["registroProducto"]["prod_desc"].value;
    var val = document.forms["registroProducto"]["prod_val"].value;

    var errorDiv = document.getElementById("errorDiv");
    errorDiv.innerHTML = ""; // Limpiar mensajes de error anteriores

    if (nombre.length < 5) {
        errorDiv.innerHTML += "El nombre del producto debe tener al menos 5 caracteres<br>";
        return false;
    }
    if (desc.length < 20) {
        errorDiv.innerHTML += "La descripción del producto debe tener al menos 20 caracteres<br>";
        return false;
    }
    if (isNaN(id) || id.length !== 6) {
        errorDiv.innerHTML += "El ID del producto debe ser un número de 6 dígitos<br>";
        return false;
    }

    if (isNaN(precio)) {
        errorDiv.innerHTML += "El precio del producto debe ser un número<br>";
        return false;
    }
    if (isNaN(val)) {
        errorDiv.innerHTML += "La valoración del producto debe ser un número<br>";
        return false;
    }
    // Si todas las validaciones son exitosas, se envía el formulario
    return true;
}

function enviarFormulario() {
    if (validarFormulario()) {
        document.forms["registroProducto"].action = "producto_validado.php";
        document.forms["registroProducto"].submit();
    }
}
</script>
</head>

<body>

<div id="contenedor">

<?php
    require('cabecera.php');
    require('sidebarIzq.php');
?>

<main>
    <article>
        <h1>Registrar Producto</h1>

        <form name="registroProducto" action="procesar_add_Producto.php" method="POST">
        <fieldset>
            <legend>Datos del Producto</legend>
            <div><label>Name:</label> <input type="text" name="prod_name" /></div>
            <div><label>ID:</label> <input type="number" name="prod_ID" /></div>
            <div><label>Descripción:</label> <input type="text" name="prod_desc" /></div>
            <div><label>Precio:</label> <input type="number" name="prod_precio" /></div>
            div><label>Valoración:</label> <input type="number" name="prod_val" /></div>
            <div id="errorDiv" style="color: red;"></div> <!-- Div para mostrar mensajes de error -->
            <div><button type="button" onclick="enviarFormulario()">Crear</button></div>
        </fieldset>
        </form> <!-- Se agregó la etiqueta de cierre del formulario -->
    </article>
</main>

<?php
    require('sidebarDer.php');
    require('pie.php');
?>
</div>

</body>
</html>
