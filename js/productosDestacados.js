document.addEventListener('DOMContentLoaded', function() {
    const flechaIzquierda = document.querySelector('.flecha-izquierda-producto');
    const flechaDerecha = document.querySelector('.flecha-derecha-producto');
    const contenedorProductos = document.querySelector('.contenedor-productos');

    flechaDerecha.addEventListener('click', function() {
        contenedorProductos.scrollBy({
            left: 300,
            behavior: 'smooth'
        });
    });

    flechaIzquierda.addEventListener('click', function() {
        contenedorProductos.scrollBy({
            left: -300,
            behavior: 'smooth'
        });
    });
});