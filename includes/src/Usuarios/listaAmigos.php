<?php

use es\ucm\fdi\aw\src\Usuarios\Usuario;
use es\ucm\fdi\aw\src\BD;

require_once 'includes/config.php';
require_once __DIR__.'/visualizaUsuario.php';
$tituloPagina = 'Lista de Usuarios';
$contenidoPrincipal = listaAmigos();

function listaAmigos()
{
    $correo_usuario = $_SESSION['correo'];

    $usuario = Usuario::buscaUsuario($correo_usuario);
    $idUser = $usuario->getId();
    
    $Usuarios = Usuario::obtenerUsuariosSeguidos($idUser); // Llamar al método en la instancia
    if($Usuarios){
        
        $html = "<div class='Usuarios'>";
        foreach ($Usuarios as $Usuario) {
            $html .= visualizaUsuario($Usuario);
        }
    }    
    else{
        $html = "<div class='Usuarios'>";
        $html .= "<h1>No tienes gente siguiendo :(</h1>";
    
    }
    $html .= "</div>";
    return $html;
}





?>
