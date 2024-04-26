<?php
require_once __DIR__.'/../../config.php';
use \es\ucm\fdi\aw\src\Productos\Producto;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use \es\ucm\fdi\aw\src\BD;

$app = BD::getInstance();

if (!$app->usuarioLogueado())  {
    $rutaLogin = resuelve('/login.php');
    header("Location: $rutaLogin");
    exit();
}

// Obtener el ID de usuario del usuario actual
$correo_usuario = $_SESSION['correo'];
$usuario = Usuario::buscaUsuario($correo_usuario);
$id_usuario = $usuario->getId();

// Verificar si se ha enviado el formulario de valoración
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del producto y la valoración del formulario
    $id_producto = $_POST['id_producto'];
    $valoracion = $_POST['valoracion'];
    $comentario = $_POST['comentario'];
    
    $nuevaValoracion = Valoracion::crea($id_usuario, $id_producto, $valoracion, $comentario);
    
    if ($nuevaValoracion->guarda()) {
        $rutaDetalleProducto = resuelve('includes/carrito_usuario.php');
        header("Location: $rutaDetalleProducto");
        exit();
    } else {
        $error = "Error al enviar la valoración. Por favor, inténtalo de nuevo.";
    }
}

$id_producto = $_GET['id_producto'];

$producto = Producto::buscaPorId($id_producto);

if (!$producto) {
    echo "Producto no encontrado.";
    exit();
}

// Título de la página
$tituloPagina = 'Valorar Producto: ' . $producto->getNombre();


$contenidoPrincipal = <<<EOF
<div class="formulario-container-val">
    <form id="formulario-valoracion" action="nuevaValoracion.php" method="post">
        <input type="hidden" name="id_producto" value="{$producto->getIdProducto()}">
        
        <h2>Valoración:</h2> <!-- Encabezado para la valoración -->
        <input type="hidden" id="valoracion" name="valoracion" value="0"> 
        
        <!-- Estrellas -->
        <span class="estrella" onclick="seleccionarEstrella(1)">★</span>
        <span class="estrella" onclick="seleccionarEstrella(2)">★</span>
        <span class="estrella" onclick="seleccionarEstrella(3)">★</span>
        <span class="estrella" onclick="seleccionarEstrella(4)">★</span>
        <span class="estrella" onclick="seleccionarEstrella(5)">★</span>
        
        <label for="comentario">Comentario:</label>
        <textarea id="comentario" name="comentario"></textarea> 
        
        <button type="submit">Enviar valoración</button>
    </form>

EOF;

$imagenPath = RUTA_IMGS . $producto->getImagen();
$contenidoPrincipal .= <<<EOF
    <div class="producto_valoracion">
        <div class="producto_info">
            <div class="info_texto">
                <h2>{$producto->getNombre()}</h2>
            </div>
            <img src="$imagenPath" alt="{$producto->getNombre()}" class="valoracion_imagen">
        </div>
        <p><strong>Precio:</strong> {$producto->getPrecio()} €</p>
    </div>
</div>
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
