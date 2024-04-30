<?php

require_once 'includes/config.php'; 


use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use es\ucm\fdi\aw\src\BD;



function visualizaMensajes($idEmisor, $idReceptor, $viewPoint)
{
    $mensajes = Mensaje::GetMensajesInPrivateChat($idEmisor, $idReceptor);
    $mensaje_class = '';
    $usuario = Usuario::buscaUsuario($_SESSION['correo']);
    $rutaJS = resuelve('/js/mensajes.js');
    $rutaJS2 = resuelve('/js/jquery-3.7.1.min.js');
    if ($usuario) {
        $nombreUsuario = $usuario->getNombre();
        $imagenUsuario = $usuario->getAvatar();
    }
    
    $idEmisor = $usuario->getId();
    $idReceptor = $_POST['id'];
    $receptor = Usuario::buscaPorId($idReceptor);
    $autor = $receptor->getNombre();
    $imagenPath = $receptor->getAvatar() ? RUTA_IMGS . $receptor->getAvatar() : RUTA_IMGS . 'images/avatarPorDefecto.png'; 
    $rutaNew = resuelve('includes/src/Mensajes/nuevo_mensaje.php');
    $rutaGetter = resuelve('includes/src/Mensajes/get_mensaje.php');

    $mensaje_class .= <<<HTML
    <div class="conv-mensaje ">
        
    </div>
    <div class="wrapper">
        <section class="chat-area">
            <header class="custom-header">          
                <a href="javascript:history.back()" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="{$imagenPath}" alt="Avatar de {$usuario->getNombre()}" class="avatar_usuario">               
                <div class="details">
                    <span>$autor</span>
                    
                    </div>
            </header>
            <div class="chat-box">
HTML;

    // Obtener mensajes del chat
    
    
        $mensaje_class .= <<<HTML
                </div>
                <form action="#" class="typing-area">
                    <input type="hidden" name="idEmisor" value="$idEmisor">
                    <input type="hidden" name="idDestinatario" value="$idReceptor">
                    <input type="text" name="message" class="input-field" placeholder="Escribe un mensaje aquí ..." autocomplete="off">
                    <div id="enviarMensaje" class="enviar-mensaje" onclick="enviarMensaje()">
                        <button><i class="fab fa-telegram-plane"></i></button>
                    </div>


                </form>

            </section>
        </div>
        

    HTML;

    return $mensaje_class;
}





?>
<?php

$id_usuario_receptor = $_POST['id'];

$usuario_receptor = Usuario::buscaPorId($id_usuario_receptor);

$usuario_emisor = Usuario::buscaUsuario($_SESSION['correo']);
$id_usuario_emisor = $usuario_emisor->getId();
$mensajesView = visualizaMensajes($id_usuario_emisor, $id_usuario_receptor, $id_usuario_emisor);

$tituloPagina = 'Chat Usuario';
$contenidoPrincipal = <<<HTML
    <h1>Chat en linea</h1>
    $mensajesView
HTML;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Chat en línea'];
$app->generaVista('/plantillas/plantilla.php', $params);
?>


<script>
// Definir chatBox como una variable global
let chatBox;

// Código JavaScript para el manejo de mensajes en tiempo real
let idUsuarioEmisor = "<?php echo $id_usuario_emisor; ?>";
let idUsuarioReceptor = "<?php echo $id_usuario_receptor; ?>";
let rutaNuevoMensaje = "../../src/Mensajes/nuevo_mensaje.php";
let rutaObtenerMensajes = "../../src/Mensajes/get_mensaje.php";

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

    chatBox = document.querySelector(".chat-box"); // Asignar chatBox dentro del evento DOMContentLoaded

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

    setInterval(() => {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "includes/src/Mensajes/get_mensaje.php", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.responseText;
                    chatBox.innerHTML = data;
                    if (!chatBox.classList.contains("active")) {
                        scrollToBottom();
                    }
                }
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("incoming_id=<?php echo $id_usuario_receptor; ?>");
    }, 500);
});

function enviarMensaje() {
    let inputField = document.querySelector(".input-field");
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

    xhr.open("POST", "includes/src/Mensajes/put_mensaje.php", true);
    xhr.onload = () => {
        console.log("Respuesta del servidor recibida");
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log("Mensaje enviado correctamente");
                inputField.value = ""; // Limpiar el campo de texto después de enviar el mensaje
                scrollToBottom();
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


</script>