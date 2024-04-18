<?php

namespace es\ucm\fdi\aw\src\Eventos;

use es\ucm\fdi\aw;
use es\ucm\fdi\aw\src\Eventos\Evento;
use es\ucm\fdi\aw\src\Formulario;
use es\ucm\fdi\aw\src\BD;
use es\ucm\fdi\aw\src\Inscritos\Inscrito;


class FormularioDesinscripcionEvento extends Formulario
{
    public $idEvento;
    public $idUsuario;
    
    public function __construct() {
        parent::__construct('formInscripcion', ['urlRedireccion' => 'index.php']);


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
    //$er=count($this->errores);
   // echo $er; 
   if (count($this->errores) == 0) {
        $desinscripcion = Inscrito::eliminarPorUserYEven($idEvento, $idUsuario);

        if (!$desinscripcion) {
            $this->errores['desinscribirse'] = 'Hubo un error al desinscribirse en el evento.';
            $app = BD::getInstance();
           
        }
      
        else{
            $app = BD::getInstance();
            
            $mensajes = ['Te has desinscrito correctamente del evento !'];
            $app->putAtributoPeticion('mensajes', $mensajes);
        }
    }


    }

}
