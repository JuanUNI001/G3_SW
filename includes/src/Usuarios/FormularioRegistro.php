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
        
        $erroresCampos = self::generaErroresCampos(['nombre', 'password', 'password2', 'correo', 'precio'], $this->errores, 'span', array('class' => 'error'));

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
                    if (passwordInput.value.length >= 8 && /[!@#$%^&*(),.?":{}|<>]/.test(passwordInput.value)) {
                        mostrarExito(passwordInput);
                    } else {
                        mostrarError(passwordInput, '❌ La contraseña debe contener al menos 8 caracteres y un carácter especial.');
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
    
    
   
    

}
