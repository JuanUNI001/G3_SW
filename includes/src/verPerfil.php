<?php

//Inicio del procesamiento
session_start();
function mostrarDatosUsuario() {

	if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
		$nombre = $_SESSION['nombre'];
		$status = "Usuario corriente";
		if($_SESSION['esAdmin']){
			$status = "Administrador";
		}
		$contenidoUsuario=<<<EOS
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
		echo $contenidoUsuario;
	} else {
		echo "Todavía no te has registrado. <a href='login.php'>Registrate aquí</a>";
	}
               
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>VerPerfil</title>
</head>

<body>

<div id="contenedor">

<?php
	require('/G3_SW/includes/views/cabecera.php');
	require('/G3_SW/includes/views/sidebarIzq.php');
?>

	<main>
		<section>
			<h1>Datos de mi cuenta</h1>
			<?php
				 mostrarDatosUsuario()
			?>
		</section>
	</main>
<?php

	require('/G3_SW/includes/views/sidebarDer.php');
	require('/G3_SW/includes/views/pie.php');

?>
</div>

</body>
</html>