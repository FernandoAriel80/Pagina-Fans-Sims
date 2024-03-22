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
$datoLike = '';
$datoOrder;
$datoDireccion;
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
                $datoWhere[] = array('CategoriaDiario.idCategoria' => $idCategoria ) ;
            }
        }
      
        if (isset($_POST['OrdenarF'])) {
           //$datoOrder = ($_POST['OrdenarF'] == 1) ? 'fechaActualizacionDiario' : '';
           //$datoOrder = ($_POST['OrdenarF'] == 2) ? 'fechaCreacionDiario' : '';
           //$datoOrder = ($_POST['OrdenarF'] == 3) ? 'puntoPromedio' : '';
            if ($_POST['OrdenarF'] == 1) {
                $datoOrder = 'fechaActualizacionDiario';
            }
            if ($_POST['OrdenarF'] == 2) {
                $datoOrder = 'fechaCreacionDiario';
            }
            if ($_POST['OrdenarF'] == 3) {
                $datoOrder = 'puntoPromedio';
            }
        } 

        if (isset($_POST['DireccionF'])) {
            //$datoDireccion = ($_POST['DireccionF'] == 1) ? 'DESC' : '';
            //$datoDireccion = ($_POST['DireccionF'] == 2) ? 'ASC' : '';
            if ($_POST['DireccionF'] == 1) {
                $datoDireccion = ' DESC ';
            }
            if ($_POST['DireccionF'] == 2) {
                $datoDireccion = ' ASC ';
            }
        }  

        if (isset($_POST['tituloF'])) {
            $datoLike = $_POST['tituloF'];
        }  
        $todosDiarios = muestraTodosDiarios(
                            $diarioModelo, 
                            $favoritoModelo, 
                            $idUsuarioActual,
                            $datoWhere,
                            $datoLike,
                            $datoOrder,
                            $datoDireccion
                        );
       
    }
}else {
    $todosDiarios = muestraTodosDiarios(
               $diarioModelo, 
               $favoritoModelo, 
               $idUsuarioActual,
               $datoWhere,
               $datoLike,
               $datoOrder = 'fechaActualizacionDiario',
               $datoDireccion = 'DESC'
           ); 
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

$vistaCategoria = muestraCategorias($datoCategoriaModelo);
$dataBase->desconectar();


function muestraTodosDiarios(
    $diarioModelo, 
    $favoritoModelo, 
    $idUsuarioActual, 
    $datoWhere,
    $datoLike,
    $datoOrder ,
    $datoDireccion
    ) {
    $losDiarios = array();
   

    $datoJoin = array(
        'Usuario ON Usuario.idUsuario = Diario.idUsuario',
        'CategoriaDiario ON CategoriaDiario.idDiario = Diario.idDiario'
    );
    
    $resultadosJoin = $diarioModelo->filtroJoin($datoJoin, $datoWhere,$datoLike, $datoOrder,$datoDireccion);

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

function vistaDiarios(
    $idAutor,
    $idDiario,
    $token,
    $tituloDiario,
    $fechaCreacion,
    $fechaActualizacion,
    $puntaje,
    $autor,
    $idUsuarioActual,
    $favoritoModelo
    ){
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
