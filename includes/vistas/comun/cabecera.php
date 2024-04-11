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
        Usuario desconocido. <a href="{$loginUrl}" class="login-button">Login</a> <a href="{$registroUrl}" class="login-button">Registro</a>
      EOS;
    }

    return $html;
}

?>
<header>
    <h1><?= $params['cabecera'] ?? 'Mesamaestra' ?></h1>
    <div class="saludo">
        <?= mostrarSaludo(); ?>
    </div>
</header>