<?php
namespace es\ucm\fdi\aw\src\Productos;

use es\ucm\fdi\aw\src\Formulario;

class FormularioEdicionProducto extends Formulario
{
    const EXTENSIONES_PERMITIDAS = array('jpg', 'jpe', 'jpeg', 'png', 'webp', 'avif');

    private $producto;

    public function __construct($producto) {
        parent::__construct('formEdicionProducto', ['enctype' => 'multipart/form-data', 'urlRedireccion' => 'tienda.php']);
        $this->producto = $producto;
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $datos['id'] =  $this->$producto->getIdProducto();
        $nombreProducto = $this->$producto->getIdNombre();
        $precio = $this->$producto->getPrecio();
        $descripcion = $this->$producto->getDescripcion();
        $imagen = $this->$producto->getImagen();
        $eliminar = 0;
        $cantidad = $this->$producto->getCantidad();

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreProducto', 'precio', 'descripcion', 'cantidad', 'nueva_imagen'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $rutadir = RUTA_IMGS;
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset class="fieldset-form">
            <legend class="legend-form">Datos producto</legend>

            <img id="imagen_producto" src="{$imagen}" alt="Imagen Producto" style="width: 30%;">

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
            <label for="nueva_imagen" class="input-label">Nueva Imagen:</label>
            <input id="nueva_imagen" type="file" name="nueva_imagen"/>
            </div>
            <div class="error-message">{$erroresCampos['nueva_imagen']}</div>

            <div class="input-textarea">
                <label for="descripcion" class="input-label">Descripcion:</label>
                <textarea id="descripcion" name="descripcion">$descripcion</textarea>
            </div>
            <div class="error-message">{$erroresCampos['descripcion']}</div>

            <div>
            <label for="cantidad" class="input-label">Cantidad:</label>
            <input id="cantidad" type="number"  name="cantidad" class="input-label" value="$cantidad"
             style="border: #bababa 1px solid; color:#000000;" step="1" min="0">

            </div>
            <div class="error-message">{$erroresCampos['cantidad']}</div>

            <div>
                <input type="checkbox" id="eliminar" name="eliminar" value="$eliminar" $eliminar>
                <label for="eliminar" class="input-label">Eliminar</label>
            </div>
            <div class="enviar-button">
                <button type="submit" name="crear">Aceptar</button>
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
            $this->errores['cantidad'] = 'Cantidad no puede estar vacía.';
        }

        $imagen = $this->imagen;
        $imagen_nueva = $_FILES['nueva_imagen']['tmp_name'];
        if(isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] === UPLOAD_ERR_OK && count($_FILES) == 1 && !empty($imagen_nueva)){
            $extension = pathinfo($_FILES['nueva_imagen']['name'], PATHINFO_EXTENSION);

            if(self::comprobarExtension($extension)){
    
                $numero_random = uniqid(); //para generar un numero random basado en la hora
                $fichero = "{$numero_random}.{$extension}";
                $ruta_imagen = RUTA_IMGS2 . $fichero;
                if (!move_uploaded_file($imagen_nueva, $ruta_imagen)) {
                    $this->errores['nueva_imagen'] = 'Error al mover el archivo.';
                }else{
                    $imagen = $ruta_imagen;
                }     
            }
        }

        $eliminar = isset($_POST['eliminar']);
        
        if (count($this->errores) === 0) {
            if ($eliminar)
            {
                Producto::borraPorId($this->id);
            } else
            {
                $prodActual = Producto::buscaPorId($this->id);
                $nuevoProducto = Producto::crea($this->id, $nombreProducto, $precio, $descripcion, $imagen, $prodActual->getValoracion(), $prodActual->getNumValoraciones(),$cantidad);
                Producto::actualiza($nuevoProducto);
            }
        }
    }

    private function comprobarExtension($extension){
        /*Comprueba el tipo de extension de la imagen */
        if (! in_array($extension, self::EXTENSIONES_PERMITIDAS)) {
            $this->errores['nueva_imagen'] = 'Error, la extensión del archivo no está permitida.';
            return false;
        }

        /*Comprueba el tipo mime del archivo corresponde a una imagen imagen */
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($_FILES['nueva_imagen']['tmp_name']);
        if (! (preg_match('/image\/.+/', $mimeType) === 1)) {
            $this->errores['nueva_imagen'] = 'Error, el tipo de archivo no está permitido.';
            return false;
        }

        return true;
    }

    
}
