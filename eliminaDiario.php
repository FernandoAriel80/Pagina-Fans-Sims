
<?php 
require_once 'validations/validaSesiones.php';
if (!sesionActiva()) {
    header("Location: index.php");
    exit();
 }
?>
<?php include_once 'controllers/eliminaDiarioControlador.php';?>