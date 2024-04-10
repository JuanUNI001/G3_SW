<?php
namespace es\ucm\fdi\aw\src\Mensajes;
use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use es\ucm\fdi\aw\src\Formulario;
class FormularioMensaje extends Formulario
{
    public function __construct() {
        parent::__construct('formMensaje', ['urlRedireccion' => 'index.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el nombre de usuario introducido previamente o se deja en blanco
        $mensaje = $datos['mensaje'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['mensaje'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <div>
                <input id="mensaje" type="text" name="mensaje" value="$mensaje" />
                {$erroresCampos['mensaje']}
            </div>

            <div>
                <button type="submit" name="enviar">Enviar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    } 

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $mensaje = trim($datos['mensaje'] ?? '');
        $mensaje = filter_var($mensaje, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $correo || empty($mensaje) ) {
            $this->errores['mensaje'] = 'El mensaje no puede estar vacío';
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
