<?php include 'includes/header.php'; ?>

<main>
    <div class="contenedor-main-flex">
        <div class="contenedor-izquierdo-flex" id="contenedor-formulario">
            <div class="contenedor-cosas">
                <div class="contenedor-cosas-arriba">
                    <div class="contenedor-cosas-imagen"></div>
                </div>
                <div class="contenedor-cosas-abajo">
                    <form method="" class="formulario-login" action="post">
                        <!-- Campos de formulario aquí -->
                        <input type="text" id="usuarioL" name="usuarioL" placeholder="Usuario">
                        <input type="password" id="contraseñaL" name="contraseñaL" placeholder="Contraseña">
                        <input type="submit" value="" class="boton-login" name="botonLogin">
                        <div id="mensajeErrorLogin" class="mensaje-error" value="" style="display: none;"></div>
                    </form>
                    <div class="contenedor-cosas-abajo-nav">
                        <form class="formulario-nav-registro" action=" " method="post">
                            <!-- Otros campos del formulario aquí -->
                            <input type="submit" value="" class="boton-nav-registrar" name="botonNavRegistrar">
                        </form>
                        <form class="formulario-nav-perfil" action=" " method="post">
                            <!-- Otros campos del formulario aquí -->
                            <input type="submit" value="" class="boton-nav-perfil" name="botonNavPerfil">
                        </form>
                    </div>
                </div>
            </div>
            <div class="contenedor-cosas">
                <div class="contenedor-cosas-arriba">Registro</div>
                <div class="contenedor-cosas-abajo">
                    <form class="formulario-registro" action=" " method="post">
                        <!-- Campos de formulario aquí -->
                        <input type="text" id="nombreR" name="nombreR" placeholder="Nombre">
                        <input type="email" id="emailR" name="emailR" placeholder="Email">
                        <input type="text" id="usuarioR" name="usuarioR" placeholder="Usuario">
                        <input type="password" id="contraseñaR" name="contraseñaR" placeholder="Contraseña">
                        <input type="password" id="confirmarContraseñaR" name="confirmarContraseñaR"
                            placeholder="ConfirmarContraseña">
                        <input type="submit" value="" class="boton-registrar">
                        <div id="mensajeErrorRegistro" class="mensaje-error" value="" style="display: none;"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="contenedor-flex">

            <!-- <p>Dale un vistazo <a href="diario.html">freeCodeCamp</a>.</p> -->

        </div>
</main>

<?php include 'includes/footer.php'; ?>