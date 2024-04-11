<?php
namespace es\ucm\fdi\aw\src\usuarios;

use es\ucm\fdi\aw\src\Formulario;

class FormularioEdicionUsuario extends Formulario
{
    public $id;
    public $nombre;
    public $rol;
    public $correo;
    public $avatar;

    public function __construct() {
        parent::__construct('formLogin', ['urlRedireccion' => 'index.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {

        $datos['id'] =  $this->id;
        $nombre = $this->nombre;
        $rol = $this->rol;
        $correo = $this->correo;
        $avatar = $this->avatar;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'rol', 'correo', 'avatar'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos usuario</legend>
            <div>
                <label for="nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                {$erroresCampos['nombre']}
            </div>
            <div>
                <label for="rol">Rol: user(1),teacher(2)</label>
                <input id="rol" type="text" name="rol" value="$rol"/>
                {$erroresCampos['rol']}
            </div>
            <div>
                <label for="correo">Correo:</label>
                <input id="correo" type="text" name="correo" value="$correo"/>
                {$erroresCampos['correo']}
            </div>
            <div>
                <label for="avatar">Avatar:</label>
                <input id="avatar" type="text" name="avatar" value="$avatar"/>
                {$erroresCampos['avatar']}
            </div>
            <div>
                <button type="submit" name="actualizar">Actualizar</button>
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
            $this->errores['nombre'] = 'El nombre de usuario no puede estar vacio';
        }
        
        $rol = trim($datos['rol'] ?? '');
        $rol = filter_var($rol, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $rol || empty($rol) || $rol == 0) {
            $this->errores['rol'] = 'Rol no valido.';
        }

        $correo = trim($datos['correo'] ?? '');
        $correo = filter_var($correo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $correo || empty($correo) ) {
            $this->errores['correo'] = 'El correo no puede estar vacío.';
        }

        $avatar = trim($datos['avatar'] ?? '');
        $avatar = filter_var($avatar, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $avatar || empty($avatar) ) {
            $this->errores['avatar'] = 'El avatar no puede estar vacío.';
        }


        if (count($this->errores) === 0) {

            $nuevoUsuario = Usuario::buscaPorId($this->id);
            $nuevoUsuario->setNombre($nombre);           
            $nuevoUsuario->setRol($rol + 1);
            $nuevoUsuario->setAvatar($avatar);
            Usuario::actualizaDatosFormulario($this->id,$nuevoUsuario);            
        }
    }
}
