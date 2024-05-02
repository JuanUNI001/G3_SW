document.addEventListener('DOMContentLoaded', function() {
    var usuarioRadio = document.getElementById('usuario');
    var profesorRadio = document.getElementById('profesor');
    var campoPrecio = document.getElementById('campo_precio');
    var avatarActual = 1;
    var numAvatares = 6;

    function actualizarVisibilidadPrecio() {
        if (profesorRadio.checked) {
            campoPrecio.style.display = 'block';  // Mostrar el campo de precio si el rol es Profesor
        } else {
            campoPrecio.style.display = 'none';   // Ocultar el campo de precio si el rol es Usuario
        }
    }
    
    usuarioRadio.addEventListener('change', actualizarVisibilidadPrecio);
    profesorRadio.addEventListener('change', actualizarVisibilidadPrecio);
    actualizarVisibilidadPrecio();                   

    function actualizarAvatar() {
        var avatarSeleccionado = document.getElementById('avatar-seleccionado');
        avatarSeleccionado.src = 'images/opcion' + avatarActual + '.png';
        avatarSeleccionado.alt = 'Avatar seleccionado ' + avatarActual;

        // Almacena la ruta de la imagen seleccionada en un campo oculto
        document.getElementById('ruta-avatar').value = 'images/opcion' + avatarActual + '.png';
    }
    
    document.getElementById('avatar-anterior').addEventListener('click', function() {
        avatarActual = (avatarActual === 1) ? numAvatares : avatarActual - 1;
        actualizarAvatar();
    });

    document.getElementById('avatar-siguiente').addEventListener('click', function() {
        avatarActual = (avatarActual === numAvatares) ? 1 : avatarActual + 1;
        actualizarAvatar();
    });
});

