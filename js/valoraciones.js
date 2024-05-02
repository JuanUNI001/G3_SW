function seleccionarEstrella(valor) {
    // Establecer el valor de la valoración
    document.getElementById('valoracion').value = valor;
    
    // Obtener todas las estrellas
    var estrellas = document.getElementsByClassName('estrella');
    
    // Iterar sobre todas las estrellas
    for (var i = 0; i < estrellas.length; i++) {
        // Si el índice de la estrella es menor o igual al valor, establecer su color a amarillo, de lo contrario, establecerlo a blanco
        estrellas[i].style.color = i < valor ? 'yellow' : 'white';
    }
}

