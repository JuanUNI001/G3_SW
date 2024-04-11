<?php
namespace es\ucm\fdi\aw\src\Mensajes;
use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\usuarios\Usuario;
use es\ucm\fdi\aw\src\Formulario;
class FormularioEnviarMensajeUsuario extends Formulario
{
    private $idConversacion;
    public function __construct($idConversacion) {
        parent::__construct('formMensaje', ['urlRedireccion' => 'index.php']);
         this->idConversacion = $idConversacion;
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['texto, idConversacion'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <div>
                <input id="texto" type="text" name="texto" />
                {$erroresCampos['texto']}
                <input id="idConversacion" type="hidden" name="idConversacion" />
                {$erroresCampos['idConversacion']}
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
        $texto = trim($datos['texto'] ?? '');
        $texto = filter_var($texto, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (empty($texto)) {
            $this->errores['texto'] = 'El mensaje no puede estar vacío';
        }

        if (count($this->errores) === 0) {
            $correo = $_SESSION['correo'];
            $usuario = Usuario::buscaUsuario($correo);                
            $mensaje = Mensaje::crea(null, $usuario->getId(), $idDestinatario, null, $texto);
            Mensaje::inserta($mensaje);
        
            if (!$mensaje) {
                $this->errores[] = "Error al crear el mensaje";
            }

        }else{
            $this->errores[] = "Error al crear el mensaje";
        }
    }
}
