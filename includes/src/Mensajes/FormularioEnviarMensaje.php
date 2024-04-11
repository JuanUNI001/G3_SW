<?php
namespace es\ucm\fdi\aw\src\Mensajes;

use es\ucm\fdi\aw\src\Formulario;

class FormularioEnviarMensaje extends Formulario
{
    public $id;

    public $idEmisor;

    public $idDestinatario;

    public $es_privado;

    public $mensaje;


    public function __construct() {
        parent::__construct('formLogin', ['urlRedireccion' => 'index.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {

        $datos['id'] =  $this->id;
        $mensaje = $this->mensaje;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['mensaje'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
            <div>
                <label for="mensaje">Mensaje:</label>
                <textarea id="mensaje" name="mensaje" rows="1" cols="50">$mensaje</textarea>
                {$erroresCampos['mensaje']}
            </div>
            <div>
                <button type="submit" name="login">Enviar</button>
            </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {

        $this->errores = [];
        $mensaje = trim($datos['mensaje'] ?? '');
        $mensaje = filter_var($mensaje, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $mensaje || empty($mensaje) ) {
            $this->errores['mensaje'] = 'mensaje vacio';
        }

        if (count($this->errores) === 0)
        {

        }
    }
}