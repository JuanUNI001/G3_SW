<?php
use es\ucm\fdi\aw\src\Usuarios\Usuario;
use es\ucm\fdi\aw\src\BD;

function visualizaUsuario($Usuario) {
    $imagenPath = $Usuario->getAvatar() ? RUTA_IMGS . $Usuario->getAvatar() : RUTA_IMGS . 'images/avatarPorDefecto.png'; 
    $id =  $Usuario->getId();
   

    $app = BD::getInstance();
    if ($app->usuarioLogueado()) 
    {
        $correo_usuario = $_SESSION['correo'];

        $usuario = Usuario::buscaUsuario($correo_usuario);
        $idUser = $usuario->getId();
        $rutaChat = resuelve('/ChatView.php');
        $rutaSeguir = resuelve('js/seguir.js');
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
                <div>
                    <form action="$rutaChat" method="post">
                        <input type="hidden" name="id" value="$id">
                        <button type="submit" class="button-user">Contactar</button>
                    </form>
                </div>
            </div>
            <div class="corazon-container">
                <div id="corazon_$id" class="corazon $corazonClase" onclick="toggleSeguir($idUser, $id)">&hearts;</div>
            </div>
        </div>
    

        <script src=$rutaSeguir></script>
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