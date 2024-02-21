<?php
require_once 'models/Usuario.php';
require_once 'models/CategoriaDiario.php';
require_once 'models/Diario.php';
require_once 'models/Capitulo.php';
require_once 'config/DataBase.php';
require_once 'validations/validaciones.php';
require_once 'validations/validaSesiones.php';

$dataBase = new DataBase();
$coneccion = $dataBase->conectar();
$diarioModelo = new Diario($coneccion);
$usuarioModelo = new Usuario($coneccion);
$capituloModelo = new Capitulo($coneccion);
$categoriaDiarioModelo = new CategoriaDiario($coneccion);

$diario= '';
$categoria= '';
$capitulo= '';

if (isset($_GET['tokenU'])) {
    $idUsuarioActual = obteneTokenId($_GET['tokenU']);
}
if (isset($_GET['tokenD'])) {
    $idDiarioActual = obteneTokenId($_GET['tokenD']);
}

$datoDiarioModelo = $diarioModelo->obtenerTodosDiarios();
$datocapituloModelo = $capituloModelo->obtenerTodosCapitulos();
$datoUsuarioModelo = $usuarioModelo->obtenerTodosUsuarios();

$diario = vistaDiario($datoDiarioModelo,$idUsuarioActual,$idDiarioActual);
$categoria = vistaCategoria($categoriaDiarioModelo,$idDiarioActual);
$capitulo = vistaCapitulo($datocapituloModelo,$idDiarioActual);

function vistaDiario($datoD,$idautor,$idDiario){    
    if ($datoD) {
        foreach ($datoD as $diario ) {
            if ($idDiario == $diario->idDiario) {
                if ($idautor == $diario->idUsuario) {
                    $vista = '  <!-- contenido diario -->
                                <div class="contenidoDiario">
                                    <div class = "DiarioText" >
                                        <h2>'.$diario->titulo.'</h2>
                                        <p>'.$diario->descripcion.'</p>
                                    </div>          
                                </div>';
                return $vista;
                }
            }
        }
    }
}

function vistaCategoria(CategoriaDiario $modelo,$idDiario){
    $vista = 'Categoria: ';
    $dato = $modelo->getAllJoin('Categoria');
    if (!empty($dato)) {
        foreach ($dato as $key) {
            if ($key['idDiario']==$idDiario) {
                $vista .= ' '.$key['descripcion'];
            }    
        }
        return $vista;
    }
}
function vistaCapitulo($datoC,$idDiario){
    $vista ='';
    if (!empty($datoC)) {
        foreach ($datoC as $capitulo) {
            if ($capitulo->idDiario == $idDiario) {
                if ($capitulo->imagen != null) {
                    $vista = '  <div class = "capituloText" >
                                    <h2>'.$capitulo->titulo.'</h2>
                                    <p>'.$capitulo->parrafo.'</p>
                                </div>
                                <div class="imagenCapitulo">
                                    <img width= 50% src="data:image/png;base64,'.$capitulo->imagen.'" alt="Imagen" />
                                </div>';
                } else {
                    $vista = '  <div class = "capituloText" >
                                    <h2>'.$capitulo->titulo.'</h2>
                                    <p>'.$capitulo->parrafo.'</p>
                                </div>';
                }
            }    
        }
        return $vista;
    }
}
// <div class="botonesDiario">
// <button class="boton-modificar">Modificar</button>
// <button class="boton-favorito">Favorito</button>
// </div>
                    // <div class="puntuacion">
                    //     <label for="puntuacion">Puntuación:</label>
                    //     <input type="number" id="puntuacionD" name="puntuacionD" min="0" max="10" step="1">
                    // </div>