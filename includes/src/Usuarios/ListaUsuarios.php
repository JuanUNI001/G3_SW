<?php

use es\ucm\fdi\aw\src\Usuarios\Usuario;
use es\ucm\fdi\aw\src\BD;

require_once __DIR__.'/../../config.php';
require_once __DIR__.'/visualizaUsuario.php';
$tituloPagina = 'Lista de Usuarios';
$contenidoPrincipal = listaUsuarios();


function listaUsuarios()
{
    $app = BD::getInstance();
    if ($app->usuarioLogueado())  {
        $correo_usuario = $_SESSION['correo'];

        $usuario = Usuario::buscaUsuario($correo_usuario);
        $idUser = $usuario->getId();
    }
    else{
        $idUser = 0;
    }

    $Usuarios = Usuario::listarUsuarios($idUser);
    
    $html = "<div class='Usuarios'>";

    foreach ($Usuarios as $Usuario) {
        $html .= visualizaUsuario($Usuario);
    }

    $html .= "</div>";
    return $html;

}
function  listarUsuariosBusqueda($buscar, $correo,$tipo, $orden)
{
    $app = BD::getInstance();
    
    if ($app->usuarioLogueado())  {
        $correo_usuario = $_SESSION['correo'];

        $usuario = Usuario::buscaUsuario($correo_usuario);
        $idUser = $usuario->getId();
    }
    else{
        $idUser = 0;
    }
    $Usuarios = Usuario::listarUsuariosBusqueda($buscar, $correo,$tipo, $orden,$idUser);

    $html = "<div class='Usuarios'>";

    foreach ($Usuarios as $Usuario) {
        $html .= visualizaUsuario($Usuario);
    }
    if(isset($_SESSION["rolUser"]) && $_SESSION["rolUser"] == "admin") {
        $Usuarios = Usuario::listarUsuariosBusquedaArchivados($buscar, $correo,$tipo, $orden,$idUser);
        foreach ($Usuarios as $Usuario) {
            $html .= visualizaUsuarioArchivados($Usuario);
        }
    }

    $html .= "</div>";
    return $html;
}




?>
