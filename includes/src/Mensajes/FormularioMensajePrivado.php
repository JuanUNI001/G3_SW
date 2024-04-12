<?php
namespace es\ucm\fdi\aw\src\Mensajes;

use es\ucm\fdi\aw\src\Formulario;

class FormularioMensajePrivado extends Formulario
{
    public $idEmisor;
    public $idDestinatario;

    public function __construct() {
        parent::__construct('formMensajePrivado', ['urlRedireccion' => 'profesores.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {

        $idEmisor=$this->idEmisor;
        $idDestinatario=$this->idDestinatario;
        $mensaje = '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['mensaje'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <div class="formDirect">
            <div class="inputDirect">
            <label for="mensaje" class="labelDirect">Mensaje:</label>
            <textarea id="mensaje" name="mensaje">$mensaje</textarea>
            </div>
            <div class="enviarDirect">
                <button type="submit" name="enviar">Enviar</button>
            </div>
        </div>
        <div class="errorDirect">{$erroresCampos['mensaje']}</div>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {

        $this->errores = [];
        $mensaje = trim($datos['mensaje'] ?? '');
        $mensaje = filter_var($mensaje, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $mensaje || empty($mensaje) ) {
            $this->errores['mensaje'] = 'El mensaje no puede estar vacío';
        }
        

        if (count($this->errores) === 0) {

           
        }
    }
}
