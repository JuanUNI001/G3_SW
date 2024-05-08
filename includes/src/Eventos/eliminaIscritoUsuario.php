<?php
use \es\ucm\fdi\aw\src\Eventos\Evento;
use \es\ucm\fdi\aw\src\Inscritos\Inscrito;
function eliminaIscritoUsuario($idUsuario){
    $eventosInscritos = Inscrito::buscaPorIdUsuario($idUsuario);
    if ($eventosInscritos !== null) {
        foreach ($eventosInscritos as $evento) {          
            if ($evento->getEstado() != 'Terminado') {
                
                Inscrito::borraPorId($evento->getId(), $idUsuario);
            }
        
           
        }
    }


}

?>