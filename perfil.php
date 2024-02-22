<?php include 'includes/header.php'; ?>
<?php include 'controllers/perfilControlador.php';?>
<?php 
require_once 'validations/validaSesiones.php';
if (!sesionActiva()) {
    header("Location: index.php");
    exit();
 }

?>
<main>
    <div class="contenedor-main-flex">
        <?php include 'includes/Left.php'; ?>
        <div class="contenedor-flex">
            <!-- CONTENEDOR -->
            <div class="diario">
                <!-- perfil -->
                <?php echo$perfil;?>
                <!-- perfil end -->
                <div class="elemento-diario">
                    <!-- cada diario  -->
                    <?php if (is_array($misDiarios)) {
                        foreach ($misDiarios as $diario) {
                            echo $diario;
                          }
                    }?>
                    <!-- cada diario end  -->
                </div>
                <h4>TODOS LOS DIARIOS:</h4>
                <div class="elemento-diario">
                    <!-- cada diario  -->
                    <?php if (is_array($todosDiarios)) {
                        foreach ($todosDiarios as $diario) {
                            echo $diario;
                          }
                    }?>
                    <!-- cada diario end  -->
                </div>
            </div>

             <!-- END CONTENEDOR -->
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>