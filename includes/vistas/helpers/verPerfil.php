<?php

use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use es\ucm\fdi\aw\src\BD;
echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/estilos.css">';

function mostrar_contenidoPerfil()
{
    $app = BD::getInstance();
    
    $contenido;
    if ($app->usuarioLogueado())  {

        $correo_usuario = $_SESSION['correo'];
        $usuario = Usuario::buscaUsuario($correo_usuario);
        $nombre = $usuario->getNombre();
        $rol = Usuario::rolUsuario($usuario);
        $avatar = $usuario->getAvatar() ? (RUTA_IMGS . $usuario->getAvatar()) : (RUTA_IMGS . 'images/avatarPorDefecto.png');
        $direccionEditor = resuelve("EditorUsuarioView.php");
        $imagenRuta = resuelve('/images/editar_producto.png');

        $contenido =<<<EOS
	<div class="perfil-container">
		<section>
			<img src="$avatar" width="140" height="140" alt="Avatar">
			<h2>Información sobre mi perfil</h2>
			<article>
				<h3>Nombre:</h3>
				<p>$nombre</p>
			</article>
			<article>
				<h3>Rol:</h3>
				<p>$rol</p>
			</article>
			<article>
            <h3>Correo electrónico:</h3>
				<div class="email-container">
					<p>$correo_usuario</p>
				</div>
			</article>
			<div class="editar_Usuario">
				<a href="{$direccionEditor}?id={$usuario->getId()}">
					<img src="$imagenRuta" alt="Editor Producto" width="50" height="50">
				</a>   
			</div>
		</section>
	</div>
EOS;


    } else {
        $contenido=<<<EOS
        <h2>Aviso:</h2>
        <p>Todavía no te has registrado.</p>
        EOS;
    }
    return $contenido;
}
