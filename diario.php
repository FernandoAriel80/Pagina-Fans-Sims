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
            <h4>DIARIOS:</h4>
            <p>Aqui encontraras tus diarios. Donde podras poner tus imagenes y las locuras que hacen tus Sims. <br>
                Esta es la lista de todos los diarios disponibles del momento.<br>
                No seas timido y pon el tuyo!.</p>
            <h4>DIARIOS MAS POPULARES</h4>
            <div class="elemento">
                <div class="diario">
                    <h4>Mi primer diario</h4>
                    <div class="diario-datos">
                        <div>Fecha creacion: 23-06-1995</div>
                        <div>Fecha actualizacion: 3-07-1995</div>
                        <div>Puntaje: 4.5</div>
                        <div>Autor: KaoPlox </div>
                    </div>
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
        </div>
</main>

<?php include 'includes/footer.php'; ?>