
<?php include 'controllers/eliminaCapituloControlador.php';?>
<?php 
require_once 'validations/validaSesiones.php';
if (!sesionActiva()) {
    header("Location: index.php");
    exit();
 }
?>