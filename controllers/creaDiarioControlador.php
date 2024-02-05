<?php
require_once 'config/DataBase.php';
require_once 'validations/validaciones.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    ////////////////////////// BOTON REGISTRAR ////////////////////
    if (isset($_POST["botonNavRegistrar"])) {
        $vistaLeft= muestraRegistro();
    }
}