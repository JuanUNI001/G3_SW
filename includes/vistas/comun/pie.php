
<?php
use es\ucm\fdi\aw\src\BD;
?>

<footer>
    <div class="footer-content">
        <div>
        <a href="https://www.op.gg">Puede contactarnos a través del siguiente enlace</a>
            <ul>
                <li><a href="/index.php">Inicio</a></li>
                <li><a href="<?php echo resuelve('/terminosYCondiciones.php'); ?>">Términos y condiciones</a></li>
                <li><a href="/politica-de-privacidad">Política de privacidad</a></li>
            </ul>      
        </div>

        <div class="contactos">
            <p>Teléfono: 555-555-789</p>
            <a href="mailto:mesamaestra@gmail.com">Correo electrónico: mesamaestra@gmail.com</a></li>
        </div>

        <div class="redes-sociales">
            <p>Síguenos en:</p>
                <a href="https://www.facebook.com"><i class="fab fa-facebook"></i></a>
                <a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
                <a href="https://www.linkedin.com"><i class="fab fa-linkedin"></i></a>
                <a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a>
        </div>
    </div>
    <p class="copyright">&copy; <?php echo date("Y"); ?> Mesa Mestra</p>
</footer>
