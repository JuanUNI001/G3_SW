<?php
function mostrar_contenidoPerfil()
{
    $contenido;
    if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
		//$nombre = $_SESSION['nombre'];
		$nombre = "UserName";
		//$status = "Usuario corriente";
		/*if($_SESSION['esAdmin']){
			$status = "Administrador";
		}*/
		$status = "Rol de mi usuario (Regular, profesor u administrador)";
		$correo = "usermail@gmail.com";
		$direccion = 28005;
		$contenido=<<<EOS
		<article>
			<h2>Nombre de usuario:</h2>
			<p>$nombre</p>
		</article>
		<article>
			<h2>Tipo de usuario:</h2>
			<p>$status</p>
		</article>
		<article>
			<h2>Correo electrónico:</h2>
			<p>$correo</p>
		</article>
		<article>
			<h2>Dirección postal:</h2>
			<p>$direccion</p>
		</article>
		EOS;
	} else {
        $contenido=<<<EOS
        <h2>Aviso:</h2>
        <p>Todavía no te has registrado. <a href='/G3_SW/loginView.php'>Registrate aquí</a></p>
        EOS;
	}
    return $contenido;
}