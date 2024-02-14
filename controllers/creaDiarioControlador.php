<?php
require_once 'config/DataBase.php';
require_once 'models/Categoria.php';
require_once 'models/CategoriaDiario.php';
require_once 'models/Capitulo.php';
require_once 'models/Diario.php';
require_once 'validations/validaciones.php';

$dataBase = new DataBase();
$coneccion = $dataBase->conectar();
$categoriaModelo = new Categoria($coneccion);
$vistaCategoria = muestraCategorias($categoriaModelo);
$dataBase->desconectar();
$mensaje='';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ////////////////////////// BOTON CREAR DIARIO + CAPITULO ////////////////////
    if (isset($_POST["botonCrearDiario"])) {
        $diarioModelo = new Diario($coneccion);
        $categoriaDiarioModelo = new CategoriaDiario($coneccion);
        $capituloModelo = new Capitulo($coneccion);
        if (isset($_POST["tituloD"])&&isset($_POST["descripcionD"])&&isset($_POST["checkD"])
        &&isset($_POST["tituloE"])&&isset($_POST["contenidoE"])&&isset($_FILES['imagenE'])
        &&isset($_POST['categoriaD']) && is_array($_POST['categoriaD'])) {
            // solo datos diario
            $mensaje=muestraMensajea($_POST["tituloD"]);
            $tituloDiario = sinEspaciosLados($_POST["tituloD"]);
            $descripcion = sinEspaciosLados($_POST["descripcionD"]);
            $checkDiario = checkValida($_POST["checkD"]); /// de "on" : "off" a 1 : 0
            // solo datos categoriaDiario
            $categoria = $_POST["categoriaD"];
            // solo datos capitulo
            $tituloEntrada = sinEspaciosLados($_POST["tituloE"]);
            $contenidoE = limpiarTexto($_POST["contenidoE"]);
            //$imagen = codificaImagen($_POST["imagenE"]);
            // $imagen = $_FILES["imagenE"];
            $mensaje=muestraMensajea($tituloDiario);
            if(validaCreaDiario($tituloDiario,$descripcion,$tituloEntrada,$_FILES["imagenE"])){
                $imagen = codificaImagen($_FILES["imagenE"]);
                $mensaje=muestraMensajea("validaCreaDiario");
                //$diarioModelo->datosDiario($tituloDiario,$descripcion,$checkDiario);
                //categoriaSelecionada($categoriaDiarioModelo,$id,$categoria);
       
                if($diarioModelo->creaDiario($_SESSION['idUsuario'],$tituloDiario,$descripcion,$checkDiario)){
                    $diarioModelo->guardaDatosCreaDiarioDB($_SESSION['idUsuario'],$tituloDiario);
                    $capituloModelo->creaCapitulo($diarioModelo->getId(),$tituloEntrada,$imagen,$contenidoE);
                    $mensaje=muestraMensajea($diarioModelo->getId());
                   header("Location: perfil.php");
                }
            }else{
                $mensaje=muestraMensajea("problema con validarCreaDiario");
            }

        }else{
            $mensaje=muestraMensajea("problema ingresar datos");
        }
    }
}
function muestraMensajea($message){
    $vista='<div class="contenedor-cosas">
                <h4>'.$message.'</h4>
            </div>';
    return $vista;
}
function muestraCategorias(Categoria $Modelo){
    $dato = $Modelo->getAll();
    $vista="";
    if (!empty($dato)) {
        foreach ($dato as $key) {
            $vista.="<div class='selector-categoria'>
                        <input type='checkbox' id='categoria-input' name='categoriaD[]' value='" . $key["idCategoria"] . "'>
                        <label for='categoria_" . $key["idCategoria"] . "' class='checkbox-label'>" . $key["descripcion"] . "</label>
                    </div>";
        } 
        return $vista;    
    }
}

function validaCreaDiario(string $tituloDiario,string $descripcion,string $tituloEntrada,$imagen){
    if (/*nombreValida($tituloDiario)&&nombreValida($descripcion)&&nombreValida($tituloEntrada)&&*/imagenValida($imagen)) {
        return true;
    } else {
        return false;
    } 
}

function categoriaSelecionada(CategoriaDiario $modelo,$id,$categorias){
    foreach ($categorias as $dato) {
        echo "Dato seleccionado: " . $dato . "<br>";
        // Aquí puedes realizar cualquier procesamiento adicional con los datos seleccionados
    }
}