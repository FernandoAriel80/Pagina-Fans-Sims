<?php include 'includes/header.php'; ?>

<?php 
require_once 'validations/validaSesiones.php';
if (!sesionActiva()) {
    header("Location: index.php");
    exit();
 }
?>

<!-- PORCION LEFT -->

</div>
<?php include 'controllers/diarioControlador.php';?>
<!-- FINAL DE LA PORCION LEFT -->
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

        <?php if (is_array($todosCapitulos)) {
                        foreach ($todosCapitulos as $capitulo) {?>
        <div class="dato-capitulo">
            <?php echo $capitulo;?>
        </div>
        <?php }
                    }?>

        <!-- puntos -->
        <div class="contenedor-puntos">
            <div class="puntos">
                <h4>Tu puntuacion:</h4>
                <?php echo $misPuntos;?>
            </div>
            <div class="rating">
                <form class="" action="" method="POST">
                    <div class="rating">
                        <label class="ratingNum">5</label>
                        <label class="ratingNum">4</label>
                        <label class="ratingNum">3</label>
                        <label class="ratingNum">2</label>
                        <label class="ratingNum">1</label>
                    </div>
                    <div class="rating">
                        <input type="radio" id="star5" name="punto" value="5">
                        <input type="radio" id="star4" name="punto" value="4">
                        <input type="radio" id="star3" name="punto" value="3">
                        <input type="radio" id="star2" name="punto" value="2">
                        <input type="radio" id="star1" name="punto" value="1">
                    </div>
                    </br>
                    <input type="submit" value="Calificar Diario" name="botonCalificar">
                </form>
            </div>
            <div class="puntos">
                <h4>Puntuacion del Diario:</h4>
                <?php echo $totalPuntos;?>
            </div>
        </div>



        <!-- END CONTENEDOR -->

        <?php include 'includes/footer.php'; ?>