<?php
namespace es\ucm\fdi\aw\src\Productos;

use es\ucm\fdi\aw\src\Formulario;
require_once __DIR__.'/../../config.php';

class FormularioAddProducto extends Formulario
{
    const EXTENSIONES_PERMITIDAS = array('gif', 'jpg', 'jpe', 'jpeg', 'png', 'webp', 'avif');
    const MAX_FILENAME = 250;

    public function __construct() {
        parent::__construct('formAddProducto', ['enctype' => 'multipart/form-data', 'urlRedireccion' => 'tienda.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {

        $nombreProducto='';
        $precio='';
        $descripcion='';
        $imagen='';
        $cantidad='';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreProducto', 'precio', 'descripcion', 'imagen', 'cantidad'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset class="fieldset-form">
            <legend class="legend-form">Datos producto</legend>
            <div class="input-text">
                <label for="nombreProducto" class="input-label">Nombre:</label>
                <input id="nombreProducto" type="text" name="nombreProducto" value="$nombreProducto" />
            </div>
            <div class="error-message">{$erroresCampos['nombreProducto']}</div>

            <div class="input-text">
                <label for="precio" class="input-label">Precio:</label>
                <input id="precio" type="text" name="precio" value="$precio"/>
            </div>
            <div class="error-message">{$erroresCampos['precio']}</div>

            <div class="input-file">
                <label for="imagen" class="input-label">Imagen:</label>
                <input id="imagen" type="file" name="imagen"/ value="$imagen">
            </div>
            <div class="error-message">{$erroresCampos['imagen']}</div>

            <div class="input-areatext">
                <label for="descripcion" class="input-label">Descripcion:</label>
                <textarea id="descripcion" name="descripcion">$descripcion</textarea>
            </div>
            <div class="error-message">{$erroresCampos['descripcion']}</div>

            <div class="input-text">
                <label for="cantidad" class="input-label">Cantidad:</label>
                <input id="cantidad" type="text" name="cantidad" value="$cantidad"/>
            </div>
            <div class="error-message">{$erroresCampos['cantidad']}</div>

            <div class="enviar-button">
                <button type="submit" name="crear">crear</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {

        $this->errores = [];
        $nombreProducto = trim($datos['nombreProducto'] ?? '');
        $nombreProducto = filter_var($nombreProducto, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombreProducto || empty($nombreProducto) ) {
            $this->errores['nombreProducto'] = 'El nombre de producto no puede estar vacío';
        }
        
        $precio = trim($datos['precio'] ?? '');
        $precio = filter_var($precio, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $precio || empty($precio)) {
            $this->errores['precio'] = 'El precio no puede estar vacío.';
        }else if(!filter_var($precio, FILTER_VALIDATE_FLOAT)){
            $this->errores['precio'] = 'El precio debe ser un numero.';
        }

        $descripcion = trim($datos['descripcion'] ?? '');
        $descripcion = filter_var($descripcion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $descripcion || empty($descripcion) ) {
            $this->errores['descripcion'] = 'La descripcion no puede estar vacía.';
        }

        $cantidad = trim($datos['cantidad'] ?? '');
        $cantidad = filter_var($cantidad, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($cantidad < 0 || $cantidad == NULL) {
            $this->errores['cantidad'] = 'La cantidad no puede estar vacía.';
        }

        $imagen = $_FILES['imagen']['tmp_name'];
        if(!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK || count($_FILES) != 1 || empty($imagen)){
            $this->errores['imagen'] = 'Debe introducir un archivo.';
        }

        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        if(empty($this->errores) && self::comprobarExtension($extension)){

            $numero_random = uniqid(); //para generar un numero random basado en la hora
            $fichero = "{$numero_random}.{$extension}";
            $ruta_imagen = RUTA_IMGS2 . $fichero;
            if (!move_uploaded_file($imagen, $ruta_imagen)) {
                $this->errores['imagen'] = 'Error al mover el archivo.';
            }else{
                $imagen = $ruta_imagen;
                $nuevoProducto = Producto::crea(null, $nombreProducto, $precio, $descripcion, $imagen, 0, 0, $cantidad);
                $nuevoProducto->guarda(); 
            }     
        }
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