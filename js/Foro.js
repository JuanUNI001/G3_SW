let chatBox;

// Definir la función scrollToBottom
function scrollToBottom() {
    if (chatBox) {
        chatBox.scrollTop = chatBox.scrollHeight;
    }
}

document.addEventListener("DOMContentLoaded", function() {
    let form = document.querySelector(".typing-area"),
        inputField = form.querySelector(".input-field"),
        sendBtn = form.querySelector("button");

    chatBox = document.querySelector(".foro-box"); // Asignar chatBox dentro del evento DOMContentLoaded

    form.onsubmit = (e) => {
        e.preventDefault();
    }

    inputField.focus();
    inputField.onkeyup = () => {
        if (inputField.value.trim() !== "") {
            sendBtn.classList.add("active");
        } else {
            sendBtn.classList.remove("active");
        }
    }

    chatBox.onmouseenter = () => {
        chatBox.classList.add("active");
    }

    chatBox.onmouseleave = () => {
        chatBox.classList.remove("active");
    }
});

function enviarMensaje() {
    let inputField = document.querySelector(".input-field-foro");
    let message = inputField.value.trim(); // Obtener el valor del campo de texto y eliminar espacios en blanco al principio y al final
    
    // Verificar si el mensaje está vacío
    if (message === "") {
        console.log("El mensaje está vacío. No se puede enviar.");
        return; // Salir de la función si el mensaje está vacío
    }

    // Si el mensaje no está vacío, continuar con el proceso de envío
    console.log("Botón de enviar clicado");
    let xhr = new XMLHttpRequest();
    let form = document.querySelector(".typing-area");

    xhr.open("POST", "includes/src/Mensajes/put_mensaje_foro.php", true);
    xhr.onload = () => {
        console.log("Respuesta del servidor recibida");
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log("Mensaje enviado correctamente");
                inputField.value = ""; // Limpiar el campo de texto después de enviar el mensaje
                scrollToBottom();
                // Llamar a get_mensaje después de enviar el mensaje exitosamente
                obtenerMensajes();
            } else if (xhr.status === 302) { // Redirección encontrada
                console.log("Redireccionando...");
                window.location.href = xhr.getResponseHeader("Location");
            } else {
                console.error("Error en la solicitud: " + xhr.status);
            }
        }
    };

    xhr.onerror = () => {
        console.error("Error en la solicitud");
    };

    let formData = new FormData(form);
    xhr.send(formData);
}

function obtenerMensajes() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "includes/src/Mensajes/get_mensaje_foro.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.responseText;
                chatBox.innerHTML = data;
                scrollToBottom();
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id="+idForo);
}

// Llamar a obtenerMensajes() cuando se cargue la página por primera vez
window.addEventListener("load", obtenerMensajes);

// Definir el intervalo en milisegundos (por ejemplo, cada 5 segundos)
let intervalo = 15000; // 5000 milisegundos = 5 segundos

// Función para llamar a obtenerMensajes() cada cierto intervalo de tiempo
setInterval(obtenerMensajes, intervalo);