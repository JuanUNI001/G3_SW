<?php

namespace es\ucm\fdi\aw\src\usuarios;
use es\ucm\fdi\aw\src\BD;

class Profesor extends Usuario
{
    private $valoracion;
    private $precio;
    private $categoria;
    public function __construct($rol, $nombre, $password, $correo,  $precio,$valoracion, $avatar,$id = null)
    {
        parent::__construct($rol, $nombre, self::hashPassword($password), $correo, $avatar, $id);
        
        $this->valoracion =  $valoracion;
        $this->precio =  $precio;
       
    }
    public static function creaProfesor($nombre, $password, $correo, $precio)
    {
        $user = new Profesor(self::TEACHER_ROLE, $nombre, $password, $correo,  $precio, null, null);
        $guardado = $user->guarda();
        if ($guardado) {
            $user->actualizaPrecio($precio);
        }
        return $guardado;
    }
    
    public function getValoracion()
    {
        return $this->valoracion;
    }
    public function getPrecio()
    {
        return $this->precio;
    }
    public function getCategoria()
    {
        return $this->categoria;
    }



    public function actualizaPrecio($nuevoPrecio)
    {
        $conn = BD::getInstance()->getConexionBd();
        $idProfesor = $this->getId(); // Llamo a getId para coger el id de Usuario
        $nuevoPrecio = $conn->real_escape_string($nuevoPrecio);
        
        $query = "UPDATE Usuarios SET precio = '$nuevoPrecio' WHERE id = $idProfesor";

        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }
    public static function listarProfesores()
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = "SELECT * FROM Usuarios WHERE rolUser = " . self::TEACHER_ROLE;
        
        $rs = $conn->query($query);
        $profesores = array(); 
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $profesor = new Profesor(      
                    $fila['rolUser'],         
                    $fila['nombre'],   
                    $fila['password'],                 
                    $fila['correo'],
                    $fila['precio'],   
                    $fila['valoracion'],   
                    $fila['avatar'],                                       
                    $fila['id']
                );
                $profesores[] = $profesor; 
            }
            $rs->free();
        }
        return $profesores;
    }
}

