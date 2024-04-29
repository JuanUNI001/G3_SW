let form = document.querySelector(".typing-area"),
    inputField = form.querySelector(".input-field"),
    sendBtn = form.querySelector("button"),
    chatBox = document.querySelector(".chat-box");

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

sendBtn.onclick = () => {
    console.log("Botón de enviar clicado");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../../src/Mensajes/nuevo_mensaje.php", true);
    xhr.onload = () => {
        console.log("Respuesta del servidor recibida");
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log("Mensaje enviado correctamente");
                inputField.value = "";
                scrollToBottom();
            } else {
                console.error("Error en la solicitud: " + xhr.status);
            }
        }
    }
    xhr.onerror = () => {
        console.error("Error en la solicitud");
    }
    let formData = new FormData(form);
    xhr.send(formData);
}

chatBox.onmouseenter = () => {
    chatBox.classList.add("active");
}

chatBox.onmouseleave = () => {
    chatBox.classList.remove("active");
}

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../../src/Mensajes/get_mensaje.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                chatBox.innerHTML = data;
                if (!chatBox.classList.contains("active")) {
                    scrollToBottom();
                }
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id=" + form.querySelector(".incoming_id").value);
}, 500);

function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}
