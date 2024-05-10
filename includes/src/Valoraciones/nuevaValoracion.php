<?php
require_once __DIR__.'/../../config.php';
use \es\ucm\fdi\aw\src\Valoraciones\Valoracion;
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del producto y la valoración del formulario
    $id_producto = $_POST['id_producto'];
    $valoracion = $_POST['valoracion'];
    $comentario = $_POST['comentario'];
    if ($valoracion != 0) {
        $nuevaValoracion = Valoracion::crea($id_usuario, $id_producto, $valoracion, $comentario);
        
        if ($nuevaValoracion->guarda()) {
            $producto = Producto::buscaPorId($id_producto);
            if ($producto) {
                $producto->actualizarValoracion($valoracion);
            }
            $rutaDetalleProducto = resuelve('verPedidosAnteriores.php');
            header("Location: $rutaDetalleProducto");
            $mensajes = ['Producto valorado correctamente'];
           
        } else {
            $mensajes = ['Parece que algo ha salido mal :('];
            $rutaDetalleProducto = resuelve('verPedidosAnteriores.php');
            header("Location: $rutaDetalleProducto");
            $mensajes = ['Producto valorado correctamente'];
            
        }
    }
    else {
        $mensajes = ['La valoración no puede ser 0'];
        $rutaValoracion = resuelve('includes/src/Valoraciones/newValoracion.php?id_producto=' . $id_producto);
        header("Location: $rutaValoracion");
        $mensajes = ['La valoracion no puede ser 0'];
       
    }
}
$app->putAtributoPeticion('mensajes', $mensajes);
exit();
?>
