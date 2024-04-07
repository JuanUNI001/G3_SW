<?php
/* */
/* Parámetros de configuración de la aplicación */
/* */

// Parámetros de configuración generales
//define('RUTA_APP', '/Practica2/G3_SW');
define('RUTA_APP', '/G3_SW');

define('RUTA_IMGS', RUTA_APP . '/');
define('RUTA_CSS', RUTA_APP . '/css');
define('RUTA_JS', RUTA_APP . '/js');
define('RUTA_VISTAS_COMUN', __DIR__ . '/vistas/comun');
define('RUTA_VISTAS', RUTA_APP . '/includes/vistas');
define('INSTALADA', true);

// Parámetros de configuración de la BD
define('BD_HOST', 'localhost');
define('BD_NAME', 'mesamaestra');
define('BD_USER', 'root');
define('BD_PASS', '');

/**
 * Configuración del soporte de UTF-8, localización (idioma y país) y zona horaria
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

spl_autoload_register(function ($clase) {
      
    $prefix = 'es\\ucm\\fdi\\aw\\';
       
    $base_dir = __DIR__ . '/';
      
    $len = strlen($prefix);
    if (strncmp($prefix, $clase, $len) !== 0) {       
        return;
    }
    
    $relative_class = substr($clase, $len);
    
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});
// Inicializa la aplicación

$app = es\ucm\fdi\aw\src\BD::getInstance();
$app->init(['host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS]);

if (! INSTALADA) {
	$app->paginaError(502, 'Error', 'Oops', 'La aplicación no está configurada. Tienes que modificar el fichero config.php');
}
/**
 * @see http://php.net/manual/en/function.register-shutdown-function.php
 * @see http://php.net/manual/en/language.types.callable.php
 */

register_shutdown_function(array($app, 'shutdown'));

// Incluimos funciones de utiliría básicas que se utilizan en la mayoría de páginas
require_once __DIR__ . '/vistas/helpers/utils.php';