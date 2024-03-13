<?php

require_once 'models/Usuario.php';
require_once 'models/Diario.php';
require_once 'models/Favorito.php';
require_once 'models/Categoria.php';
require_once 'config/DataBase.php';
require_once 'validations/validaciones.php';
require_once 'validations/validaSesiones.php';


$dataBase = new DataBase();
$coneccion = $dataBase->conectar();
$diarioModelo = new Diario($coneccion);
$usuarioModelo = new Usuario($coneccion);
$favoritoModelo = new Favorito($coneccion);
$categoriaModelo = new Categoria($coneccion);


$todosDiarios = [];
$datoWhere = array();
$aviso = '';

if (isset($_SESSION['idUsuario'])) {
    $idUsuarioActual = $_SESSION['idUsuario'];
}

$datoCategoriaModelo = $categoriaModelo->obtenerTodosCategorias();
$datoDiarioModelo = $diarioModelo->obtenerTodosDiarios();

////////////////////////// FILTRA ////////////////////
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
  
    if (isset($_POST["botonFiltra"])) {
 
        if (isset($_POST['categoriaF']) && is_array($_POST['categoriaF'])) {
            $categoriaElegida = $_POST["categoriaF"];
          
            foreach ($categoriaElegida as $idCategoria) {
                //$datoWhere['CategoriaDiario.idCategoria'] = $idCategoria;
              // $datoWhere[] = array('CategoriaDiario.idCategoria' => $idCategoria);
              //$condicion = array('CategoriaDiario.idCategoria' => $idCategoria);
              //$datoWhere[] = $condicion;
              $datoWhere['CategoriaDiario.idCategoria'] = $idCategoria;
            }
        }
        /* if (isset($_POST['tituloF'])) {
            $tituloElegido = $_POST['tituloF'];

            foreach ($datoDiarioModelo as $diario) {
                if (strpos($diario->titulo, $tituloElegido) !== false) {
                    $datoWhere['Diario.titulo'] = $diario->titulo;
                }
            }
            
        }  */

        $todosDiarios = muestraTodosDiarios($diarioModelo, $favoritoModelo, $idUsuarioActual, $datoWhere);
       /*  if (empty($todosDiarios)) {
            $aviso = '<h4>¡no se encontro datos relacionados!</h4>';
        } */
    }
}
/////////////////////FAVORITO/////////////////////////////////////
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["botonDiarioFavPerfil"])) {
        if (isset($_POST["idDiarioActualPerfil"])) {
            $idDiarioActual = $_POST["idDiarioActualPerfil"];
            $resultadoFavorito = $favoritoModelo->favoritoExistente($idUsuarioActual,$idDiarioActual);
            if ($resultadoFavorito) {
                $favoritoModelo->eliminaFavorito($idUsuarioActual,$idDiarioActual);

            }else{
                $favoritoModelo->creaFavorito($idUsuarioActual,$idDiarioActual);
            }
            $dataBase->desconectar();
        }
    }
}


$todosDiarios = muestraTodosDiarios($diarioModelo, $favoritoModelo, $idUsuarioActual, $datoWhere);
$vistaCategoria = muestraCategorias($datoCategoriaModelo);
$dataBase->desconectar();


function muestraTodosDiarios($diarioModelo, $favoritoModelo, $idUsuarioActual, $datoWhere) {
    $losDiarios = array();
   

    $datoJoin = array(
        'Usuario ON Usuario.idUsuario = Diario.idUsuario',
        'CategoriaDiario ON CategoriaDiario.idDiario = Diario.idDiario'
    );


    $datoWhere['Diario.visible'] = '1';
    //$datoWhere[] = array('Diario.visible' => '1');
 /* 
    $condicion = array('Diario.visible' => 1);
    $datoWhere[] = $condicion;
     */
    $resultadosJoin = $diarioModelo->consultaJoin($datoJoin, $datoWhere);

    if ($resultadosJoin) {
        foreach ($resultadosJoin as $datos) {
            $fechaCreado = soloFecha($datos['fechaCreacionDiario']);
            $fechaActualizado = '';
            if ($datos['fechaActualizacionDiario']) {
                $fechaActualizado = soloFecha($datos['fechaActualizacionDiario']);
            }
            $losDiarios[] = vistaDiarios(
                $datos['idUsuario'],
                $datos['idDiario'],
                $datos['token'],
                $datos['tituloDiario'],
                $fechaCreado,
                $fechaActualizado,
                $datos['puntoPromedio'],
                $datos['nombre'],
                $idUsuarioActual,
                $favoritoModelo
            );
        }
        return $losDiarios;
    } else {
        return '<h4>¡NO HAY NINGUN DIARIO!</h4>';
    }
}

function vistaDiarios($idAutor,$idDiario,$token,$tituloDiario,$fechaCreacion,$fechaActualizacion,$puntaje,$autor,$idUsuarioActual,$favoritoModelo){
    $tokenIdUsuario = generaTokenId($idAutor,$token);
    $tokenD = bin2hex(random_bytes(32));
    $tokenIdDiario = generaTokenId($idDiario,$tokenD);
    
    $vista = '  <div class="cada-diario">
                    <div class="diario-datos">
                        <a href="diario.php?tokenU='.$tokenIdUsuario.'&tokenD='.$tokenIdDiario.'&autor='.$autor.'">
                            <div class="diario-datos-arriba">
                                <h4>'.$tituloDiario.'</h4>
                            </div>
                            <div class="diario-datos-abajo">
                                <div>Fecha creacion: '.$fechaCreacion.'</div>
                                <div>Fecha actualizacion: '.$fechaActualizacion.'</div>
                                <div>Puntaje: '.$puntaje.'</div>
                            </div>
                        </a>
                    </div>
                    <div class="diario-derecho">
                        <div class="diario-autor">
                            <!-- autor -->
                           
                            <div> <a href="perfil.php?token='.$tokenIdUsuario.'">'.$autor.'</a></div>
                        </div>
                    ';

                $resultadoFavorito = $favoritoModelo->favoritoExistente($_SESSION['idUsuario'],$idDiario);
                if ($resultadoFavorito) {
                    $vista .= '
                            <div class="diario-fav">
                                <form class="contenedor-favorito-amarillo" action=" " method="post" >
                                    <input type="hidden" value="'.$idDiario.'"  name="idDiarioActualPerfil">
                                    <input type="submit" value=" " class="contenedor-favorito-amarillo" name="botonDiarioFavPerfil" title="agrega diario como favorito">
                                </form>
                            </div>
                        </div>
                    </div>';
                }else{
                    $vista .= '
                            <div class="diario-fav">
                                <form class="contenedor-favorito-negro" action=" " method="post" >
                                    <input type="hidden" value="'.$idDiario.'"  name="idDiarioActualPerfil">
                                    <input type="submit" value=" " class="contenedor-favorito-negro" name="botonDiarioFavPerfil" title="agrega diario como favorito">
                                </form>
                            </div>
                        </div>
                    </div>';
                }
                
                //  <form class="contenedor-favorito-amarillo" action=" " method="post" >
    return $vista;
}


function muestraCategorias($datoCate){

    $vista="";
    if (!empty($datoCate)) {
        foreach ($datoCate as $categoria) {
            $vista.="<div class='selector-categoria'>
                        <input type='checkbox' id='categoria-input' name='categoriaF[]' value='" . $categoria->idCategoria . "'>
                        <label for='categoria_" . $categoria->idCategoria. "' class='checkbox-label'>" . $categoria->descripcionCategoria . "</label>
                    </div>";
        } 
        return $vista;    
    }
}
/*  function muestraTodosDiarios($diarioModelo,$usuarioModelo,$idUsuarioActual,$favoritoModelo){
    $losDiarios = [];
    
    $datoWhere = array(
        'visible' => '1',
    );

    $resultadosDiario = $diarioModelo->getByCondition($datoWhere);
    if (!empty($resultadosDiario)) {
        foreach ($resultadosDiario as $diario){
                $datoUsuario=$usuarioModelo->obtenerUnUsuario($diario['idUsuario']);
                $fechaCreado = soloFecha($diario['fechaCreacion']);
                $fechaActualizado= '';
                if ($diario['fechaActualizacion']) {
                    $fechaActualizado = soloFecha($diario['fechaActualizacion']);
                } 
                $losDiarios[] = vistaDiarios($diario['idUsuario'],$diario['idDiario'],$datoUsuario->token,
                $diario['titulo'],$fechaCreado,$fechaActualizado,$diario['puntoPromedio'],$datoUsuario->nombre,$idUsuarioActual,$favoritoModelo);                        
            

        }
        return $losDiarios; 
    }else {
        return '<h4>¡NO HAY NINGUN DIARIO!</h4>';
    }
}  */

/* function muestraTodosDiarios($datoDiario, $datoUsuario,$idUsuarioActual,$favoritoModelo){
    $losDiarios = []; 
    if (!empty($datoDiario)) {
        foreach ($datoDiario as $diario){
            if (!empty($datoUsuario)) {
                foreach ($datoUsuario as $usuario){
                    if ($usuario->idUsuario == $diario->idUsuario) {
                       if ($diario->visible == '1') {
                            $fechaCreado = soloFecha($diario->fechaCreacion);
                            $fechaActualizado= '';
                            if ($diario->fechaActualizacion) {
                                $fechaActualizado = soloFecha($diario->fechaActualizacion);
                            } 
                            $losDiarios[] = vistaDiarios($diario->idUsuario,$diario->idDiario,$diario->token,
                            $diario->titulo,$fechaCreado,$fechaActualizado,$diario->puntoPromedio,$usuario->nombre,$idUsuarioActual,$favoritoModelo);                        
                        }
                    }
                }
            }  
        }
        return $losDiarios; 
    }else {
        return '<h4>¡NO HAY NINGUN DIARIO!</h4>';
    }
} */