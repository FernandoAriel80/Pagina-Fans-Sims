var abierto = 1;
  function mostrarFormulario() { 
    var contenedorFormulario = document.getElementById('contenedor-formulario');
    if (abierto==1) {
      contenedorFormulario.style.display = 'flex';
       abierto = 0;
    }else{
      contenedorFormulario.style.display = 'none';
      abierto = 1;
    } 
};

// document.addEventListener("DOMContentLoaded", function () {
//   var miMiniCirculo = document.getElementById("miMiniCirculo");

//   miMiniCirculo.addEventListener("touchstart", function () {
//     console.log("Clic en miniCírculo");
//       mostrarFormulario();
//   });
// });

// var abierto = 1;

// function mostrarFormulario() {
//   var contenedorFormulario = document.getElementById('contenedor-formulario');
//   if (abierto == 1) {
//       contenedorFormulario.style.display = 'flex';
//       abierto = 0;
//   } else {
//       contenedorFormulario.style.display = 'none';
//       abierto = 1;
//   }
// }
