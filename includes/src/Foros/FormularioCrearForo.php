<?php
namespace es\ucm\fdi\aw\src\Foros;

use es\ucm\fdi\aw\src\Formulario;
use es\ucm\fdi\aw\src\Foros;

class FormularioCrearForo extends Formulario
{

    private  $idAutor;

    public function __construct($redirectionURL, $idAutor) {
        parent::__construct('formLogin', ['urlRedireccion' => $redirectionURL]);
        $this->idAutor = $idAutor;
    }
    
    protected function generaCamposFormulario(&$datos)
    {

        $tituloForo='';
        $descripcion='';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['tituloForo', 'descripcion'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos del Foro</legend>
            <div>
                <label for="tituForo">Titulo del Foro:</label>
                <input id="tituloForo" type="text" name="tituloForo" value="$tituloForo" />
                {$erroresCampos['tituloForo']}
            </div>

            <div>
            <label for="descripcion">Descripcion del Foro:</label>
            <input id="descripcion" type="text" name="descripcion" value="$descripcion" />
            {$erroresCampos['descripcion']}
        </div>
            <div>
                <button type="submit" name="crear">crear</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {

        $this->errores = [];
        $tituloForo = trim($datos['tituloForo'] ?? '');
        $tituloForo = filter_var($tituloForo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $tituloForo || empty($tituloForo) ) {
            $this->errores['tituloForo'] = 'El titulo del foro no puede estar vacío';
        }
        
        $descripcion = trim($datos['descripcion'] ?? '');
        $descripcion = filter_var($descripcion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $descripcion || empty($descripcion) ) {
            $this->errores['descripcion'] = 'La descripcion no puede estar vacía.';
        }

        if (count($this->errores) === 0) {
            $nuevoForo = Foro::crea(null, $idAutor, $tituloForo);
            $nuevoForo->guarda();         
        }
    }
}