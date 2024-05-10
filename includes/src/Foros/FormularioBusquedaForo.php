<?php
namespace es\ucm\fdi\aw\src\Foros;


echo '<link rel="stylesheet" type="text/css" href="' . RUTA_CSS . '/busqueda.css">';

use es\ucm\fdi\aw\src\Formulario;

class FormularioBusquedaForo extends Formulario
{
    
    private $foros;

    public function __construct() {
        parent::__construct('FormularioBusquedaForo', ['urlRedireccion' => 'foros.php']);
    }
   
    protected function generaCamposFormulario(&$datos)
    {
    // Verificar si se ha enviado el formulario por POST
        
        // Capturar valores de los filtros
        $autor = $_SESSION['filtro_autor'] ?? '';
        $tema = $_SESSION['filtro_tema'] ?? '';       
        $orden = $_SESSION['filtro_orden_foro'] ?? '';
        $this->foros = listarForosBusqueda($autor, $tema,$orden);
       
    
    
    // Generar el HTML del formulario
    $html = '
    <div class="container mt-5">
        <div class="col-12">
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Chatea aprende y diviertete en los foros</h4>
                            <form id="form2" name="form2" method="POST" action="<?php echo $ruta; ?>">
                                <div class="col-12 row">
                                    <div class="mb-3 textomitad">
                                        <label class="form-label">Autor a buscar</label>
                                        <input type="text" class="form-control" id="autor" name="autor" value="' .  $autor  . '">
                                    </div>
                                    <div class="mb-3 textomitad">
                                        <label class="form-label">Tema a buscar</label>
                                        <input type="text" class="form-control" id="tema" name="tema" value="' .  $tema  . '">
                                    </div>
                                  
                                    <div class="col-11 ">
                                        <h4 class="card-title">Filtro para ordenar</h4>	
                                        <table class="table">
                                            <thead>
                                                <tr class="filters">
                                                    <th>
                                                        Ordenados por:
                                                        <select id="assigned-tutor-filter" id="orden" name="orden" class="form-control mt-2" style="border: #bababa 1px solid; color:#000000;">
                                                                                                                   
                                                            <option value=""></option>
                                                            <option value="1">Ordenar por autor</option>
                                                            <option value="2">Ordenar por tema</option>
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
                                ' . $this->foros . '
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
            document.getElementById("autor").value = "";
            document.getElementById("tema").value = "";
            document.getElementById("orden").value = "";
           
        });
    </script>';



    return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        // Asignar los valores de los filtros a $_SESSION antes de procesar los datos
        $_SESSION['filtro_autor'] = $datos['autor'] ?? '';
        $_SESSION['filtro_tema'] = $datos['tema'] ?? '';
        $_SESSION['filtro_orden_foro'] = $datos['orden'] ?? '';
       
        
        // Procesar los datos
        $this->errores = [];
        $autor = trim($datos['autor'] ?? '');
        $autor = filter_var($autor, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $tema = trim($datos['tema'] ?? '');
        $tema = filter_var($tema, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

       
        $orden = isset($datos['limpiar-filtros-btn']) ? '' : trim($datos['orden'] ?? '');
        $orden = filter_var($orden, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        // Validación de los datos recibidos
        if (empty($autor) && empty($tema) && empty($orden)) {
            $this->errores['general'] = 'Debes proporcionar al menos un filtro para realizar la búsqueda.';
        }
    
        // Si no hay errores, se procesan los datos
        if (count($this->errores) === 0) {
            $this->foros = listarForosBusqueda($autor, $tema, $orden);
        }
    }
    

}
?>
