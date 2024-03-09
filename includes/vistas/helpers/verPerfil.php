<?php
function contenidoPerfil()
{
    $contenidoMensaje;
    if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
		$nombre = $_SESSION['nombre'];
		$status = "Usuario corriente";
		if($_SESSION['esAdmin']){
			$status = "Administrador";
		}
		$contenidoMensaje=<<<EOS
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
			<p> </p>
		</article>
		<article>
			<h2>Dirección:</h2>
			<p> </p>
		</article>
		EOS;
	} else {
        $contenidoMensaje=<<<EOS
        <h2>Aviso:</h2>
        <p>Todavía no te has registrado. <a href='/G3_SW/loginView.php'>Login</a></p>
        EOS;
	}
    return $contenidoMensaje;
}