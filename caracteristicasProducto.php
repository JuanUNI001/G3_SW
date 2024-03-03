<?php
// Conexión a la base de datos (si es necesario)

    if (isset($_GET['id_producto'])) {
        $id_producto = $_GET['id_producto'];

        // Aquí realizar consultas a la base de datos para obtener información detallada del producto, reseñas, comentarios, etc

        // Ejemplo de salida de las características del producto
        $producto = array(
            "nombre" => "Preguntados",
            "imagen" => "images/preguntados.jpg",
            "descripcion" => "Este es un juego de preguntas y respuestas muy divertido.",
            "precio" => "$19.99"
        );
        $reseñas = array(
            array("usuario" => "Usuario1", "comentario" => "¡Me encanta este juego!"),
            array("usuario" => "Usuario2", "comentario" => "Es muy entretenido."),
            
        );

        echo "<h2>" . $producto['nombre'] . "</h2>";
        echo "<img src='" . $producto['imagen'] . "' alt='" . $producto['nombre'] . "'>";
        echo "<p><strong>Precio:</strong> " . $producto['precio'] . "</p>";
        echo "<p><strong>Descripción:</strong> " . $producto['descripcion'] . "</p>";

        echo "<h3>Reseñas y Comentarios</h3>";
        foreach ($reseñas as $resena) {
            echo "<p>" . $resena['usuario'] . ": " . $resena['comentario'] . "</p>";
        }
    }
?>
