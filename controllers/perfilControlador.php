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

$diariosFavoritos = [];
$perfil= '';


if (isset($_SESSION['idUsuario'])) {
    $idUsuarioActual = $_SESSION['idUsuario'];
}
if (isset($_GET['token'])) {
    $idUsuarioActual = obteneTokenId($_GET['token']);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["botonDiarioFavPerfil"])) {
        if (isset($_POST["idDiarioActualPerfil"])) {
            $idDiarioActual = $_POST["idDiarioActualPerfil"];
            $resultadoFavorito = $favoritoModelo->favoritoExistente($_SESSION['idUsuario'],$idDiarioActual);
            if ($resultadoFavorito) {
                $favoritoModelo->eliminaFavorito($_SESSION['idUsuario'],$idDiarioActual);

            }else{
                $favoritoModelo->creaFavorito($_SESSION['idUsuario'],$idDiarioActual);
            }
            $dataBase->desconectar();
        }
    }
}

$datoUsuarioModelo = $usuarioModelo->obtenerTodosUsuarios();
$datoFavoritoModelo = $favoritoModelo->obtenerTodosFavorito();
$datoDiarioModelo = $diarioModelo->obtenerTodosDiariosOrden('fechaActualizacionDiario');



$perfil = muestraPerfil($usuarioModelo,$idUsuarioActual);
$misDiarios = muestraMisDiarios($datoDiarioModelo,$datoUsuarioModelo,$idUsuarioActual,$favoritoModelo);
$diariosFavoritos = muestraFavoritos($datoDiarioModelo,$datoUsuarioModelo,$datoFavoritoModelo,$idUsuarioActual,$favoritoModelo);
$dataBase->desconectar(); 



function muestraPerfil(Usuario $modeloU,$idU){
    $datoUsuario = $modeloU->obtenerUnUsuario($idU);
    if ($datoUsuario) {
        
        if ($idU == $_SESSION['idUsuario']) {
            if ($datoUsuario->foto != null) {
                $vista = ' 
                    <div class = "modificaEntrada" >
                        <a class="contenedor-icono-modifica" href="editaPerfil.php"></a>
                    </div>
                    <h1>'.$datoUsuario->nombre.'</h1>
                    <div class = "contenedor-perfil" >
                        <div class="imagenPerfil">
                            <a href="public/ImagenesPerfil/'.$datoUsuario->foto.'">
                                <img src="public/ImagenesPerfil/'.$datoUsuario->foto.'" alt="Foto de perfil"/>
                            </a>  
                        </div>
                    
                    </div>';
    
                
            }else {
                $vista = ' 
              
                    <div class = "modificaEntrada" >
                        <a class="contenedor-icono-modifica" href="editaPerfil.php"></a>
                    </div>
                    <h1>'.$datoUsuario->nombre.'</h1>
                    <div class = "contenedor-perfil" >
                        <div class="imagenPerfil">
                            <a href="public/Iconos/perfilFoto.png">
                                <img src="public/Iconos/perfilFoto.png" alt="Foto de perfil"/>
                            </a>  
                        </div>
                    
                    </div>';
            }
            return $vista .='<!-- contenido modifica entrada -->

                            <h4>DIARIOS:</h4>
                            <div class="elemento-diario">
                                <div class="crea-diario">
                                    <!-- autor -->
                                    <div> <a class="boton-crea-diario" href="creaDiario.php">CREA NUEVO DIARIO</a></div>
                                </div>
                            </div>
                            <div class="elemento-diario">
                                <p>Aquí encontraras tus diarios. Donde podrás poner tus imágenes y las locuras que hacen tus Sims. <br>
                                    Esta es la lista de todos los diarios disponibles del momento.<br>
                                    No seas tímido y pon el tuyo!. 
                                </p>
                            </div>
                            <h4>MIS DIARIOS:</h4>';
        } else {
            if ($datoUsuario->foto != null) {
                $vista = ' 
                <h1>'.$datoUsuario->nombre.'</h1>
                <div class = "contenedor-perfil" >
                    
                    <div class="imagenPerfil">
                        <a href="public/ImagenesPerfil/'.$datoUsuario->foto.'">
                            <img src="public/ImagenesPerfil/'.$datoUsuario->foto.'" alt="Foto de perfil"/>
                        </a>  
                    </div>
                </div>';
    
                
            }else {
                $vista = '
                <h1>'.$datoUsuario->nombre.'</h1>
                <div class = "contenedor-perfil" >  
                    <div class="imagenPerfil">
                        <a href="public/Iconos/perfilFoto.png">
                            <img src="public/Iconos/perfilFoto.png" alt="Foto de perfil"/>
                        </a>  
                    </div>
                    
                </div>';
            }
            return $vista .='
                            <h4>DIARIOS:</h4>
                            <h4>SUS DIARIOS:</h4>';
        }  
    }
}
function muestraMisDiarios($datoDiario, $datoUsuario,$idU,$favoritoModelo){
    $misDiarios = []; 
    if (!empty($datoDiario)) {
        foreach ($datoDiario as $diario){
            if (!empty($datoUsuario)) {
                foreach ($datoUsuario as $usuario){
                    if ($usuario->idUsuario == $diario->idUsuario) {
                        if ($idU == $diario->idUsuario) {
                            if ($idU == $_SESSION['idUsuario']) {
                                $fechaCreado = soloFecha($diario->fechaCreacionDiario);
                                $fechaActualizado= '';
                                if ($diario->fechaActualizacionDiario) {
                                    $fechaActualizado = soloFecha($diario->fechaActualizacionDiario);
                                } 
                                $misDiarios[] = vistaDiarios(
                                    $diario->idUsuario,
                                    $diario->idDiario,
                                    $usuario->token,
                                    $diario->tituloDiario,
                                    $fechaCreado,
                                    $fechaActualizado,
                                    $diario->puntoPromedio,
                                    $usuario->nombre,
                                    $idU,
                                    $favoritoModelo); 
                            }else{
                                if ($diario->visible == '1') {
                                    $fechaCreado = soloFecha($diario->fechaCreacionDiario);
                                    $fechaActualizado= '';
                                    if ($diario->fechaActualizacionDiario) {
                                        $fechaActualizado = soloFecha($diario->fechaActualizacionDiario);
                                    } 
                                    $misDiarios[] = vistaDiarios(
                                        $diario->idUsuario,
                                        $diario->idDiario,
                                        $usuario->token,
                                        $diario->tituloDiario,
                                        $fechaCreado,
                                        $fechaActualizado,
                                        $diario->puntoPromedio,
                                        $usuario->nombre,
                                        $idU,
                                        $favoritoModelo); 
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


function muestraFavoritos($datoDiario, $datoUsuario,$datoFavorito,$idUsuarioActual,$favoritoModelo){
    $losDiarios = []; 
    if (!empty($datoDiario)) {
        foreach ($datoDiario as $diario){
            if (!empty($datoUsuario)) {
                foreach ($datoUsuario as $usuario){
                    if (!empty($datoFavorito)) {
                        foreach ($datoFavorito as $favorito){
                            if ($usuario->idUsuario == $diario->idUsuario) {
                                if ($favorito->idUsuario == $idUsuarioActual && $favorito->idDiario == $diario->idDiario) {
                                    if ($diario->visible == '1') {
                                        $fechaCreado = soloFecha($diario->fechaCreacionDiario);
                                        $fechaActualizado= '';
                                        if ($diario->fechaActualizacionDiario) {
                                            $fechaActualizado = soloFecha($diario->fechaActualizacionDiario);
                                        } 
                                        $losDiarios[] = vistaDiarios(
                                            $diario->idUsuario,
                                            $diario->idDiario,
                                            $usuario->token,
                                            $diario->tituloDiario,
                                            $fechaCreado,
                                            $fechaActualizado,
                                            $diario->puntoPromedio,
                                            $usuario->nombre,
                                            $idUsuarioActual,
                                            $favoritoModelo);                        
                                    }
                                }  
                             } 
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
                
    return $vista;
}
