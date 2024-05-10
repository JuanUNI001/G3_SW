<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Términos y Condiciones';

$contenidoPrincipal = <<<HTML
<div class="contenido">
    <section class="politica-privacidad">
        <article>
            <h2>Política de Privacidad</h2>
            <p>En nuestra plataforma de juegos de mesa en línea, nos tomamos muy en serio la privacidad de nuestros usuarios. Esta Política de Privacidad describe cómo recopilamos, utilizamos y protegemos la información que nos proporcionas cuando utilizas nuestros servicios.</p>
        </article>

        <article>
            <h3>1. Información que Recopilamos</h3>
            <p>Recopilamos información personal cuando te registras en nuestra plataforma, participas en actividades en línea o interactúas con otros usuarios. Esta información puede incluir tu nombre, dirección de correo electrónico, información de pago y otra información relevante para brindarte nuestros servicios.</p>
        </article>

        <article>
            <h3>2. Uso de la Información</h3>
            <p>Utilizamos la información que recopilamos para proporcionar, mantener y mejorar nuestros servicios, así como para personalizar tu experiencia y comunicarnos contigo. También podemos utilizar tu información para fines de marketing y publicidad, siempre y cuando hayas dado tu consentimiento para ello.</p>
        </article>

        <article>
            <h3>3. Compartir Información</h3>
            <p>No compartimos tu información personal con terceros, excepto en los casos en que sea necesario para brindar nuestros servicios o cuando estemos legalmente obligados a hacerlo. En tales casos, nos aseguramos de proteger tu privacidad y seguridad.</p>
        </article>

        <article>
            <h3>4. Seguridad de la Información</h3>
            <p>Implementamos medidas de seguridad para proteger tu información contra accesos no autorizados, pérdidas o alteraciones. Sin embargo, debes tener en cuenta que ninguna medida de seguridad en Internet es completamente infalible.</p>
        </article>

        <article>
            <h3>5. Menores de Edad</h3>
            <p>Nuestros servicios están dirigidos a personas mayores de 18 años. No recopilamos intencionalmente información de menores de edad sin el consentimiento verificable de sus padres o tutores legales.</p>
        </article>

        <article>
            <h3>6. Cambios en la Política de Privacidad</h3>
            <p>Nos reservamos el derecho de modificar esta Política de Privacidad en cualquier momento. Te recomendamos que revises periódicamente esta página para estar al tanto de cualquier cambio. Al continuar utilizando nuestros servicios después de cualquier modificación, aceptas los términos actualizados.</p>
        </article>

        <article>
            <p>Si tienes alguna pregunta o inquietud sobre nuestra Política de Privacidad, no dudes en contactarnos.</p>
            <p>Fecha de entrada en vigencia: [6/5/2024]</p>
            <p>Última actualización: [8/5/2024]</p>
        </article>
    </section>
</div>
HTML;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
