<?php
namespace es\ucm\fdi\aw\src\Usuarios;

echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/imagenes.css">';
echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/busqueda.css">';
require_once 'includes/src/Usuarios/ListaUsuarios.php';
use es\ucm\fdi\aw\src\Formulario;

class FormularioBusquedaUsuarios extends Formulario
{
    
    public $usuarios;

    public function __construct() {
        parent::__construct('FormularioBusquedaUsuarios', ['urlRedireccion' => 'usuariosView.php']);
    }
    protected function generarSelectorUsuario() {
        $disponible = ['Usuario', 'Profesor'];
        $html = ' <div class="col-11 categoria-selector">
                    <h4 class="card-title">Tipo usuario</h4>	
                    <select class="form-control mt-2" name="tipo">
                        <option value="">Todos</option>';
        foreach ($disponible as $dispo) {
            $html .= '<option value="' . $dispo . '">' . $dispo . '</option>';
        }
        $html .= '</select>
                </div>';
        return $html;
    }
    protected function generaCamposFormulario(&$datos)
    {
    // Verificar si se ha enviado el formulario por POST
        
        // Capturar valores de los filtros
        $buscar = $_SESSION['filtro_buscar'] ?? '';
        $correo = $_SESSION['filtro_buscar_correo'] ?? '';
        $tipo = $_SESSION['filtro_tipo'] ?? '';
        $orden = $_SESSION['filtro_orden'] ?? '';
        $usuarios = listarUsuariosBusqueda($buscar, $correo,$tipo, $orden);
       
    
    
    // Generar el HTML del formulario
    $html = '
    <div class="container mt-5">
        <div class="col-12">
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Usuarios</h4>
                            <form id="form2" name="form2" method="POST" action="<?php echo $ruta; ?>">
                                <div class="col-12 row">
                                    <div class="mb-3 textomitad">
                                        <label class="form-label">Nombre a buscar</label>
                                        <input type="text" class="form-control" id="buscar" name="buscar" value="' .  $buscar  . '">
                                    </div>
                                    <div class="mb-3 textomitad">
                                        <label class="form-label">Correo a buscar</label>
                                        <input type="text" class="form-control" id="correo" name="correo" value="' .  $correo  . '">
                                    </div>';
                                    
                                    
                                    $html .= $this->generarSelectorUsuario();
                                    $html .= '
                                   
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
                                                            <option value="2">Ordenar por correo</option>
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
                                ' . $usuarios . '
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
            document.getElementById("tipo").value = "";
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
        $_SESSION['filtro_tipo'] = $datos['tipo'] ?? '';
        $_SESSION['filtro_orden'] = $datos['orden'] ?? '';
    
        // Procesar los datos
        $this->errores = [];
        $buscar = trim($datos['buscar'] ?? '');
        $buscar = filter_var($buscar, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $correo = trim($datos['correo'] ?? '');
        $correo = filter_var($correo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $tipo = trim($datos['tipo'] ?? '');
        $tipo = filter_var($buscar, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // Aquí establecemos el valor de $orden a vacío si se hace clic en "Limpiar filtros"
        $orden = isset($datos['limpiar-filtros-btn']) ? '' : trim($datos['orden'] ?? '');
        $orden = filter_var($orden, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        // Validación de los datos recibidos
        if (empty($buscar) && empty($correo) && empty($tipo) && empty($orden)) {
            $this->errores['general'] = 'Debes proporcionar al menos un filtro para realizar la búsqueda.';
        }
    
        // Si no hay errores, se procesan los datos
        if (count($this->errores) === 0) {
            $usuarios = listarUsuariosBusqueda($buscar, $correo,$tipo, $orden);
        }
    }
    

}
?>
