document.getElementById("registroForm").addEventListener("submit", function(event) {
    event.preventDefault();
    
    let nombre = document.getElementById("nombre").value.trim();
    let email = document.getElementById("email").value.trim();
    let edad = document.getElementById("edad").value.trim();
    let password = document.getElementById("password").value.trim();
    
    let valid = true;
    
    // Validar Nombre
    if (nombre === "") {
        document.getElementById("errorNombre").textContent = "El nombre no puede estar vacío.";
        valid = false;
    } else {
        document.getElementById("errorNombre").textContent = "";
    }
    
    // Validar Email
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        document.getElementById("errorEmail").textContent = "Ingrese un correo electrónico válido.";
        valid = false;
    } else {
        document.getElementById("errorEmail").textContent = "";
    }
    
    // Validar Edad
    if (isNaN(edad) || edad < 18) {
        document.getElementById("errorEdad").textContent = "Debe ser mayor de 18 años.";
        valid = false;
    } else {
        document.getElementById("errorEdad").textContent = "";
    }
    
    // Validar Contraseña
    if (password.length < 8) {
        document.getElementById("errorPassword").textContent = "La contraseña debe tener al menos 8 caracteres.";
        valid = false;
    } else {
        document.getElementById("errorPassword").textContent = "";
    }
    
    if (valid) {
        alert("Formulario enviado correctamente.");
        document.getElementById("registroForm").reset();
    }
});
