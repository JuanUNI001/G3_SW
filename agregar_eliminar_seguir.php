<?php

use es\ucm\fdi\aw\src\Usuarios\Usuario;
use es\ucm\fdi\aw\src\BD;

require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['idUsuario'], $_POST['idUsuarioSeguir'])) {
        $idUsuario = $_POST['idUsuario'];
        $idUsuarioSeguir = $_POST['idUsuarioSeguir'];

        // Insertar o eliminar la relación de seguimiento según corresponda
        $usuario = Usuario::buscaPorId($idUsuario);
        $sigueUsuario = $usuario->usuarioSigue($idUsuario, $idUsuarioSeguir);
        if ($sigueUsuario) {
            // Si ya sigue al usuario, eliminar la relación
            $usuario->eliminarRelacionSeguir($idUsuario, $idUsuarioSeguir);
            echo 'eliminado';
        } else {
            // Si no sigue al usuario, agregar la relación
            $usuario->insertarRelacionSeguir($idUsuario, $idUsuarioSeguir);
            echo 'agregado';
        }
    } else {
        // Si no se reciben los parámetros necesarios, devolver un mensaje de error
        echo 'error';
    }
}

?>
