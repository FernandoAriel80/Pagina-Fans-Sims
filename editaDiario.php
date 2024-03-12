<?php include 'includes/header.php'; ?>

<?php 
require_once 'validations/validaSesiones.php';
if (!sesionActiva()) {
    header("Location: index.php");
    exit();
 }
?>
<?php include 'controllers/editaDiarioControlador.php';?>
<!-- PORCION LEFT -->

</div>

<!-- FINAL DE LA PORCION LEFT -->
<div class="contenedor-flex">

    <!-- CONTENEDOR -->
    <div class="contenedor-crea-diario">
        <h2>EDITA TU DIARIO</h2>
        <p>Edita tu diario "<?php echo $diario?>" contando de que se van a tratar tus historias o aventuras y las
            locuras
            que hacen tus
            Sims.. :D</p>
        <!-- agrega formulario diario -->
        <form class="formulario-crea-diario" action=" " enctype="multipart/form-data" method="POST">
            <!-- agrega input desde el controlador -->
            <?php echo $vistaTituloYDescripcion?>
            <div class="contenedor-categoria">
                <h4>ELIJE LOS GENEROS DE TU DIARIO</h4>
                <!-- agrega selector desde el controlador -->
                <?php echo $vistaCategoria?>
            </div>
            <div class="subYcheck">
                <!-- agrega checkBox desde el controlador -->
                <?php echo $vistaCheck?>
                <input type="submit" id="boton-crea-diario" value="Edita Diario" name="botonEditaDiario">
            </div>
            <div id="mensajeErrorCreaDiario" class="mensaje-error" value="" style="display: none;"></div>
        </form>
        <!-- end formulario -->
        <?php echo $mensaje; ?>
    </div>
    <!-- END CONTENEDOR -->

    <?php include 'includes/footer.php'; ?>