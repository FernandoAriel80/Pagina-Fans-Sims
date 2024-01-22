

function validarFormularioLogin(){

    let nombre = document.getElementById('nombre').value;
    let clave = document.getElementById('clave').value;
    let ventanaError = document.getElementById('mensajeError');
    // Validar nombre (por ejemplo, no debe estar vacío)
    if (nombre.trim() === '') {
        alertaMensaje(ventanaError,"red","ingrese algun nombre");
        return false; // Detiene el envío del formulario
    }
    
    let hasUpperCase = /[A-Z]/.test(clave);
    let hasLowerCase = /[a-z]/.test(clave);
    let hasNumbers = /\d/.test(clave);
    let hasSpecialChars = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/.test(clave);

    if (clave.length < 8) {
        alertaMensaje(ventanaError,"red","La contraseña debe tener al menos 8 caracteres.");
        return false;
    }else if(!hasUpperCase){
        alertaMensaje(ventanaError,"red","La contraseña debe incluir mayúsculas.");
        return false;
    }else if(!hasLowerCase){
        alertaMensaje(ventanaError,"red","La contraseña debe incluir minúsculas.");
        return false;
    }else if(!hasNumbers){
        alertaMensaje(ventanaError,"red","La contraseña debe incluir números.");
        return false;
    }else if(!hasSpecialChars){
        alertaMensaje(ventanaError,"red","La contraseña debe incluir caracteres especiales.");
        return false;
    }
    ventanaError.style.display = 'none';
    return true; // Permite el envío del formulario
};

function alertaMensaje(ventana,color,mensaje) {
    if (ventana.style.display=="none") {
        ventana.style.display = 'flex';
        ventana.style.backgroundColor = color;
        ventana.textContent= mensaje;
    }else if (ventana.style.display=="flex") {
        ventana.style.display = 'flex';
        ventana.style.backgroundColor = color;
        ventana.textContent= mensaje;
    }       
}

// usar en register
// let hasUpperCase = /[A-Z]/.test(clave);
// let hasLowerCase = /[a-z]/.test(clave);
// let hasNumbers = /\d/.test(clave);
// let hasSpecialChars = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/.test(clave);

// if (clave.length < 8) {
//     alertaMensaje(ventanaError,"red","La contraseña debe tener al menos 8 caracteres.");
//     return false;
// }else if(!hasUpperCase){
//     alertaMensaje(ventanaError,"red","La contraseña debe incluir mayúsculas.");
//     return false;
// }else if(!hasLowerCase){
//     alertaMensaje(ventanaError,"red","La contraseña debe incluir minúsculas.");
//     return false;
// }else if(!hasNumbers){
//     alertaMensaje(ventanaError,"red","La contraseña debe incluir números.");
//     return false;
// }else if(!hasSpecialChars){
//     alertaMensaje(ventanaError,"red","La contraseña debe incluir caracteres especiales.");
//     return false;
// }