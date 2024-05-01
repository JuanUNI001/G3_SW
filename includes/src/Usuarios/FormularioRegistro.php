<?php
namespace es\ucm\fdi\aw\src\Usuarios;

use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use \es\ucm\fdi\aw\src\Profesores\Profesor;
use es\ucm\fdi\aw\src\Formulario;
use es\ucm\fdi\aw\src\BD;

class FormularioRegistro extends Formulario
{
    private $rutaImagen;

    public function __construct() {
        parent::__construct('formLogin', ['urlRedireccion' => BD::getInstance()->resuelve('/index.php')]);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $nombre = $datos['nombre'] ?? '';
        $correo = $datos['correo'] ?? '';
        
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'password', 'password2', 'correo', 'precio'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
            $htmlErroresGlobales
            <fieldset class="fieldset-form">
            <legend class="legend-form">Datos para el registro</legend>
                
                
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
                    {$erroresCampos['precio']}
                    
                </div>
               

                <div class="enviar-button">
                    <button type="submit" name="registro">Registrar</button>
                </div>
            </fieldset>
        EOF;

           
        $html .= '<script src="js/avatares.js" ></script>';
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
        
        // Valida los campos del formulario
        
        // Crea el usuario o profesor según corresponda
        if ($rolSeleccionado === 'Usuario') {
            $usuario = Usuario::crea(2, $nombre, $password, $correo, $rutaAvatar);
            if (!$usuario) {
                $this->errores[] = "Error al crear el usuario. Por favor, inténtalo de nuevo.";
            }
        } elseif ($rolSeleccionado === 'Profesor') {
            if (!$precio) {
                $this->errores[] = 'Por favor, introduce un precio válido.';
            } else {
                $password = Profesor::anadeContrasena( $password);
                $profesor = Profesor::creaProfesor($nombre, $password, $correo, $precio, $rutaAvatar, null);
                
                if (!$profesor) {
                    $this->errores[] = "Error al crear el profesor. Por favor, inténtalo de nuevo.";
                }
            }
        } else {
            $this->errores[] = 'Debe seleccionar un rol válido.';
        }
        
        // Si no hay errores, inicia sesión y redirige
        if (empty($this->errores)) {
            $_SESSION['login'] = true;
            $_SESSION['nombre'] = $nombre;
            $_SESSION['correo'] = $correo;
            $_SESSION['rolUser'] = $rolSeleccionado;
            header('Location: ' . $this->urlRedireccion);
            exit;
        }
    }
}
