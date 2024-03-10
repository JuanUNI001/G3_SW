<?php
function mostrarSaludo() {
	if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
		echo "Bienvenido, " . $_SESSION['nombre'] . ".<a href='/G3_SW/logout.php'>(salir)</a>";

	} else {
		echo "Usuario desconocido. <a href='/G3_SW/loginView.php'>Login</a>";
	}
}
?>
<header>
	<h1>MesaMaestra</h1>
	<div class="saludo">
	<?php
		mostrarSaludo();
	?>
	</div>
</header>