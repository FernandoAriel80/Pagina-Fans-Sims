<?php

require_once 'models/Usuario.php';
require_once 'models/Diario.php';
require_once 'config/DataBase.php';
require_once 'validations/validaciones.php';
require_once 'validations/validaSesiones.php';

$dataBase = new DataBase();
$coneccion = $dataBase->conectar();
$diarioModelo = new Diario($coneccion);
$usuarioModelo = new Usuario($coneccion);
$misDiarios = [];
$todosDiarios = [];
$perfil= '';
$idUsuarioActual = $_SESSION['idUsuario'];

if (isset($_GET['token'])) {
    $idUsuarioActual = obteneTokenId($_GET['token']);
}

$perfil = muestraPerfil($usuarioModelo,$idUsuarioActual);
$datoU = $usuarioModelo->obtenerTodosUsuarios();
$datoD = $diarioModelo->obtenerTodosDiarios();
$misDiarios = muestraMisDiarios($datoD,$datoU,$idUsuarioActual);
$todosDiarios = muestraTodosDiarios($datoD,$datoU);

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
function muestraMisDiarios($datoDiario, $datoUsuario,$idU){
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
                                $diario->titulo,$fechaCreado,$fechaActualizado,$diario->puntoPromedio,$usuario->nombre); 
                            }else{
                                if ($diario->visible == '1') {
                                    $fechaCreado = soloFecha($diario->fechaCreacion);
                                    $fechaActualizado= '';
                                    if ($diario->fechaActualizacion) {
                                        $fechaActualizado = soloFecha($diario->fechaActualizacion);
                                    } 
                                    $misDiarios[] = vistaDiarios($diario->idUsuario,$diario->idDiario,$diario->token,
                                    $diario->titulo,$fechaCreado,$fechaActualizado,$diario->puntoPromedio,$usuario->nombre); 
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

function muestraTodosDiarios($datoDiario, $datoUsuario){
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
                            $diario->titulo,$fechaCreado,$fechaActualizado,$diario->puntoPromedio,$usuario->nombre);                        
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
function vistaDiarios($idAutor,$idDiario,$token,$tituloDiario,$fechaCreacion,$fechaActualizacion,$puntaje,$autor){
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
                                <input type="submit" value="" class="boton-diario-fav" name="botonDiarioFav">
                            </form>
                        </div>
                    </div>
                </div>';
    return $vista;
}