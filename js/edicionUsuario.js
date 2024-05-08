

document.addEventListener('DOMContentLoaded', function() {

    var usuarioRadio = document.getElementById('user_role');
    var profesorRadio = document.getElementById('teacher_role');
    var campoPrecio = document.getElementById('campo_precio');
    //var avatarActual = {$avatarActual};
    if (typeof avatarActual !== 'number' || isNaN(avatarActual)) {
        avatarActual = 1;
    } 
    var numAvatares = 6;

    function actualizarVisibilidadProfesor() {
        if (profesorRadio.checked) {
            campoPrecio.style.display = 'block';  // Mostrar el campo de precio si el rol es Profesor
        } else {
            campoPrecio.style.display = 'none';   // Ocultar el campo de precio si el rol es Usuario
        }
    }
    
    usuarioRadio.addEventListener('change', actualizarVisibilidadProfesor);
    profesorRadio.addEventListener('change', actualizarVisibilidadProfesor);
    actualizarVisibilidadProfesor();                   

    function actualizarAvatar() {
        if(isNaN(avatarActual) || avatarActual > numAvatares){
            avatarActual = 1; 
        }
        else if(avatarActual < 1){
            avatarActual = numAvatares; 
        }
        var avatarSeleccionado = document.getElementById('avatar-seleccionado');
        avatarSeleccionado.src = 'images/opcion' + avatarActual + '.png';
        avatarSeleccionado.alt = 'Avatar seleccionado ' + avatarActual;

        // Almacena la ruta de la imagen seleccionada en un campo oculto
        document.getElementById('editar-ruta-avatar').value = 'images/opcion' + avatarActual + '.png';
    }
    
    document.getElementById('avatar-anterior').addEventListener('click', function() {
        //avatarActual = (avatarActual === 1) ? numAvatares : avatarActual - 1;
        avatarActual = avatarActual - 1;
        actualizarAvatar();
    });

    document.getElementById('avatar-siguiente').addEventListener('click', function() {
        //avatarActual = (avatarActual === numAvatares) ? 1 : avatarActual + 1;
        avatarActual = avatarActual + 1;
        actualizarAvatar();
    });
});
