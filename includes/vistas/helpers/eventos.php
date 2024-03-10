<?php


function mostrarEventos(){

    $listaEventos = <<<EOS
        <h1>Listado de los Eventos mas actuales</h1>
        <div>
            <fieldset>
                <legend>Torneo de Póker</legend>
                <p>Ubicacion: Casio Gran Casino, Madrid </p>
                <p>Plazas restantes: 31</p>
            </fieldset>

            <fieldset>
                <legend>Amistoso de Yu-Gi-Oh</legend>
                <p>Ubicacion: Palacio de Cristal, Madrid</p>
                <p>Plazas restantes: 4</p>
            </fieldset>

            <fieldset>
            <legend>Torneo de Pokemon Perla</legend>
            <p>Ubicacion: Reccindo de Ifema, Madrid</p>
            <p>Plazas restantes: 31</p>
            </fieldset>
            <p>...</p>
        </div>    
    EOS;
    return  $listaEventos;

}