CREATE TABLE Usuario(
	idUsuario INT AUTO_INCREMENT,
	nomUsuario VARCHAR(30) NOT NULL UNIQUE,
	nombre VARCHAR(30) NOT NULL UNIQUE,
    correo VARCHAR(150) NOT NULL UNIQUE,
    clave VARCHAR(255) NOT NULL,
    sal VARCHAR(255) NOT NULL,
    token VARCHAR(255) NULL UNIQUE,
    foto VARCHAR (200) NULL,
    descripcionUsuario VARCHAR(600) NULL,
    fechaCreacionUsuario TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    activo TINYINT(1) DEFAULT '0',
    rol VARCHAR(10) NOT NULL DEFAULT 'Usuario',
	PRIMARY KEY(idUsuario)
);

CREATE TABLE Diario(
	idDiario INT AUTO_INCREMENT,
    idUsuario INT NOT NULL,
    tituloDiario VARCHAR(30) NOT NULL,
    fechaCreacionDiario TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fechaActualizacionDiario TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    descripcionDiario TEXT NULL,
    puntoPromedio INT NULL,
    visible TINYINT(1) DEFAULT '1',
    PRIMARY KEY(idDiario),
    FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
);

CREATE TABLE Capitulo(
	idCapitulo INT AUTO_INCREMENT,
    idDiario INT NOT NULL,
    tituloCapitulo VARCHAR(30) NULL,
    imagenCapitulo VARCHAR (200) NULL,
    parrafo VARCHAR(600) NULL,
    fechaCreacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(idCapitulo),
    FOREIGN KEY(idDiario) REFERENCES diario(idDiario)
);

CREATE TABLE Categoria(
	idCategoria INT AUTO_INCREMENT,
    descripcionCategoria VARCHAR(10),
    PRIMARY KEY(idCategoria)
);

CREATE TABLE CategoriaDiario(
	idCategoriaDiario INT AUTO_INCREMENT,
    idDiario INT NOT NULL,
    idCategoria INT NOT NULL,
    PRIMARY KEY(idDiario,idCategoria),
    FOREIGN KEY(idDiario)REFERENCES diario(idDiario),
    FOREIGN KEY(idCategoria)REFERENCES categoria(idCategoria)
);

CREATE TABLE Reporte(
	idReporte INT AUTO_INCREMENT,
    idUsuario INT NOT NULL,
    descripcionReporte VARCHAR(600) NOT NULL,
    fechaReporte TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	lugarReporte VARCHAR(30) NOT NULL,
    PRIMARY KEY(idReporte),
    FOREIGN KEY(idUsuario)REFERENCES usuario(idUsuario)
);

CREATE TABLE Foro(
	idForo INT AUTO_INCREMENT,
    tituloForo VARCHAR(30) NOT NULL,
    descripcionForo VARCHAR(600) NULL,
    totalTemas INT NULL,
    totalMensajes INT NULL,
    PRIMARY KEY(idForo)
);

CREATE TABLE Tema(
	idTema INT AUTO_INCREMENT,
    idUsuario INT NOT NULL,
    tituloTema VARCHAR(30) NOT NULL,
    descripcionTema VARCHAR(600) NULL,
    totalMensajes INT NULL,
    fechaPublicacionTema TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(idTema),
    FOREIGN KEY(idUsuario)REFERENCES usuario(idUsuario)
);


CREATE TABLE Mensaje(
	idMensaje INT AUTO_INCREMENT,
    idUsuario INT NOT NULL,
    descripcionMensaje VARCHAR(600) NULL,
    fechaPublicacionMensaje TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(idMensaje),
    FOREIGN KEY(idUsuario)REFERENCES usuario(idUsuario)
);

CREATE TABLE Puntaje (
    idPuntajes INT AUTO_INCREMENT,
    idUsuario INT NOT NULL,
    idDiario INT NOT NULL,
    puntajeDato INT NOT NULL,
    fecha_puntaje TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(idPuntajes),
    FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario),
    FOREIGN KEY (idDiario) REFERENCES diario(idDiario)
);

CREATE TABLE Favorito (
    idFavoritos INT AUTO_INCREMENT,
    idUsuario INT NOT NULL,
    idDiario INT NOT NULL,
    PRIMARY KEY(idFavoritos),
    fechaCreacionFavorito TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario),
    FOREIGN KEY (idDiario) REFERENCES diario(idDiario)
);

INSERT INTO Categoria(descripcionCategoria)VALUES
    ('Acción'),
    ('Aventura'),
    ('Romance'),
    ('Comedia'),
    ('Terror'),
    ('Misterio'),
    ('Fantasia'),
    ('Drama'),
    ('Boys Love'),
    ('Girls Love')

