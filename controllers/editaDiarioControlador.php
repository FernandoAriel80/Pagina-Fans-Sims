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
                    //$resultado=$diarioModelo->editaDiario($idDiarioActual,$tituloDiario,$descripcion,$checkDiario);
                    
                    // if (isset($_POST['categoriaD']) && is_array($_POST['categoriaD'])) {
                    //     $categoriaElegida = $_POST["categoriaD"];
                    
                    //     // Almacena los ids de las categorías originales
                    //     $idsCategoriasOriginales = array_map(function($categoria) {
                    //         return $categoria->idCategoria;
                    //     }, $datoCategoriaDiarioModelo);
                    
                    //     // Itera sobre las categorías seleccionadas
                    //     foreach ($categoriaElegida as $idCategoria) {
                    
                    //         if (in_array($idCategoria, $idsCategoriasOriginales)) {
                    //             echo 'La categoría ' . $idCategoria . ' está seleccionada' . '</br>';
                    //             // Puedes realizar acciones adicionales para las categorías seleccionadas
                    //         } else {
                    //             echo 'La categoría ' . $idCategoria . ' es una selección adicional' . '</br>';
                    //             // Puedes realizar acciones adicionales para las selecciones adicionales
                    //         }
                    //     }
                    
                    //     // Itera sobre las categorías originales
                    //     foreach ($datoCategoriaDiarioModelo as $categoriaActual) {
                    //         $idCategoriaActual = $categoriaActual->idCategoria;
                    //         if (!in_array($idCategoriaActual, $categoriaElegida)) {
                    //             echo 'La categoría ' . $idCategoriaActual . ' está deseleccionada' . '</br>';
                    //             // Puedes realizar acciones adicionales para las categorías deseleccionadas
                    //         }
                    //     }
                    // }
                    
                    //////////////////////////////////////////////////////////////////////
                    // if (isset($_POST['categoriaD']) && is_array($_POST['categoriaD'])) {
                    //     $categoriaElegida = $_POST["categoriaD"];
                    //     $categoriaExistente= [];
                    //     // Recorre todas las categorías presentes en $datoCategoriaDiarioModelo
                    //     foreach ($datoCategoriaDiarioModelo as $categoriaActual) {
                           
                    //         if ($categoriaActual->idDiario == $idDiarioActual ) {
                    //             $idCategoriaActual = $categoriaActual->idCategoria;
                    //             $estaSeleccionada = in_array($idCategoriaActual, $categoriaElegida);
             
                    //             if ($estaSeleccionada) {
                    //                 $categoriaExistente = $idCategoriaActual;
                    //                 echo 'La categoría ' . $idCategoriaActual . ' está seleccionada' . '</br>';
                    //                 // Aquí puedes realizar cualquier acción adicional para las categorías seleccionadas
                    //             } else {
                                    
                    //                 echo 'La categoría ' . $idCategoriaActual . ' está deseleccionada' . '</br>';
                    //                 // Aquí puedes realizar cualquier acción adicional para las categorías deseleccionadas
                    //             }
                    //         }
                           
                    //     }

                    //         foreach ($categoriaElegida as $idcategoria) {
                    //             if ($idcategoria != $categoriaExistente) {
                    //                         echo('incluido'.'</br>');
                    //                         echo($idcategoria.'</br>');
                                                   
                    //                 } 
                    //         }
                       
                    // }
                    
                    //////////////////////////////////////////////////////////
                    // if (isset($_POST['categoriaD']) && is_array($_POST['categoriaD'])) {
                    //     $categoriaElegida = $_POST["categoriaD"];
                    //         foreach ($categoriaElegida as $idcategoria) {
                    //             $categoriaExistente= [];
                    //             foreach ($datoCategoriaDiarioModelo as $categoriaActual) {
                    //                 if ($categoriaActual->idDiario == $idDiarioActual ) {
                    //                     if ($categoriaActual->idCategoria == $idcategoria) {
                    //                         $categoriaExistente = $idcategoria; 
                    //                         echo('ya estaba'.'</br>');
                    //                         //echo($idcategoria.'</br>'); 
                    //                         echo($categoriaActual->idCategoria.'</br>');
                    //                         //$categoriaDiarioModelo->eliminaCategoria($idDiarioActual, $categoriaActual->idCategoria);
                                           
                    //                     }else if($categoriaActual->idCategoria != $categoriaExistente){
                    //                         echo('no se eligio'.'</br>');
                    //                         echo($idcategoria.'</br>');
                    //                     }
                                      
                    //                 }
                    //             }
                                
                    //            if ($idcategoria != $categoriaExistente) {
                    //                echo('incluido'.'</br>');
                    //                echo($idcategoria.'</br>');
                                   
                    //            }   
                                    
                               
            
                   
                    //             //if (!in_array($categoriaActual['idCategoria'], $categoriaElegida)) {
                    //             //    $categoriaDiarioModelo->eliminaCategoria($idDiarioActual, $categoriaActual['idCategoria']);
                    //             //}
                    //         }
                          
                   
                          
                           
                      
                    //        // $categoriaDiarioModelo->categoriaSeleccionada($idDiarioActual,$categoriaElegida);
                        
                    // }
                  
                    if($resultado){
                       $diarioModelo->fechaActualizarDiario($idDiarioActual); 
                    }
                  //header("Location: perfil.php");
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
                $vista='<input type="text" id="tituloD" name="tituloD" placeholder="Titulo del diario" value = "'.$diario->titulo.'" required>
                        <input type="text" id="descripcionD" name="descripcionD" value = "'.$diario->descripcion.'"
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
                                        <label for='categoria_" . $categoria->idCategoria. "' class='checkbox-label'>" . $categoria->descripcion . "</label>
                                    </div>";
                        $categoriasElegida = $categoria->idCategoria;
                    }               
                }
            }
            if ($categoria->idCategoria != $categoriasElegida) {
                $vista.="   <div class='selector-categoria'>
                                <input  type='checkbox' id='categoria-input' name='categoriaD[]' value='" . $categoria->idCategoria . "'>
                                <label for='categoria_" . $categoria->idCategoria. "' class='checkbox-label'>" . $categoria->descripcion . "</label>
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