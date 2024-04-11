<?php

use \es\ucm\fdi\aw\src\usuarios\Usuario;
use es\ucm\fdi\aw\src\BD;
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