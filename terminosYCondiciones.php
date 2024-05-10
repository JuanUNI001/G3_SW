<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/src/Usuarios/ListaUsuarios.php';

$tituloPagina = 'Términos y Condiciones';

$contenidoPrincipal = <<<HTML
<div class="contenido">
    <section class="terminos-y-condiciones">
        <article>
        <h2>Términos y Condiciones de Uso</h2>
        <p>¡Bienvenido a nuestra plataforma de juegos de mesa en línea! Antes de comenzar a disfrutar de todos los servicios que ofrecemos, te pedimos que leas detenidamente estos Términos y Condiciones de Uso. Al acceder y utilizar nuestros servicios, aceptas cumplir con estos términos y cualquier otra política que podamos publicar en el sitio.</p>
        </article>

        <article>
        <h3>Servicios Ofrecidos</h3>
        <p>Ofrecemos una plataforma en línea para la venta de juegos de mesa, así como foros y chat privados para la comunidad.
        También proporcionamos la posibilidad de contratar a profesores para mejorar tus habilidades en juegos específicos.</p>
        </article>

        <article>
        <h3>Registro y Cuentas de Usuario</h3>
        <p>Para acceder a ciertos servicios, es posible que necesites registrarte y crear una cuenta de usuario.
        La información proporcionada durante el registro debe ser precisa y actualizada. Eres responsable de mantener la confidencialidad de tu cuenta y contraseña.</p>
        </article>

        <article>
        <h3>Uso Adecuado de la Plataforma</h3>
        <p>Te comprometes a utilizar nuestros servicios de manera adecuada y legal.
        No puedes utilizar nuestros servicios para actividades ilegales, fraudulentas o inapropiadas.</p>
        </article>

        <article>
        <h3>Foros y Chat Privados</h3>
        <p>Los foros y el chat privado son lugares para interactuar con otros usuarios de manera respetuosa.
        No se tolerarán comportamientos ofensivos, difamatorios, discriminatorios o cualquier otro tipo de conducta inapropiada.</p>
        </article>

        <article>
        <h3>Contratación de Profesores</h3>
        <p>La contratación de profesores está sujeta a disponibilidad y a los términos específicos de cada instructor.
        Nos esforzamos por proporcionar profesores calificados, pero no podemos garantizar los resultados de las lecciones.</p>
        </article>

        <article>
        <h3>Propiedad Intelectual</h3>
        <p>Todo el contenido proporcionado en nuestra plataforma, incluidos textos, imágenes y juegos, está protegido por derechos de autor y otros derechos de propiedad intelectual.
        No puedes utilizar nuestro contenido de manera no autorizada sin nuestro consentimiento.</p>
        </article>

        <article>
        <h3>Limitación de Responsabilidad</h3>
        <p>No somos responsables de cualquier daño directo, indirecto, incidental, especial, consecuente u otros daños resultantes de tu uso de nuestros servicios.
        No garantizamos que nuestro sitio esté libre de errores o que funcione sin interrupciones.</p>
        </article>

        <article>
        <h3>Modificaciones de los Términos y Condiciones</h3>
        <p>Nos reservamos el derecho de modificar estos Términos y Condiciones en cualquier momento. Te recomendamos que revises periódicamente esta página para estar al tanto de cualquier cambio.</p>
        </article>

        <article>
        <p>Al utilizar nuestros servicios, aceptas estos Términos y Condiciones en su totalidad. Si tienes alguna pregunta o inquietud, no dudes en contactarnos.</p>
       
        <p>Fecha de entrada en vigencia: [6/5/2024]</p>
        <p>Última actualización: [8/5/2024]</p>
        </article>
    </section>
</div>
HTML;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
