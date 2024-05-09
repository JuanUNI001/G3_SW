<?php
namespace es\ucm\fdi\aw\src\Eventos;

echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/imagenes.css">';
echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/busqueda.css">';

use es\ucm\fdi\aw\src\Formulario;

class FormularioBusquedaEventos extends Formulario
{
    
    private $eventos;

    public function __construct() {
        parent::__construct('FormularioBusquedaEventos', ['urlRedireccion' => 'eventos.php']);
    }
    protected function generarSelectorCategorias() {
        $categorias = ['Deportes', 'Cultura'];
        $html = ' <div class="col-11 categoria-selector">
                    <h4 class="card-title">Categoría</h4>	
                    <select class="form-control mt-2" name="categoria">
                        <option value="">Todas</option>';
        foreach ($categorias as $categoria) {
            $html .= '<option value="' . $categoria . '">' . $categoria . '</option>';
        }
        $html .= '</select>
                </div>';
        return $html;
    }
    protected function generarSelectorDisponibilidad() {
        $disponible = ['Disponible', 'Cerrado'];
        $html = ' <div class="col-11 categoria-selector">
                    <h4 class="card-title">Estado</h4>	
                    <select class="form-control mt-2" name="estado">
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
        $buscar = $_SESSION['filtro_buscar_ev'] ?? '';
        $buscaPrecioDesde = $_SESSION['filtro_precio_desde_ev'] ?? '';
        $buscaPrecioHasta = $_SESSION['filtro_precio_hasta_ev'] ?? '';
        $orden = $_SESSION['filtro_orden_ev'] ?? '';
        $categoria =  $_SESSION['filtro_categoria_ev'] ?? '';
        $estado = $_SESSION['filtro_estado_ev'] ?? '';
        $fechaDesde =  $_SESSION['filtro_fecha_desde_ev']  ?? '';
        $fechaHasta = $_SESSION['filtro_fecha_hasta_ev'] ?? '';
        $this->eventos = listaeventosBusqueda($buscar, $buscaPrecioDesde, $buscaPrecioHasta, $fechaDesde, $fechaHasta, $orden, $categoria, $estado);
       
    
    // Generar el HTML del formulario
    $html = '
    <div class="container mt-5">
        <div class="col-12">
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Eventos que pueden interesarte</h4>
                            <form id="form2" name="form2" method="POST" action="<?php echo $ruta; ?>">
                                <div class="col-12 row">
                                    <div class="mb-3 col-12">
                                        <label class="form-label">Nombre evento</label>
                                        <input type="text" class="form-control" id="buscar" name="buscar" value="' .  $buscar  . '">
                                    </div>

                                    <div class="col-11">
                                        <h4 class="card-title">Tasa de inscripción</h4>
                                        <table class="table">
                                            <thead>
                                                <tr class="filters">
                                                    <th>
                                                        Tasa desde:
                                                        <input type="number" id="buscaPrecioDesde" name="buscaPrecioDesde" class="form-control mt-2" value="' . $buscaPrecioDesde . '" style="border: #bababa 1px solid; color:#000000;" step="0.01" min="0">
                                                    </th>
                                                    <th>
                                                        Tasa hasta:
                                                        <input type="number" id="buscaPrecioHasta" name="buscaPrecioHasta" class="form-control mt-2" value="' . $buscaPrecioHasta . '" style="border: #bababa 1px solid; color:#000000;" step="0.01" min="0">
                                                    </th>
                                                </tr>                                     
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="col-11">
                                    <h4 class="card-title">Fechas de inicio y fin</h4>
                                    <table class="table">
                                        <thead>
                                            <tr class="filters">
                                                <th>
                                                    Fecha:
                                                    <input type="date" id="fechaDesde" name="fechaDesde" class="form-control mt-2" value="' . $fechaDesde . '" style="border: #bababa 1px solid; color:#000000;">
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
                                                            <option value="1"></option>
                                                            <option value="1">Ordenar por nombre</option>
                                                            <option value="2">Ordenar por inscripción</option>
                                                            <option value="3">Ordenar por fecha</option>
                                                        </select>
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>';	
                                    
                                    
                                    $html .= $this->generarSelectorCategorias();
                                    $html .= $this->generarSelectorDisponibilidad();
                                    $html .= '
                                    
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
                                ' . $this->eventos . '
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
            // Limpiar los campos del formulario incluyendo los de fecha
            document.getElementById("buscar").value = "";
            document.getElementById("buscaPrecioDesde").value = "";
            document.getElementById("buscaPrecioHasta").value = "";
            document.getElementById("orden").value = "";
            
        });
    </script>
    ';



    return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        // Asignar los valores de los filtros a $_SESSION antes de procesar los datos
        $_SESSION['filtro_buscar_ev'] = $datos['buscar'] ?? '';
        $_SESSION['filtro_precio_desde_ev'] = $datos['buscaPrecioDesde'] ?? '';
        $_SESSION['filtro_precio_hasta_ev'] = $datos['buscaPrecioHasta'] ?? '';
        $_SESSION['filtro_orden_ev'] = $datos['orden'] ?? '';
        $_SESSION['filtro_categoria_ev'] = $datos['categoria'] ?? ''; // Nueva línea
        $_SESSION['filtro_estado_ev'] = $datos['estado'] ?? ''; // Nueva línea
        $_SESSION['filtro_fecha_desde_ev'] = $datos['fechaDesde'] ?? '';
        $_SESSION['filtro_fecha_hasta_ev'] = $datos['fechaHasta'] ?? '';


        // Procesar los datos
        $this->errores = [];
        $buscar = trim($datos['buscar'] ?? '');
        $buscar = filter_var($buscar, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $buscaPrecioDesde = trim($datos['buscaPrecioDesde'] ?? '');
        $buscaPrecioDesde = filter_var($buscaPrecioDesde, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $buscaPrecioHasta = trim($datos['buscaPrecioHasta'] ?? '');
        $buscaPrecioHasta = filter_var($buscaPrecioHasta, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $orden = isset($datos['limpiar-filtros-btn']) ? '' : trim($datos['orden'] ?? '');
        $orden = filter_var($orden, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $categoria = trim($datos['categoria'] ?? ''); // Nueva línea
        $categoria = filter_var($categoria, FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Nueva línea

        $estado = trim($datos['estado'] ?? ''); // Nueva línea
        $estado = filter_var($estado, FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Nueva línea

        $fechaDesde = trim($datos['fechaDesde'] ?? ''); // Nueva línea
        $fechaHasta = trim($datos['fechaHasta'] ?? ''); // Nueva línea

        // Validación de los datos recibidos
        if (empty($buscar) && empty($buscaPrecioDesde) && empty($buscaPrecioHasta) && empty($orden) && empty($categoria) && empty($estado) && empty($fechaDesde) && empty($fechaHasta)) {
            $this->errores['general'] = 'Debes proporcionar al menos un filtro para realizar la búsqueda.';
        }

        // Si no hay errores, se procesan los datos
        if (count($this->errores) === 0) {
            $this->eventos = listaEventosBusqueda($buscar, $buscaPrecioDesde, $buscaPrecioHasta, $fechaDesde, $fechaHasta, $orden, $categoria, $estado);
        }
    }

    

}
?>
