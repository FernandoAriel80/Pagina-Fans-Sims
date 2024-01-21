<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Título de tu página perdo</title>

    <!--enlace archivo CSS -->

    <link rel="stylesheet" href="public/CSS/styles.css">

    <!-- Agrega enlaces a tus hojas de estilo CSS aquí si es necesario -->
</head>

<body>

    <header>

        <div class="contenedor-titulo">
            <div class="circulo">
                <div class="imagen-sims"></div>
                <div class="miniCirculo" onclick="mostrarFormulario()">
                    <div class="imagen-linas">
                    </div>
                </div>
            </div>
            <div class="rectangulo">
                <div class="contenedor-icono">
                    <!-- contenido de buscador -->
                </div>
            </div>
        </div>

    </header>

    <main>

        <!-- <button id="toggle-button">☰ Menú</button> <div class="menu"> <ul class="menu-list"> 
    <li><a href="#">Inicio</a></li> <li><a href="#">Acerca de</a></li> <li><a href="#">Servicios</a></li> 
    <li><a href="#">Contacto</a></li> </ul> </div> -->
        <!-- Contenido principal de tu página -->

        <div class="contenedor-main-flex">
            <div class="contenedor-izquierdo-flex" id="contenedor-formulario">
                <div class="contenedor-cosas">
                    <div class="contenedor-cosas-arriba">
                        <div class="contenedor-cosas-imagen"></div>
                    </div>
                    <div class="contenedor-cosas-abajo">
                        <form class="formulario">
                            <!-- Tus campos de formulario aquí -->
                            <input type="text" id="nombre" name="nombre" placeholder="nombre">
                            <input type="email" id="email" name="email" placeholder="email">
                            <input type="submit" value="" class="boton-enviar">
                        </form>
                    </div>
                </div>
                <div class="contenedor-cosas">
                    <div class="contenedor-cosas-arriba"></div>
                    <div class="contenedor-cosas-abajo"></div>
                </div>
            </div>

            <div class="contenedor-diarios-flex">
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

    <footer>
        <!-- Pie de página, puede contener información de contacto, enlaces adicionales, etc. -->
        <p>&copy; 2023 Nombre de tu Sitio. Todos los derechos reservados.</p>
    </footer>

    <!-- Agrega enlaces a tus scripts de JavaScript aquí si es necesario -->
    <script src="public/JS/app.js"></script>
</body>

</html>