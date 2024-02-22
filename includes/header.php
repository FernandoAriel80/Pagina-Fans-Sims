<?php require_once 'validations/validaSesiones.php';?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--enlace archivo CSS -->
    <link rel="stylesheet" type="text/css" href="public/CSS/styles.css">
    <link rel="stylesheet" type="text/css" href="public/CSS/indexStyles.css">
    <link rel="stylesheet" type="text/css" href="public/CSS/todosDiariosStyles.css">
    <link rel="stylesheet" type="text/css" href="public/CSS/creaDiarioStyles.css">
    <link rel="stylesheet" type="text/css" href="public/CSS/perfilStyles.css">
    <link rel="stylesheet" type="text/css" href="public/CSS/diarioStyles.css">
    <title>Pagina Fans Sims</title>
    <link rel="icon" href="public/Iconos/logo.png" type="image/png">
    <!-- Agrega enlaces a tus hojas de estilo CSS aquí si es necesario -->
</head>

<body>
    <header>
        <div class="contenedor-titulo">
            <div class="circulo">
                <div class="imagen-sims"></div>
                <div class="mini-circulo">
                    <button id="miniCirculo" class="boton-con-imagen"></button>
                </div>
            </div>
            <div class="rectangulo">
                <div class="contenedor-rectangulo-izquierdo"></div>
                <div class="contenedor-rectangulo-derecho">
                    <div class="contenedor-icono">
                        <a class="contenedor-icono-inicio" href="index.php"></a>
                    </div>
                    <div class="contenedor-icono">
                        <a class="contenedor-icono-perfil" href="perfil.php"></a>
                    </div>
                    <div class="contenedor-icono">
                        <a class="contenedor-icono-diario" href="todosDiarios.php"></a>
                    </div>
                </div>
            </div>
        </div>
    </header>