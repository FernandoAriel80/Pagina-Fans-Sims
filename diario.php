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
            <div class="diario-container">
                <!-- CONTENIDO DIARIO -->
                <div class="contenidoDiario">
                    <h2>Título del Diario</h2>
                    <p>Historia del diario...</p>
                    <div class="botonesDiario">
                        <button class="boton-modificar">Modificar</button>
                        <button class="boton-favorito">Favorito</button>
                    </div>
                    <div class="puntuacion">
                        <label for="puntuacion">Puntuación:</label>
                        <input type="number" id="puntuacionD" name="puntuacionD" min="0" max="10" step="1">
                    </div>
                </div>
                <div class="imagenDiario">
                    <img src="ruta/a/la/imagen.jpg" alt="Imagen del Diario">
                </div>
            </div>
            <!-- END CONTENEDOR -->
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>