<?php


require_once '../../config.php';

use es\ucm\fdi\aw\src\Profesores\Profesor;
use es\ucm\fdi\aw\src\Usuarios\Usuario;
use es\ucm\fdi\aw\src\BD;

$tituloPagina = 'Contratar profesor';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $idProfesor = $_POST['idProfesor'];
    $idAlumno = $_POST['idAlumno'];
    $imagenPath = $_POST['imagenPath'];

    $profesor = Profesor::buscaPorId($idProfesor);
    //$imagenPath = $profesor->getAvatar() ? RUTA_IMGS . $profesor->getAvatar() : RUTA_IMGS . 'images/avatarPorDefecto.png';
    $contenidoPrincipal = '';

    $resultado = Profesor::DeleteAlumno($idProfesor,$idAlumno);


    if ($resultado === true) {
        $mensajeResultado = "Te has dado de baja correctamente del profesor ";
    } elseif ($resultado === false) {
        $mensajeResultado = "Ya estabas dado de baja del profesor ";
    } else {
        $mensajeResultado = "Error al darse de baja del profesor ";
    }



    $contenidoPrincipal .= <<<EOF
        <div class="contratar-text">
            <div class="avatar_container_contratar">
                <img src="{$imagenPath}" alt="Avatar de {$profesor->getNombre()}" class="profesor_avatar_contratar">
            </div>
            <h1>{$mensajeResultado}{$profesor->getNombre()}</h1>
            <a href="javascript:history.back()" class="boton_retroceder"><i class="fas fa-arrow-left"></i>Aceptar</a>
        </div>
    EOF;
}
else{
    $contenidoPrincipal = 'Algo ha ido mal';
}
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);