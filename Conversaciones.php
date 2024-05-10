<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\src\Usuarios\Usuario;
use es\ucm\fdi\aw\src\BD;
$tituloPagina = 'Mis Conversaciones';



$conversaciones="logueate para ver tus conversaciones";

if ($app->usuarioLogueado()) 
{
    $usuario = Usuario::buscaUsuario($_SESSION['correo']);
    $id_usuario = $usuario->getId();

    $conversaciones = listaConversaciones($id_usuario);
}


$contenidoPrincipal = <<<HTML
    
    <div>
        $conversaciones
    </div>
HTML;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Conversaciones'];
$app->generaVista('/plantillas/plantilla.php', $params);


function listaConversaciones($id_usuario)
{
    $Usuarios = Usuario::listarUsuariosEnConversacion($id_usuario);

    $html = "<div class='Usuarios'>";

    foreach ($Usuarios as $Usuario) {
        $html .= visualizaUsuario($Usuario);
    }

    $html .= "</div>";
    return $html;
}

function visualizaUsuario($Usuario) {
        $imagenPath = $Usuario->getAvatar() ? RUTA_IMGS . $Usuario->getAvatar() : RUTA_IMGS . 'images/avatarPorDefecto.png'; 
        $id =  $Usuario->getId();

        $app = BD::getInstance();
        if ($app->usuarioLogueado()) 
        {
            $rutaChat = resuelve('/ChatView.php');
            $formHtml = <<<HTML
            <form action="$rutaChat" method="POST" style="display: inline;">
                <input type="hidden" name="id" value="$id">
                <button type="submit" class="button-like-link">Contactar</button>
            </form>
        HTML;

            $html = <<<EOF
            <div class="tarjeta_usuario">
                <img src="{$imagenPath}" alt="Avatar de {$Usuario->getNombre()}" class="avatar_usuario">
                <div class="info_usuario">
                    <div class="texto"><strong>Nombre:</strong> {$Usuario->getNombre()}</div>
                    <div class="texto"><strong>Correo:</strong> {$Usuario->getCorreo()}</div>
                    <div class="texto"><strong>Rol:</strong> {$Usuario->getRolString()}</div>
                    <div>
                        $formHtml
                    </div>
                </div>
            </div>
        EOF;
        }
        else
        {
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