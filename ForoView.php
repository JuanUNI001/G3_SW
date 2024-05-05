<?php

require_once 'includes/config.php';


use es\ucm\fdi\aw\src\Mensajes\Mensaje;
use es\ucm\fdi\aw\src\Foros\Foro;
use es\ucm\fdi\aw\src\BD;
use es\ucm\fdi\aw\src\Usuarios\Usuario;
?>
<?php
function visualizaMensajes($idEmisor, $idReceptor, $viewPoint)
{

    $mensaje_class = '';
    $usuario = Usuario::buscaUsuario($_SESSION['correo']);
    if ($usuario) {
        $nombreUsuario = $usuario->getNombre();
        $imagenUsuario = $usuario->getAvatar();
    }
    
    $idEmisor = $usuario->getId();
    $idForo = $_POST['id'];
    $idReceptor = $idForo;
    $receptor = Usuario::buscaPorId($idReceptor);
    $autor = $receptor->getNombre();
    $imagenPath = $receptor->getAvatar() ? RUTA_IMGS . $receptor->getAvatar() : RUTA_IMGS . 'images/avatarPorDefecto.png'; 
    $rutaNew = resuelve('includes/src/Mensajes/put_mensaje_foro.php');
    $rutaGetter = resuelve('includes/src/Mensajes/get_mensaje_foro.php');

    $mensaje_class .= <<<HTML
    <div class="conv-mensaje ">
        
    </div>
    <div class="wrapper-foro">
        <section class="foro-area">
HTML;

//cabecera
$foroView = visualizaForo($idForo);

$mensaje_class .= <<<HTML
            <header class="custom-header-foro">          
                <a href="javascript:history.back()" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <h1>Discusión en el Foro</h1>
                $foroView
            </header>
            <div class="foro-box">
HTML;

    // Obtener mensajes del chat
    
    
        $mensaje_class .= <<<HTML
                </div>
                <form action="#" class="typing-area">
                    <input type="hidden" name="idEmisor" value="$idEmisor">
                    <input type="hidden" name="idDestinatario" value="$idReceptor">
                    <textarea name="message" class="input-field-foro" placeholder="Escribe un mensaje aquí ..." autocomplete="off"></textarea>
                    <div id="enviarMensaje" class="enviar-mensaje" onclick="enviarMensaje()">
                        <button><i class="fab fa-telegram-plane"></i></button>
                    </div>


                </form>

            </section>
        </div>
        

    HTML;

    return $mensaje_class;
}

function visualizaForo($idForo) {
    
    $foro = Foro::buscaForo($idForo);

    $autor_id = $foro->getAutor();
    $autor = \es\ucm\fdi\aw\src\Usuarios\Usuario::buscaPorId($autor_id);
    $nombreAutor = $autor ? $autor->getNombre() : "Desconocido";
    $html = <<<HTML
   

    <div class="foro">
        <div class="foro_info">

                <div class="foro_autor">
                    <strong> $nombreAutor</strong>
                </div>
                <div class="foro_titulo">
                    <strong>{$foro->getTitulo()}</strong> 
                </div>
            </a>
           
        </div>
    </div>
    HTML;
    
    return $html;
    
  }



?>

<?php

$idForo = $_POST['id'];


$usuario_emisor = Usuario::buscaUsuario($_SESSION['correo']);
$id_usuario_emisor = $usuario_emisor->getId();

$mensajesView = visualizaMensajes($id_usuario_emisor, $idForo, $id_usuario_emisor);

$tituloPagina = 'Chat Usuario';
$contenidoPrincipal = <<<HTML
    $mensajesView
HTML;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Discusión en el Foro'];
$app->generaVista('/plantillas/plantilla.php', $params);
?>

<script>
// Definir chatBox como una variable global
let chatBox;

// Código JavaScript para el manejo de mensajes en tiempo real
let idUsuarioEmisor = "<?php echo $id_usuario_emisor; ?>";
let idUsuarioReceptor = "<?php echo $idForo; ?>";


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

// Función para obtener mensajes del chat
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
    xhr.send("incoming_id=<?php echo $idForo; ?>");
}

// Llamar a obtenerMensajes() cuando se cargue la página por primera vez
window.addEventListener("load", obtenerMensajes);

// Definir el intervalo en milisegundos (por ejemplo, cada 5 segundos)
let intervalo = 15000; // 5000 milisegundos = 5 segundos

// Función para llamar a obtenerMensajes() cada cierto intervalo de tiempo
setInterval(obtenerMensajes, intervalo);

</script>