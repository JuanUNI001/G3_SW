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
        if ( ! $precio || empty($precio) ) {
            $this->errores['precio'] = 'El precio no puede estar vacío.';
        }

        $descripcion = trim($datos['descripcion'] ?? '');
        $descripcion = filter_var($descripcion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $descripcion || empty($descripcion) ) {
            $this->errores['descripcion'] = 'La descripcion no puede estar vacía.';
        }

        $cantidad = trim($datos['cantidad'] ?? '');
        $cantidad = filter_var($cantidad, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $cantidad || empty($cantidad) ) {
            $this->errores['cantidad'] = 'La cantidad no puede estar vacía.';
        }

        $nombre = $_FILES['imagen']['name'];
        $extension = pathinfo($nombre, PATHINFO_EXTENSION);
        $ruta_imagen="";
        if(self::comprobarImagen($nombre, $extension)){
            $tmp_name = $_FILES['imagen']['tmp_name'];
            $numero_random = uniqid(); //para generar un numero random basado en la hora
            $fichero = "{$numero_random}.{$extension}";
            $ruta_imagen = RUTA_IMGS2 . $fichero;
            $ruta = RUTA_IMGS2 . $fichero;
            if (!move_uploaded_file($tmp_name, $ruta)) {
                $this->errores['imagen'] = 'Error al mover el archivo';
            }
        }

        if (count($this->errores) === 0) {

            $nuevoProducto = Producto::crea(null, $nombreProducto, $precio, $descripcion, $ruta_imagen, 0, 0, $cantidad);
            $nuevoProducto->guarda();            
        }
    }

    private function comprobarImagen($nombre, $extension){

        /* 1. Verificamos que la subida ha sido correcta*/
        $ok = $_FILES['imagen']['error'] == UPLOAD_ERR_OK && count($_FILES) == 1;
        if (! $ok ) {
            $this->errores['imagen'] = 'Error al subir el archivo.';
            return false;
        }

        /* 2. comprueba la longitud del nombre */
        if (! self::check_file_uploaded_length($nombre)) {
            $this->errores['imagen'] = 'Error, el nombre del archivo es demasiado largo.';
            return false;
        }

        /* 3. comprueba los cararteres del nombre/* */
        if (! self::check_file_uploaded_name($nombre)) {
            $this->errores['imagen'] = 'Error, el nombre del archivo no está permitido.';
            return false;
        }

        /* 3. comprueba el tipo de extension de la imagen */
        if (! in_array($extension, self::EXTENSIONES_PERMITIDAS)) {
            $this->errores['imagen'] = 'Error, la extensión del archivo no está permitida.';
            return false;
        }

        /* 3. comprueba el tipo mime del archivo corresponde a una imagen imagen */
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($_FILES['imagen']['tmp_name']);
        if (! (preg_match('/image\/.+/', $mimeType) === 1)) {
            $this->errores['imagen'] = 'Error, el tipo de archivo no está permitido.';
            return false;
        }

        return true;
    }

    /**
     * Check $_FILES[][name]
     * @param (string) $filename - Uploaded file name.
     * @author Yousef Ismaeil Cliprz
     * @See http://php.net/manual/es/function.move-uploaded-file.php#111412
     */
    private static function check_file_uploaded_name($filename)
    {
        return (bool) ((preg_match('/^[0-9A-Z-_\.]+$/i', $filename) === 1) ? true : false);
    }

    private static function sanitize_file_uploaded_name($filename)
    {
        /* Remove anything which isn't a word, whitespace, number
     * or any of the following caracters -_~,;[]().
     * If you don't need to handle multi-byte characters
     * you can use preg_replace rather than mb_ereg_replace
     * Thanks @Łukasz Rysiak!
     */
        $newName = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $filename);
        // Remove any runs of periods (thanks falstro!)
        $newName = mb_ereg_replace("([\.]{2,})", '', $newName);

        return $newName;
    }

     /**
     * Check $_FILES[][name] length.
     *
     * @param (string) $filename - Uploaded file name.
     * @author Yousef Ismaeil Cliprz.
     * @See http://php.net/manual/es/function.move-uploaded-file.php#111412
     */
    private static function check_file_uploaded_length($filename)
    {
        return (bool) ((mb_strlen($filename, 'UTF-8') < self::MAX_FILENAME) ? true : false);
    }
}
