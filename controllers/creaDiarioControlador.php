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

$mensaje='';

$datoCategoriaModelo = $categoriaModelo->obtenerTodosCategorias();

$vistaCategoria = muestraCategorias($datoCategoriaModelo);
$dataBase->desconectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ////////////////////////// BOTON CREAR DIARIO + CAPITULO ////////////////////
    if (isset($_POST["botonCrearDiario"])) {
        $diarioModelo = new Diario($coneccion);
        $categoriaDiarioModelo = new CategoriaDiario($coneccion);
        $capituloModelo = new Capitulo($coneccion);
        if (isset($_POST["tituloD"])&&isset($_POST["tituloE"])) {
            // solo datos diario
            $tituloDiario = sinEspaciosLados($_POST["tituloD"]);
            $descripcion = sinEspaciosLados($_POST["descripcionD"]);
            $checkDiario = checkValida($_POST["checkD"]); /// de "on" : "off" a 1 : 0

            $tituloEntrada = sinEspaciosLados($_POST["tituloE"]);
            $contenidoE = sinEspaciosLados(limpiarTexto($_POST["contenidoE"]));
            if(validaCreaDiario($tituloDiario,$descripcion,$tituloEntrada,$contenidoE)){
                if(isset($_FILES["imagenE"])){
                    if(imagenValida($_FILES["imagenE"])){
                        $imagen = $_FILES["imagenE"]["name"];
                        $temp = $_FILES["imagenE"]["tmp_name"];
                        $imagenNombre = guardaImagen($temp,'public/ImagenesDiario/',$imagen);
                    }
                }   
                $idDiario=$diarioModelo->creaDiario($_SESSION['idUsuario'],$tituloDiario,$descripcion,$checkDiario);
                if($idDiario !== null){ 
                    $idCapitulo=$capituloModelo->creaCapitulo($idDiario,$tituloEntrada,$imagenNombre,$contenidoE); 
                    if (isset($_POST['categoriaD']) && is_array($_POST['categoriaD'])) {
                        $categoriaElegida = $_POST["categoriaD"];
                        $categoriaDiarioModelo->categoriaSeleccionada($idDiario,$categoriaElegida);
                    }
                   //header("Location: perfil.php"); 
                    echo '<meta http-equiv="refresh" content="0;url=perfil.php">';
                }
            }else{
                $mensaje=muestraMensajea("problema con validarCreaDiario");
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
function muestraCategorias($datoCate){

    $vista="";
    if (!empty($datoCate)) {
        foreach ($datoCate as $categoria) {
            $vista.="<div class='selector-categoria'>
                        <input type='checkbox' id='categoria-input' name='categoriaD[]' value='" . $categoria->idCategoria . "'>
                        <label for='categoria_" . $categoria->idCategoria. "' class='checkbox-label'>" . $categoria->descripcionCategoria . "</label>
                    </div>";
        } 
        return $vista;    
    }
}

function validaCreaDiario(string $tituloDiario,$descripcionDiario,string $tituloEntrada,string $descripcionCapitulo){
    if (tituloValido($tituloDiario)&&textoValido($descripcionDiario)&&tituloValido($tituloEntrada)&&textoValido($descripcionCapitulo)) {
        return true;
    } 
    return false;
}

