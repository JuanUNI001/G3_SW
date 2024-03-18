<?php

function mostrarSaludo() {
	$rutaApp = RUTA_APP;
	$html='';
	if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
		$html.= "Bienvenido, {$_SESSION['nombre']} <a href='{$rutaApp}/logout.php'>(salir)</a>";
	} else {
		$html.= "Usuario desconocido. <a href='{$rutaApp}/loginView.php'>Login</a> <a href='{$rutaApp}/registro.php'>Registro</a>";
	}
	return $html;
}
?>