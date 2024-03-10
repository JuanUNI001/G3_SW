<?php

function buildFormularioEditorProducto($nombreActual='', $nombreNuevo='', $precioNuevo='', $eliminar='')
{
    return <<<EOS
    <form id="formLogin" action="procesarEdicion.php" method="POST">
        <fieldset>

            <div><label>Nombre producto:</label> <input type="text" name="username" value="$nombreActual" /></div>
            <div><label>Nuevo nombre:</label> <input type="text" name="password" password="$nombreNuevo" /></div>
            <div><label>precio:</label> <input type="text" name="password" password="$precioNuevo" /></div>
            <div>
                <input type="checkbox" id="eliminar" name="eliminar" value="1" $eliminar>
                <label for="eliminar">Eliminar</label>
            </div>
            <div><button type="submit">Entrar</button></div>
        </fieldset>
    </form>
    EOS;
}