<?php
function mostrarSaludo() {
	if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
		echo "Bienvenido, " . $_SESSION['nombre'] . ".<a href='/G3_SW/includes/views/logout.php'>(salir)</a>";

	} else {
		echo "Usuario desconocido. <a href='/G3_SW/includes/views/loginView.php'>Login</a>";
	}
}
?>
<header>
	<h1>Mi gran página web</h1>
	<div class="saludo">
	<?php
		mostrarSaludo();
	?>
	</div>
</header>