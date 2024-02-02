
document.addEventListener("DOMContentLoaded",function(){
  let formularioLogin = document.querySelector(".formulario-login");
  formularioLogin.addEventListener("submit", function (event) {
      // Realizar validaciones aquí
      if (!validarFormularioLogin()) {
          event.preventDefault(); // Detener el envío del formulario si no es válido
      }
  });
});


document.addEventListener("DOMContentLoaded",function(){
  let formularioLogin = document.querySelector(".formulario-registro");
  formularioLogin.addEventListener("submit", function (event) {
      // Realizar validaciones aquí
      if (!validarFormularioRegistro()) {
          event.preventDefault(); // Detener el envío del formulario si no es válido
      }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  var miBoton = document.getElementById("miniCirculo");

  miBoton.addEventListener("click", function () {
    mostrarFormulario();
  });
});

function mostrarFormulario() { 
    let contenedorFormulario = document.getElementById('contenedor-formulario');
    if (contenedorFormulario.style.display=="flex") {
      contenedorFormulario.style.display = 'none';
    }else{
      contenedorFormulario.style.display = 'flex';
    } 
};







