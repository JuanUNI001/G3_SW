<?php
use \es\ucm\fdi\aw\src\usuarios\Usuario;
?>

<aside id="sidebarDer">

<?php if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) : $avatar =(RUTA_IMGS . 'images/avatarPorDefecto.png');?>
        <!-- Si el usuario no está logueado, muestra la foto por defecto -->
        
        <img src="<?php echo $avatar; ?>" alt="Avatar por defecto" width="60" height="60">
    <?php else: ?>
        <!-- Si el usuario está logueado, muestra la foto del usuario si está disponible -->
            <?php 
            $correo_usuario = $_SESSION['correo'];
            $usuario = Usuario::buscaUsuario($correo_usuario);
            $avatar = $usuario->getAvatar() ? (RUTA_IMGS . $usuario->getAvatar()) : (RUTA_IMGS . 'images/avatarPorDefecto.png');
            ?>
            <ul class="dropdown">
                <li class="menu1"><img src="<?php echo $avatar; ?>" alt="Avatar de <?php echo $usuario->getNombre(); ?>" width="60" height="60">

                    <ul class="dropdown-content">
                    <li><a href="<?php echo resuelve('/verPerfil.php'); ?>">Ver mi cuenta</a></li>
                    <li><a href="<?php echo resuelve('/verPedidosAnteriores.php'); ?>">Pedidos anteriores</a></li>
                </ul>
            </li>
        </ul>
    <?php endif; ?>

    <!--AQUI HAY QUE HACER LO DEL CARRO QUE EXPLICO EN CLASE-->
    <div class="sidebar-section" id="carrito">
        <p><a href="/G3_SW/includes/carrito_usuario.php" target="_self">Carrito</a></p>
    </div>

   
</aside>