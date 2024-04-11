<?php
namespace es\ucm\fdi\aw\src\Mensajes;
use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\usuarios\Usuario;
use es\ucm\fdi\aw\src\Formulario;
class FormularioEnviarMensaje extends Formulario
{
    public function __construct() {
        parent::__construct('formMensaje', ['urlRedireccion' => 'index.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['mensaje'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <div>
                <input id="mensaje" type="text" name="mensaje" />
                {$erroresCampos['mensaje']}
            </div>

            <div>
                <button type="submit" name="enviar">Enviar</button>
            </div>
        </fieldset>
                <button type="submit" name="login">Enviar</button>
            </div>  

        EOF;
        return $html;
    } 

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $texto = trim($datos['mensaje'] ?? '');
        $texto = filter_var($texto, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $correo || empty($texto) ) {
            $this->errores['mensaje'] = 'El mensaje no puede estar vacío';
        }
        
        if (count($this->errores) === 0) {

            $usuario = Usuario::login($correo, $password);
            $usuario = Usuario::buscaUsuario($correo);
            $mensaje = Mensaje::crea($usuario->getId(), $idDestinatario, $texto, null)
        
            if (!$mensaje) {
                $this->errores[] = "Erro al crear el mensaje";
            }
        }
    }
}
