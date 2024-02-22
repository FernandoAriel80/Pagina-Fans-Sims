<?php include 'includes/header.php'; ?>
<?php include 'controllers/diarioControlador.php';?>
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
                <div class="dato-capitulo">
                    <?php echo $capitulo; ?>
                </div>
                <div class="dato-capitulo">
                    <?php echo $capitulo; ?>
                </div>
                    
            
            </div>
            <!-- END CONTENEDOR -->
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>