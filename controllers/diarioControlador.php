<?php
require_once 'models/Usuario.php';
require_once 'models/CategoriaDiario.php';
require_once 'models/Diario.php';
require_once 'models/Capitulo.php';
require_once 'config/DataBase.php';
require_once 'models/Favorito.php';
require_once 'models/Puntaje.php';
require_once 'validations/validaciones.php';
//require_once 'validations/validaSesiones.php';

$dataBase = new DataBase();
$coneccion = $dataBase->conectar();
$diarioModelo = new Diario($coneccion);
$usuarioModelo = new Usuario($coneccion);
$capituloModelo = new Capitulo($coneccion);
$favoritoModelo = new Favorito($coneccion);
$puntajeModelo = new Puntaje($coneccion);
$categoriaDiarioModelo = new CategoriaDiario($coneccion);

$diario= '';
$categoria= '';
$todosCapitulos= [];
$restoPuntos= '/5';
$misPuntos= '';
$totalPuntos= '';


if (isset($_GET['tokenU'])) {
    $idUsuarioActual = obteneTokenId($_GET['tokenU']);
}
if (isset($_GET['tokenD'])) {
    $idDiarioActual = obteneTokenId($_GET['tokenD']);
}
if (isset($_GET['autor'])) {
    $autor = $_GET['autor'];
}
if (isset($_SESSION["idUsuario"])){
    $idSession =$_SESSION["idUsuario"];
}

$datoDiarioModelo = $diarioModelo->obtenerTodosDiarios();
$datocapituloModelo = $capituloModelo->obtenerTodosCapitulos();
$datoUsuarioModelo = $usuarioModelo->obtenerTodosUsuarios();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["botonDiarioFav"])) {
        if (isset($_POST["idDiarioActual"])) {
            $idDiarioActualForm = $_POST["idDiarioActual"];
            $resultadoFavorito = $favoritoModelo->favoritoExistente($idSession,$idDiarioActualForm);
            if ($resultadoFavorito) {
                $favoritoModelo->eliminaFavorito($idSession,$idDiarioActualForm);
            }else{
                $favoritoModelo->creaFavorito($idSession,$idDiarioActualForm);    
            }
        }
    }
}




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["botonCalificar"])) {      
        if (isset($_POST["punto"])) {
            $punto = $_POST["punto"];
            if ($punto <= 5) {
                $datoFiltro=[
                    'idUsuario' => $idSession,
                    'idDiario' => $idDiarioActual
                ];
                $resultadoExistente = $puntajeModelo->getByFilterData($datoFiltro);
               
                if (empty($resultadoExistente)) {
                  
                    $datoInsertar=[
                        'idUsuario'=>$idSession,
                        'idDiario'=>$idDiarioActual,
                        'puntajeDato'=>$punto
                    ];
                    $resultadoInsertar = $puntajeModelo->insert($datoInsertar);  
                    if ($resultadoInsertar) {
                        $promedioPuntos = $puntajeModelo->promedioPuntaje($idDiarioActual);
                        if ($promedioPuntos["promedioPuntuacion"] != null) {
                            $datoUpDateDiario=[
                                'puntoPromedio' => $promedioPuntos["promedioPuntuacion"]
                            ];
                            $diarioModelo->upDateById($idDiarioActual,$datoUpDateDiario);
                        } 
                    }   
                                  
                }else {
                    foreach ($resultadoExistente as $puntaje) {
                        if ($puntaje['puntajeDato'] != $punto) {
                            $datoUpDatePunto=[
                                'puntajeDato'=>$punto
                            ];
                            $resultadoUpDate = $puntajeModelo->upDateById($puntaje['idPuntaje'],$datoUpDatePunto);
                            if (!empty($resultadoUpDate)) {
                                $promedioPuntos = $puntajeModelo->promedioPuntaje($idDiarioActual);
                                if ($promedioPuntos["promedioPuntuacion"] != null) {
                                    $datoUpDateDiario=[
                                        'puntoPromedio'=>$promedioPuntos["promedioPuntuacion"]
                                    ];
                                    $diarioModelo->upDateById($idDiarioActual,$datoUpDateDiario);
                                } 
                            }
                        }
                    }
                }
            }  
        }
    }
}
    $datoFiltro=[
        'idUsuario' => $idSession,
        'idDiario' => $idDiarioActual
    ];
    $resultadoExistentePuntaje = $puntajeModelo->getByFilterData($datoFiltro);
    if ($resultadoExistentePuntaje) {
        foreach ($resultadoExistentePuntaje as $puntaje) {
             $misPuntos= $puntaje['puntajeDato'].$restoPuntos;
        }   
    }else {
        $misPuntos = "0".$restoPuntos;
    }
    //////////////////////////////////////////////////////////////////
    $resultadoExistenteDiario = $diarioModelo->obtenerUnDiario($idDiarioActual);
    if ($resultadoExistenteDiario) {
        $totalPuntos= $resultadoExistenteDiario->puntoPromedio.$restoPuntos;
    }

$diario = vistaDiario($datoDiarioModelo,$idUsuarioActual,$idDiarioActual,$autor,$favoritoModelo);
$categoria = vistaCategoria($categoriaDiarioModelo,$idDiarioActual);
$todosCapitulos = muestraTodosCapitulos($datocapituloModelo,$idUsuarioActual,$idDiarioActual);
$dataBase->desconectar(); 

/////////////////////FAVORITO/////////////////////////////////////

function vistaDiario($datoD,$idAutor,$idDiario,$autor,$favoritoModelo){ 
    $tokenD = bin2hex(random_bytes(32));
    $tokenIdDiario = generaTokenId($idDiario,$tokenD);   
    if ($datoD) {
        foreach ($datoD as $diario ) {
            if ($idDiario == $diario->idDiario) {
                if ($idAutor == $diario->idUsuario) {
                    if ($idAutor == $_SESSION['idUsuario']) {
                        $resultadoFavorito = $favoritoModelo->favoritoExistente($_SESSION['idUsuario'],$idDiario);
                        if ($resultadoFavorito) {
                            $vista = '  <!-- contenido modifica diario -->
                                        <div class = "modifica-creaEntrada" >
                                            <form class="contenedor-favorito-amarillo" action=" " method="post" >
                                                <input type="hidden" value="'.$diario->idDiario.'" name="idDiarioActual">
                                                <input type="submit" value=" " class="contenedor-favorito-amarillo" name="botonDiarioFav" title="agrega diario como favorito">
                                            </form>';
                        }else{
                            $vista = '  <!-- contenido modifica diario -->
                                        <div class = "modifica-creaEntrada" >
                                            <form class="contenedor-favorito-negro" action=" " method="post" >
                                                <input type="hidden" value="'.$diario->idDiario.'" name="idDiarioActual">
                                                <input type="submit" value=" " class="contenedor-favorito-negro" name="botonDiarioFav" title="agrega diario como favorito">
                                            </form>';
                        }
                        $vista .= '         
                                        <a class="contenedor-icono-crea" href="creaCapitulo.php?tokenD='.$tokenIdDiario.'&diario='.$diario->tituloDiario.'" title="agrega una entrada"></a>
                                        <a class="contenedor-icono-modifica" href="editaDiario.php?tokenD='.$tokenIdDiario.'&diario='.$diario->tituloDiario.'" title="modifica diario"></a>
                                        <a class="contenedor-icono-elimina" href="eliminaDiario.php?tokenD='.$tokenIdDiario.'" title="elimina diario" ></a> 
                                    </div>
                                    <!-- contenido diario -->
                                    <div class="contenidoDiario">
                                        <div class = "DiarioText" >
                                            <h2>'.$diario->tituloDiario.'</h2>
                                            <p>'.$diario->descripcionDiario.'</p>
                                            <p> Autor: '.$autor.'</p>
                                        </div>          
                                    </div>';
                    }else{
                        $resultadoFavorito = $favoritoModelo->favoritoExistente($_SESSION['idUsuario'],$idDiario);
                        if ($resultadoFavorito) {
                            $vista = '  <!-- contenido modifica diario -->
                                        <div class = "modifica-creaEntrada" >
                                            <form class=contenedor-favorito-amarillo" action=" " method="post">
                                                <input type="hidden" value="'.$idDiario.'"  name="idDiarioActual">
                                                <input type="submit" value=" " class="contenedor-favorito-amarillo" name="botonDiarioFav">
                                            </form>
                                        </div>';
                        }else{
                            $vista = '  <!-- contenido modifica diario -->
                                        <div class = "modifica-creaEntrada" >
                                           <form class="contenedor-favorito-negro" action=" " method="post">
                                                <input type="hidden" value="'.$idDiario.'"  name="idDiarioActual">
                                                <input type="submit" value=" " class="contenedor-favorito-negro" name="botonDiarioFav">
                                            </form>
                                        </div>';
                        }

                        $vista .= ' <!-- contenido diario -->
                                    <div class="contenidoDiario">
                                        <div class = "DiarioText" >
                                            <h2>'.$diario->tituloDiario.'</h2>
                                            <p>'.$diario->descripcionDiario.'</p>
                                            <p> Autor: '.$autor.'</p>
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
                $vista .= ' '.$key['descripcionCategoria'];
            }    
        }
        return $vista;
    }
}
function muestraTodosCapitulos($datoC,$idautor,$idDiario){
    $losCapitulos= [];
    if (!empty($datoC)) {
        foreach ($datoC as $capitulo) {
            if ($capitulo->idDiario == $idDiario) {              
                $losCapitulos[] = vistacapitulo($idautor,$capitulo->idDiario,$capitulo->idCapitulo,$capitulo->imagenCapitulo,$capitulo->tituloCapitulo,$capitulo->parrafoCapitulo);
            }    
        }
        return $losCapitulos;
    }
}

function vistacapitulo($idautor,$idDiario,$idCapitulo,$imagen,$titulo,$parrafo){
    $tokenC = bin2hex(random_bytes(32));
    $tokenIdCapitulo = generaTokenId($idCapitulo,$tokenC); 
    $tokenD = bin2hex(random_bytes(32));
    $tokenIdDiario = generaTokenId($idDiario,$tokenD);
    if ($imagen != null) {
        if ($parrafo != '') {
            $vista = '  <div class="contenidoCapitulos">
                            <div class = "capituloText" >
                                <h4>'.$titulo.'</h4>
                                <p>'.$parrafo.'</p>
                            </div>
                            <div class="imagenCapitulo">
                                <a href="public/ImagenesDiario/'.$imagen.'">
                                    <img src="public/ImagenesDiario/'.$imagen.'"/>
                                </a>  
                            </div>
                        </div>';
        } else {
            $vista = '  <div class="contenidoCapitulos " style="display: block;">
                            <div class = "capituloText" >
                                <h4>'.$titulo.'</h4>
                            </div>
                            <div class="imagenCapitulo" style="width: 80%;">
                                <a href="public/ImagenesDiario/'.$imagen.'">
                                    <img src="public/ImagenesDiario/'.$imagen.'"/>
                                </a>
                            </div>
                        </div>';
        }
       
    } else {
        $vista = '  <div class="contenidoCapitulos">
                        <div class = "capituloText" style="width: 100%;">
                            <h4>'.$titulo.'</h4>
                            <p>'.$parrafo.'</p>
                        </div>
                    </div>';
    }
    if ($idautor == $_SESSION['idUsuario']) {
        $vista .= ' <!-- contenido modifica entrada -->
                    <div class = "modificaEntrada" >
                        <a class="contenedor-icono-modifica" href="editaCapitulo.php?tokenC='.$tokenIdCapitulo.'&tokenD='.$tokenIdDiario.'" title="modifica entrada"></a>
                        <a class="contenedor-icono-elimina" href="eliminaCapitulo.php?tokenC='.$tokenIdCapitulo.'&tokenD='.$tokenIdDiario.'" title="elimina entrada" onclick="confirmarEliminar()"></a>
                    </div>';
    }
    return $vista;
}    


// return $vista;
// }
// <div class="botonesDiario">
// <button class="boton-modificar">Modificar</button>
// <button class="boton-favorito">Favorito</button>
// </div>
                    // <div class="puntuacion">
                    //     <label for="puntuacion">Puntuación:</label>
                    //     <input type="number" id="puntuacionD" name="puntuacionD" min="0" max="10" step="1">
                    // </div>