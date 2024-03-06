<?php
$server = 'localhost';
$usuario = 'root';
$password = ''; 
$dbname = 'productos'; 

// Establecer la conexión
$conexion = new mysqli($server, $usuario, $password, $dbname);

// Verificar si hay errores de conexión
if ($conexion->connect_error) {
    die('<strong>No pudo conectarse:</strong> ' . $conexion->connect_error);
}
?>
