<?php
namespace es\ucm\fdi\aw\src\Profesores;

echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/imagenes.css">';
echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/busqueda.css">';
require_once 'includes/src/Profesores/listaProfesores.php';

use es\ucm\fdi\aw\src\Formulario;

class FormularioBusquedaProfesor extends Formulario
{
    
    public $productos;

    public function __construct() {
        parent::__construct('FormularioBusquedaProfesor', ['urlRedireccion' => 'profesores.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
    // Verificar si se ha enviado el formulario por POST
        
        // Capturar valores de los filtros
        $buscar = $_SESSION['filtro_buscar'] ?? '';
        $correo = $_SESSION['filtro_buscar_correo'] ?? '';
        $buscaPrecioDesde = $_SESSION['filtro_precio_desde'] ?? '';
        $buscaPrecioHasta = $_SESSION['filtro_precio_hasta'] ?? '';
        $orden = $_SESSION['filtro_orden'] ?? '';
        $productos = listaProfesoresFiltrada($buscar, $correo,$buscaPrecioDesde, $buscaPrecioHasta, $orden);
       
    
    
    // Generar el HTML del formulario
    $html = '
    <div class="container mt-5">
        <div class="col-12">
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Productos a la venta</h4>
                            <form id="form2" name="form2" method="POST" action="<?php echo $ruta; ?>">
                                <div class="col-12 row">
                                    <div class="mb-3 textomitad">
                                        <label class="form-label">Nombre a buscar</label>
                                        <input type="text" class="form-control" id="buscar" name="buscar" value="' .  $buscar  . '">
                                    </div>
                                    <div class="mb-3 textomitad">
                                        <label class="form-label">Correo a buscar</label>
                                        <input type="text" class="form-control" id="correo" name="correo" value="' .  $correo  . '">
                                    </div>
                                    <div class="col-11">
                                        <h4 class="card-title">Filtro Precio</h4>
                                        <table class="table">
                                            <thead>
                                                <tr class="filters">
                                                    <th>
                                                        Precio desde:
                                                        <input type="number" id="buscaPrecioDesde" name="buscaPrecioDesde" class="form-control mt-2" value="' . $buscaPrecioDesde . '" style="border: #bababa 1px solid; color:#000000;" step="0.01" min="0">
                                                    </th>
                                                    <th>
                                                        Precio hasta:
                                                        <input type="number" id="buscaPrecioHasta" name="buscaPrecioHasta" class="form-control mt-2" value="' . $buscaPrecioHasta . '" style="border: #bababa 1px solid; color:#000000;" step="0.01" min="0">
                                                    </th>
                                                </tr>                                     
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="col-11">
                                        <h4 class="card-title">Filtro para ordenar</h4>	
                                        <table class="table">
                                            <thead>
                                                <tr class="filters">
                                                    <th>
                                                        Ordenados por:
                                                        <select id="assigned-tutor-filter" id="orden" name="orden" class="form-control mt-2" style="border: #bababa 1px solid; color:#000000;">
                                                                                                                   
                                                            <option value=""></option>
                                                            <option value="1">Ordenar por nombre</option>
                                                            <option value="2">Ordenar por precio</option>
                                                            <option value="3">Ordenar por valoración</option>
                                                        </select>
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>	
                                    <div class="col-11 mt-3 custom-btn-container">
                                        <button type="submit" id="aplicar-filtros-btn" class="btn btn-primary custom-btn">Aplicar filtros</button>
                                    </div>
                                    
                                    <div class="col-11 mt-3 custom-btn-container">
                                        <button type="button" id="limpiar-filtros-btn" class="btn btn-primary custom-btn">Limpiar filtros</button>
                                    </div>
                                </div>
                            </form>
                            <p style="font-weight: bold; color: pink;"><i class="mdi mdi-file-document"></i>Resultados encontrados</p>
                            <div class="table-responsive">
                                ' . $productos . '
                            </div>
                        </div>	
                    </div>
                </div>	
            </div>	
        </div>										
    </div>';
    $html .= '
    <script>
        document.getElementById("limpiar-filtros-btn").addEventListener("click", function() {
            // Limpiar los campos del formulario
            document.getElementById("buscar").value = "";
            document.getElementById("correo").value = "";
            document.getElementById("buscaPrecioDesde").value = "";
            document.getElementById("buscaPrecioHasta").value = "";
            document.getElementById("orden").value = "";
            
        });
    </script>';



    return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        // Asignar los valores de los filtros a $_SESSION antes de procesar los datos
        $_SESSION['filtro_buscar'] = $datos['buscar'] ?? '';
        $_SESSION['filtro_buscar_correo'] = $datos['correo'] ?? '';
        $_SESSION['filtro_precio_desde'] = $datos['buscaPrecioDesde'] ?? '';
        $_SESSION['filtro_precio_hasta'] = $datos['buscaPrecioHasta'] ?? '';
        $_SESSION['filtro_orden'] = $datos['orden'] ?? '';
    
        // Procesar los datos
        $this->errores = [];
        $buscar = trim($datos['buscar'] ?? '');
        $buscar = filter_var($buscar, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $correo = trim($datos['correo'] ?? '');
        $correo = filter_var($correo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $buscaPrecioDesde = trim($datos['buscaPrecioDesde'] ?? '');
        $buscaPrecioDesde = filter_var($buscaPrecioDesde, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        $buscaPrecioHasta = trim($datos['buscaPrecioHasta'] ?? '');
        $buscaPrecioHasta = filter_var($buscaPrecioHasta, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        // Aquí establecemos el valor de $orden a vacío si se hace clic en "Limpiar filtros"
        $orden = isset($datos['limpiar-filtros-btn']) ? '' : trim($datos['orden'] ?? '');
        $orden = filter_var($orden, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        // Validación de los datos recibidos
        if (empty($buscar) && empty($buscaPrecioDesde) && empty($buscaPrecioHasta) && empty($orden)) {
            $this->errores['general'] = 'Debes proporcionar al menos un filtro para realizar la búsqueda.';
        }
    
        // Si no hay errores, se procesan los datos
        if (count($this->errores) === 0) {
            $productos = listaProfesoresFiltrada($buscar, $correo,$buscaPrecioDesde, $buscaPrecioHasta, $orden);
        }
    }
    

}
?>
