<div class="contenedor-izquierdo-flex" id="contenedor-formulario">
    <div class="contenedor-cosas">
        <div class="contenedor-cosas-arriba">
            <div class="contenedor-cosas-imagen-login"></div>
        </div>
        <!--////////////////////////////////////////////////////////////////////////////// -->
        <!--formularios aquí (login, registrar)-->
        <div class="contenedor-cosas-abajo">
            <form method="" class="formulario-login" action="post">
                <!-- Campos de formulario aquí -->
                <input type="text" id="usuarioL" name="usuarioL" placeholder="Usuario">
                <input type="password" id="contraseñaL" name="contraseñaL" placeholder="Contraseña">
                <input type="submit" value="" class="boton-login" name="botonLogin">
                <div id="mensajeErrorLogin" class="mensaje-error" value="" style="display: none;"></div>
            </form>
        </div>
    </div>
    <div class="contenedor-cosas">
        <form class="formulario-nav-registro" action=" " method="post">
            <input type="submit" value="" class="boton-nav-registrar" name="botonNavRegistrar">
        </form>
    </div>
    <!--////////////////////////////////////////////////////////////////////////////// -->
    <!--otras cosas aquí -->
    <div class="contenedor-cosas">
        <div class="contenedor-cosas-arriba">
            <div class="contenedor-cosas-imagen-registro"></div>
        </div>
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
    <!--////////////////////////////////////////////////////////////////////////////// -->
</div>