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
        parent::__construct('formAddEvento', ['enctype' => 'multipart/form-data', 'urlRedireccion' => 'eventos.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {

        $nombre='';
        $categoria='';
        $fecha='';
        $lugar='';
        $premio='';
        $tasa='';
        $inscritos='';
        $aforo='';
        $descripcion='';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'categoria', 'fecha', 'lugar', 'premio','tasa','aforo','descripcion'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset class="fieldset-form">
            <legend class="legend-form">Datos evento</legend>
            <div class="input-text">
                <label for="nombre" class="input-label">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
            </div>
            <div class="error-message">{$erroresCampos['nombre']}</div>

            <div class="input-text">
                <label for="categoria" class="input-label">Categoría:</label>
                <input id="categoria" type="text" name="categoria" value="$categoria"/>
            </div>
            <div class="error-message">{$erroresCampos['categoria']}</div>

            <div class="input-text">
                <label for="fecha" class="input-label">Fecha:</label>
                <textarea id="fecha" name="fecha">$fecha</textarea>
            </div>
            <div class="error-message">{$erroresCampos['fecha']}</div>

            <div class="input-text">
                <label for="lugar" class="input-label">Lugar:</label>
                <input id="lugar" type="text" name="lugar" value="$lugar"/>
            </div>
            <div class="error-message">{$erroresCampos['lugar']}</div>

            <div class="input-text">
                <label for="premio" class="input-label">Premio:</label>
                <input id="premio" type="text" name="premio" value="$premio"/>
            </div>
            <div class="error-message">{$erroresCampos['premio']}</div>

            <div class="input-text">
                <label for="tasa" class="input-label">Tasa:</label>
                <input id="tasa" type="text" name="tasa" value="$tasa"/>
            </div>
            <div class="error-message">{$erroresCampos['tasa']}</div>

            <div class="input-text">
                <label for="aforo" class="input-label">Aforo:</label>
                <input id="aforo" type="text" name="aforo" value="$aforo"/>
            </div>
            <div class="error-message">{$erroresCampos['aforo']}</div>

            <div class="input-text">
                <label for="descripcion" class="input-label">descripción:</label>
                <input id="descripcion" type="text" name="descripcion" value="$descripcion"/>
            </div>
            <div class="error-message">{$erroresCampos['descripcion']}</div>

            <div class="enviar-button">
                <button type="submit" name="crear">crear</button>
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
        if ( ! $nombre || empty($nombre) ) {
            $this->errores['nombre'] = 'El nombre no puede estar vacío';
        }
        
        $tasa = trim($datos['tasa'] ?? '');
        $tasa = filter_var($tasa, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $tasa || empty($tasa)) {
            $this->errores['tasa'] = 'La tasa no puede estar vacío.';
        }else if(!filter_var($tasa, FILTER_VALIDATE_FLOAT)){
            $this->errores['tasa'] = 'La tasa debe ser un numero.';
        }

        $premio = trim($datos['premio'] ?? '');
        $premio = filter_var($premio, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $premio || empty($premio)) {
            $this->errores['premio'] = 'El premio no puede estar vacío.';
        }

        $descripcion = trim($datos['descripcion'] ?? '');
        $descripcion = filter_var($descripcion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $descripcion || empty($descripcion) ) {
            $this->errores['descripcion'] = 'La descripcion no puede estar vacía.';
        }

        $aforo = trim($datos['aforo'] ?? '');
        $aforo = filter_var($aforo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($aforo < 0 || $aforo == NULL) {
            $this->errores['aforo'] = 'La cantidad no puede estar vacía.';
        }

        $fecha = trim($datos['fecha'] ?? '');
        $fecha = filter_var($fecha, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$fecha  || $fecha == NULL) {
            $this->errores['fecha'] = 'La fecha no puede estar vacía.';
        }

        $lugar = trim($datos['lugar'] ?? '');
        $lugar = filter_var($lugar, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$lugar || $lugar == NULL) {
            $this->errores['lugar'] = 'El lugar no puede estar vacía.';
        }

        $categoria = trim($datos['categoria'] ?? '');
        $categoria = filter_var($categoria, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$categoria || $categoria == NULL) {
            $this->errores['categoria'] = 'La categoria no puede estar vacía.';
        }

     
        if(count($this->errores) ==0 ){
            $fechaDateTime = DateTime::createFromFormat('Y-m-d', $fecha);

            $nuevEvento = Evento::Nuevo(null, 0, $categoria, $aforo, $nombre, $descripcion, $fechaDateTime, $lugar,'Abierto',$premio,NULL,$tasa);
            $nuevEvento->guarda();
        }
               
        
    }

    
}