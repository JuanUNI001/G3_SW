<?php
namespace es\ucm\fdi\aw;
use \es\ucm\fdi\aw\src\usuarios\Usuario;
class FormularioRegistro extends Formulario
{
    public function __construct() {
        parent::__construct('formRegistro', ['urlRedireccion' => 'index.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $rolUser = $datos['rolUser'] ?? '';
        $nombre = $datos['nombre'] ?? '';
        $correo = $datos['correo'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['rolUser', 'nombre', 'password', 'password2', 'correo'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos para el registro</legend>
            
            <div>
                <label for="nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                {$erroresCampos['nombre']}
            </div>
            <div>
                <label for="correo">Correo electrónico:</label>
                <input id="correo" type="text" name="correo" value="$correo" />
                {$erroresCampos['correo']}
            </div>
            <div>
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" />
                {$erroresCampos['password']}
            </div>
            <div>
                <label for="password2">Reintroduce el password:</label>
                <input id="password2" type="password" name="password2" />
                {$erroresCampos['password2']}
            </div>
            <div>
                <label for="rol_usuario">Selecciona tu rol:</label><br>
                <input id="usuario" type="radio" name="rol" value="Usuario" required />
                <label for="usuario">Usuario</label><br>
                <input id="profesor" type="radio" name="rol" value="Profesor" />
                <label for="profesor">Profesor</label>
            </div>
            <div>
                <button type="submit" name="registro">Registrar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
    

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $rolUser = $datos['rolUser'] ?? '';
      

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombre || mb_strlen($nombre) < 5) {
            $this->errores['nombre'] = 'El nombre tiene que tener una longitud de al menos 5 caracteres.';
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password || mb_strlen($password) < 5 ) {
            $this->errores['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
        }

        $password2 = trim($datos['password2'] ?? '');
        $password2 = filter_var($password2, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password2 || $password != $password2 ) {
            $this->errores['password2'] = 'Los passwords deben coincidir';
        }
        $correo = trim($datos['correo'] ?? '');
        $correo = filter_var($correo, FILTER_SANITIZE_EMAIL);
        
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $this->errores['correo'] = 'El correo electrónico proporcionado no tiene un formato válido.';
        }
        if (count($this->errores) === 0) {
            $usuario = Usuario::buscaUsuario($correo);	
            if ($usuario) {
                $this->errores[] = "El usuario ya existe";
            } else {
               
                $usuario = Usuario::crea($rolUser, $nombre, $password, $correo, Usuario::USER_ROLE);
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $usuario->getNombre();
                
            }
        }
    }
}