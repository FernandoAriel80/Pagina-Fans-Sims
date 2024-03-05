

function validarFormularioLogin(){
    let usuario = document.getElementById('usuarioL').value;
    let clave = document.getElementById('contraseñaL').value;
    let ventanaError = document.getElementById('mensajeErrorLogin');  
    // Validar usuario (por ejemplo, no debe estar vacío)
    if (usuario.trim() === '') {
        alertaMensaje(ventanaError,"red","ingrese algun usuario");
        return false;// Detiene el envío del formulario
    }else if(usuario.length < 3 || usuario.length > 50){
        alertaMensaje(ventanaError,"red","El usuario debe tener entre 3 y 50 caracteres.");
        return false;
    }
    let tieneMayus = /[A-Z]/.test(clave);
    let tieneMinus = /[a-z]/.test(clave);
    let tieneNum = /\d/.test(clave);
    let tieneCaracEspecial = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/.test(clave);
    if (clave.length < 8 || clave.length > 20) {
        alertaMensaje(ventanaError,"red","La contraseña debe tener al menos  entre 8  y 20 caracteres.");
        return false;
    }else if(!tieneMayus){
        alertaMensaje(ventanaError,"red","La contraseña debe incluir mayúsculas.");
        return false;
    }else if(!tieneMinus){
        alertaMensaje(ventanaError,"red","La contraseña debe incluir minúsculas.");
        return false;
    }else if(!tieneNum){
        alertaMensaje(ventanaError,"red","La contraseña debe incluir números.");
        return false;
    }else if(!tieneCaracEspecial){
        alertaMensaje(ventanaError,"red","La contraseña debe incluir caracteres especiales.");
        return false;
    }else{
        ventanaError.style.display = 'none';
        return true; // Permite el envío del formulario
    };
};
   
function validarFormularioRegistro(){
    let nombre = document.getElementById('nombreR').value;
    let email = document.getElementById('emailR').value;
    let usuario = document.getElementById('usuarioR').value;
    let clave = document.getElementById('contraseñaR').value;
    let confirmacionClave = document.getElementById('confirmarContraseñaR').value;
    let ventanaError = document.getElementById('mensajeErrorRegistro');  
    // Validar nombre (por ejemplo, no debe estar vacío)
    if (nombre.trim() === '') {
        alertaMensaje(ventanaError,"red","ingrese algun nombre");
        return false;// Detiene el envío del formulario
    }else if(nombre.length < 3 || nombre.length > 50){
        alertaMensaje(ventanaError,"red","El nombre debe tener entre 3 y 50 caracteres.");
        return false;
    }
    // Validar email (por ejemplo, no debe estar vacío)
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email.trim() === '') {
        alertaMensaje(ventanaError,"red","Por favor, ingresa un correo electrónico.");
        return false;
    }else if (!emailRegex.test(email)) {
       alertaMensaje(ventanaError,"red","El formato del email no es válido.");
       return false;
     }
    // Validar usuario (por ejemplo, no debe estar vacío)
    if (usuario.trim() === '') {
        alertaMensaje(ventanaError,"red","ingrese algun usuario");
        return false;// Detiene el envío del formulario
    }else if(usuario.length < 3 || usuario.length > 50){
        alertaMensaje(ventanaError,"red","El usuario debe tener entre 3 y 50 caracteres.");
        return false;
    }
    // Validar clave (por ejemplo, no debe estar vacío)
    let tieneMayus = /[A-Z]/.test(clave);
    let tieneMinus = /[a-z]/.test(clave);
    let tieneNum = /\d/.test(clave);
    let tieneCaracEspecial = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/.test(clave);
    if (clave.length < 8 || clave.length > 20) {
        alertaMensaje(ventanaError,"red","La contraseña debe tener al menos  entre 8  y 20 caracteres.");
        return false;
    }else if(!tieneMayus){
        alertaMensaje(ventanaError,"red","La contraseña debe incluir mayúsculas.");
        return false;
    }else if(!tieneMinus){
        alertaMensaje(ventanaError,"red","La contraseña debe incluir minúsculas.");
        return false;
    }else if(!tieneNum){
        alertaMensaje(ventanaError,"red","La contraseña debe incluir números.");
        return false;
    }else if(!tieneCaracEspecial){
        alertaMensaje(ventanaError,"red","La contraseña debe incluir caracteres especiales.");
        return false;
    }
    if (clave.length < 8 || clave.length > 20) {
        alertaMensaje(ventanaError,"red","La confirmacion de clave debe tener al menos  entre 8  y 20 caracteres.");
        return false;
    }else if (clave !== confirmacionClave) {
        alertaMensaje(ventanaError,"red","Las contraseñas no coinciden.");
        return false;
    }else{
        ventanaError.style.display = 'none';
        return true; // Permite el envío del formulario
    }
};



function validarFormularioCreaDiario(){
    let tituloDiario = document.getElementById('tituloD').value;
    let descripcionDiario = document.getElementById('descripcionD').value;
    let tituloCapitulo = document.getElementById('tituloE').value;
    let contenidoCapitulo = document.getElementById('contenidoE').value;
    let ventanaError = document.getElementById('mensajeErrorCreaDiario'); 
    
    if (tituloDiario.trim() === '') {
        alertaMensaje(ventanaError,"red","ingrese algun titulo para el diario");
        return false;
    } else if (!tituloValido(tituloDiario)) {
        alertaMensaje(ventanaError,"red","El titulo para el diario solo permite los siguientes caracteres: letras, números, espacios y los siguientes caracteres especiales: @, #, $, %, ^, &, *, <, >");
        return false;
    }
    
    if (tituloCapitulo.trim() === '') {
        alertaMensaje(ventanaError,"red","ingrese algun titulo para la entrada");
        return false;
    } else if (!tituloValido(tituloCapitulo)) {
        alertaMensaje(ventanaError,"red","El titulo para la entrada solo permite los siguientes caracteres: letras, números, espacios y los siguientes caracteres especiales: @, #, $, %, ^, &, *, <, >");
        return false;
    }

    if (descripcionDiario.trim() === '') {
        return true;
    } else if (!tituloValido(descripcionDiario)) {
        alertaMensaje(ventanaError,"red","La descripcion del diario solo permite los siguientes caracteres: letras, números, espacios y los siguientes caracteres especiales: @, #, $, %, ^, &, *, <, >");
        return false;
    }

    if (contenidoCapitulo.trim() === '') {
        return true;
    } else if (!tituloValido(contenidoCapitulo)) {
        alertaMensaje(ventanaError,"red","La entrada solo permite los siguientes caracteres: letras, números, espacios y los siguientes caracteres especiales: @, #, $, %, ^, &, *, <, >");
        return false;
    }else{
        ventanaError.style.display = 'none';
        return true; 
    }

}

function validarFormularioCreaCapitulo(){
    let tituloCapitulo = document.getElementById('tituloE').value;
    let contenidoCapitulo = document.getElementById('contenidoE').value;
    let ventanaError = document.getElementById('mensajeErrorCreaDiario'); 
    
    if (tituloCapitulo.trim() === '') {
        alertaMensaje(ventanaError,"red","ingrese algun titulo para la entrada");
        return false;
    } else if (!tituloValido(tituloCapitulo)) {
        alertaMensaje(ventanaError,"red","El titulo para la entrada solo permite los siguientes caracteres: letras, números, espacios y los siguientes caracteres especiales: @, #, $, %, ^, &, *, <, >");
        return false;
    }

    if (contenidoCapitulo.trim() === '') {
        return true;
    } else if (!tituloValido(contenidoCapitulo)) {
        alertaMensaje(ventanaError,"red","La entrada solo permite los siguientes caracteres: letras, números, espacios y los siguientes caracteres especiales: @, #, $, %, ^, &, *, <, >");
        return false;
    }else{
        ventanaError.style.display = 'none';
        return true; 
    }

}

function tituloValido(titulo) {
    // Verifica si el título contiene el signo "="
    if (titulo.includes('=')) {
        return false;
    }
    // Expresión regular para verificar si el título contiene solo caracteres alfanuméricos y especiales permitidos
    let regex = /^[a-zA-ZÀ-ÿ0-9_!@#$%^&*()<>\s¿?"¡,.:]+$/;
    if (!regex.test(titulo)) {
        return false;
    }
    return true;
}

//////////////////////////////////
function alertaMensaje(ventana,color,mensaje) {
    if (ventana.style.display=="none") {
        ventana.style.display = 'flex';
        ventana.style.backgroundColor = color;
        ventana.textContent= mensaje;
    }else if (ventana.style.display=="flex") {
        ventana.style.display = 'flex';
        ventana.style.backgroundColor = color;
        ventana.textContent= mensaje;
    };
};

