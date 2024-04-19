
<?php

    use es\ucm\fdi\aw\src\Usuarios\Usuario;
    use es\ucm\fdi\aw\src\BD;
    require_once __DIR__.'/../../config.php';
    $tituloPagina = 'Lista de Usuarios';
    echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/imagenes.css">';
    $contenidoPrincipal = listaUsuarios();
?>

<?php
function listaUsuarios()
{
    $Usuarios = Usuario::listarUsuarios();

    $html = "<div class='Usuarios'>";

    foreach ($Usuarios as $Usuario) {
        $html .= visualizaUsuario($Usuario);
    }

    $html .= "</div>";
    return $html;
}
function  listarUsuariosBusqueda($buscar, $correo,$tipo, $orden)
{
    $Usuarios = Usuario::listarUsuariosBusqueda($buscar, $correo,$tipo, $orden);

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
            $html = <<<EOF
            <div class="tarjeta_usuario">
                <img src="{$imagenPath}" alt="Avatar de {$Usuario->getNombre()}" class="avatar_usuario">
                <div class="info_usuario">
                    <div class="texto"><strong>Nombre:</strong> {$Usuario->getNombre()}</div>
                    <div class="texto"><strong>Correo:</strong> {$Usuario->getCorreo()}</div>
                    <div class="texto"><strong>Rol:</strong> {$Usuario->getRolString()}</div>
                    <div>
                        <a href="$rutaChat?id=$id" class="button-like-link">Contactar</a>
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
