<?php

use \es\ucm\fdi\aw\src\usuarios\Usuario;

function mostrar_contenidoPerfil()
{
    $contenido;
    if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {

		$correo_usuario = $_SESSION['correo'];
		$usuario = Usuario::buscaUsuario($correo_usuario);
		$nombre = $usuario->getNombre();
		$rol = Usuario::rolUsuario($usuario);
		$avatar = $usuario->getAvatar() ? (RUTA_IMGS . $usuario->getAvatar()) : (RUTA_IMGS . 'images/avatarPorDefecto.png');
		$contenido =<<<EOS
		<section>
		<img src = $avatar width="140" height="140"> </img>
		<h2> Informacion sobre mi perfil</h2>
			<article>
				<h3>Nombre de usuario:</h3>
				<p>$nombre.</p>
			</article>

			<article>
				<h3>Rol de usuario:</h3>
				<p>$rol.</p>
			</article>

			<article>
				<h3>Correo electrónico:</h3>
				<p>$correo_usuario.</p>
			</article>
			
		</section>
		EOS;
	} else {
        $contenido=<<<EOS
        <h2>Aviso:</h2>
        <p>Todavía no te has registrado.</p>
        EOS;
	}
    return $contenido;
}