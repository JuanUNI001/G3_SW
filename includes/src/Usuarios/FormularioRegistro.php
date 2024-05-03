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
        $nombre = $datos['nombre'] ?? '';
        $correo = $datos['correo'] ?? '';
        
        // Se generan los mensajes de error si existen.
        self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'password', 'password2', 'correo', 'precio', 'imagen'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
           
        <fieldset class="fieldset-form">
            <legend class="legend-form">Datos para el registro</legend>
                
            <div>
                <label for="nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                <span id="nombre-validacion"></span> 
            </div>
            <div>
                <label for="correo">Correo electrónico:</label>
                <input id="correo" type="text" name="correo" value="$correo" />
                <span id="correo-validacion"></span> 
            </div>
            <div>
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" />
                <span id="password-validacion"></span> 
            </div>
            <div>
                <label for="password2">Reintroduce el password:</label>
                <input id="password2" type="password" name="password2" />
                <span id="password2-validacion"></span> 
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
        $html .= <<<EOF
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var nombreInput = document.getElementById('nombre');
                var correoInput = document.getElementById('correo');
                var passwordInput = document.getElementById('password');
                var password2Input = document.getElementById('password2');
                var nombreValidacion = document.getElementById('nombre-validacion');
                var correoValidacion = document.getElementById('correo-validacion');
                var passwordValidacion = document.getElementById('password-validacion');
                var password2Validacion = document.getElementById('password2-validacion');

                // Función para mostrar mensajes de error
                function mostrarError(input, mensaje) {
                    input.nextElementSibling.textContent = mensaje;
                    input.nextElementSibling.style.color = 'red';
                }

                // Función para mostrar mensajes de éxito
                function mostrarExito(input) {
                    input.nextElementSibling.textContent = '✔️';
                    input.nextElementSibling.style.color = 'green';
                }

                nombreInput.addEventListener('input', function() {
                    if (nombreInput.value.length >= 3) {
                        mostrarExito(nombreInput);
                    } else {
                        mostrarError(nombreInput, '❌ El nombre debe tener al menos 3 caracteres.');
                    }
                });

                correoInput.addEventListener('input', function() {
                    if (correoInput.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                        mostrarExito(correoInput);
                    } else {
                        mostrarError(correoInput, '❌ El correo electrónico es inválido.');
                    }
                });

                passwordInput.addEventListener('input', function() {
                    // Expresión regular para verificar si hay al menos 8 caracteres, una mayúscula y un carácter especial
                    var regex = /^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>])(?=.{8,})/;
                    
                    if (regex.test(passwordInput.value)) {
                        mostrarExito(passwordInput);
                    } else {
                        mostrarError(passwordInput, '❌ La contraseña debe contener al menos 8 caracteres, una mayúscula y un carácter especial.');
                    }
                });
                

                password2Input.addEventListener('input', function() {
                    if (password2Input.value === passwordInput.value) {
                        mostrarExito(password2Input);
                    } else {
                        mostrarError(password2Input, '❌ Las contraseñas no coinciden.');
                    }
                });
            });
        </script>
        EOF;

        return $html;
    }
    
    
    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
    
        // Recoge los datos del formulario
        $nombre = $datos['nombre'] ?? '';
        $correo = $datos['correo'] ?? '';
        $password = $datos['password'] ?? '';
        $password2 = $datos['password2'] ?? '';
        $rolSeleccionado = $datos['rol'] ?? '';
        $rutaAvatar = $datos['rutaAvatar'] ?? '';
        $precio = isset($datos['precio']) ? floatval($datos['precio']) : null;
    
        // Validación de campos
        if (empty($nombre) || strlen($nombre) < 3) {
            $this->errores[] = "El nombre debe tener al menos 3 caracteres.";
        }
        
        if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $this->errores[] = "El correo electrónico es inválido.";
        }
    
        if (empty($password) || empty($password2)) {
            $this->errores[] = "La contraseña no puede estar vacía.";
        } elseif ($password !== $password2) {
            $this->errores[] = "Las contraseñas no coinciden.";
        } elseif (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $this->errores[] = "La contraseña debe tener al menos 8 caracteres, incluyendo al menos una mayúscula y un carácter especial.";
        }
        
    
        if (empty($rolSeleccionado) || !in_array($rolSeleccionado, ['Usuario', 'Profesor'])) {
            $this->errores[] = "Debe seleccionar un rol válido.";
        }
    
        if ($rolSeleccionado === 'Profesor' && (!$precio || $precio <= 0)) {
            $this->errores[] = "Por favor, introduce un precio válido para el profesor.";
        }

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK && count($_FILES) == 1 && empty($this->errores)) {
            $imagen = $_FILES['imagen']['tmp_name'];
            if (!empty($imagen)) {
                $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                if (self::comprobarExtension($extension)) {
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
        }else{
            $this->errores['imagen'] = 'Debe introducir un archivo.';
        }
    
        // Si no hay errores, crea el usuario o profesor y redirige
        if (empty($this->errores)) {
            if(!Usuario::buscaUsuario($correo) ){
                if ($rolSeleccionado === 'Usuario') {
                    $usuario = Usuario::crea(2, $nombre, $password, $correo, $rutaAvatar);
                    if (!$usuario) {
                        $this->errores[] = "Error al crear el usuario. Por favor, inténtalo de nuevo.";
                    }
                } elseif ($rolSeleccionado === 'Profesor') {
                    $password = Profesor::anadeContrasena($password);
                    $profesor = Profesor::creaProfesor($nombre, $password, $correo, $precio, $rutaAvatar, null);
                    if (!$profesor) {
                        $this->errores[] = "Error al crear el profesor. Por favor, inténtalo de nuevo.";
                    }
                }
            }
            else{
                $this->errores[] = "Este correo ya es usado por un usuario";
            }
            // Si no hay errores después de intentar crear el usuario o profesor, inicia sesión y redirige
            if (empty($this->errores)) {
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $nombre;
                $_SESSION['correo'] = $correo;
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
