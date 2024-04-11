<?php
namespace es\ucm\fdi\aw\src\Mensajes;
use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\usuarios\Usuario;
use es\ucm\fdi\aw\src\Formulario;
class FormularioEnviarMensajeForo extends Formulario
{
    private $idDestinatario;
    private $idForo;
    public function __construct() {
        parent::__construct('formMensaje', ['urlRedireccion' => 'index.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['texto'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <div>
                <input id="texto" type="text" name="texto" />
                {$erroresCampos['texto']}
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
        if(isset($_GET['idForo']) && $_GET['idForo'] !== null) {

            $texto = trim($datos['texto'] ?? '');
            $texto = filter_var($texto, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (empty($texto)) {
                $this->errores['texto'] = 'El mensaje no puede estar vacío';
            }
            $idForo = $_GET['idForo'];
            if (count($this->errores) === 0) {
                $correo = $_SESSION['correo'];
                $usuario = Usuario::buscaUsuario($correo);               
                $mensaje = Mensaje::crea(null, $usuario->getId(), null, $idForo, $texto);
                Mensaje::inserta($mensaje);
            
                if (!$mensaje) {
                    $this->errores[] = "Error al crear el mensaje";
                }

            }else{
                $this->errores[] = "Error al crear el mensaje";
            }
        }
    }
}
