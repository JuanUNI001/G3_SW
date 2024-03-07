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

?>

<?php

require_once '/G3_SW/includes/config.php';

$tituloPagina = 'Pagina principal';

$contenidoPrincipal=<<<EOS
<h1>Página principal</h1>
	<p> Aquí está el contenido público, visible para todos los usuarios. </p>
EOS;

require '/G3_SW/includes/vistas/comun/layout.php';
