<?php

namespace es\ucm\fdi\aw\src\Eventos;

use es\ucm\fdi\aw;
use es\ucm\fdi\aw\src\Eventos\Evento;
use es\ucm\fdi\aw\src\Formulario;



class FormularioInscripcion extends Formulario
{
    public $idEvento;
    
    public function __construct() {
        parent::__construct('formInscripcion', ['urlRedireccion' => 'eventos.php']);


    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $idEvento = $this->idEvento;
        
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
 
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Inscripción a evento</legend>
            <div>
                <input type="hidden" name="idEvento" value="$idEvento" />
            </div>
            <div>
                <button type="submit" name="inscribir">Inscribirse</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {

        $this->errores = [];
        $idEvento = $datos['id'] ?? '';
        if ( ! $idEvento || empty($idEvento) ) {
            $this->errores['idEvento'] = 'El ID del evento es inválido';
        }

        if (count($this->errores) === 0) {

            $inscripcionExitosa = Evento::inscribirseEvento($idEvento);
            if ($inscripcionExitosa) {
                $dir=resuelve('includes/src/Eventos/inscripcionExitosa');
                header('$dir');
                exit();
            } else {

                $this->errores['inscripcion'] = 'Hubo un error al realizar la inscripción al evento';
            }
        }
    }
}
