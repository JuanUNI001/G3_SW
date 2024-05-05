<?php

use es\ucm\fdi\aw\src\BD;
use es\ucm\fdi\aw\src\Usuarios\FormularioLogout;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;


function mostrarSaludo()
{
    $html = '';
    $app = BD::getInstance();
    if ($app->usuarioLogueado()) {
        $nombreUsuario = $app->nombreUsuario();

        $formLogout = new FormularioLogout();
        $htmlLogout = $formLogout->gestiona();
        $html = "Bienvenido, {$nombreUsuario}. $htmlLogout";
    } else {
        $loginUrl = $app->resuelve('/login.php');
        $registroUrl = $app->resuelve('/registro.php');
        $html = <<<EOS
        Usuario desconocido. <a href="{$loginUrl}" class="login-button">Login</a> <a href="{$registroUrl}" class="login-button">Registro</a>
      EOS;
    }

    return $html;
}
function mostrarLogo() {
    $app = BD::getInstance();
    $logoUrl = $app->buildUrl('/index.php');
    $logoSrc = $app->buildUrl('images/Logo.png');
    return <<<EOS
    <div class="logo">
    <a href="{$logoUrl}"><img src="{$logoSrc}" alt = "CineFlex" /></a>
    </div>
    EOS;
}

function mostrarInfoUsuario() {
    $app = BD::getInstance();

    if (!$app->usuarioLogueado())  {
        $avatar = (RUTA_IMGS . 'images/avatarPorDefecto.png');
        // Si el usuario no está logueado, muestra la foto por defecto
        
        echo "<img src='{$avatar}' alt='Avatar' class='avatar-dropdown'>";
        
    } else {
        $correo_usuario = $_SESSION['correo'];
        $usuario = Usuario::buscaUsuario($correo_usuario);
        $avatar = $usuario->getAvatar() ? (RUTA_IMGS . $usuario->getAvatar()) : (RUTA_IMGS . 'images/avatarPorDefecto.png');

        echo "<div class='info-usuario'>";
        echo "<div class='dropdown'>";
        echo "<div class='avatar-container' style='height: 60px;'>"; // Contenedor con altura fija
        echo "<img src='{$avatar}' alt='Avatar de {$usuario->getNombre()}' class='avatar-dropdown'>";
        echo "</div>";
        echo "<ul class='dropdown-content'>";
        echo "<li><a href='" . resuelve('/verPerfil.php') . "'>Ver mi cuenta</a></li>";
        echo "<li><a href='" . resuelve('/verPedidosAnteriores.php') . "'>Pedidos anteriores</a></li>";
        echo "<li><a href='" . resuelve('/verEventosInscritos.php') . "'>Calendario</a></li>";
        echo "<li><a href='" . resuelve('/verEventosInscritosSinCalendario.php') . "'>Eventos Inscritos</a></li>";
        echo "<li><a href='" . resuelve('/seguidos.php') . "'>Follows</a></li>"; // Enlace al carrito
        echo "</ul></div></div>";
    }
}

?>
<?php
// Importa las clases necesarias
use es\ucm\fdi\aw\src\Pedidos\Pedido;
use es\ucm\fdi\aw\src\Pedidos\Pedidos_producto;

// Suponiendo que $cantidadEnCarrito contiene la cantidad de elementos en el carrito
$cantidadEnCarrito = 0; // Aquí debes asignar el valor adecuado

$app = BD::getInstance();

if ($app->usuarioLogueado())  {
    $correo_usuario = $_SESSION['correo'];

    $usuario = Usuario::buscaUsuario($correo_usuario);
    $idUser = $usuario->getId();

    $pedidoEnCarrito = Pedido::obtenerPedidosEnCarrito($idUser);
    if ($pedidoEnCarrito) {
        $productosEnCarrito = Pedidos_producto::buscaPorIdPedido_Producto($pedidoEnCarrito->getIdPedido());
        
        // Calcula la cantidad total de productos en el carrito
        foreach ($productosEnCarrito as $producto) {
            // Suma la cantidad de cada producto al total
            $cantidadEnCarrito += $producto->getCantidad();
        }
    }
    
}
?>

<header style="background-image: url('<?php echo resuelve("images/background.png"); ?>');">
    <h1><?= $params['cabecera'] ?? 'Mesa Maestra' ?></h1>

    <div class="saludo">
        <?= mostrarSaludo(); ?>
    </div>

    <nav>
        <ul>
            <li><a href="<?= RUTA_APP?>/index.php"class="sideBarDerButton">Inicio</a></li>
            <li><a href="<?= RUTA_APP?>/tienda.php" class="sideBarDerButton">Tienda</a></li>
            <li><a href="<?= RUTA_APP?>/foros.php"class="sideBarDerButton">Foro</a></li>
            <li><a href="<?= RUTA_APP?>/eventos.php"class="sideBarDerButton">Eventos</a></li>
            <li><a href="<?= RUTA_APP?>/profesores.php"class="sideBarDerButton">Profesores</a></li>
            <li><a href="<?= RUTA_APP?>/usuariosView.php"class="sideBarDerButton">Usuarios</a></li>
            <li>
            <div class="carrito">
                <a href="<?= RUTA_APP?>/Conversaciones.php" class="sideBarDerButton">✉</a>

                <a href="<?= RUTA_APP?>/includes/vistas/helpers/carrito_usuario.php" class="sideBarDerButton cart-icon">
                    <span class="cart-count"><?= $cantidadEnCarrito ?></span>
                    &#x1F6D2;
                </a>

            </div>
        </li>
        </ul>
        
    </nav>
    


    <div class="info-usuario">
        <?= mostrarInfoUsuario(); ?>
    </div>
   

</header>