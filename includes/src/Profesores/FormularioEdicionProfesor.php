<?php
namespace es\ucm\fdi\aw\src\Profesores;

use es\ucm\fdi\aw\src\Formulario;

class FormularioEdicionProfesor extends Formulario
{
    public $id;
    public $nombre;

    public function __construct() {
        parent::__construct('formEdicionProfesor', ['urlRedireccion' => 'profesores.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {

        $datos['id'] =  $this->id;
        $nombre = $this->nombre;
        $banear = 0;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos profesor</legend>
            <div>
                <label for="nombre">Nombre del profesor:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" readonly/>
                {$erroresCampos['nombre']}
            </div>
            <div>
                <input type="checkbox" id="banear" name="banear" value="$banear" $banear>
                <label for="banear">Banear</label>
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
        if ( ! $nombre || empty($nombre) ) {
            $this->errores['nombre'] = 'El nombrel profesor no puede estar vacio';
        }
        
        $banear = isset($_POST['banear']);
        
        if (count($this->errores) === 0) {
            if ($banear)
            {
                $profesor = Profesor::buscaPorId($this->id);
                $profesor->SetAnunciableFalse();
            } else
            {

            }
        }
    }
}
