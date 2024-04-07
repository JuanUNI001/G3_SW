<?php

namespace es\ucm\fdi\aw\src\usuarios;

use es\ucm\fdi\aw\src\BD;
use es\ucm\fdi\aw\src\Formulario;

class FormularioLogout extends Formulario
{
    public function __construct() {
        parent::__construct('formLogout', [
            'action' =>  BD::getInstance()->resuelve('/logout.php'),
            'urlRedireccion' => BD::getInstance()->resuelve('/index.php')]);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $camposFormulario = <<<EOS
            <button class="enlace" type="submit">(salir)</button>
        EOS;
        return $camposFormulario;
    }

    /**
     * Procesa los datos del formulario.
     */
    protected function procesaFormulario(&$datos)
    {
        $app = BD::getInstance();

        $app->logout();
        $mensajes = ['Hasta pronto !'];
        $app->putAtributoPeticion('mensajes', $mensajes);
    }
}
