<?php

function buildFormularioEditorProducto($nombre='',$id='', $precioNuevo='', $descripcionNueva='', $eliminar='')
{
    return <<<EOS
    <form id="formLogin" action="procesarEdicion.php" method="POST">
        <fieldset>

            <div><label>Nombre producto:</label> <input type="text" name="nombre" value="$nombre" /></div>
            <div><label>Id producto:</label> <input type="text" name="id" value="$id" /></div>
            <div><label>Precio nuevo:</label> <input type="text" name="nombreNuevo" password="$precioNuevo" /></div>
            <div><label>Descripcion nueva:</label> <input type="text" name="descripcionNueva" password="$descripcionNueva" /></div>
            <div>
                <input type="checkbox" id="eliminar" name="eliminar" value="1" $eliminar>
                <label for="eliminar">Eliminar</label>
            </div>
            <div><button type="submit">Entrar</button></div>
        </fieldset>
    </form>
    EOS;
}