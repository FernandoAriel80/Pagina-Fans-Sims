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

            <div class="contenedor-crea-diario">
                <h2>CREA TU DIARIO</h2>
                <p>Crea tu diario contando de que se van a tratar tus historias o aventuras,
                    para despues poder crear los capitulos de tu diario donde podras poner tus
                    imagenes y las locuras que hacen tus Sims.. :D</p>

                     <!-- agrega formulario -->
                <form class="formulario-crea-diario" action=" " method="post">
                    <input type="text" name="tituloD" placeholder="Titulo del diario">
                    <textarea name="contenidoD" rows="5" cols="40"
                        placeholder="escribe detalles de tu diario"></textarea>
                    <div class="contenedor-categoria">
                    <!-- agrega selector desde el controlador -->
                        <?php include 'controllers/creaDiarioControlador.php';?>
                        <?php echo $vistaCategoria?>
                    </div>
                    <div class="subYcheck">
                        <input title="Quieres que tu diario sea publico?" type="checkbox" id="check-diario"
                            name="checkD" value=" " checked>
                        <input type="submit" id="boton-crea-diario" value="Crear Diario" name="botonCrearDiario">
                    </div>
                </form>

                <!-- end formulario -->
            </div>
            <!-- <input type="file" name="imagen" > enctype="multipart/form-data"-->
            <!-- END CONTENEDOR -->
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>