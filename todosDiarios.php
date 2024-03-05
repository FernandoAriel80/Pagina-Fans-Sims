<?php include 'includes/header.php'; ?>
<?php 
require_once 'validations/validaSesiones.php';
if (!sesionActiva()) {
    header("Location: index.php");
    exit();
 }
?>
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
                    <div> <a href="perfil.php">KaoPlox</a></div>
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
<!-- separador -->
<h4>DIARIOS RECIENTES</h4>
<div class="elemento">
    <div class="diario">
        <h4>Mi segundo diario</h4>
        <div class="diario-datos">
            <div>Fecha creacion: 23-06-1996</div>
            <div>Fecha actualizacion: 3-07-1996</div>
            <div>Puntaje: 5.0</div>
            <div>Autor: KaoPlox </div>
        </div>
    </div>
    <div class="diario">
        <h4>diario perdo</h4>
        <div class="diario-datos">
            <div>Fecha creacion: 25-06-2000</div>
            <div>Fecha actualizacion: 13-07-2001</div>
            <div>Puntaje: 2.5</div>
            <div>Autor: PerRuiz </div>
        </div>
    </div>
</div>
<!-- END CONTENEDOR -->

<?php include 'includes/footer.php'; ?>