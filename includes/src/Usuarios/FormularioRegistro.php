<?php
namespace es\ucm\fdi\aw\src\Usuarios;

use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use \es\ucm\fdi\aw\src\Profesores\Profesor;
use es\ucm\fdi\aw\src\Formulario;
use es\ucm\fdi\aw\src\BD;

class FormularioRegistro extends Formulario
{

    const EXTENSIONES_PERMITIDAS = array('gif', 'jpg', 'jpe', 'jpeg', 'png', 'webp', 'avif');
    const MAX_FILENAME = 250;
    private $rutaImagen;

    public function __construct() {
        parent::__construct('formLogin', ['enctype' => 'multipart/form-data', 'urlRedireccion' => BD::getInstance()->resuelve('/index.php')]);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $nombre_busca = $datos['nombre_busca'] ?? '';
        $correo_busca = $datos['correo_busca'] ?? '';
        
        // Se generan los mensajes de error si existen.
        self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre_busca', 'password', 'password2', 'correo_busca', 'precio', 'imagen'], $this->errores, 'span', array('class' => 'error'));
        
        $html = <<<EOF
           
        <fieldset class="fieldset-form">
            <legend class="legend-form">Datos para el registro</legend>
                
            <div>
                <label for="nombre_busca">Nombre:</label>
                <input id="nombre_busca" type="text" name="nombre_busca" value="$nombre_busca" />
                <input type="hidden" id="nombre-valido" name="nombre-valido" value="0">
                    <span id="validUser">✔️</span>
                    <span id="invalidUser">❌ Debe tener más de 3 caracteres</span>
            </div>
            <div>
                <label for="correo_busca">Correo electrónico:</label>
                <input id="correo_busca" type="text" name="correo_busca" value="$correo_busca" />
                <input type="hidden" id="correo-valido" name="correo-valido" value="0">
                    <span id="email-valido">✔️</span>
                    <span id="email-invalido">❌</span>
            </div>
            <div>
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" />
                <input type="hidden" id="password-valido" name="password-valido" value="0">

                    <span id="password-valida">✔️</span>
                    <span id="password-invalida">❌ Debe contener un al menos 5 caracteres</span>

            </div>
            <div>
                <label for="password2">Reintroduce el password:</label>
                <input id="password2" type="password" name="password2" />
                <input type="hidden" id="password2-valido" name="password2-valido" value="0">

                    <span id="password-match">✔️</span>
                    <span id="password-nomatch">❌No coincide</span>

            </div>
    
            
            
            
            <div class="input-file">
            <label for="imagen" class="input-label">Imagen:</label>
            <input id="imagen" type="file" name="imagen"/>
            </div>
            <div class="error-message">{$erroresCampos['imagen']}</div>
    
            <div id="avatar-selector">
                <button id="avatar-anterior" type="button">&lt;</button>
                <img id="avatar-seleccionado" src="images/opcion2.png" alt="Avatar seleccionado" style="width: 150px;">     
                <button id="avatar-siguiente" type="button">&gt;</button>
            </div>
            <input type="hidden" id="ruta-avatar" name="rutaAvatar" value="images/opcion2.png"> 
            <div class="radio-buttons">
                <label for="rol_usuario">Selecciona tu rol:</label><br>
                <div class="rol-option">
                    <input id="usuario" type="radio" name="rol" value="Usuario" required />
                    <label for="usuario">Usuario</label>
                </div>
                <div class="rol-option">
                    <input id="profesor" type="radio" name="rol" value="Profesor" />
                    <label for="profesor">Profesor</label>
                </div>
            </div>
            <div id="campo_precio" >
                
                <label for="precio">Precio:</label>
                <input id="precio" type="number" step="0.01" name="precio" value="0" size="10" />
                
                
            </div>
    
            <div class="enviar-button">
                <button type="submit" name="registro">Registrar</button>
            </div>
        </fieldset>
    EOF;
    
           
        $html .= '<script src="js/avatares.js" ></script>';
        $html .= '<script src="js/validacionRegistro.js" ></script>';
    
        return $html;
    }
    
    
    
    protected function procesaFormulario(&$datos)
{
    $this->errores = [];
  
    $nombre_busca = $datos['nombre_busca'] ?? '';
    $correo_busca = $datos['correo_busca'] ?? '';
    $password = $datos['password'] ?? '';
    $password2 = $datos['password2'] ?? '';
    $rolSeleccionado = $datos['rol'] ?? '';
    $rutaAvatar = $datos['rutaAvatar'] ?? '';
    $precio = isset($datos['precio']) ? floatval($datos['precio']) : null;
    $nombreValido = isset($datos['nombre-valido']) ? ($datos['nombre-valido'] === '1') : false;
    $correoValido = isset($datos['correo-valido']) ? ($datos['correo-valido'] === '1') : false;
    $passwordValido = isset($datos['password-valido']) ? ($datos['password-valido'] === '1') : false;
    $password2Valido = isset($datos['password2-valido']) ? ($datos['password2-valido'] === '1') : false;



    // Validar campos
    if (!$nombreValido) {
        $this->errores[] = "El nombre no es válido.";
    }

    if (!$correoValido) {
        $this->errores[] = "El correo electrónico no es válido.";
        
    }

    if (!$passwordValido) {
        $this->errores[] = "La contraseña no es válida.";
    }

    if (!$password2Valido) {
        $this->errores[] = "La confirmación de la contraseña no es válida.";
    }


    
    if ($rolSeleccionado === 'Profesor' && (!$precio || $precio <= 0)) {
        $this->errores[] = "Por favor, introduce un precio válido para el profesor.";
    }

    $imagen = $_FILES['imagen']['tmp_name'];
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK && count($_FILES) == 1 && !empty($imagen)){
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);

        if(self::comprobarExtension($extension)){

            $numero_random = uniqid(); //para generar un numero random basado en la hora
            $fichero = "{$numero_random}.{$extension}";
            $ruta_imagen = RUTA_IMGS2 . $fichero;
            if (!move_uploaded_file($imagen, $ruta_imagen)) {
                $this->errores['imagen'] = 'Error al mover el archivo.';
            }else{
                $rutaAvatar = $ruta_imagen;
            }     
        }
    }
    if (empty($this->errores)) {
        // Validar si el correo ya está en uso
        if (!Usuario::buscaUsuario($correo_busca)) {
            if ($rolSeleccionado === 'Usuario') {
                $usuario = Usuario::crea(2, $nombre_busca, $password, $correo_busca, $rutaAvatar);
                $usuario->guarda();
                if (!$usuario) {
                    $this->errores[] = "Error al crear el usuario. Por favor, inténtalo de nuevo.";
                }
            } elseif ($rolSeleccionado === 'Profesor') {
                $password = Profesor::anadeContrasena($password);
                $profesor = Profesor::creaProfesor($nombre_busca, $password, $correo_busca, $precio, $rutaAvatar,null);
                if (!$profesor) {
                    $this->errores[] = "Error al crear el profesor. Por favor, inténtalo de nuevo.";
                }
            }
        } else {
            $this->errores[] = "Este correo ya es usado por un usuario";
            
        }

        // Si no hay errores después de intentar crear el usuario o profesor, inicia sesión y redirige
        if (empty($this->errores)) {
            $_SESSION['login'] = true;
            $_SESSION['nombre_busca'] = $nombre_busca;
            $_SESSION['correo_busca'] = $correo_busca;
            $_SESSION['rolUser'] = $rolSeleccionado;
            header('Location: ' . $this->urlRedireccion);
            exit;
        }
    }
    
    $app = BD::getInstance();
    $app->putAtributoPeticion('mensajes', $this->errores);
}

    
    private function comprobarExtension($extension){

        /*Comprueba el tipo de extension de la imagen */
        if (! in_array($extension, self::EXTENSIONES_PERMITIDAS)) {
            $this->errores['imagen'] = 'Error, la extensión del archivo no está permitida.';
            return false;
        }

        /*Comprueba el tipo mime del archivo corresponde a una imagen imagen */
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($_FILES['imagen']['tmp_name']);
        if (! (preg_match('/image\/.+/', $mimeType) === 1)) {
            $this->errores['imagen'] = 'Error, el tipo de archivo no está permitido.';
            return false;
        }

        return true;
    }

}
