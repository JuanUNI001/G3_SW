let eventoActual = 0;
let eventos = document.querySelectorAll(".evento-custom");

function cambiarEvento(direccion) {
    eventoActual += direccion;
    if (eventoActual < 0) { eventoActual = 0; }
    if (eventoActual >= eventos.length) { eventoActual = eventos.length - 1; }
    eventos.forEach(evento => evento.style.display = "none");
    eventos[eventoActual].style.display = "block";

    // Ajustar el desplazamiento horizontal
    eventos[eventoActual].scrollIntoView({ behavior: "smooth", inline: "center" });
}

cambiarEvento(0);
