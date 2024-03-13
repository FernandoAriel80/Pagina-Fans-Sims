<?php
require_once 'config/DataBase.php';
require_once 'models/Categoria.php';
require_once 'models/CategoriaDiario.php';
require_once 'models/Diario.php';
require_once 'validations/validaciones.php';

$dataBase = new DataBase();
$coneccion = $dataBase->conectar();
$categoriaModelo = new Categoria($coneccion);
$categoriaDiarioModelo = new CategoriaDiario($coneccion);
$diarioModelo = new Diario($coneccion);

$mensaje='';
$vistaTituloYDescripcion = '';
$vistaCategoria = '';
$vistaCheck= '';

$datoCategoriaModelo = $categoriaModelo->obtenerTodosCategorias();
$datoCategoriaDiarioModelo = $categoriaDiarioModelo->obtenerTodosCategoriaDiario();
$datoDiarioModelo = $diarioModelo->obtenerTodosDiarios();

if (isset($_GET['tokenD'])) {
    $idDiarioActual = obteneTokenId($_GET['tokenD']);
}
if (isset($_GET['diario'])) {
    $diario = $_GET['diario'];
}

$vistaTituloYDescripcion = muestraDatosDiario($datoDiarioModelo,$idDiarioActual);
$vistaCategoria = muestraCategorias($datoCategoriaModelo,$datoCategoriaDiarioModelo,$idDiarioActual);
$vistaCheck = muestraCheck($datoDiarioModelo,$idDiarioActual);
$dataBase->desconectar();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ////////////////////////// BOTON CREAR DIARIO + CAPITULO ////////////////////
    if (isset($_POST["botonEditaDiario"])) {


        if (isset($_POST["tituloD"])) {
            // solo datos diario
            $tituloDiario = sinEspaciosLados($_POST["tituloD"]);
            $descripcion = sinEspaciosLados($_POST["descripcionD"]);
            $checkDiario = checkValida($_POST["checkD"]); /// de "on" : "off" a 1 : 0
            if(validaEditaDiario($tituloDiario,$descripcion)){
                if($idDiarioActual !== null){

                    $resultado=$diarioModelo->editaDiario($idDiarioActual,$tituloDiario,$descripcion,$checkDiario); 

                    //////////////////////////CATEGORIA////////////////////////////////
                     if (isset($_POST['categoriaD']) && is_array($_POST['categoriaD'])) {
                        $categoriaElegida = $_POST["categoriaD"];
                        $categoriaAgregadas= [];
                        foreach ($categoriaElegida as $idcategoria) {
                            $categoriaExistente= []; 
                            foreach ($datoCategoriaDiarioModelo as $categoriaActual) {
                                if ($categoriaActual->idDiario == $idDiarioActual ) {
                                    if ($categoriaActual->idCategoria == $idcategoria) {
                                        $categoriaExistente = $idcategoria;  
                                    }
                                    if (!in_array($categoriaActual->idCategoria, $categoriaElegida)) {
                                       $idExistente = $categoriaDiarioModelo->obtenerUnCategoriaDiario($categoriaActual->idCategoriaDiario);
                                        if(!empty($idExistente)){
                                           $categoriaDiarioModelo->deleteById($categoriaActual->idCategoriaDiario);
                                        }
                                    }
                                }
                            }               
                            if ($idcategoria != $categoriaExistente) {
                                $categoriaAgregadas[] = $idcategoria;               
                            }
                        }
                        if(isset($categoriaAgregadas)){
                            $categoriaDiarioModelo->categoriaSeleccionada($idDiarioActual,$categoriaAgregadas); 
                        }          
                    }
                    if($resultado){
                       $diarioModelo->fechaActualizarDiario($idDiarioActual); 
                    }
                    header("Location: perfil.php");
                }
            }else{
                $mensaje=muestraMensajea("problema con validaEditaDiario");
            }

        }else{
            $mensaje=muestraMensajea("problema ingresar datos");
        }
    }
    $dataBase->desconectar();
}

function muestraMensajea($message){
    $vista='<div class="contenedor-cosas">
                <h4>'.$message.'</h4>
            </div>';
    return $vista;
}
function muestraDatosDiario($datoDiario, $idDiarioActual){
    $vista = '';
    if (!empty($datoDiario)) {
        foreach ($datoDiario as $diario) {
            if ($diario->idDiario == $idDiarioActual) {
                $vista='<input type="text" id="tituloD" name="tituloD" placeholder="Titulo del diario" value = "'.$diario->tituloDiario.'" required>
                        <input type="text" id="descripcionD" name="descripcionD" value = "'.$diario->descripcionDiario.'"
                        placeholder="Pequeña descripcion de que se trata tu diario ">';
            }
        }
    }

    return $vista;
}

function muestraCheck($datoDiario, $idDiarioActual){
    $vista = '';
    foreach ($datoDiario as $diario) {
        if ($diario->idDiario == $idDiarioActual) {
            if ($diario->visible == '1') {
                $vista ='<input title="Quieres que tu diario sea publico?" type="checkbox" id="check-diario" name="checkD" checked>';  
            } else {
                $vista ='<input title="Quieres que tu diario sea publico?" type="checkbox" id="check-diario" name="checkD" >';  
            }
        }
    }

    return $vista;
}
function muestraCategorias($datoC,$datoCD,$idDiarioActual){
    
    $vista="";
    if (!empty($datoC)) {
        foreach ($datoC as $categoria) {
            $categoriasElegida = '';
            if (!empty($datoCD)) {
                foreach ($datoCD as $cateDiario) {     
                    if ($categoria->idCategoria == $cateDiario->idCategoria && $cateDiario->idDiario == $idDiarioActual) {
                        $vista.="   <div class='selector-categoria'>
                                        <input checked type='checkbox' id='categoria-input' name='categoriaD[]' value='" . $categoria->idCategoria . "'>
                                        <label for='categoria_" . $categoria->idCategoria. "' class='checkbox-label'>" . $categoria->descripcionCategoria . "</label>
                                    </div>";
                        $categoriasElegida = $categoria->idCategoria;
                    }               
                }
            }
            if ($categoria->idCategoria != $categoriasElegida) {
                $vista.="   <div class='selector-categoria'>
                                <input  type='checkbox' id='categoria-input' name='categoriaD[]' value='" . $categoria->idCategoria . "'>
                                <label for='categoria_" . $categoria->idCategoria. "' class='checkbox-label'>" . $categoria->descripcionCategoria . "</label>
                            </div>";
            }          
        }  
        return $vista;    
    }
}

function validaEditaDiario(string $tituloDiario,$descripcionDiario){
    if (tituloValido($tituloDiario)&&textoValido($descripcionDiario)) {
        return true;
    } 
    return false;
}