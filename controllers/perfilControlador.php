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

if (isset($_GET['idAutor'])) {
    $idUsuarioActual = $_GET['idAutor'];
}

$perfil = muestraPerfil($usuarioModelo,$idUsuarioActual);
$misDiarios = muestraMisDiarios($diarioModelo,$idUsuarioActual);
$todosDiarios = muestraTodosDiarios($diarioModelo);

function muestraPerfil(Usuario $modelo,$id){
    $datoUsuario = $modelo->getById($id);
    if ($datoUsuario) {
        if ($id == $_SESSION['idUsuario']) {
            return $vista ='<h4>El perfil del Usuario: '.$datoUsuario['nombre'].'</h4>
                            <h4>DIARIOS:</h4>
                            <div class="elemento-diario">
                                <div class="crea-diario">
                                    <!-- autor -->
                                    <div> <a href="creaDiario.php">CREA NUEVO DIARIO</a></div>
                                </div>
                            </div>
                            <h4>MIS DIARIOS:</h4>';
        } else {
            return $vista ='<h4>El perfil del Usuario: '.$datoUsuario['nombre'].'</h4>
                            <h4>DIARIOS:</h4>
                            <h4>SUS DIARIOS:</h4>';
        }  
    }
}
function muestraMisDiarios(Diario $modelo,$id){
    $dato = $modelo->getAllJoin('Usuario');
    $misDiarios = []; 
    if (!empty($dato)) {
        foreach ($dato as $key){
            if ($id == $key['idUsuario']) {
                $misDiarios[] = vistaDiarios($key['idUsuario'],$key['titulo'],$key['fechaCreacion'],$key['fechaActualizacion'],$key['puntoPromedio'],$key['nombre']);
            }    
        }
        return $misDiarios; 
    }else {
        return '<h4>¡NO CREASTE NINGUN DIARIO!</h4>';
    }
}

function muestraTodosDiarios(Diario $modelo){
    $dato = $modelo->getAllJoin('Usuario');
    $losDiarios = []; 
    if (!empty($dato)) {
        foreach ($dato as $key){
            $losDiarios[] = vistaDiarios($key['idUsuario'],$key['titulo'],$key['fechaCreacion'],$key['fechaActualizacion'],$key['puntoPromedio'],$key['nombre']); 
        }
        return $losDiarios; 
    }else {
        return '<h4>¡NO HAY NINGUN DIARIO!</h4>';
    }
}
function vistaDiarios($idAutor,$tituloDiario,$fechaCreacion,$fechaActualizacion,$puntaje,$autor){
    $vista = '  <div class="cada-diario">
                    <div class="diario-datos">
                        <a href="">
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
                            <div> <a href="/paginaSims/perfil.php?idAutor='.$idAutor.'">'.$autor.'</a></div>
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