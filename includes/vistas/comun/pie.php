
<?php
use es\ucm\fdi\aw\src\BD;
?>

<footer>
    <div class="footer-content">
        <div id="contenido-legal">
            <p>Condiciones de Uso y Privacidad</p>
            <a href="<?php echo resuelve('/terminosYCondiciones.php'); ?>">Términos y condiciones</a>
            <a href="<?php echo resuelve('/politicaDePrivacidad.php'); ?>">Política de privacidad</a>  
        </div>

        <div id="vistas">
            <p>¡Bienvenido! Explora nuestra página web:</p>
            <a href="<?php echo resuelve('/index.php'); ?>">Inicio</a>
            <a href="<?php echo resuelve('/tienda.php'); ?>">Tienda</a>
            <a href="<?php echo resuelve('/foros.php'); ?>">Foros</a>
            <a href="<?php echo resuelve('/eventos.php'); ?>">Eventos</a>
            <a href="<?php echo resuelve('/profesores.php'); ?>">Profesores</a>  
        </div>

        <div id="contactos">
            <p>Contacta con nosotros</p>
            <p>Teléfono atencion al cliente: 555-555-789</p>
            <p>Teléfono RRHH: 555-555-420</p>
            <a href="mailto:mesamaestra@gmail.com">Email: mesamaestra@gmail.com</a></li>
        </div>

        <div id="redes-sociales">
            <p>Síguenos en:</p>
            <div class="iconos-redes-sociales">
                <a href="https://www.facebook.com"><i class="fab fa-facebook"></i></a>
                <a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
                <a href="https://www.linkedin.com"><i class="fab fa-linkedin"></i></a>
                <a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
    <p class="copyright">&copy; <?php echo date("Y"); ?> Mesa Mestra</p>
</footer>
