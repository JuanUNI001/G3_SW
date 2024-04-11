<?php
namespace es\ucm\fdi\aw\src\Mensajes;
use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\usuarios\Usuario;
use es\ucm\fdi\aw\src\Formulario;
class FormularioEnviarMensaje extends Formulario
{
    private $idDestinatario;
    private $idForo;

    public function __construct($idDestinatario, $idForo) {
        parent::__construct('formMensaje', ['urlRedireccion' => 'index.php']);
         $this->idDestinatario = $idDestinatario;
         $this->idForo = $idForo;
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['texto, idDestinatario'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <div>
                <input id="texto" type="text" name="texto" />
                {$erroresCampos['texto']}
                <input id="idDestinatario" type="hidden" name="idDestinatario" />
                {$erroresCampos['idDestinatario']}
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
        }else{
            if (count($this->errores) === 0) {
                $correo = $_SESSION['correo'];
                $usuario = Usuario::buscaUsuario($correo);
                if(this->idDestinatario == null){
                    $mensaje = Mensaje::crea(null, $usuario->getId(), null, $this->idForo, $texto);
                }else if(this->idDestinatario == null){
                    $mensaje = Mensaje::crea(null, $usuario->getId(), $this->idDestinatario, null, $texto);
                }         
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
