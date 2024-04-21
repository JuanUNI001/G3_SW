<?php
namespace es\ucm\fdi\aw\src\Productos;

use es\ucm\fdi\aw\src\Formulario;

class FormularioEdicionProducto extends Formulario
{
    public $id;
    public $nombre;
    public $precio;
    public $descripcion;
    public $imagen;
    public $cantidad = null;

    public function __construct() {
        parent::__construct('formEdicionProducto', ['urlRedireccion' => 'tienda.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {

        $datos['id'] =  $this->id;
        $nombreProducto = $this->nombre;
        $precio = $this->precio;
        $descripcion = $this->descripcion;
        $imagen = $this->imagen;
        $eliminar = 0;
        $cantidad = $this->cantidad;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreProducto', 'precio', 'descripcion', 'cantidad', 'imagen'], $this->errores, 'span', array('class' => 'error'));

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
            <div class="input-text">
                <label for="imagen" class="input-label">Imagen:</label>
                <input id="imagen" type="text" name="imagen" value="$imagen"/>
            </div>
            <div class="error-message">{$erroresCampos['imagen']}</div>
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
                <button type="submit" name="crear">Crear</button>
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

        $imagen = trim($datos['imagen'] ?? '');
        $imagen = filter_var($imagen, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $imagen || empty($imagen) ) {
            $this->errores['imagen'] = 'La imagen no puede estar vacía.';
        }

        $cantidad = trim($datos['cantidad'] ?? '');
        $cantidad = filter_var($cantidad, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($cantidad == null) {
            $this->errores['cantidad'] = 'Cantidad no puede estar vacía.';
        }

        $eliminar = isset($_POST['eliminar']);
        
        if (count($this->errores) === 0) {
            if ($eliminar)
            {
                Producto::borraPorId($this->id);
            } else
            {
                $prodActual = Producto::buscaPorId($this->id);
                $nuevoProducto = Producto::crea($this->id, $nombreProducto, $precio, $descripcion, $prodActual->getImagen(), $prodActual->getValoracion(), $prodActual->getNumValoraciones(),$cantidad);
                Producto::actualiza($nuevoProducto);
            }
        }
    }
}
