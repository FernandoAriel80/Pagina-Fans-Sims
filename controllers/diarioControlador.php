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
$capitulo = vistaCapitulo($datocapituloModelo,$idUsuarioActual,$idDiarioActual);

function vistaDiario($datoD,$idautor,$idDiario){    
    if ($datoD) {
        foreach ($datoD as $diario ) {
            if ($idDiario == $diario->idDiario) {
                if ($idautor == $diario->idUsuario) {
                    if ($idautor == $_SESSION['idUsuario']) {
                        $vista = '  <!-- contenido modifica diario -->
                                    <div class = "modifica-creaEntrada" >
                                        <a class="contenedor-icono-crea" href="todosDiarios.php"></a>
                                        <a class="contenedor-icono-modifica" href="todosDiarios.php"></a>
                                    </div>
                                    <!-- contenido diario -->
                                    <div class="contenidoDiario">
                                        <div class = "DiarioText" >
                                            <h2>'.$diario->titulo.'</h2>
                                            <p>'.$diario->descripcion.'</p>
                                        </div>          
                                    </div>';
                    }else{
                        $vista = ' <!-- contenido diario -->
                                    <div class="contenidoDiario">
                                        <div class = "DiarioText" >
                                            <h2>'.$diario->titulo.'</h2>
                                            <p>'.$diario->descripcion.'</p>
                                        </div>          
                                    </div>';

                    }
                    
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
function vistaCapitulo($datoC,$idautor,$idDiario){
    $vista ='';
    if (!empty($datoC)) {
        foreach ($datoC as $capitulo) {
            if ($capitulo->idDiario == $idDiario) {              
                if ($capitulo->imagen != null) {
                    $vista = '  <div class="contenidoCapitulos">
                                    <div class = "capituloText" >
                                        <h4>'.$capitulo->titulo.'</h4>
                                        <p>'.$capitulo->parrafo.'</p>
                                    </div>
                                    <div class="imagenCapitulo">
                                        <img src="public/Imagenes/'.$capitulo->imagen.'"/>
                                    </div>
                                </div>';
                } else {
                    $vista = '  <div class="contenidoCapitulos">
                                    <div class = "capituloText" >
                                        <h4>'.$capitulo->titulo.'</h4>
                                        <p>'.$capitulo->parrafo.'</p>
                                    </div>
                                </div>';
                }
                if ($idautor == $_SESSION['idUsuario']) {
                    $vista .= ' <!-- contenido modifica entrada -->
                                <div class = "modificaEntrada" >
                                    <a class="contenedor-icono-modifica" href="todosDiarios.php"></a>
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