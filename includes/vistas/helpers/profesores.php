<?php

function mostrarProfesores(){
   
    $contenidoProfesores = <<<EOS
        <h1>Diviértete y aprende con un Tutor</h1>
        <div>
            <fieldset>
                <legend>Ignacio Wardaugh</legend>
                <p>¡Aprende ajedrez de forma divertida!</p>
                <p>Conocimientos:</p>
                <lu>
                    <li>Maestro de Ajedrez</li>       
                </lu>
                <div><button type="button">Contactar</button></div>
            </fieldset>

            <fieldset>
                <legend>Pablo Rabanal</legend>
                <p>Te enseñaré a ser un profesional en el Póker</p>
                <p>Conocimientos:</p>
                <lu>
                    <li>Jugador de Póker competitivo</li>
                    <li>Campeón de Póker Nacional</li>
                </lu>
                <div><button type="button">Contactar</button></div>
            </fieldset>

            <fieldset>
                <legend>Ramon Salva</legend>
                <p>Curso intensivo de Go en 3 meses</p>
                <p>Conocimientos:</p>
                <lu>
                    <li>15 años de juego competitivo de Go</li>
                    <li>Título de campeón de Go 2015</li>   
                </lu>
                <div><button type="button">Contactar</button></div>
            </fieldset>
            <p>...</p>
        </div>    
    EOS;
    return  $contenidoProfesores;

}