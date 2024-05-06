
$(document).ready(function() {
    // Hide validation indicators
    $("#email-valido").hide();
    $("#validUser").hide();
    $("#email-invalido").hide();
    $("#invalidUser").hide();
    $("#password-valida").hide();
    $("#password-invalida").hide();
    $("#password-match").hide();
    $("#password-nomatch").hide();
    // Email field change event

    $("#nombre").change(function(){
        const nombre = $("#nombre").val();
    
        if (nombre.length >= 3) {
            $("#validUser").show();
            $("#invalidUser").hide();
            $("#nombre-valido").val("1"); // Actualiza el campo oculto
        } else {
            $("#validUser").hide();
            $("#invalidUser").show();
            $("#nombre-valido").val("0"); // Actualiza el campo oculto
        }
    });
    
    $("#correo").change(function(){
        const campo = $("#correo");
        campo[0].setCustomValidity("");
        
        const esCorreoValido = campo[0].checkValidity();
        
        if (esCorreoValido && correoValidoFuncion(campo.val())) {
            $("#email-valido").show(); // Muestra el tick de correo válido
            $("#email-invalido").hide(); // Oculta la marca de correo inválido
            $("#correo-valido").val("1"); // Actualiza el campo oculto
            $("#correo")[0].setCustomValidity(""); // Restablece la validación personalizada
        } else {
            $("#correo-valido").val("0"); // Actualiza el campo oculto
            $("#email-valido").hide(); // Oculta el tick de correo válido
            $("#email-invalido").show(); // Muestra la marca de correo inválido
            campo[0].setCustomValidity("El correo debe ser válido");
        }
    });
    
    
    
    
    $("#password").change(function(){
        const password = $("#password").val();
        const contieneCaracterEspecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
    
        if (password.length >= 8 && contieneCaracterEspecial) {
            $("#password-valida").show();
            $("#password-invalida").hide();
            $("#password-valido").val("1"); // Actualiza el campo oculto
        } else {
            $("#password-valida").hide();
            $("#password-invalida").show();
            $("#password-valido").val("0"); // Actualiza el campo oculto
            $("#password")[0].setCustomValidity("La contraseña debe tener al menos 8 caracteres y contener al menos un carácter especial.");
        }
    });
    
    $("#password2").change(function(){
        const password = $("#password").val();
        const password2 = $("#password2").val();
    
        if (password === password2) {
            $("#password-match").show();
            $("#password-nomatch").hide();
            $("#password2-valido").val("1"); // Actualiza el campo oculto
        } else {
            $("#password-match").hide();
            $("#password-nomatch").show();
            $("#password2-valido").val("0"); // Actualiza el campo oculto
            $("#password2")[0].setCustomValidity("Las contraseñas no coinciden.");
        }
    });
    
    
    function correoValidoFuncion(correo) {
        if (correo.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            return true;
        } else {
           return false;
        }
    }
    
    
    
    
    
    
});

