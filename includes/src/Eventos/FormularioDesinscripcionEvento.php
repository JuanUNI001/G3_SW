<?php

namespace es\ucm\fdi\aw\src\Eventos;

use es\ucm\fdi\aw;
use es\ucm\fdi\aw\src\Eventos\Evento;
use es\ucm\fdi\aw\src\Formulario;
use es\ucm\fdi\aw\src\BD;
use es\ucm\fdi\aw\src\Inscritos\Inscrito;


class FormularioDesinscripcionEvento extends Formulario
{
    private $idEvento;
    private $idUsuario;
    
    public function __construct($idEvento, $idUsuario) {
        parent::__construct('formInscripcion', ['urlRedireccion' => 'eventos.php']);
        $this->idUsuario = $idEvento;
        $this->idEvento = $idUsuario;
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $idEvento = $this->idEvento;
        $idUsuario = $this->idUsuario;
        
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
 
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Inscripción a evento</legend>
            <div>
                <input type="hidden" name="idEvento" value="$idEvento" />
            </div>
            <div>
                <input type="hidden" name="idUsuario" value="$idUsuario" />
            </div>
            <div>
            <button type="submit" name="desinscribirse" class="sideBarDerButton">desinscribirse</button>

            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
    $this->errores = [];
    $idEvento = $datos['idEvento'];
    $idUsuario = $datos['idUsuario'];

    if (empty($idEvento) || empty($idUsuario)) {
        $this->errores['campos'] = 'Faltan datos necesarios para la inscripción.';
    }
 
   if (count($this->errores) == 0) {
        $desinscripcion = Inscrito::borraPorId($idEvento, $idUsuario);

        if (!$desinscripcion) {
            $this->errores['desinscribirse'] = 'Hubo un error al desinscribirse en el evento.';
            $app = BD::getInstance();
           
        }
      
        else{
            $app = BD::getInstance();
            Evento::desinscribirseEvento($idEvento);
            
            $mensajes = ['Te has desinscrito correctamente del evento !'];
            $app->putAtributoPeticion('mensajes', $mensajes);
        }
    }


    }

}
