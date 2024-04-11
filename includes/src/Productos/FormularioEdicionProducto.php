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

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreProducto', 'precio', 'descripcion', 'imagen'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos producto</legend>
            <div>
                <label for="nombreProducto">Nombre del producto:</label>
                <input id="nombreProducto" type="text" name="nombreProducto" value="$nombreProducto" />
                {$erroresCampos['nombreProducto']}
            </div>
            <div>
                <label for="precio">Precio del producto:</label>
                <input id="precio" type="text" name="precio" value="$precio"/>
                {$erroresCampos['precio']}
            </div>
            <div>
                <label for="imagen">Imagen del producto:</label>
                <input id="imagen" type="text" name="imagen" value="$imagen"/>
                {$erroresCampos['imagen']}
            </div>
            <div>
                <label for="descripcion">Descripcion del producto:</label>
                <textarea id="descripcion" name="descripcion" rows="4" cols="50">$descripcion</textarea>
                {$erroresCampos['descripcion']}
            </div>
            <div>
                <input type="checkbox" id="eliminar" name="eliminar" value="$eliminar" $eliminar>
                <label for="eliminar">Eliminar</label>
            </div>
            <div>
                <button type="submit" name="login">Entrar</button>
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

        $eliminar = isset($_POST['eliminar']);
        
        if (count($this->errores) === 0) {
            if ($eliminar)
            {
                Producto::borraPorId($this->id);
            } else
            {
                $prodActual = Producto::buscaPorId($this->id);
                $nuevoProducto = Producto::crea($this->id, $nombreProducto, $precio, $descripcion, $prodActual->getImagen(), $prodActual->getValoracion(), $prodActual->getNumValoraciones(),$prodActual->getCantidad());
                Producto::actualiza($nuevoProducto);
            }
        }
    }
}
