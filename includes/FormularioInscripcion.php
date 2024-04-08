<?php

namespace es\ucm\fdi\aw\FormularioInscripcion ;

use es\ucm\fdi\aw;
use es\ucm\fdi\aw\src\Eventos\Evento;
use es\ucm\fdi\aw\src\Formulario;



class FormularioInscripcion extends Formulario
{
    public $idEvento;

    public function __construct() {
        parent::__construct('formInscripcion', ['urlRedireccion' => 'index.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $idEvento = $this->idEvento;
        
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
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
        $idEvento = $datos['idEvento'] ?? '';
        if ( ! $idEvento || empty($idEvento) ) {
            $this->errores['idEvento'] = 'El ID del evento es inválido';
        }

        if (count($this->errores) === 0) {
            // Realizar la inscripción al evento
            $inscripcionExitosa = Evento::inscribirseEvento($idEvento);
            if ($inscripcionExitosa) {
                // La inscripción se realizó correctamente
                // Aquí podrías redirigir a una página de éxito o mostrar un mensaje de éxito
                // Por ejemplo:
                header('Location: inscripcion_exitosa.php');
                exit();
            } else {
                // Hubo un error al realizar la inscripción
                $this->errores['inscripcion'] = 'Hubo un error al realizar la inscripción al evento';
            }
        }
    }
}
