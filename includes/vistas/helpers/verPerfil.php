<?php
function mostrar_contenidoPerfil()
{
    $contenido;
    if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
		//$nombre = $_SESSION['nombre'];
		$nombre = "UserName";
		//$status = "Usuario corriente";
		/*if($_SESSION['esAdmin']){
			$status = "Administrador";
		}*/
		$status = "Rol de mi usuario (Regular, profesor u administrador)";
		$correo = "usermail@gmail.com";
		$direccion = 28005;
		$contenido =<<<EOS
		<section>
		<h2> Informacion sobre mi perfil</h2>
			<article>
			<h3>Nombre de usuario:</h3>
			<p>$nombre.</p>
			</article>

			<article>
				<h3>Tipo de usuario:</h3>
				<p>$status.</p>
			</article>

			<article>
				<h3>Correo electrónico:</h3>
				<p>$correo.</p>
			</article>
			
			<article>
				<h3>Dirección postal:</h3>
				<p>$direccion.</p>
			</article>
		</section>
		EOS;
	} else {
        $contenido=<<<EOS
        <h2>Aviso:</h2>
        <p>Todavía no te has registrado.</p>
        EOS;
	}
    return $contenido;
}