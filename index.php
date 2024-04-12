<?php

//Inicio del procesamiento

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'MesaMaestra';
$login = resuelve('/login.php');

$contenidoPrincipal=<<<EOS
  <h1>Página principal</h1>
<<<<<<< HEAD
 <p>orem ipsum es el texto que se usa habitualmente en diseño gráfico en demostraciones de tipografías o de borradores de diseño para probar el diseño visual antes de insertar el texto final.

 Aunque no posee actualmente fuentes para justificar sus hipótesis, el profesor de filología clásica Richard McClintock asegura que su uso se remonta a los impresores de comienzos del siglo xvi.1​ Su uso en algunos editores de texto muy conocidos en la actualidad ha dado al texto lorem ipsum nueva popularidad.
 
 El texto en sí no tiene sentido aparente, aunque no es aleatorio, sino que deriva de un texto de Cicerón en lengua latina, a cuyas palabras se les han eliminado sílabas o letras. El significado del mismo no tiene importancia, ya que solo es una demostración o prueba. El texto procede de la obra De finibus bonorum et malorum (Sobre los límites del bien y del mal) que comienza con:</p>
=======
  <p> Bienvenidos a Mesamaestra, tu punto de encuentro para tus juegos de mesa favoritos. </p>
>>>>>>> main
EOS;


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
