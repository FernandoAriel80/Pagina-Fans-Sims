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
        if (isset($_POST["tituloD"])/*&&isset($_POST["descripcionD"])*/&&isset($_POST["checkD"])
        &&isset($_POST["tituloE"])/*&&isset($_POST["contenidoE"])*/) {
            // solo datos diario
            $tituloDiario = sinEspaciosLados($_POST["tituloD"]);
            $descripcion = sinEspaciosLados($_POST["descripcionD"]);
            $checkDiario = checkValida($_POST["checkD"]); /// de "on" : "off" a 1 : 0
            // solo datos categoriaDiario
            //$categoria = $_POST["categoriaD"];
            // solo datos capitulo
            $tituloEntrada = sinEspaciosLados($_POST["tituloE"]);
            $contenidoE = sinEspaciosLados(limpiarTexto($_POST["contenidoE"]));
            //$imagen = codificaImagen($_POST["imagenE"]);
            // $imagen = $_FILES["imagenE"];
            if(validaCreaDiario($tituloDiario,$descripcion,$tituloEntrada,$contenidoE)){
                if(isset($_FILES["imagenE"])){
                    if(imagenValida($_FILES["imagenE"])){
                        $imagen = codificaImagen($_FILES["imagenE"]);
                    }
                }   
                //$diarioModelo->datosDiario($tituloDiario,$descripcion,$checkDiario);
                //categoriaSelecionada($categoriaDiarioModelo,$id,$categoria);

                // el idUsuario lo tengo que recuperar de otra manera, porque en cookies es inseguro y con session se pierde al cerrar el navegador
                $idDiario=$diarioModelo->creaDiario($_SESSION['idUsuario'],$tituloDiario,$descripcion,$checkDiario);
                if($idDiario !== null){
                    //$diarioModelo->guardaDatosCreaDiarioDB($_SESSION['idUsuario'],$tituloDiario);
                    $idCapitulo=$capituloModelo->creaCapitulo($idDiario,$tituloEntrada,$imagen,$contenidoE);
                    if (isset($_POST['categoriaD']) && is_array($_POST['categoriaD'])) {
                        $categoriaElegida = $_POST["categoriaD"];
                        categoriaSelecionada($categoriaDiarioModelo,$idCapitulo,$categoriaElegida);
                    }
                   header("Location: perfil.php");
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

function validaCreaDiario(string $tituloDiario,$descripcionDiario,string $tituloEntrada,string $descripcionCapitulo){
    if (tituloValido($tituloDiario)&&tituloValido($descripcionDiario)&&tituloValido($tituloEntrada)&&tituloValido($descripcionCapitulo)) {
        return true;
    } 
    return false;
}

function categoriaSelecionada(CategoriaDiario $modelo,$id,$categorias){
    foreach ($categorias as $idCategoria) {
        $dato=[
            'idDiario' => $id,
            'idCategoria' => $idCategoria
        ];
        $modelo->insert($dato);
    }
}