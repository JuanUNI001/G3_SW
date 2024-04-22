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

// Obtener los pedidos anteriores del usuario con estado "comprado"
$pedidosAnteriores = Pedido::buscarPedidosAnteriores($id_usuario);

// Verificar si se encontraron pedidos
if ($pedidosAnteriores) {
    $contenidoPrincipal = '<ul id="listaPedidos">';
    foreach ($pedidosAnteriores as $pedido) {
        $contenidoPrincipal .= '<li class="pedido">';
        $contenidoPrincipal .= '<p style="margin-right: 80px;"><strong>Fecha:</strong> ' . $pedido->getFecha() . '</p>';
        $contenidoPrincipal .= '<table>';
        $totalProductos = count(Pedidos_producto::buscaPorIdPedido_Producto($pedido->getIdPedido()));
        $contenidoPrincipal .= '<tr><th>Total Productos: ' . $totalProductos . '</th></tr>';
        $contenidoPrincipal .= '<tr><td class="precio"><strong>Total:</strong> ' . $pedido->getPrecioTotal() . ' €</td></tr>';
        $contenidoPrincipal .= '</table>';
        $contenidoPrincipal .= '<a class="detalle-btn" href="includes/src/Pedidos/detalle_pedido.php?id=' . $pedido->getIdPedido() . '">Detalles</a>';
        $contenidoPrincipal .= '</li>';

        

    }
    $contenidoPrincipal .= '</ul>';
} else {
    $contenidoPrincipal = "No tienes pedidos anteriores :(";
}
return $contenidoPrincipal;

}
