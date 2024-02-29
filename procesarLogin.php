<?php

//Inicio del procesamiento
session_start();

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;
$esValido = $username != null && $password != null;

// Se puede utilizar == para comparar cadenas por igualdad ya que hace comparación byte a byte
if ($username=='user' && $password=='userpass') {
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
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Portada</title>
</head>

<body>

<div id="contenedor">

<?php
	require('cabecera.php');
	require('sidebarIzq.php');
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
	require('sidebarDer.php');
	require('pie.php');
?>
</div>

</body>
</html>