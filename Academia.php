<?php

require_once 'includes/config.php';
require_once 'includes/src/Usuarios/visualizaUsuario.php';
require_once 'includes/src/Profesores/visualizaProfesor.php';

use es\ucm\fdi\aw\src\Profesores\Profesor;
use es\ucm\fdi\aw\src\Usuarios\Usuario;
use es\ucm\fdi\aw\src\BD;

function listaAlumnos($idProfesor)
{
    $alumnos = Usuario::listarAlumnosDeProfesor($idProfesor);

    $html = "<div class='alumnos-academia'>";

    foreach ($alumnos as $alumno) {
        $html .= visualizaUsuario($alumno);
    }

    $html .= "</div>";
    return $html;
}

function listaProfesores($idAlumno)
{
    $profesores = Profesor::listarProfesoresDeAlumno($idAlumno);

    $html = "<div class='profesores-academia'>";

    foreach ($profesores as $profesor) {
        $html .= visualizaProfesor($profesor);
    }

    $html .= "</div>";
    return $html;
}


$usuario = Usuario::buscaUsuario($_SESSION['correo']);


$tituloPagina = 'Academia';

$contenidoPrincipal =  '';

if(isset($_SESSION["rolUser"]) && ( $_SESSION["rolUser"] == "user" || $_SESSION["rolUser"] == "admin"))
{
    $contenidoPrincipal.='<h1>Estos son Tus profesores contratados</h1>';
    $contenidoPrincipal.=listaProfesores($usuario->getId());
}
else
{
    $contenidoPrincipal.='<h1>Estos son tus alumnos</h1>';
    $contenidoPrincipal.=listaAlumnos($usuario->getId());
}






$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
