<?php
namespace es\ucm\fdi\aw\src\Eventos;

use es\ucm\fdi\aw\src\Formulario;
use es\ucm\fdi\aw\src\BD;

class FormularioAnyadirGanador extends Formulario
{
    private $evento;

    public function __construct($evento) {
        parent::__construct('formAnyadirGanador', ['urlRedireccion' => 'eventos.php']);
        $this->evento = $evento;
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $ganador = $this->evento->getGanador();

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = $this->generaListaErroresGlobales($this->errores);
        $erroresCampos = $this->generaErroresCampos(['ganador'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos ganador</legend>
            
            <div>
                <label for="ganador">Añadir ganador:</label>
                <textarea id="ganador" name="ganador" cols="50">$ganador</textarea>
                {$erroresCampos['ganador']}
            </div>

            <div class="enviar-button">
                <button type="submit" name="crear">Aceptar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $ganador = trim($datos['ganador'] ?? '');
        $ganador = filter_var($ganador, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$ganador || empty($ganador)) {
            $this->errores['ganador'] = 'El ganador no puede estar vacío';
        }
        
        if (count($this->errores) == 0) {
            $idEvento = $this->evento->getId();
            // Actualizar el ganador y el estado del evento
            $app = BD::getInstance();

            $nuevoEvento = Evento::Nuevo($this->evento->getId(),$this->evento->getInscritos(),$this->evento->getCategoria(),$this->evento->getNumJugadores(), $this->evento->getEvento(),$this->evento->getDescripcion(),$this->evento->getFecha(),$this->evento->getLugar(),"Terminado",$this->evento->getPremio(),$ganador,$this->evento->getTasaInscripcion());
            Evento::actualiza($nuevoEvento);
            $mensajes = ['¡Has actualizado al ganador!'];
            $app->putAtributoPeticion('mensajes', $mensajes);
            
        }
    }
}


