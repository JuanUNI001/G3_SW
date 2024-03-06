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
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/G3_SW/includes/views/estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Portada</title>
</head>

<body>

<div id="contenedor">

<?php
	require('../views/cabecera.php');
	require('../views/sidebarIzq.php');
?>

<main>
	<article>
<?php if (isset($_SESSION['login'])) { ?>
	<h1>Bienvenido<?= $_SESSION['nombre'] ?></h1>
	<p>Usa el menú de la izquierda para navegar.</p>
<?php } else { ?>
	<h1>ERROR</h1>
	<p>El usuario o contraseña no son válidos.</p>
<?php } ?>
	</article>
</main>

<?php
	require('../views/sidebarDer.php');
	require('../views/views/pie.php');
?>
</div>

</body>
</html>