<?php

use es\ucm\fdi\aw\src\BD;
use es\ucm\fdi\aw\src\Usuarios\FormularioLogout;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use \es\ucm\fdi\aw\src\Profesores\Profesor;


function mostrarSaludo()
{
    $html = '';
    $app = BD::getInstance();
    if ($app->usuarioLogueado()) {
        $nombreUsuario = $app->nombreUsuario();

        $formLogout = new FormularioLogout();
        $htmlLogout = $formLogout->gestiona();
        $html = "Bienvenido, {$nombreUsuario}. $htmlLogout";
    } else {
        $loginUrl = $app->resuelve('/login.php');
        $registroUrl = $app->resuelve('/registro.php');
        $html = <<<EOS
        Usuario desconocido. <a href="{$loginUrl}">Login</a> <a href="{$registroUrl}">Registro</a>
      EOS;
    }

    return $html;
}

function mostrarInfoUsuario() {
    $app = BD::getInstance();

    if (!$app->usuarioLogueado())  {
        $avatar = (RUTA_IMGS . 'images/avatarPorDefecto.png');
        // Si el usuario no está logueado, muestra la foto por defecto
        echo "<img src='{$avatar}' alt='Avatar por defecto' width='60' height='60'>";
    } else {
        $correo_usuario = $_SESSION['correo'];
        $usuario = Usuario::buscaUsuario($correo_usuario);
        $avatar = $usuario->getAvatar() ? (RUTA_IMGS . $usuario->getAvatar()) : (RUTA_IMGS . 'images/avatarPorDefecto.png');

        echo "<div class='info-usuario'>";
        echo "<div class='dropdown'>";
        echo "<img src='{$avatar}' alt='Avatar de {$usuario->getNombre()}' width='60' height='60' class='avatar-dropdown'>";
        echo "<ul class='dropdown-content'>";
        echo "<li><a href='" . resuelve('/verPerfil.php') . "'>Ver mi cuenta</a></li>";
        echo "<li><a href='" . resuelve('/verPedidosAnteriores.php') . "'>Pedidos anteriores</a></li>";
        echo "<li><a href='" . resuelve('/includes/carrito_usuario.php') . "'>Carrito</a></li>"; // Enlace al carrito
        echo "</ul></div></div>";
    }
}


function mostrarLogo() {
    $app = BD::getInstance();
    $logoUrl = $app->buildUrl('/index.php');
    $logoSrc = $app->buildUrl('/images/logo.png');
    return <<<EOS
    <div class="logo">
    <a href="{$logoUrl}"><img src="{$logoSrc}" alt = "Mesa Maestra" /></a>
    </div>
    EOS;
}


?>
<header>
 
        <div class="logo">
            <?= mostrarLogo() ?>
        </div>
        <div class="saludo">
            <?= mostrarSaludo(); ?>
        </div>
        <nav id="sidebarIzq">
	<nav>
        <ul>
            <li><a href="<?= RUTA_APP?>/index.php">Inicio</a></li>
            <li><a href="<?= RUTA_APP?>/tienda.php">Tienda</a></li>
            <li><a href="<?= RUTA_APP?>/foros.php">Foro</a></li>
            <li><a href="<?= RUTA_APP?>/eventos.php">Eventos</a></li>
            <li><a href="<?= RUTA_APP?>/profesores.php">Profesores</a></li>
        </ul>
    </nav>
        <div class="info-usuario">
            <?= mostrarInfoUsuario(); ?>
        </div>

</header>
