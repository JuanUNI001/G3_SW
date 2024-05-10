<?php
use es\ucm\fdi\aw\src\Usuarios\Usuario;
use es\ucm\fdi\aw\src\Profesores\Profesor;
use es\ucm\fdi\aw\src\BD;


function visualizaProfesor($profesor) {
    $imagenPath = $profesor->getAvatar() ? RUTA_IMGS . $profesor->getAvatar() : RUTA_IMGS . 'images/avatarPorDefecto.png'; 
    $precio = $profesor->getPrecio();
    $valoracion = $profesor->getValoracion();
    $id =  $profesor->getId();
    if ($precio === null) {
        $precioTexto = '-';
    } else {
        $precioTexto = $precio . ' €';
    }

    if ($valoracion === null) {
        $valoracionTexto = '-';
    } else {
        $valoracionTexto = $valoracion;
    }
    $app = BD::getInstance();


    $botones = '';
    if ($app->usuarioLogueado()) 
    {
        $usuario_session = Usuario::buscaUsuario($_SESSION['correo']);
        $id_usuario = $usuario_session->getId();

        $botones = visualizarBotones($id, $id_usuario, $imagenPath);
    }



    $html = <<<EOF
    <div class="profesor_container">
    <div class="profesor">
        <div class="avatar_container">
            <img src="{$imagenPath}" alt="Avatar de {$profesor->getNombre()}" class="profesor_avatar">
        </div>
        <div class="separator_vertical"><br></br></div> <!-- Separador vertical -->
        <div class="info_container">
            <div class="profesor_nombre"><strong>Nombre:</strong> {$profesor->getNombre()}</div>
            <div class="separator_horizontal"></div> <!-- Separador horizontal -->
            <div class="profesor_precio"><strong>Precio:</strong> {$precioTexto}</div>
            <div class="profesor_valoracion"><strong>Valoracion:</strong> {$valoracionTexto}</div>
            <div class="profesor_correo"><strong>Correo:</strong> {$profesor->getCorreo()}</div>
            $botones
        </div>
        </div>
        </div> 
    EOF;

return $html;
}


function visualizarBotones($idProfesor, $idUsuario, $imagenPath)
{
    $html = '';
    
    $rutaChat = resuelve('/ChatView.php');
    $rutaContratar = resuelve('/includes/src/Profesores/Contratar.php');
    $rutaDescontratar = resuelve('/includes/src/Profesores/Descontratar.php');



    $html .= <<<EOF
                <form action="{$rutaChat}" method="post">
                    <input type="hidden" name="id" value="{$idProfesor}">
                    <button type="submit" class="button-profesor">Enviar Mensaje</button>
                </form>
                EOF;

    if(Profesor::EsAlumnoDe($idProfesor, $idUsuario))
    {
        $html .=  <<<EOF
                    <form action="{$rutaDescontratar}" method="post">
                        <input type="hidden" name="idProfesor" value="{$idProfesor}">
                        <input type="hidden" name="idAlumno" value="{$idUsuario}">
                        <input type="hidden" name="imagenPath" value="{$imagenPath}">
                        <button type="submit" class="button-profesor">Darse de baja</button>
                    </form>
                    EOF;
    }
    else
    {
        $html .=  <<<EOF
                    <form action="{$rutaContratar}" method="post">
                    <input type="hidden" name="idProfesor" value="{$idProfesor}">
                    <input type="hidden" name="idAlumno" value="{$idUsuario}">
                    <input type="hidden" name="imagenPath" value="{$imagenPath}">
                    <button type="submit" class="button-profesor-contratar">Contratar</button>
                    </form>
                    EOF;
    }

    return $html;
}

function visualizaProfesorAcademia($profesor) {
    $imagenPath = $profesor->getAvatar() ? RUTA_IMGS . $profesor->getAvatar() : RUTA_IMGS . 'images/avatarPorDefecto.png'; 
    $precio = $profesor->getPrecio();
    $valoracion = $profesor->getValoracion();
    $id =  $profesor->getId();
    if ($precio === null) {
        $precioTexto = '-';
    } else {
        $precioTexto = $precio . ' €';
    }

    if ($valoracion === null) {
        $valoracionTexto = '-';
    } else {
        $valoracionTexto = $valoracion;
    }
    $app = BD::getInstance();


    $rutaChat = resuelve('/ChatView.php');
    $rutaDescontratar = resuelve('/includes/src/Profesores/Descontratar.php');

    $usuario_session = Usuario::buscaUsuario($_SESSION['correo']);
    $idUsuario = $usuario_session->getId();
    $idProfesor =  $profesor->getId();

    $html = <<<EOF
    <div class="profesor_container_academia">
    <div class="profesor_academia">
        <div class="avatar_container_academia">
            <img src="{$imagenPath}" alt="Avatar de {$profesor->getNombre()}" class="profesor_avatar_academia">
        </div>
        <div class="separator_vertical"><br></br></div> <!-- Separador vertical -->
        <div class="info_container_academia">
            <div class="profesor_nombre_academia"><strong>Nombre:</strong> {$profesor->getNombre()}</div>
            <div class="separator_horizontal"></div> <!-- Separador horizontal -->
            <div class="profesor_precio_academia"><strong>Precio:</strong> {$precioTexto}</div>
            <div class="profesor_valoracion_academia"><strong>Valoracion:</strong> {$valoracionTexto}</div>
            <div class="profesor_correo_academia"><strong>Correo:</strong> {$profesor->getCorreo()}</div>
            <form action="{$rutaChat}" method="post">
                <input type="hidden" name="id" value="{$idProfesor}">
                <button type="submit" class="button-like-link">Enviar Mensaje</button>
            </form>
            <form action="{$rutaDescontratar}" method="post">
                <input type="hidden" name="idProfesor" value="{$idProfesor}">
                <input type="hidden" name="idAlumno" value="{$idUsuario}">
                <input type="hidden" name="imagenPath" value="{$imagenPath}">
                <button type="submit" class="button-profesor-academia">Darse de baja</button>
            </form>
        </div>
        </div>
        </div> 
    EOF;

    return $html;
}

?>