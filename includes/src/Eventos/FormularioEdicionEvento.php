<?php
namespace es\ucm\fdi\aw\src\Eventos;

use es\ucm\fdi\aw\src\Formulario;
use es\ucm\fdi\aw\src\BD;

class FormularioEdicionEvento extends Formulario
{
    private $evento;

    public function __construct($evento) {
        parent::__construct('formEdicionEvento', ['urlRedireccion' => 'eventos.php']);
        $this->evento = $evento;
    }
    
    protected function generaCamposFormulario(&$datos)
    {

        $datos['id'] =  $this->evento->getId();
        $nombre = $this->evento->getNombre();
        $descripcion = $this->evento->getDescripcion();
        $categoria = $this->evento->getCategoria();
        $fecha = $this->evento->getFecha();
        $lugar = $this->evento->getLugar();
        $premio = $this->evento->getPremio();
        $tasa = $this->evento->getTasaInscripcion();
        $inscritos = $this->evento->getInscritos();
        $aforo = $this->evento->getNumJugadores();
        $eliminar = 0;
        $estado =$this->evento->getEstado();
        $ganador = $this->evento->getGanador();

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'descripcion', 'categoria', 'fecha', 'lugar', 'premio', 'tasa', 'inscritos', 'aforo'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos Evento</legend>
            <div>
                <label for="nombre">Nombre del evento:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                {$erroresCampos['nombre']}
            </div>
            <div>
                <label for="descripcion">Descripcion del producto:</label>
                <textarea id="descripcion" name="descripcion" rows="4" cols="50">$descripcion</textarea>
                {$erroresCampos['descripcion']}
            </div>
            <div>
                <label for="categoria">categoria del evento:</label>
                <input id="categoria" type="text" name="categoria" value="$categoria" />
                {$erroresCampos['categoria']}
            </div>
            <div>
                <label for="fecha">Fecha del evento (Y-M-D):</label>
                <input id="fecha" type="text" name="fecha" value="{$fecha->format('Y-m-d H:i:s')}" />
                {$erroresCampos['fecha']}
            </div>
            <div>
                <label for="lugar">Lugar del evento:</label>
                <input id="lugar" type="text" name="lugar" value="$lugar" />
                {$erroresCampos['lugar']}
            </div>
            <div>
                <label for="premio">Premio del evento:</label>
                <input id="premio" type="text" name="premio" value="$premio" />
                {$erroresCampos['premio']}
            </div>
            <div>
                <label for="tasa">Tasa del evento:</label>
                <input id="tasa" type="text" name="tasa" value="$tasa" />
                {$erroresCampos['tasa']}
            </div>
            <div>
                <label for="inscritos">Inscritos:</label>
                <input id="inscritos" type="text" name="inscritos" value="$inscritos" />
                {$erroresCampos['inscritos']}
            </div>
            <div>
                <label for="aforo">Aforo:</label>
                <input id="aforo" type="text" name="aforo" value="$aforo" />
                {$erroresCampos['aforo']}
            </div>
            <div>
                <input type="checkbox" id="eliminar" name="eliminar" value="$eliminar" $eliminar>
                <label for="eliminar" class="input-label">Eliminar</label>
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
        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( !$nombre || empty($nombre) ) {
            $this->errores['nombre'] = 'El nombre del evento no puede estar vacío';
        }
        
        $descripcion = trim($datos['descripcion'] ?? '');
        $descripcion = filter_var($descripcion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (! $descripcion || empty($descripcion)) {
            $this->errores['descripcion'] = 'La descripción no puede estar vacía.';
        }

        $categoria = trim($datos['categoria'] ?? '');
        $categoria = filter_var($categoria, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (! $categoria || empty($categoria)) {
            $this->errores['categoria'] = 'La categoria no puede estar vacía.';
        }

        $fecha = trim($datos['fecha'] ?? '');
        $fecha = filter_var($fecha, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (! $fecha || empty($fecha)) {
            $this->errores['fecha'] = 'La fecha no puede estar vacía.';
        }

        $lugar = trim($datos['lugar'] ?? '');
        $lugar = filter_var($lugar, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (! $lugar || empty($lugar)) {
            $this->errores['lugar'] = 'El lugar no puede estar vacío.';
        }

        $premio = trim($datos['premio'] ?? '');
        $premio = filter_var($premio, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (! $premio || empty($premio)) {
            $this->errores['premio'] = 'El premio no puede estar vacío.';
        }

        $estado = trim($datos['estado'] ?? '');
        $estado = filter_var($estado, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (! $premio || empty($premio)) {
            $this->errores['estado'] = 'El estado no puede estar vacío.';
        }

        $tasa = trim($datos['tasa'] ?? '');
        $tasa = filter_var($tasa, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); // Filtrar como número de coma flotante
        if (!filter_var($tasa, FILTER_VALIDATE_FLOAT) || $tasa < 0) {
            $this->errores['tasa'] = 'La tasa debe ser un número positivo.';
        }

        $inscritos = trim($datos['inscritos'] ?? '');
        $inscritos = filter_var($inscritos, FILTER_SANITIZE_NUMBER_INT); // Filtrar como número entero
        if (!filter_var($inscritos, FILTER_VALIDATE_INT) || $inscritos < 0) {
            $this->errores['inscritos'] = 'El número de inscritos debe ser un número entero positivo.';
        }

        $aforo = trim($datos['aforo'] ?? '');
        $aforo = filter_var($aforo, FILTER_SANITIZE_NUMBER_INT); // Filtrar como número entero
        if (!filter_var($aforo, FILTER_VALIDATE_INT) || $aforo < 0) {
            $this->errores['aforo'] = 'El número de inscritos debe ser un número entero positivo.';
        }

        

        $eliminar = isset($_POST['eliminar']);
        
        if (count($this->errores) == 0) {
            if ($eliminar)
            {
                $app = BD::getInstance();
                Evento::borraPorId($this->evento->getId());
                $mensajes = ['Se ha eliminado el evento!'];
                $app->putAtributoPeticion('mensajes', $mensajes);
            } else
            {
              
                $app = BD::getInstance();
                $nuevoEvento = Evento::Nuevo($this->evento->getId(),$inscritos,$categoria,$aforo, $nombre,$descripcion,$fecha,$lugar,$estado,$premio,NULL,$tasa);
                Evento::actualiza($nuevoEvento);
                $mensajes = ['Se ha actualizado el evento!'];
                $app->putAtributoPeticion('mensajes', $mensajes);
            }
        }
    }
}
