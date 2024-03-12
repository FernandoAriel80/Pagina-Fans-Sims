<?php


require_once 'models/Usuario.php';
require_once 'models/Diario.php';
require_once 'models/Favorito.php';
require_once 'config/DataBase.php';
require_once 'validations/validaciones.php';
require_once 'validations/validaSesiones.php';


$dataBase = new DataBase();
$coneccion = $dataBase->conectar();
$diarioModelo = new Diario($coneccion);
$usuarioModelo = new Usuario($coneccion);
$favoritoModelo = new Favorito($coneccion);


$todosDiarios = [];


if (isset($_SESSION['idUsuario'])) {
    $idUsuarioActual = $_SESSION['idUsuario'];
}

/////////////////////FAVORITO/////////////////////////////////////
/* if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["botonDiarioFavPerfil"])) {
        if (isset($_POST["idDiarioActualPerfil"])) {
            $idDiarioActual = $_POST["idDiarioActualPerfil"];
            $resultadoFavorito = $favoritoModelo->favoritoExistente($idSession,$idDiarioActual);
            if ($resultadoFavorito) {
                $favoritoModelo->eliminaFavorito($idSession,$idDiarioActual);

            }else{
                $favoritoModelo->creaFavorito($idSession,$idDiarioActual);
            }
        }
    }
} */


$todosDiarios = muestraTodosDiarios($diarioModelo,$usuarioModelo,$idUsuarioActual,$favoritoModelo);

function muestraTodosDiarios($diarioModelo, $usuarioModelo, $idUsuarioActual, $favoritoModelo) {
    $losDiarios = array();

    $datoJoin = array(
        'Usuario ON Usuario.idUsuario = Diario.idUsuario',
        'CategoriaDiario ON CategoriaDiario.idDiario = Diario.idDiario'
    );

    $datoWhere = array(
        'Diario.visible' => '1',
        
    );
    //$datoWhere['CategoriaDiario.idCategoria'] = '6';
    
    $resultadosJoin = $diarioModelo->consultaJoin($datoJoin, $datoWhere);

    if ($resultadosJoin) {
        foreach ($resultadosJoin as $datos) {
            $fechaCreado = soloFecha($datos['fechaCreacion']);
            $fechaActualizado = '';
            if ($datos['fechaActualizacion']) {
                $fechaActualizado = soloFecha($datos['fechaActualizacion']);
            }
            $losDiarios[] = vistaDiarios(
                $datos['idUsuario'],
                $datos['idDiario'],
                $datos['token'],
                $datos['titulo'],
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
                              
                                    <input type="hidden" value="'.$idDiario.'"  name="idDiarioActualPerfil">
                                    <input type="submit" value=" " class="contenedor-favorito-amarillo" name="botonDiarioFavPerfil" title="agrega diario como favorito">
                                
                            </div>
                        </div>
                    </div>';
                }else{
                    $vista .= '
                            <div class="diario-fav">
                              
                                    <input type="hidden" value="'.$idDiario.'"  name="idDiarioActualPerfil">
                                    <input type="submit" value=" " class="contenedor-favorito-negro" name="botonDiarioFavPerfil" title="agrega diario como favorito">
                               
                            </div>
                        </div>
                    </div>';
                }
                
                //  <form class="contenedor-favorito-amarillo" action=" " method="post" >
    return $vista;
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