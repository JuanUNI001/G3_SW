<?php
namespace es\ucm\fdi\aw\src;
/**
 * Clase que mantiene el estado global de la aplicación.
 */
class BD
{
	const ATRIBUTOS_PETICION = 'attsPeticion';

	private static $instancia;
	
	/**
	 * Devuele una instancia de {@see Aplicacion}.
	 * 
	 * @return Applicacion Obtiene la única instancia de la <code>Aplicacion</code>
	 */
	public static function getInstance() {
		if (  !self::$instancia instanceof self) {
			self::$instancia = new static();
		}
		return self::$instancia;
	}

	/**
	 * @var array Almacena los datos de configuración de la BD
	 */
	private $bdDatosConexion;
	
	/**
	 * Almacena si la Aplicacion ya ha sido inicializada.
	 * 
	 * @var boolean
	 */
	private $inicializada = false;
	
	/**
	 * @var \mysqli Conexión de BD.
	 */
	private $conn;

	/**
	 * @var array Tabla asociativa con los atributos pendientes de la petición.
	 */
	private $atributosPeticion;
	
	/**
	 * Evita que se pueda instanciar la clase directamente.
	 */
	private function __construct()
	{
	}
	
	/**
	 * Inicializa la aplicación.
     *
     * Opciones de conexión a la BD:
     * <table>
     *   <thead>
     *     <tr>
     *       <th>Opción</th>
     *       <th>Descripción</th>
     *     </tr>
     *   </thead>
     *   <tbody>
     *     <tr>
     *       <td>host</td>
     *       <td>IP / dominio donde se encuentra el servidor de BD.</td>
     *     </tr>
     *     <tr>
     *       <td>bd</td>
     *       <td>Nombre de la BD que queremos utilizar.</td>
     *     </tr>
     *     <tr>
     *       <td>user</td>
     *       <td>Nombre de usuario con el que nos conectamos a la BD.</td>
     *     </tr>
     *     <tr>
     *       <td>pass</td>
     *       <td>Contraseña para el usuario de la BD.</td>
     *     </tr>
     *   </tbody>
     * </table>
	 * 
	 * @param array $bdDatosConexion datos de configuración de la BD
	 */
	public function init($bdDatosConexion)
	{
        if ( ! $this->inicializada ) {
    	    $this->bdDatosConexion = $bdDatosConexion;
    		$this->inicializada = true;
    		session_start();
			/* Se inicializa los atributos asociados a la petición en base a la sesión y se eliminan para que
			* no estén disponibles después de la gestión de esta petición.
			*/
			$this->atributosPeticion = $_SESSION[self::ATRIBUTOS_PETICION] ?? [];
			unset($_SESSION[self::ATRIBUTOS_PETICION]);
        }
	}
	
	/**
	 * Cierre de la aplicación.
	 */
	public function shutdown()
	{
	    $this->compruebaInstanciaInicializada();
	    if ($this->conn !== null && ! $this->conn->connect_errno) {
	        $this->conn->close();
	    }
	}
	
	/**
	 * Comprueba si la aplicación está inicializada. Si no lo está muestra un mensaje y termina la ejecución.
	 */
	private function compruebaInstanciaInicializada()
	{
	    if (! $this->inicializada ) {
	        echo "Aplicacion no inicializa";
	        exit();
	    }
	}
	
	/**
	 * Devuelve una conexión a la BD. Se encarga de que exista como mucho una conexión a la BD por petición.
	 * 
	 * @return \mysqli Conexión a MySQL.
	 */
	public function getConexionBd()
	{
	    $this->compruebaInstanciaInicializada();
		if (! $this->conn ) {
			
			
			$driver = new \mysqli_driver();
			$driver->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

			$conn = new \mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);
			$conn->set_charset("utf8mb4");
			$this->conn = $conn;
		}
		return $this->conn;
	}

	/**
	 * Añade un atributo <code>$valor</code> para que esté disponible en la siguiente petición bajo la clave <code>$clave</code>.
	 * 
	 * @param string $clave Clave bajo la que almacenar el atributo.
	 * @param any    $valor Valor a almacenar como atributo de la petición.
	 * 
	 */
	public function putAtributoPeticion($clave, $valor)
	{
		$atts = null;
		if (isset($_SESSION[self::ATRIBUTOS_PETICION])) {
			$atts = &$_SESSION[self::ATRIBUTOS_PETICION];
		} else {
			$atts = array();
			$_SESSION[self::ATRIBUTOS_PETICION] = &$atts;
		}
		$atts[$clave] = $valor;
	}

	/**
	 * Devuelve un atributo establecido en la petición actual o en la petición justamente anterior.
	 * 
	 * 
	 * @param string $clave Clave sobre la que buscar el atributo.
	 * 
	 * @return any Attributo asociado a la sesión bajo la clave <code>$clave</code> o <code>null</code> si no existe.
	 */
	public function getAtributoPeticion($clave)
	{
		$result = $this->atributosPeticion[$clave] ?? null;
		if(is_null($result) && isset($_SESSION[self::ATRIBUTOS_PETICION])) {
			$result = $_SESSION[self::ATRIBUTOS_PETICION][$clave] ?? null;
		}
		return $result;
	}
}