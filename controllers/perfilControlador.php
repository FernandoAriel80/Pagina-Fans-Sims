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

$misDiarios = [];
$todosDiarios = [];
$perfil= '';
$imagenEstrella = "estrella_negra.png";
$idUsuarioActual = $_SESSION['idUsuario'];

if (isset($_GET['token'])) {
    $idUsuarioActual = obteneTokenId($_GET['token']);
}

$datoUsuarioModelo = $usuarioModelo->obtenerTodosUsuarios();
//$datoFavoritoModelo = $favoritoModelo->obtenerTodosFavorito();
$datoDiarioModelo = $diarioModelo->obtenerTodosDiariosOrden('fechaActualizacion');

$perfil = muestraPerfil($usuarioModelo,$idUsuarioActual);
$misDiarios = muestraMisDiarios($datoDiarioModelo,$datoUsuarioModelo,$idUsuarioActual,$imagenEstrella);
$todosDiarios = muestraTodosDiarios($datoDiarioModelo,$datoUsuarioModelo,$imagenEstrella);
$dataBase->desconectar(); 

/////////////////////FAVORITO/////////////////////////////////////
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["botonDiarioFav"])) {
        if (isset($_POST["idDiarioActual"])) {
            $idDiarioActual = $_POST["idDiarioActual"];
            $resultadoFavorito = $favoritoModelo->favoritoExistente($idUsuarioActual,$idDiarioActual);
            if ($resultadoFavorito) {
                $favoritoModelo->eliminaFavorito($idUsuarioActual,$idDiarioActual);
                $imagenEstrella = 'estrella_negra.png';
            }else{
                $favoritoModelo->creaFavorito($idUsuarioActual,$idDiarioActual);
                $imagenEstrella = 'estrella_amarilla.png';
            }
        }
    }
}

function muestraPerfil(Usuario $modeloU,$idU){
    $datoUsuario = $modeloU->obtenerUnUsuario($idU);
    if ($datoUsuario) {
        if ($idU == $_SESSION['idUsuario']) {
            return $vista ='<!-- contenido modifica entrada -->
                            <div class = "modificaEntrada" >
                                <a class="contenedor-icono-modifica" href="todosDiarios.php"></a>
                            </div>
                            <h4>El perfil del Usuario: '.$datoUsuario->nombre.'</h4>
                            <h4>DIARIOS:</h4>
                            <div class="elemento-diario">
                                <div class="crea-diario">
                                    <!-- autor -->
                                    <div> <a class="boton-crea-diario" href="creaDiario.php">CREA NUEVO DIARIO</a></div>
                                </div>
                            </div>
                            <h4>MIS DIARIOS:</h4>';
        } else {
            return $vista ='<h4>El perfil del Usuario: '.$datoUsuario->nombre.'</h4>
                            <h4>DIARIOS:</h4>
                            <h4>SUS DIARIOS:</h4>';
        }  
    }
}
function muestraMisDiarios($datoDiario, $datoUsuario,$idU,$imagenEstrella){
    $misDiarios = []; 
    if (!empty($datoDiario)) {
        foreach ($datoDiario as $diario){
            if (!empty($datoUsuario)) {
                foreach ($datoUsuario as $usuario){
                    if ($usuario->idUsuario == $diario->idUsuario) {
                        if ($idU == $diario->idUsuario) {
                            if ($idU == $_SESSION['idUsuario']) {
                                $fechaCreado = soloFecha($diario->fechaCreacion);
                                $fechaActualizado= '';
                                if ($diario->fechaActualizacion) {
                                    $fechaActualizado = soloFecha($diario->fechaActualizacion);
                                } 
                                $misDiarios[] = vistaDiarios($diario->idUsuario,$diario->idDiario,$diario->token,
                                $diario->titulo,$fechaCreado,$fechaActualizado,$diario->puntoPromedio,$usuario->nombre,$imagenEstrella); 
                            }else{
                                if ($diario->visible == '1') {
                                    $fechaCreado = soloFecha($diario->fechaCreacion);
                                    $fechaActualizado= '';
                                    if ($diario->fechaActualizacion) {
                                        $fechaActualizado = soloFecha($diario->fechaActualizacion);
                                    } 
                                    $misDiarios[] = vistaDiarios($diario->idUsuario,$diario->idDiario,$diario->token,
                                    $diario->titulo,$fechaCreado,$fechaActualizado,$diario->puntoPromedio,$usuario->nombre,$imagenEstrella); 
                                }
                            }
                            
                        }  
                    }
                }
            }  
        }
        return $misDiarios; 
    }else {
        return '<h4>¡NO CREASTE NINGUN DIARIO!</h4>';
    }
}

function muestraTodosDiarios($datoDiario, $datoUsuario,$imagenEstrella){
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
                            $diario->titulo,$fechaCreado,$fechaActualizado,$diario->puntoPromedio,$usuario->nombre,$imagenEstrella);                        
                        }
                    }
                }
            }  
        }
        return $losDiarios; 
    }else {
        return '<h4>¡NO HAY NINGUN DIARIO!</h4>';
    }
}
function vistaDiarios($idAutor,$idDiario,$token,$tituloDiario,$fechaCreacion,$fechaActualizacion,$puntaje,$autor,$imagenEstrella){
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
                        <div class="diario-fav">
                            <form class="formulario-diario-fav" action=" " method="post">
                                <input type="hidden" value="'.$idDiario.'" class="boton-diario-fav" name="idDiarioActual">
                                
                                <input type="submit" src="public/Iconos/'.$imagenEstrella.'" value=" " class="boton-diario-fav" name="botonDiarioFav" style =" background-image: url("/public/Iconos/'.$imagenEstrella.'");">
                            </form>
                        </div>
                    </div>
                </div>';
    return $vista;
}