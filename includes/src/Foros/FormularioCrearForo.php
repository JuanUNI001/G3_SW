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

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset class="formulario-llamativo">
            <legend>Datos del Foro</legend>
            <div class="campos-container">
                <div class="campo">
                    <label for="tituloForo">Título del Foro:</label>
                    <input id="tituloForo" type="text" name="tituloForo" value="$tituloForo" />
                    {$erroresCampos['tituloForo']}
                </div>
                
                <div class="campo">
                    <label for="descripcion">Descripción del Foro:</label>
                    <textarea id="descripcion" name="descripcion">$descripcion</textarea>
                    {$erroresCampos['descripcion']}
                </div>
            </div>
            
            <div>
                <button type="submit" name="crear">Crear</button>
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
            $nuevoForo = Foro::crea(null,  $this->idAutor, $tituloForo,$descripcion);
            $nuevoForo->guarda();         
        }
    }
}