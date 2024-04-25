<?php
namespace es\ucm\fdi\aw\src\Usuarios;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use es\ucm\fdi\aw\src\Formulario;
class FormularioLogin extends Formulario
{
    public function __construct() {
        parent::__construct('formLogin', ['urlRedireccion' => 'index.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el nombre de usuario introducido previamente o se deja en blanco
        $correo = $datos['correo'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['correo', 'password'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset class="fieldset-form">
            <legend class="legend-form">Usuario y contraseña</legend>
            <div class="input-text">    
                <label for="correo" class="input-label">Correo:</label>
                <input id="correo" type="text" name="correo" value="$correo" />
            </div>
            <div class="error-message">{$erroresCampos['correo']}</div>
            <div class="input-text">
                <label for="password" class="input-label">Password:</label>
                <input id="password" type="password" name="password" />
            </div>
            <div class="error-message">{$erroresCampos['password']}</div>
            <div class="enviar-button">
                <button type="submit" name="login">Entrar</button>
            </div>
        </fieldset>
        EOF;    
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $correo = trim($datos['correo'] ?? '');
        $correo = filter_var($correo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $correo || empty($correo) ) {
            $this->errores['correo'] = 'El correo de usuario no puede estar vacío';
        }
        
        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password || empty($password) ) {
            $this->errores['password'] = 'El password no puede estar vacío.';
        }
        
        if (count($this->errores) === 0) {
            $usuario = Usuario::login($correo, $password);
        
            if (!$usuario) {
                $this->errores[] = "El usuario o el password no coinciden";
            } else {
                $usuario = Usuario::buscaUsuario($correo);
                $_SESSION['correo'] = $correo;
               
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $usuario->getNombre();
                $_SESSION['rolUser'] = Usuario::rolUsuario($usuario);
            }
        }
    }
}
