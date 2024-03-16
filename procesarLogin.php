<?php

//Inicio del procesamiento
session_start();

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null; 

// Se puede utilizar == para comparar cadenas por igualdad ya que hace comparación byte a byte
if ($username == null) {
	echo 'Error campo "name" no se ha rellenado correctamente';

} else if ($password == null) {
	echo 'Error campo "contraseña" no se ha rellenado correctamente';

} else if ($username=='user' && $password=='userpass') {
	$_SESSION['login'] = true;
	$_SESSION['nombre'] = 'Usuario';
	
} else if ($username=='admin' && $password=='adminpass') {
	$_SESSION['login'] = true;
	$_SESSION['nombre'] = 'Administrador';
	$_SESSION['esAdmin'] = true;
}

require_once 'includes/config.php';

$tituloPagina = 'Pagina principal';

$contenidoPrincipal=<<<EOS
<h1>Página principal</h1>
	<p> Aquí está el contenido público, visible para todos los usuarios. </p>
EOS;

require 'includes/vistas/comun/layout.php';

/*

require_once 'includes/config.php';
require_once 'includes/vistas/helpers/usuarios.php';
require_once 'includes/vistas/helpers/autorizacion.php';
require_once 'includes/vistas/helpers/login.php';

$tituloPagina = 'Login';

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$password = $_POST["password"] ?? null;

$esValido = $username && $password && ($usuario = Usuario::login($username, $password));
if (!$esValido) {
	$htmlFormLogin = buildFormularioLogin($username, $password);
	$contenidoPrincipal=<<<EOS
		<h1>Error</h1>
		<p>El usuario o contraseña no son válidos.</p>
		$htmlFormLogin
	EOS;
	require 'includes/vistas/comun/layout.php';
	exit();
}

$_SESSION['idUsuario'] = $usuario->id;
$_SESSION['roles'] = $usuario->roles;
$_SESSION['nombre'] = $usuario->nombre;

$contenidoPrincipal=<<<EOS
	<h1>Bienvenido ${_SESSION['nombre']}</h1>
	<p>Usa el menú de la izquierda para navegar.</p>
EOS;

require 'includes/vistas/comun/layout.php';
*/