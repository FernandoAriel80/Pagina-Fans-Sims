<?php include 'includes/header.php'; ?>
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
                <h4>DIARIOS:</h4>
                <div class="elemento-diario">

                    <div class="crea-diario">
                        <!-- autor -->
                        <div> <a href="creaDiario.php">CREA DIARIO</a></div>
                    </div>
                </div>
                <h4>DIARIOS MAS POPULARES</h4>
                <div class="elemento-diario">
                    <!-- cada diario  -->
                    <div class="cada-diario">
                        <div class="diario-datos">
                            <a href="">
                                <div class="diario-datos-arriba">
                                    <h4>Mi primer diario</h4>
                                </div>
                                <div class="diario-datos-abajo">
                                    <div>Fecha creacion: 23-06-1995</div>
                                    <div>Fecha actualizacion: 3-07-1995</div>
                                    <div>Puntaje: 4.5</div>
                                </div>
                            </a>
                        </div>
                        <div class="diario-derecho">
                            <div class="diario-autor">
                                <!-- autor -->
                                <div> <a href="">KaoPlox</a></div>
                            </div>
                            <div class="diario-fav">
                                <form class="formulario-diario-fav" action=" " method="post">
                                    <input type="submit" value="" class="boton-diario-fav" name="botonDiarioFav">
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- cada diario end  -->
                </div>
            </div>

             <!-- END CONTENEDOR -->
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>