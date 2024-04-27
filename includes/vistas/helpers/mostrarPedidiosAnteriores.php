<?php
require_once __DIR__.'/../../config.php';
use \es\ucm\fdi\aw\src\Pedidos\Pedido;
use \es\ucm\fdi\aw\src\Pedidos\Pedidos_producto;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;

function mostrar_pedidosAnteriores()
{

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Redirige al usuario a la página de inicio de sesión si no ha iniciado sesión
    $rutaLogin = resuelve('/login.php');
    header("Location: $rutaLogin");
    exit();
}
$tituloPagina = 'Pedidos anteriores';
$correo_usuario = $_SESSION['correo'];

$usuario = Usuario::buscaUsuario($correo_usuario);
$id_usuario = $usuario->getId();

$pedidosAnteriores = Pedido::buscarPedidosAnteriores($id_usuario);
// Verificar si se encontraron pedidos
if ($pedidosAnteriores) {
    $contenidoPrincipal = <<<EOF
    <ul id="listaPedidos">
    EOF;
    
    foreach ($pedidosAnteriores as $pedido) {
        $totalProductos = count(Pedidos_producto::buscaPorIdPedido_Producto($pedido->getIdPedido()));
        $fecha_pedido = date_format(date_create($pedido->getFecha()), 'd/m/Y');
        
        $contenidoPrincipal .= <<<EOF
        <li class="pedido">
            <div class="pedido-header">
                <p class="fecha"><strong>Fecha:</strong> $fecha_pedido </p>
                <p class="total">Total: {$pedido->getPrecioTotal()} €</p>
            </div>
            <div class="pedido-content">
                <table>
                    <tr>
                        <th><a class="total-productos" href="includes/src/Pedidos/detalle_pedido.php?id={$pedido->getIdPedido()}">Total Productos: {$totalProductos}</a></th>
                    </tr>
                   
                </table>
            </div>
            
        </li>
    EOF;
    }
    
    $contenidoPrincipal .= <<<EOF
    </ul>
    EOF;
} else {
    $contenidoPrincipal = "No tienes pedidos anteriores :(";
}
return $contenidoPrincipal;

}
