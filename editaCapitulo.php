<?php include_once 'includes/header.php'; ?>

<?php 
if (!sesionActiva()) {
    header("Location: index.php");
    exit();
 }
?>

<!-- PORCION LEFT -->

</div>
<?php include_once 'controllers/editaCapituloControlador.php';?>
<!-- FINAL DE LA PORCION LEFT -->
<div class="contenedor-flex">

    <!-- CONTENEDOR -->
    <div class="contenedor-crea-capitulo">
        <h2>CREA ENTRADA</h2>
        <p>Edita tu entrada</p>
        <!-- agrega formulario capitulo -->
        <form class="formulario-crea-capitulo" action=" " enctype="multipart/form-data" method="POST">
            <!-- agrega formulario datos -->
            <?php echo $vistaDato;?>
            <div class="imagenYboton">
                <div class="contenedor-imagen">
                    <input type="file" name="imagenE">
                </div>
                <div class="subYcheck">
                    <input type="submit" id="boton-crea-capitulo" value="Edita" name="botonEditaCapitulo">
                </div>
            </div>
            <div id="mensajeErrorCreaDiario" class="mensaje-error" value="" style="display: none;"></div>
        </form>
        <!-- end formulario -->
        <?php echo $mensaje; ?>

    </div>
    <!-- END CONTENEDOR -->

    <?php include_once 'includes/footer.php'; ?>