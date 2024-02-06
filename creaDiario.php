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
                <p>Crea tu diario contando de que se van a tratar tus historias o aventuras y las locuras que hacen tus
                    Sims.. :D</p>
                <!-- agrega formulario diario -->
                <form class="formulario-crea-diario" action=" " enctype="multipart/form-data" method="post">
                    <input type="text" name="tituloD" placeholder="Titulo del diario">
                    <input type="text" name="descripcionD" placeholder="Pequeña descripcion de que se trata tu diario ">
                    <div class="contenedor-categoria">
                        <h4>ELIJE LOS GENEROS DE TU DIARIO</h4>
                        <!-- agrega selector desde el controlador -->
                        <?php include 'controllers/creaDiarioControlador.php';?>
                        <?php echo $vistaCategoria?>
                    </div>
                    <!-- end formulario diario-->
                    <!-- agrega formulario entrada -->
                    <h2>CREA TU PRIMERA ENTRADA</h2>
                    <input type="text" name="tituloE" placeholder="Titulo de entrada">
                    <textarea name="contenidoE" rows="5" cols="40"
                        placeholder="escribe detalles de tu entrada"></textarea>
                    <div class="contenedor-imagen">
                        <input type="file" name="imagenE">
                    </div>
                    <div class="subYcheck">
                        <input title="Quieres que tu diario sea publico?" type="checkbox" id="check-diario"
                            name="checkD" value=" " checked>
                        <input type="submit" id="boton-crea-diario" value="Crear Diario" name="botonCrearDiario">
                    </div>
                </form>
                <!-- end formulario entrada-->


            </div>
            <!-- <input type="file" name="imagen" > -->
            <!-- END CONTENEDOR -->
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>