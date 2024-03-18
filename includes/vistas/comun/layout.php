<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="<?= RUTA_CSS.'/estilo.css'?>" />
	<title><?= $tituloPagina ?></title>
</head>
<body>
<div id="contenedor">
<?php

require_once('cabecera.php');
require_once('sidebarIzq.php');

?>
<main>
	<article>
		<?= $contenidoPrincipal ?>
	</article>
</main>
<?php

require_once('sidebarDer.php');
require_once('pie.php');

?>
</div>
</body>
</html>