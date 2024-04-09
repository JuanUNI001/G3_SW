<?php

use es\ucm\fdi\aw\src\BD;
use es\ucm\fdi\aw\src\usuarios\FormularioLogout;

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

?>
<header>
    <h1><?= $params['cabecera'] ?? 'Mi gran página web' ?></h1>
    <div class="saludo">
        <?= mostrarSaludo(); ?>
    </div>
</header>