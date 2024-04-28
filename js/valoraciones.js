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

function cargarValoraciones(offset) {
    fetch(`obtener_valoraciones.php?id_producto=${idProducto}&offset=${offset}`)
        .then(response => response.text())
        .then(data => {
            // Agregar nuevas valoraciones al contenedor
            valoracionesContainer.innerHTML += data; 

            // Llamar a la función para ajustar el tamaño de la barra de desplazamiento
            ajustarScrollBar();
        });
}

function ajustarScrollBar() {
    // Obtener el contenedor de valoraciones
    var valoracionesContainer = document.getElementById('valoraciones-container');

    // Obtener todas las valoraciones
    var valoraciones = valoracionesContainer.getElementsByClassName('valoracion');

    // Calcular la altura total de todas las valoraciones
    var totalHeight = 0;
    for (var i = 0; i < valoraciones.length; i++) {
        totalHeight += valoraciones[i].offsetHeight;
    }

    // Establecer la altura del contenedor para permitir el desplazamiento
    valoracionesContainer.style.height = totalHeight + 'px';
}
