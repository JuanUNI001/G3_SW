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
        $usuario = self::buscaUsuarioNoArchivado($correo);
        if ($usuario && $usuario->compruebaPassword($password)) {
            return true;
        }
        return false;
    }
    
    public static function crea($rolUser,$nombre, $password, $correo, $avatar )
    {
        $user = new Usuario($rolUser,$nombre, self::hashPassword($password), $correo, $avatar, null, '0');
        $user->id = null;
        return  $user;
    }
    public static function usuarioSigue($idUsuario, $idUsuarioSeguir) {
        $app = BD::getInstance();
        $conexion = $app->getConexionBd();
    
        // Consulta SQL para verificar si el usuario sigue al otro en la misma fila
        $consulta = "SELECT COUNT(*) AS sigue FROM seguir WHERE idUsuario = $idUsuario AND idUsuarioSeguir = $idUsuarioSeguir";
        $resultado = $conexion->query($consulta);
    
        // Verificar si hay algún resultado
        if ($resultado) {
            $row = $resultado->fetch_assoc();
            // Devuelve true si sigue al usuario en la misma fila, false si no
            return $row['sigue'] > 0;
        } else {
            // Manejar el error si la consulta falla
            error_log("Error en la consulta de usuarioSigue: {$conexion->error}");
            return false;
        }
    }
    public static function insertarRelacionSeguir($idUsuario, $idUsuarioSeguir) {
        $app = BD::getInstance();
        $conexion = $app->getConexionBd();
    
        // Consulta SQL para insertar una nueva fila en la tabla seguir
        $consultaInsert = "INSERT INTO seguir (idUsuario, idUsuarioSeguir) VALUES ($idUsuario, $idUsuarioSeguir)";
        $resultadoInsert = $conexion->query($consultaInsert);
        
        if ($resultadoInsert) {
            return true; // Se ha añadido la nueva relación de seguimiento
        } else {
            // Manejar el error si la inserción falla
            error_log("Error al añadir la nueva relación de seguimiento: {$conexion->error}");
            return false;
        }
    }
    public static function eliminarRelacionSeguir($idUsuario, $idUsuarioSeguir) {
        $app = BD::getInstance();
        $conexion = $app->getConexionBd();
    
        // Consulta SQL para eliminar la relación de seguimiento
        $consultaDelete = "DELETE FROM seguir WHERE idUsuario = $idUsuario AND idUsuarioSeguir = $idUsuarioSeguir";
        $resultadoDelete = $conexion->query($consultaDelete);
    
        if ($resultadoDelete) {
            return true; // Se ha eliminado la relación de seguimiento
        } else {
            // Manejar el error si la eliminación falla
            error_log("Error al eliminar la relación de seguimiento: {$conexion->error}");
            return false;
        }
    }
    public static function eliminarSeguirPorIdUsuario($idUsuario) {
        $app = BD::getInstance();
        $conexion = $app->getConexionBd();
    
        // Consulta SQL para eliminar las relaciones de seguimiento
        $consultaDelete = "DELETE FROM seguir WHERE idUsuario = $idUsuario";
        $resultadoDelete = $conexion->query($consultaDelete);
    
        if ($resultadoDelete) {
            return true; // Se han eliminado las relaciones de seguimiento
        } else {
            // Manejar el error si la eliminación falla
            error_log("Error al eliminar las relaciones de seguimiento para el usuario con ID $idUsuario: {$conexion->error}");
            return false;
        }
    }
    public static function eliminarSiguiendorPorIdUsuario($idUsuarioSeguir) {
        $app = BD::getInstance();
        $conexion = $app->getConexionBd();
    
        // Consulta SQL para eliminar las relaciones de seguimiento
        $consultaDelete = "DELETE FROM seguir WHERE idUsuarioSeguir = $idUsuarioSeguir";
        $resultadoDelete = $conexion->query($consultaDelete);
    
        if ($resultadoDelete) {
            return true; // Se han eliminado las relaciones de seguimiento
        } else {
            // Manejar el error si la eliminación falla
            error_log("Error al eliminar las relaciones de seguimiento para el usuario con ID $idUsuarioSeguir: {$conexion->error}");
            return false;
        }
    }
    
    public static function buscaUsuario($correo)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios U WHERE U.correo='%s'", $conn->real_escape_string($correo));
        $rs = $conn->query($query);
        $result = null;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['rolUser'], $fila['nombre'], $fila['password'],$fila['correo'], $fila['avatar'],$fila['archivado'],$fila['id']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public static function buscaUsuarioNoArchivado($correo)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios U WHERE U.correo='%s'", $conn->real_escape_string($correo));
        $rs = $conn->query($query);
        $result = null;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['rolUser'], $fila['nombre'], $fila['password'],$fila['correo'], $fila['avatar'],$fila['archivado'],$fila['id']);
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
                $result = new Usuario($fila['rolUser'], $fila['nombre'],$fila['password'],$fila['correo'], $fila['avatar'],  $fila['archivado'], $fila['id']);
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
        $rolUser = $usuario->rolUser; // Convertir a entero
        $rolExistsQuery = "SELECT COUNT(*) AS count FROM roles WHERE id = $rolUser";
        $result = $conn->query($rolExistsQuery);
        $row = $result->fetch_assoc();
        
        if ($row['count'] > 0) {
            
            $nombre = $conn->real_escape_string($usuario->nombre);
            $password = $conn->real_escape_string($usuario->password);
            $correo = $conn->real_escape_string($usuario->correo);
            $avatar =  $conn->real_escape_string($usuario->avatar);
            $archivado = $usuario->archivado;
            $query = "INSERT INTO usuarios(rolUser, nombre, password, correo, avatar, archivado) VALUES ('$rolUser', '$nombre', '$password', '$correo', '$avatar', '$archivado')";
            
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
        $query=sprintf("UPDATE usuarios U SET rolUser = '%d', nombre='%s', password='%s', correo='%s', avatar = '%s', archivado = '%d' WHERE U.id=%d"
            , $usuario->rolUser
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->correo)
            , $conn->real_escape_string($usuario->avatar)
            , $usuario->id
            , $usuario->archivado
        );
       
        
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
    public static function ocultaUsuario($idUsuario)
    {
        if (!$idUsuario) {
            return false;
        } 
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE usuarios SET archivado = 1 WHERE id = %d", $idUsuario);

        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }
    public static function recuperaUsuario($idUsuario)
    {
        if (!$idUsuario) {
            return false;
        } 
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE usuarios SET archivado = 0 WHERE id = %d", $idUsuario);

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

    protected $id;

    protected $rolUser;

    protected $password;

    protected $nombre;

    protected $correo;

    protected $avatar;//será la foto que el usuario puede incluir

    protected $archivado;

    protected  function __construct($rol,$nombre, $password, $correo, $avatar,  $archivado,$id)
    {
        $this->id = intval($id);
        $this->rolUser = $rol;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->avatar = $avatar;
        $this->archivado = intval($archivado);
    }
    
    public function esArchivado(){
        if($this->archivado === 0){
            return false;
        }
        return true;
    }
    public function getId()
    {
        return $this->id;
    }

    public function getrolUser()
    {
        return $this->rolUser;
    }
    public function getArchivado()
    {
        return $this->archivado;
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
        
        if ($this->id !== null ) {
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
    public static function obtenerUsuariosSeguidos($idUsuario) {
        $app = BD::getInstance();
        $conexion = $app->getConexionBd();
    
        // Consulta SQL para obtener los usuarios seguidos por el usuario actual
        $consulta = "SELECT U.*
                     FROM usuarios U
                     JOIN seguir S ON U.id = S.idUsuarioSeguir
                     WHERE S.idUsuario = $idUsuario AND archivado = '0'";
    
        $resultados = $conexion->query($consulta);
    
        // Verificar si hay resultados
        if ($resultados) {
            $usuariosSeguidos = array();
    
            // Iterar sobre los resultados y crear objetos Usuario
            while ($fila = $resultados->fetch_assoc()) {
                $usuario = new Usuario(
                    $fila['rolUser'],
                    $fila['nombre'],
                    '',
                    $fila['correo'],
                    $fila['avatar'],
                    $fila['archivado'],
                    $fila['id']
                );
                $usuariosSeguidos[] = $usuario;
            }
    
            // Liberar los resultados y devolver la lista de usuarios seguidos
            $resultados->free();
            return $usuariosSeguidos;
        } else {
            // Manejar el error si la consulta falla
            error_log("Error en la consulta obtenerUsuariosSeguidos: {$conexion->error}");
            return false;
        }
    }
    
    public static function listarUsuarios($idUser)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query ="SELECT * FROM usuarios WHERE rolUser != '1' AND id != $idUser AND archivado = '0'";
         
        $rs = $conn->query($query);
        $usuarios = array(); 
        if ($rs) {
        while ($fila = $rs->fetch_assoc()) {
        $usuario = new Usuario(      
        $fila['rolUser'],         
        $fila['nombre'],   
        '',
        $fila['correo'],  
        $fila['avatar'],  
        $fila['archivado'], 
        $fila['id']
        
        );
        $usuarios[] = $usuario; 
        }
        $rs->free();
        }
        return $usuarios;
    }
    public static function listarUsuariosBusqueda($buscar, $correo, $tipo, $orden, $idUser)
    {
        $conn = BD::getInstance()->getConexionBd();
        
        $query = "SELECT * FROM usuarios WHERE rolUser != '1' AND id != $idUser AND archivado = '0'";


        if (!empty($buscar)) {
            $query .= " AND (nombre LIKE '%$buscar%' )";
        }
        if (!empty($correo)) {
            $query .= " AND (correo LIKE '%$correo%')";
        }
        
        if (!empty($tipo)) {
            switch ($tipo) {
                case 'Usuario':
                    $query .= " AND rolUser = '2'";
                    break;
                case 'Profesor':
                    $query .= " AND rolUser = '3'";
                    break;
                default:
                    break;
            }
        }
        
        switch ($orden) {
            case '1':
                $query .= " ORDER BY nombre ASC";
                break;
            case '2':
                $query .= " ORDER BY correo ASC";
                break;
            default:
                break;
        }

        $rs = $conn->query($query);
        $profesores = array(); 
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $profesor = new Usuario(
                    $fila['rolUser'],         
                    $fila['nombre'],   
                    '',
                    $fila['correo'],
                    $fila['avatar'], 
                    $fila['archivado'],  
                    $fila['id']
                   
                );
                $profesores[] = $profesor; 
            }
            $rs->free();
        }
        return $profesores;
    }
    public static function listarUsuariosBusquedaArchivados($buscar, $correo, $tipo, $orden, $idUser)
    {
        $conn = BD::getInstance()->getConexionBd();
        
        $query = "SELECT * FROM usuarios WHERE rolUser != '1' AND id != $idUser AND archivado = '1'";


        if (!empty($buscar)) {
            $query .= " AND (nombre LIKE '%$buscar%' )";
        }
        if (!empty($correo)) {
            $query .= " AND (correo LIKE '%$correo%')";
        }
        
        if (!empty($tipo)) {
            switch ($tipo) {
                case 'Usuario':
                    $query .= " AND rolUser = '2'";
                    break;
                case 'Profesor':
                    $query .= " AND rolUser = '3'";
                    break;
                default:
                    break;
            }
        }
        
        switch ($orden) {
            case '1':
                $query .= " ORDER BY nombre ASC";
                break;
            case '2':
                $query .= " ORDER BY correo ASC";
                break;
            default:
                break;
        }

        $rs = $conn->query($query);
        $profesores = array(); 
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $profesor = new Usuario(
                    $fila['rolUser'],         
                    $fila['nombre'],   
                    '',
                    $fila['correo'],
                    $fila['avatar'], 
                    $fila['archivado'],  
                    $fila['id']
                   
                );
                $profesores[] = $profesor; 
            }
            $rs->free();
        }
        return $profesores;
    }
    public static function listarUsuariosBusquedaForo($buscar, $correo, $tipo, $orden)
    {
        $conn = BD::getInstance()->getConexionBd();

        $query = "SELECT * FROM usuarios WHERE 1 = 1 AND archivado = '0'";

        if (!empty($buscar)) {
            $query .= " AND (nombre LIKE '%$buscar%' )";
        }
        if (!empty($correo)) {
            $query .= " AND (correo LIKE '%$correo%')";
        }
        
        if (!empty($tipo)) {
            switch ($tipo) {
                case 'Usuario':
                    $query .= " AND rolUser = '2'";
                    break;
                case 'Profesor':
                    $query .= " AND rolUser = '3'";
                    break;
                default:
                    break;
            }
        }
        
        switch ($orden) {
            case '1':
                $query .= " ORDER BY nombre ASC";
                break;
            case '2':
                $query .= " ORDER BY correo ASC";
                break;
            default:
                break;
        }
        $rs = $conn->query($query);
        $profesores = array(); 
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $profesor = new Usuario(
                    $fila['rolUser'],         
                    $fila['nombre'],   
                    '',
                    $fila['correo'],
                    $fila['avatar'],   
                    $fila['archivado'],
                    $fila['id']
                
                );
                $profesores[] = $profesor; 
            }
            $rs->free();
        }
        return $profesores;
    }

    public static function listarUsuariosEnConversacion($idUsuario)
    {
        //devuelve los usuarios con los que el user $idUsuario tiene al menos un mensaje intercambiado
        $conn = BD::getInstance()->getConexionBd();
        $query = "SELECT DISTINCT u.id, u.nombre, u.correo, u.rolUser, u.avatar
                    FROM usuarios u
                    JOIN mensajes m ON u.id = m.idEmisor OR u.id = m.idDestinatario
                    WHERE (m.idEmisor = '$idUsuario' OR m.idDestinatario = '$idUsuario') AND u.id != '$idUsuario' AND archivado = '0'";
         
         $rs = $conn->query($query);
         $usuarios = array(); 
         if ($rs) {
         while ($fila = $rs->fetch_assoc()) {
         $usuario = new Usuario(      
         $fila['rolUser'],         
         $fila['nombre'],   
         '',
         $fila['correo'],  
         $fila['avatar'],   
         $fila['archivado'],
         $fila['id']
         );
         $usuarios[] = $usuario; 
         }
         $rs->free();
         }
         return $usuarios;
    }

    public static function listarAlumnosDeProfesor($idProfesor)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = "SELECT u.* 
                  FROM usuarios u 
                  INNER JOIN alumnos a ON u.id = a.idAlumno 
                  WHERE a.idProfesor = $idProfesor AND archivado = '0'";
    
        $rs = $conn->query($query);
        $alumnos = array(); 
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $alumno = new Usuario(      
                    $fila['rolUser'],         
                    $fila['nombre'],   
                    '',
                    $fila['correo'],  
                    $fila['avatar'],   
                    $fila['archivado'],
                    $fila['id']
                );
                $alumnos[] = $alumno; 
            }
            $rs->free();
        }
        return $alumnos;
    }

}
