<?php

require_once 'includes/config.php'; 
use \es\ucm\fdi\aw\src\Eventos\evento;
$form = new es\ucm\fdi\aw\FormularioInscripcion();


$tituloPagina = 'Inscriberse Evento';

$id_producto = $_GET['idEvento'];
$producto = Evento::buscaPorId($id_producto);
$nombre = $producto->getNombre();

$form->id = $id_producto;
$form->nombre = $nombre;
$form->precio = $producto->getPrecio();
$form->descripcion = $producto->getDescripcion();
$form->imagen = $producto->getImagen();

$htmlFormLogin = $form->gestiona();

$contenidoPrincipal=<<<EOS
    <h1>
        <p>Modificando datos de producto</p>
        <p> $nombre</p>
    </h1>
    $htmlFormLogin
EOS;

require_once 'includes/vistas/comun/layout.php';
