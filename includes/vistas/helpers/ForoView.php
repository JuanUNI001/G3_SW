<?php

require_once __DIR__.'/../../config.php';




use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Foros\Foro;
use es\ucm\fdi\aw\src\BD;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
?>
<?php
function visualizaMensajes($idEmisor,$idForo, $viewPoint)
{
    $mensajes = Mensaje::GetMensajesInForoChat($idForo);
    $mensaje_class = '';
    $usuario = Usuario::buscaUsuario($_SESSION['correo']);
    $rutaJS = resuelve('/js/mensajes.js');
    $rutaJS2 = resuelve('/js/jquery-3.7.1.min.js');
    if ($usuario) {
        $nombreUsuario = $usuario->getNombre();
        $imagenUsuario = $usuario->getAvatar();
    }
    
    $idEmisor = $usuario->getId();
    $emisor = Usuario::buscaPorId($idEmisor);
    $autor = $emisor->getNombre();
    $imagenPath = $emisor->getAvatar() ? RUTA_IMGS . $emisor->getAvatar() : RUTA_IMGS . 'images/avatarPorDefecto.png'; 
    $rutaNew = resuelve('includes/src/Mensajes/nuevo_mensaje.php');
    $rutaGetter = resuelve('includes/src/Mensajes/get_mensaje_foro.php');

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
                    <input type="hidden" name="idForo" value="$idForo">
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

function visualizaForo($foro) {
    
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
$id_foro = $_POST['id'];

$foro = Foro::buscaForo($id_foro);

$foroView = visualizaForo($foro);
$app = BD::getInstance();

if ($app->usuarioLogueado())  {
    $usuario = Usuario::buscaUsuario($_SESSION['correo']);
    $idEmisor = $usuario->getId();
    $mensajesView = visualizaMensajes($idEmisor, $id_foro, $idEmisor);


    $tituloPagina = 'Conversacion Foro';
    $contenidoPrincipal=<<<EOF
        <h1>Conversacion Foro</h1>
        $foroView
        $mensajesView
    EOF;
}
    $params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Conversacion en Foro'];
    $app->generaVista('/plantillas/plantilla.php', $params);


?>

<script>
// Definir chatBox como una variable global
let chatBox;

// Código JavaScript para el manejo de mensajes en tiempo real
let idUsuarioEmisor = "<?php echo $id_usuario_emisor; ?>";
let idUsuarioReceptor = "<?php echo $id_usuario_receptor; ?>";
let rutaNuevoMensaje = "../../src/Mensajes/nuevo_mensaje.php";
let rutaObtenerMensajes = "../../src/Mensajes/get_mensaje_foro.php";

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

    //xhr.send("idForo=<?php echo $id_foro; ?>");
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
    xhr.send("incoming_id=<?php echo $id_foro; ?>");
}

// Llamar a obtenerMensajes() cuando se cargue la página por primera vez
window.addEventListener("load", obtenerMensajes);

// Definir el intervalo en milisegundos (por ejemplo, cada 5 segundos)
let intervalo = 5000; // 5000 milisegundos = 5 segundos

// Función para llamar a obtenerMensajes() cada cierto intervalo de tiempo
setInterval(obtenerMensajes, intervalo);

</script>
