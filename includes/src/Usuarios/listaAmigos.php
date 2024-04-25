<?php

use es\ucm\fdi\aw\src\Usuarios\Usuario;
use es\ucm\fdi\aw\src\BD;

require_once 'includes/config.php';

$tituloPagina = 'Lista de Usuarios';
echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/imagenes.css">';
$contenidoPrincipal = listaAmigos();

function listaAmigos()
{
    $idUser = $_SESSION['id'];
    
    $Usuarios = Usuario::obtenerUsuariosSeguidos($idUser); // Llamar al método en la instancia
    if($Usuarios){
            $html = "<div class='rectangulo-usuarios'>";

        foreach ($Usuarios as $Usuario) {
            $html .= visualizaUsuario($Usuario);
        }
    }    
    else{
        $html = "<div class='rectangulo-usuarios'>";
        $html .= "<h1>No tienes gente siguiendo :(</h1>";
    
    }
    $html .= "</div>";
    return $html;
}


function visualizaUsuario($Usuario) {
    $imagenPath = $Usuario->getAvatar() ? RUTA_IMGS . $Usuario->getAvatar() : RUTA_IMGS . 'images/avatarPorDefecto.png'; 
    $id =  $Usuario->getId();
    
    $idUser = $_SESSION['id'];

    $app = BD::getInstance();
    if ($app->usuarioLogueado()) 
    {
        $rutaChat = resuelve('/ChatView.php');

        // Verificar si el usuario logueado sigue al usuario actual
        $sigueUsuario = $Usuario->usuarioSigue($idUser, $id);

        // Determinar el estilo del corazón
        $corazonClase = $sigueUsuario ? 'corazon_lleno' : 'corazon_vacio';

        // Construir el HTML
        $html = <<<EOF
        <div class="tarjeta_usuario">
            <img src="{$imagenPath}" alt="Avatar de {$Usuario->getNombre()}" class="avatar_usuario">
            <div class="info_usuario">
                <div class="texto"><strong>Nombre:</strong> {$Usuario->getNombre()}</div>
                <div class="texto"><strong>Correo:</strong> {$Usuario->getCorreo()}</div>
                <div class="texto"><strong>Rol:</strong> {$Usuario->getRolString()}</div>
                <div id="corazon_$id" class="corazon $corazonClase" style="font-size: 24px; cursor: pointer;" onclick="toggleSeguir($idUser, $id)">&hearts;</div>
                <div>
                    <a href="$rutaChat?id=$id" class="button-like-link">Contactar</a>
                </div>
            </div>
        </div>
        <script>
        // Función para cambiar el estado del corazón y agregar/eliminar la relación de seguimiento
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
        </script>
EOF;
    }
    else
    {
        // Si no está logueado, muestra solo la información del usuario sin el corazón
        $html = <<<EOF
        <div class="tarjeta_usuario">
            <img src="{$imagenPath}" alt="Avatar de {$Usuario->getNombre()}" class="avatar_usuario">
            <div class="info_usuario">
                <div class="texto"><strong>Nombre:</strong> {$Usuario->getNombre()}</div>
                <div class="texto"><strong>Correo:</strong> {$Usuario->getCorreo()}</div>
                <div class="texto"><strong>Rol:</strong> {$Usuario->getRolString()}</div>
            </div>
        </div>
EOF;
    }

    return $html;
}



?>