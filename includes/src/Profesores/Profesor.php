<?php

namespace es\ucm\fdi\aw\src\Profesores;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use \es\ucm\fdi\aw\src\BD;

class Profesor extends Usuario
{
    private $valoracion;
    private $precio;
    private $categoria;
    private $anunciable;

    public function __construct($rol, $nombre, $password, $correo,  $precio, $avatar,$valoracion,$id = null)
    {
        parent::__construct($rol, $nombre, self::hashPassword($password), $correo, $avatar, $id);
        
        $this->valoracion =  $valoracion;
        $this->precio =  $precio;
        $this->anunciable = true;
    }
    public static function creaProfesor($nombre, $password, $correo, $precio, $avatar,$id = null)
    {
        $user = new Profesor(self::TEACHER_ROLE, $nombre, $password, $correo,  $precio, $avatar, $valoracion,$id);
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
        
        $query = "UPDATE usuarios SET precio = '$nuevoPrecio' WHERE id = $idProfesor";

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
        $query = "SELECT * FROM usuarios WHERE rolUser = ".self::TEACHER_ROLE;
         
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
        $fila['avatar'],   
        $fila['valoracion'],
        $fila['id']
        );
        $profesores[] = $profesor; 
        }
        $rs->free();
        }
        return $profesores;
    }

    public static function buscaPorId($idPprofesor)
    {
        $result = null;
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM usuarios P WHERE P.id = %d;', $idPprofesor); 
        $rs = null;
        try{
            $rs = $conn->query($query);
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result =  new Profesor(      
                    $fila['rolUser'],         
                    $fila['nombre'],   
                    $fila['password'],
                    $fila['correo'],
                    $fila['precio'],   
                    $fila['valoracion'],   
                    $fila['avatar'],
                    $fila['id']
                    );
        }
        } finally {
            if ($rs != null) {
                $rs->free();
            }
        }
        return $result; 
    }

    //El profesor se puede anunciar en la plataforma o esta baneado
    public function GetAnunciable()
    {
        return $this->anunciable;
    }

    //El profesor se puede anunciar en la plataforma
    public function SetAnunciableTrue()
    {
        $this->anunciable = true;
    }

    //El profesor no se puede anunciar en la plataforma
    public function SetAnunciableFalse()
    {
        $this->anunciable = false;
    }
}

