function toggleSeguir(idUsuario, idUsuarioSeguir) {
    var corazon = document.getElementById('corazon_' + idUsuarioSeguir);
    var sigue = corazon.classList.contains('corazon_lleno');
    var nuevaClase = sigue ? 'corazon_vacio' : 'corazon_lleno';
    
    // Cambiar la clase del corazón
    corazon.className = nuevaClase;

    // Enviar una solicitud AJAX para agregar/eliminar la relación de seguimiento
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'agregar_eliminar_seguir.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Actualizar la interfaz de usuario si es necesario
            var respuesta = xhr.responseText;
            if (respuesta === 'agregado') {
                console.log('Se ha agregado la relación de seguimiento.');
            } else if (respuesta === 'eliminado') {
                console.log('Se ha eliminado la relación de seguimiento.');
            } else {
                console.log('Hubo un error al procesar la solicitud.');
            }
        }
    };
    xhr.send('idUsuario=' + idUsuario + '&idUsuarioSeguir=' + idUsuarioSeguir);
}