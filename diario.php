<?php include 'includes/header.php'; ?>
<?php include 'controllers/diarioControlador.php';?>
<?php 
require_once 'validations/validaSesiones.php';
if (!sesionActiva()) {
    header("Location: index.php");
    exit();
 }
?>
<!-- CONTENEDOR -->
<div class="contenido-todo-diario">
    <!-- CONTENIDO DIARIO -->
    <!-- contenido capitulo -->
    <div class="contenidoDiario">
        <?php echo $diario; ?>
    </div>
    <!-- contenido categoria -->
    <div class="contenidoCategoria">
        <?php echo $categoria; ?>
    </div>
    <!-- contenido capitulos -->

    <?php if (is_array($todosCapitulos)) {
                        foreach ($todosCapitulos as $capitulo) {?>
    <div class="dato-capitulo">
        <?php echo $capitulo;?>
    </div>
    <?php }
                    }?>
</div>
<!-- END CONTENEDOR -->

<?php include 'includes/footer.php'; ?>