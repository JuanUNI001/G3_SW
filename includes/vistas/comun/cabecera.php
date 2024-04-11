<?php

use es\ucm\fdi\aw\src\BD;
use es\ucm\fdi\aw\src\Usuarios\FormularioLogout;

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
    <?= mostrarLogo() ?>
    <nav>

        <div class="saludo">
            <?= mostrarSaludo(); ?>
        </div>
    </nav>
</header>