<?php
namespace es\ucm\fdi\aw\src\Usuarios;

use es\ucm\fdi\aw\src\Formulario;

class FormularioEdicionUsuario extends Formulario
{
    const EXTENSIONES_PERMITIDAS = array('gif', 'jpg', 'jpe', 'jpeg', 'png', 'webp', 'avif');
    const MAX_FILENAME = 250;

    public $id;
    public $nombre;
    public $rol;
    public $correo;
    public $avatar;
    public $nueva_imagen;


    public function __construct() {
        parent::__construct('formEdicionUsuario', ['enctype' => 'multipart/form-data', 'urlRedireccion' => 'verPerfil.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {

        $datos['id'] =  $this->id;
        $nombre = $this->nombre;
        $rol = $this->rol;
        $correo = $this->correo;
        $avatar = $this->avatar;
        $rutaAvatar = $avatar;//la ruta del usuario  avatar
        $avatarActual = intval(preg_replace('/[^0-9]+/', '', $this->avatar)); //coge el numero del avatar que tiene el usuario
        $nueva_imagen = $this->nueva_imagen;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'rol', 'correo', 'avatar', 'nueva_imagen', 'precio'], $this->errores, 'span', array('class' => 'error'));

        $checkedUser = ($rol == 2) ? 'checked' : '';
        $checkedTeacher = ($rol == 3) ? 'checked' : '';
        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset class="fieldset-form">
            <legend class="legend-form">Datos usuario</legend>
            <div>
                <label for="nombre" class="input-label">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
            </div>
            <div class="error-message">{$erroresCampos['nombre']}</div>
            <div class="radio-buttons">
                <label class="input-label">Rol:</label>
                <div class="rol-buttons">
                    <input id="user_role" type="radio" name="rol" value="2" $checkedUser>
                    <label for="user_role">User</label>

                    <input id="teacher_role" type="radio" name="rol" value="3" $checkedTeacher>
                    <label for="teacher_role">Profesor</label>
                </div>
            </div>
            <div class="error-message">{$erroresCampos['rol']}</div>
            <div class="input-text">
                <label for="correo" class="input-label">Correo:</label>
                <input id="correo" type="text" name="correo" value="$correo"/>
            </div>
            <div class="error-message">{$erroresCampos['correo']}</div>

            <div class="input-file">
            <label for="nueva_imagen" class="input-label">Subir Avatar:</label>
            <input id="nueva_imagen" type="file" name="nueva_imagen" value="$nueva_imagen"/>
            </div>
            <div class="error-message">{$erroresCampos['nueva_imagen']}</div>

            <div id="avatar-selector">
                <button id="avatar-anterior" type="button">&lt;</button>
                <img id="avatar-seleccionado" src="{$rutaAvatar}" alt="Avatar seleccionado" style="width: 30%;">     
                <button id="avatar-siguiente" type="button">&gt;</button>
            </div>
            <input type="hidden" id="editar-ruta-avatar" name="rutaAvatar" value="{$rutaAvatar}"> 

            <div class="enviar-button">
                <button type="submit" name="actualizar">Actualizar</button>
            </div>
            <div id="campo_precio" >
                   
                    <label for="precio">Precio:</label>
                    <input id="precio" type="number" step="0.01" name="precio" value="0" size="10" />
                    {$erroresCampos['precio']}
                    
                </div>
        </fieldset>
        EOF;
        $html .= <<<EOF
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var usuarioRadio = document.getElementById('user_role');
            var profesorRadio = document.getElementById('teacher_role');
            var campoPrecio = document.getElementById('campo_precio');
            var avatarActual = {$avatarActual}; // Obtener el número de avatar actual del usuario
            if (typeof avatarActual !== 'number' || isNaN(avatarActual)) {
                avatarActual = 1;
            } 
            var numAvatares = 6;
        
            function actualizarVisibilidadProfesor() {
                if (profesorRadio.checked) {
                    campoPrecio.style.display = 'block';  // Mostrar el campo de precio si el rol es Profesor
                } else {
                    campoPrecio.style.display = 'none';   // Ocultar el campo de precio si el rol es Usuario
                }
            }
            
            usuarioRadio.addEventListener('change', actualizarVisibilidadProfesor);
            profesorRadio.addEventListener('change', actualizarVisibilidadProfesor);
            actualizarVisibilidadProfesor();                   
        
            function actualizarAvatar() {
                var avatarSeleccionado = document.getElementById('avatar-seleccionado');
                avatarSeleccionado.src = 'images/opcion' + avatarActual + '.png';
                avatarSeleccionado.alt = 'Avatar seleccionado ' + avatarActual;
        
                // Almacena la ruta de la imagen seleccionada en un campo oculto
                document.getElementById('editar-ruta-avatar').value = 'images/opcion' + avatarActual + '.png';
            }
            
            document.getElementById('avatar-anterior').addEventListener('click', function() {
                avatarActual = (avatarActual === 1) ? numAvatares : avatarActual - 1;
                actualizarAvatar();
            });
        
            document.getElementById('avatar-siguiente').addEventListener('click', function() {
                avatarActual = (avatarActual === numAvatares) ? 1 : avatarActual + 1;
                actualizarAvatar();
            });
        });
       
        </script>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {

        $this->errores = [];
        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombre || empty($nombre) ) {
            $this->errores['nombre'] = 'El nombre de usuario no puede estar vacio';
        }
        
        $rol = trim($datos['rol'] ?? '');
        $rol = filter_var($rol, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $rol || empty($rol) || $rol == 1) {
            $this->errores['rol'] = 'Rol no valido.';
        }

        $correo = trim($datos['correo'] ?? '');
        $correo = filter_var($correo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $correo || empty($correo) ) {
            $this->errores['correo'] = 'El correo no puede estar vacío.';
        }
        $precio = isset($datos['precio']) ? floatval($datos['precio']) : null;
        $rutaAvatar = $datos['rutaAvatar'] ?? $this->avatar;

        if (count($this->errores) === 0) {

            $nuevoUsuario = Usuario::buscaPorId($this->id);
            $nuevoUsuario->setNombre($nombre);    
            $nuevoUsuario->setCorreo($correo);       
            $nuevoUsuario->setRol($rol);
            $nuevoUsuario->setAvatar($rutaAvatar);
            Usuario::actualizaDatosFormulario($this->id,$nuevoUsuario);
            $_SESSION['nombre'] = $nombre;
            $_SESSION['correo'] = $correo;
            $_SESSION['rolUser'] = $rol;            
        }
    }
}