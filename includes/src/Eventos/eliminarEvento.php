<?php
require_once __DIR__.'/../../config.php';
use es\ucm\fdi\aw\src\Eventos\Evento;
use es\ucm\fdi\aw\src\BD;


$app = BD::getInstance();


// Verificar si se recibieron los datos esperados por GET
if (isset($_POST['idEvento'])) {
    $idEven = $_POST['idEvento'];
   
    // Verificar si se proporcionaron ambos IDs
    if (!empty($idEven)) {
        // Intentar eliminar el producto del pedido
        $seHaEliminado = Evento ::borraPorId($idEven);

        if(  $seHaEliminado ){
            $mensajes = ['El evento se ha eliminado correctamente'];
        }
    }
} else {
    // Si no se recibieron los datos esperados por GET
    $mensajes = ['Parece que algo ha ido mal :('];
}

$app->putAtributoPeticion('mensajes', $mensajes);
exit();
?>
