<?php

namespace es\ucm\fdi\aw\src\Eventos;

use es\ucm\fdi\aw;
use es\ucm\fdi\aw\src\Eventos\Evento;
use es\ucm\fdi\aw\src\Formulario;
use es\ucm\fdi\aw\src\BD;
use es\ucm\fdi\aw\src\Inscritos\Inscrito;
use \DateTime;


class FormularioAddEvento extends Formulario
{
    public function __construct() {
        parent::__construct('formAddEvento', ['urlRedireccion' => 'eventos.php']);


    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
 
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Añadir evento</legend>
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required />
            </div>
            <div>
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required></textarea>
            </div>
            <div>
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" required />
            </div>
            <div>
                <label for="lugar">Lugar:</label>
                <input type="text" id="lugar" name="lugar" required />
            </div>
            <div>
                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado" required />
            </div>
            <div>
                <label for="premio">Premio:</label>
                <input type="text" id="premio" name="premio" />
            </div>
            <div>
                <label for="tasaInscripcion">Tasa de inscripción:</label>
                <input type="number" id="tasaInscripcion" name="tasaInscripcion" required />
            </div>
            <div>
                <label for="numJugadores">Número de jugadores:</label>
                <input type="number" id="numJugadores" name="numJugadores" required />
            </div>
            <div>
                <label for="categoria">Categoría:</label>
                <input type="text" id="categoria" name="categoria" required />
            </div>
            <div>
                <button type="submit" name="crearEvento" class="sideBarDerButton">Crear Evento</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $nombre = $datos['nombre'] ?? '';
        $descripcion = $datos['descripcion'] ?? '';
        $fecha = $datos['fecha'] ?? '';
        $lugar = $datos['lugar'] ?? '';
        $estado = $datos['estado'] ?? '';
        $premio = $datos['premio'] ?? '';
        $tasaInscripcion = $datos['tasaInscripcion'] ?? '';
        $numJugadores = $datos['numJugadores'] ?? '';
        $categoria = $datos['categoria'] ?? '';

        // Validar los datos recibidos

        // Aquí iría la lógica para crear el evento con los datos proporcionados
        // y almacenarlo en la base de datos.
        

        // Si hay algún error en la validación o en la creación del evento,
        // se deben añadir los mensajes de error correspondientes al array $this->errores.
    }
}
