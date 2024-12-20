<?php include_once 'includes/header.php'; ?>

<?php 
require_once 'validations/validaSesiones.php';
if (!sesionActiva()) {
    header("Location: index.php");
    exit();
 }
?>

<!-- PORCION LEFT -->

</div>
<?php include_once 'controllers/editaPerfilControlador.php';?>
<!-- FINAL DE LA PORCION LEFT -->
<div class="contenedor-flex">

    <!-- CONTENEDOR -->
    <div class="contenedor-crea-diario">
        <h2>EDITA TU PERFIL</h2>
        <p>Edita tu diario contando de que se van a tratar tus historias o aventuras y las
            locuras
            que hacen tus
            Sims.. :D</p>
        <!-- agrega formulario diario -->
        <form class="formulario-edita-perfil" action=" " enctype="multipart/form-data" method="POST">
            <!-- agrega input desde el controlador -->
            <h4>Nombre</h4>
            <?php echo $vistaDato;?>

            <h4>Cambia Foto de Perfil</h4>
            <div class="imagenYboton">
                <div class="contenedor-imagen">
                    <input type="file" name="imagenP">
                </div>
                <div class="subYcheck">
                    <input type="submit" id="boton-edita-perfil" value="Edita" name="botonEditaPerfil">
                </div>
            </div>
            <div id="mensajeErrorCreaDiario" class="mensaje-error" value="" style="display: none;"></div>

        </form>
        <!-- end formulario -->
        <?php echo $mensaje; ?>
    </div>
    <!-- END CONTENEDOR -->

    <?php include_once 'includes/footer.php'; ?>