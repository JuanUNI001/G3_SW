<?php
namespace es\ucm\fdi\aw\src\Usuarios;
use es\ucm\fdi\aw\src\BD;

class Usuario
{

    public const ADMIN_ROLE = 1;

    public const USER_ROLE = 2;

    public const TEACHER_ROLE = 3;

    public static function login($correo, $password)
    {
        $usuario = self::buscaUsuario($correo);
        if ($usuario && $usuario->compruebaPassword($password)) {
            return true;
        }
        return false;
    }
    
    public static function crea($rolUser,$nombre, $password, $correo, $avatar )
    {
        $user = new Usuario($rolUser,$nombre, self::hashPassword($password), $correo, $avatar);
        
        return $user->guarda();
    }

    public static function buscaUsuario($correo)
    {
        $conn = \es\ucm\fdi\aw\src\BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios U WHERE U.correo='%s'", $conn->real_escape_string($correo));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['rolUser'], $fila['nombre'], $fila['password'],$fila['correo'], $fila['avatar'],$fila['id']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorId($idUsuario)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios WHERE id=%d", $idUsuario);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['rolUser'], $fila['nombre'],$fila['password'],$fila['correo'], $fila['avatar'],  $fila['id']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
    protected static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    
   
    private static function inserta($usuario)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        
        // Verificar si el rol existe en la base de datos
        $rolUser = intval($usuario->rolUser); // Convertir a entero
        $rolExistsQuery = "SELECT COUNT(*) AS count FROM roles WHERE id = $rolUser";
        $result = $conn->query($rolExistsQuery);
        $row = $result->fetch_assoc();
        
        if ($row['count'] > 0) {
            // El rol existe, entonces inserta el usuario
            $nombre = $conn->real_escape_string($usuario->nombre);
            $password = $conn->real_escape_string($usuario->password);
            $correo = $conn->real_escape_string($usuario->correo);
            $avatar =  $conn->real_escape_string($usuario->avatar);
            $query = "INSERT INTO usuarios(rolUser, nombre, password, correo, avatar) VALUES ('$rolUser', '$nombre', '$password', '$correo', '$avatar')";
            
            if ($conn->query($query)) {
                $usuario->id = $conn->insert_id;
                $result = true;
            } else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
        } else {
            error_log("Error: El rol especificado no existe en la base de datos.");
        }
        
        return $result;
    }
    public static function rolUsuario($usuario)
    {
        $conn = BD::getInstance()->getConexionBd();

        // Verificar si el rol existe en la base de datos y obtener su nombre
        $rolUser = intval($usuario->rolUser); // Convertir a entero
        $rolQuery = "SELECT nombre FROM roles WHERE id = $rolUser";

        $result = $conn->query($rolQuery);

        if ($result && $result->num_rows > 0) {
            $rolRow = $result->fetch_assoc();
            return $rolRow['nombre'];
        } else {
            // El rol no existe en la base de datos, puedes manejar este caso según tus necesidades
            return null;
        }
    }



   
    
    
    private static function actualiza($usuario)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query=sprintf("UPDATE usuarios U SET rolUser = '%d', nombre='%s', password='%s', correo='%s', avatar = '%s' WHERE U.id=%d"
            , $conn->$usuario->rolUser
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->correo)
            , $conn->real_escape_string($usuario->avatar)
            , $usuario->id
        );
        if ( $conn->query($query) ) {
            $result = self::borraRoles($usuario);
            
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }

    public static function actualizaDatosFormulario($idActualizar, $usuarioNuevo)
    {
        $result = false;
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE usuarios P SET nombre = '%s', rolUser = %d, correo = '%s', avatar = '%s' WHERE P.id = %d",
            $conn->real_escape_string($usuarioNuevo->nombre),
            $usuarioNuevo->rolUsuario,
            $conn->real_escape_string($usuarioNuevo->correo),
            $conn->real_escape_string($usuarioNuevo->avatar),
            $idActualizar
        );
        $result = $conn->query($query);        
        return $result;
    }
   
    
    
    private static function borra($usuario)
    {
        return self::borraPorId($usuario->id);
    }
    
    private static function borraPorId($idUsuario)
    {
        if (!$idUsuario) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM usuarios U WHERE U.id = %d"
            , $idUsuario
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    public function cambiaAvatar($nuevoAvatar)
    {
        $conn = BD::getInstance()->getConexionBd();
        $id = $this->getId();
        $nuevoAvatar = $conn->real_escape_string($nuevoAvatar);
        
        $query = "UPDATE usuarios SET avatar = '$nuevoAvatar' WHERE id = $id";

        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    private $id;

    private $rolUser;

    private $password;

    private $nombre;

    private $correo;

    private $avatar;//será la foto que el usuario puede incluir


    protected  function __construct($rol,$nombre, $password, $correo, $avatar, $id = null)
    {
        $this->id = $id;
        $this->rolUser = $rol;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->avatar = $avatar;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getrolUser()
    {
        return $this->rolUser;
    }

    public function getRolString()
    {
        $rol = "INVALID";
        if($this->rolUser == self::ADMIN_ROLE)
        {
            $rol = "Admin";
        }
        else if($this->rolUser == self::USER_ROLE)
        {
            $rol = "User";
        }
        else if($this->rolUser == self::TEACHER_ROLE)
        {
            $rol = "Profesor";
        }

        return $rol;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function getCorreo()
    {
        return $this->correo;
    }
    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setNombre($nuevoNombre)
    {
        $this->nombre = $nuevoNombre;
    }
    public function setRol($nuevoRol)
    {
        $this->rolUsuario = $nuevoRol;
    }
    public function setCorreo($nuevoCorreo)
    {
        $this->correo = $nuevoCorreo;
    }
    public function setAvatar($nuevoAvatar)
    {
        $this->avatar = $nuevoAvatar;
    }

    public function compruebaPassword($password)
    {
        $contra = $this->password;  
        return password_verify($password, $this->password);
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->password = self::hashPassword($nuevoPassword);
    }
    public function cambiaRol($rolUser)
    {
        $this->password = self::hashPassword($nuevoPassword);
    }

    
    public function guarda()
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }
    
    public function borrate()
    {
        if ($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }

    public static function listarUsuarios()
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = "SELECT * FROM usuarios";
         
        $rs = $conn->query($query);
        $usuarios = array(); 
        if ($rs) {
        while ($fila = $rs->fetch_assoc()) {
        $usuario = new Usuario(      
        $fila['rolUser'],         
        $fila['nombre'],   
        $fila['password'],
        $fila['correo'],  
        $fila['avatar'],   
        $fila['id']
        );
        $usuarios[] = $usuario; 
        }
        $rs->free();
        }
        return $usuarios;
    }
}
