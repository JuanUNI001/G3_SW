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
        parent::__construct('formEdicionUsuario', ['urlRedireccion' => 'verPerfil.php']);
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

        $checkedUser = ($rol == 2) ? 'checked' : '';
        $checkedTeacher = ($rol == 3) ? 'checked' : '';
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
                <label>Rol:</label>
                <div class="rol-buttons">
                    <input id="user_role" type="radio" name="rol" value="2" $checkedUser>
                    <label for="user_role">User</label>

                    <input id="teacher_role" type="radio" name="rol" value="3" $checkedTeacher>
                    <label for="teacher_role">Teacher</label>
                </div>
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
        if ( ! $rol || empty($rol) || $rol == 1) {
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
            $nuevoUsuario->setCorreo($correo);       
            $nuevoUsuario->setRol($rol);
            $nuevoUsuario->setAvatar($avatar);
            Usuario::actualizaDatosFormulario($this->id,$nuevoUsuario);
            $_SESSION['nombre'] = $nombre;
            $_SESSION['correo'] = $correo;
            $_SESSION['rolUser'] = $rol;            
        }
    }
}
