<?php
require_once __DIR__.'/../../config.php';



use \es\ucm\fdi\aw\src\Usuarios\Usuario;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(isset($_POST["id_usuario"]) && isset($_SESSION["rolUser"]) && $_SESSION["rolUser"] == "admin") {
        $id_usuario = $_POST["id_usuario"];
        $usuario = Usuario::buscaPorId($id_usuario);
        
        if($usuario && $usuario->esArchivado()) {
           $usuario ->recuperaUsuario($id_usuario);
           $mensajes = ['Usuario activo de nuevo.'];
        } else {
            $mensajes = ['El usuario no se encontró.'];
        }
        $url = resuelve('usuariosView.php');
        
    }
        
    else {
        $mensajes = ['Acceso no autorizado.'];
        $url = resuelve('usuarios.php');
    }
}
else {
    $mensajes = ['Acceso no autorizado.'];
    $url = resuelve('usuarios.php');
}
header("Location: $url");
$app->putAtributoPeticion('mensajes', $mensajes);
exit();
?>
