<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/login.php';

$tituloPagina = 'Eventos';

$contenidoPrincipal=<<<EOS
<main>
<article>
	<h1>Acceso al sistema</h1>

	<form action="procesarLogin.php" method="POST">
	<fieldset>
		<legend>Usuario y contraseña</legend>
		<div><label>Name:</label> <input type="text" name="username" /></div>
		<div><label>Password:</label> <input type="password" name="password" /></div>
		<div><button type="submit">Entrar</button></div>
	</fieldset>
</article>
</main>
EOS;

require 'includes/vistas/comun/layout.php';
