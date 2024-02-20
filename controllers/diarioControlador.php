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

$diario = vistaDiario($diarioModelo,$idUsuarioActual,$idDiarioActual);
$categoria = vistaCategoria($categoriaDiarioModelo,$idDiarioActual);
$capitulo = vistaCapitulo($capituloModelo,$idDiarioActual);

function vistaDiario(Diario $modelo,$idautor,$idDiario){
    $datoDiario = $modelo->getById($idDiario);
    if ($datoDiario) {
        if ($idautor == $datoDiario['idUsuario']) {
            $vista = '  <!-- contenido diario -->
                        <div class="contenidoDiario">
                            <div class = "DiarioText" >
                                <h2>'.$datoDiario['titulo'].'</h2>
                                <p>'.$datoDiario['descripcion'].'</p>
                            </div>          
                        </div>';
        return $vista;
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
function vistaCapitulo(Capitulo $modelo,$idDiario){
    $datoFilt=array(
        'idDiario' => $idDiario,
    );
    $vista ='';
    $dato = $modelo->getByFilterData($datoFilt);
    if (!empty($dato)) {
        foreach ($dato as $key) {
            if (!empty($key['imagen'])) {
                $vista = '  <div class = "capituloText" >
                                <h2>'.$key['titulo'].'</h2>
                                <p>'.$key['parrafo'].'</p>
                            </div>
                            <div class="imagenCapitulo">
                                <img height="500px" src="data:image/png;base64,'.$key['imagen'].'" alt="Imagen" />
                            </div>';
            } else {
                $vista = '  <div class = "capituloText" >
                                <h2>'.$key['titulo'].'</h2>
                                <p>'.$key['parrafo'].'</p>
                            </div>';
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