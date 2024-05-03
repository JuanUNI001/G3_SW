<?php

namespace es\ucm\fdi\aw\src\Eventos;

use es\ucm\fdi\aw;
use es\ucm\fdi\aw\src\Eventos\Evento;
use es\ucm\fdi\aw\src\Formulario;
use es\ucm\fdi\aw\src\BD;
use es\ucm\fdi\aw\src\Inscritos\Inscrito;


class FormularioInscripcion extends Formulario
{
    public $idEvento;
    public $idUsuario;
    
    public function __construct() {
        parent::__construct('formInscripcion', ['urlRedireccion' => 'eventos.php']);


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
            <button type="submit" name="inscribir" class="sideBarDerButton">Inscribirse</button>

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
    //$er=count($this->errores);
   // echo $er; 
   //if (count($this->errores) == 0) {

        $even = Evento::buscaPorId($idEvento);
        $titulo =$even->getEvento();
        $fecha =$even->getFecha();

        //$estado = $even.getEstado();
        $incripcion = new Inscrito();
        $incripcion->setIdEvento($idEvento);
        $incripcion->setUserId($idUsuario);
        $incripcion->setTitle($titulo);
        $incripcion->setStart($fecha);
        $incripcion->setEnd($fecha);
        $inscripcionExitosa = Inscrito::guardaOActualiza($incripcion);

        if (!$inscripcionExitosa) {
            $this->errores['inscripcion'] = 'Hubo un error al inscribirse en el evento.';
            $app = BD::getInstance();
            $mensajes = ['Ya estas inscrito en este evento, no puedes volver a inscribirte'];
            $app->putAtributoPeticion('mensajes', $mensajes);
        }
      
        else{
            $app = BD::getInstance();
            Evento ::inscribirseEvento($idEvento);
            $mensajes = ['Te has inscrito correctamente en el evento !'];
            $app->putAtributoPeticion('mensajes', $mensajes);
        }
   //}


    }

}
