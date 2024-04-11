<?php
namespace es\ucm\fdi\aw\src\Eventos;

use es\ucm\fdi\aw\src\Formulario;

class FormularioEdicionEvento extends Formulario
{
    public $id;
    public $nombre;
    public $descripcion;
    public $categoria;
    public $fecha;
    public $lugar;
    public $premio;
    public $tasa;   
    public $inscritos;
    public $numJugadores;
    public $estado;
    public $ganador;


    public function __construct() {
        parent::__construct('formLogin', ['urlRedireccion' => 'index.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {

        $datos['id'] =  $this->id;
        $nombre = $this->nombre;
        $descripcion = $this->descripcion;
        $categoria = $this->categoria;
        $fecha = $this->fecha;
        $lugar = $this->lugar;
        $premio = $this->premio;
        $tasa = $this->tasa;
        $inscritos = $this->inscritos;
        $aforo = $this->numJugadores;
        $eliminar = 0;
        $estado =$this->estado;
        $ganador = $this->ganador;

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
                <input id="nombre" type="text" name="nombreProducto" value="$nombre" />
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
                <label for="fecha">Fecha del evento:</label>
                <input id="fecha" type="text" name="fecha" value="$fecha" />
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
                <label for="estado">Estado:</label>
                <input id="estado" type="text" name="estado" value="$estado" />
                {$erroresCampos['estado']}
            </div>
            <div>
                <label for="aforo">Aforo:</label>
                <input id="aforo" type="text" name="aforo" value="$aforo" />
                {$erroresCampos['aforo']}
            </div>
            <div>
                <input type="checkbox" id="eliminar" name="eliminar" value="$eliminar" $eliminar>
                <label for="eliminar">Eliminar</label>
            </div>
            <div>
                <button type="submit" name="login">Entrar</button>
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
            //$this->errores['nombre'] = 'El nombre del evento no puede estar vacío';
        }
        
        $precio = trim($datos['precio'] ?? '');
        $precio = filter_var($precio, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (! $precio || empty($precio)) {
            $this->errores['precio'] = 'El precio no puede estar vacío.';
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

        $ganador = trim($datos['ganador'] ?? '');
        $ganador = filter_var($ganador, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (! $ganador || empty($ganador)) {
            $this->errores['ganador'] = 'El lugar no puede estar vacío.';
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

        $tasa = trim($datos['tasaInscripcion'] ?? '');
        $tasa = filter_var($tasa, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (! $tasa || empty($tasa)) {
            $this->errores['tasa'] = 'La tasa no puede estar vacía.';
        }

        $inscritos = trim($datos['inscritos'] ?? '');
        $inscritos = filter_var($inscritos, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (! $inscritos || empty($inscritos)) {
            $this->errores['inscritos'] = 'El número de inscritos no puede estar vacío.';
        }

        $aforo = trim($datos['numJugadores'] ?? '');
        $aforo = filter_var($aforo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (! $aforo || empty($aforo)) {
            $this->errores['numJugadores'] = 'El aforo no puede estar vacío.';
        }

        $eliminar = isset($_POST['eliminar']);
        
        if (count($this->errores) === 0) {
            if ($eliminar)
            {
                Evento::borraPorId($this->id);
            } else
            {
                $eventoActual = Evento::buscaPorId($this->id);
                $nuevoEvento = Evento::Nuevo($this->id,$inscritos,$categoria,$aforo, $nombre,$descripcion,$fecha,$lugar,$estado,$premio,$ganador,$tasa);
                Evento::actualiza($nuevoEvento);
            }
        }
    }
}
