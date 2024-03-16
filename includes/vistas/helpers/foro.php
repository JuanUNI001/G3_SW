<?php


function mostrarListaForos(){

    $listaforos = <<<EOS
    <fieldset>
        <legend>Curiosidades del Catán</legend>
        <p>Laura26---Hoy he ganado por primera vez :-)</p>
        <p>Daniel_01---Que guayyy </p>
        <p>...</p>
    </fieldset>

    <fieldset>
        <legend>Amantes del Ajedrez</legend>
        <p>AlvaroAjedrez--  ¿Cual es la mejor apertura?</p>
        <p>...</p>
    </fieldset>

    <fieldset>
        <legend>Locos por el Jenga</legend>
        <p>...</p>
    </fieldset>
    <p>...</p>
    EOS;
    return  $listaforos;

}