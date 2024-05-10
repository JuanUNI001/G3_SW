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



$id_producto = $_GET['id_producto'];

$producto = Producto::buscaPorId($id_producto);

if (!$producto) {
    echo "Producto no encontrado.";
    exit();
}

// Título de la página
$tituloPagina = 'Valorar Producto: ' . $producto->getNombre();

$rutaValoracion = resuelve('/includes/src/Valoraciones/nuevaValoracion.php');
$contenidoPrincipal = <<<EOF
<div class="formulario-container-val">
    <form id="formulario-valoracion" action=$rutaValoracion method="post">
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
