<?php include 'includes/header.php'; ?>
<?php 
require_once 'validations/validaSesiones.php';
if (!sesionActiva()) {
    header("Location: index.php");
    exit();
 }
?>
<?php include 'controllers/todosDiariosControlador.php';?>
<!-- CONTENEDOR -->
<div class="diario">
    <h4>PERFIL:</h4>
    <div class="elemento-diario">

        <p>Aqui encontraras tus diarios. Donde podras poner tus imagenes y las locuras que hacen tus Sims.
            <br>
            Esta es la lista de todos los diarios disponibles del momento.<br>
            No seas timido y pon el tuyo!.
        </p>

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
<!-- separador -->

<!-- END CONTENEDOR -->

<?php include 'includes/footer.php'; ?>