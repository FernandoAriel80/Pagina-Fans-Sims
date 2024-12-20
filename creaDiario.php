<?php include_once 'includes/header.php'; ?>

<?php 
/* if (!sesionActiva()) {
    header("Location: index.php");
    exit();
 } */
?>

<!-- PORCION LEFT -->

</div>
<?php include_once 'controllers/creaDiarioControlador.php';?>
<!-- FINAL DE LA PORCION LEFT -->
<div class="contenedor-flex">
    <!-- CONTENEDOR -->
    <div class="contenedor-crea-diario">
        <h2>CREA TU DIARIO</h2>
        <p>Crea tu diario contando de que se van a tratar tus historias o aventuras y las locuras que hacen tus
            Sims.. :D</p>
        <!-- agrega formulario diario -->
        <form class="formulario-crea-diario" action=" " enctype="multipart/form-data" method="POST">
            <input type="text" id="tituloD" name="tituloD" placeholder="Titulo del diario" required>
            <input type="text" id="descripcionD" name="descripcionD"
                placeholder="Pequeña descripcion de que se trata tu diario ">
            <div class="contenedor-categoria">
                <h4>ELIJE LOS GENEROS DE TU DIARIO</h4>
                <!-- agrega selector desde el controlador -->
                <?php echo $vistaCategoria?>
            </div>
            <!-- end formulario diario-->
            <!-- agrega formulario entrada -->
            <h2>CREA TU PRIMERA ENTRADA</h2>
            <input type="text" id="tituloE" name="tituloE" placeholder="Titulo de entrada" required>
            <textarea id="contenidoE" name="contenidoE" rows="5" cols="40"
                placeholder="escribe detalles de tu entrada"></textarea>
            <div class="imagenYboton">
                <div class="contenedor-imagen">
                    <input type="file" name="imagenE">
                </div>
                <div class="subYcheck">
                    <input checked title="Quieres que tu diario sea publico?" type="checkbox" id="check-diario"
                        name="checkD">
                    <input type="submit" id="boton-crea-diario" value="Crear Diario" name="botonCrearDiario">
                </div>
            </div>
            <div id="mensajeErrorCreaDiario" class="mensaje-error" value="" style="display: none;"></div>
        </form>
        <!-- end formulario entrada-->
        <?php echo $mensaje; ?>

    </div>
    <!-- <input type="file" name="imagen" > -->
    <!-- END CONTENEDOR -->

    <?php include_once 'includes/footer.php'; ?>