<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inscripción Exitosa</title>
<style>
    /* Estilos para la alerta */
    .alert {
        padding: 20px;
        background-color: #4CAF50;
        color: white;
        margin-bottom: 15px;
        position: relative;
    }

    /* Estilos para el botón de cerrar */
    .close-btn {
        position: absolute;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
        cursor: pointer;
        font-weight: bold;
    }
</style>
</head>
<body>

<div class="alert">
    Inscripción exitosa. ¡Bienvenido al evento!
    <span class="close-btn" onclick="cerrarAlerta()">x</span>
</div>

<script>
// Función para cerrar la alerta
function cerrarAlerta() {
    var alerta = document.querySelector('.alert');
    alerta.style.display = 'none';
}
</script>

</body>
</html>
