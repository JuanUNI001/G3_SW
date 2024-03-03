<?php
    $server = 'localhost';
    $usuario = 'root';
    $password = 'wlodkowska';
    $db = 'mesamaestrabbdd';

    $conexion = new mysqli($server,$usuario,$password,$db);

    if($conexion->connect_errno){
        die('ERROR CONEXION BBDD'. $conexion->connect_errno);
    }
    else{
        echo'CONECTADO';
    }

?>