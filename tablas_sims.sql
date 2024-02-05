CREATE TABLE Usuario(
	idUsuario INT AUTO_INCREMENT,
	nomUsuario VARCHAR(30) NOT NULL UNIQUE,
	nombre VARCHAR(30) NOT NULL UNIQUE,
    correo VARCHAR(150) NOT NULL UNIQUE,
    clave VARCHAR(255) NOT NULL,
    sal VARCHAR(255) NOT NULL,
    token VARCHAR(255) NULL UNIQUE,
    foto LONGBLOB NULL,
    descripcion VARCHAR(600) NULL,
    fechaCreacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    activo TINYINT(1) DEFAULT '0',
    rol VARCHAR(10) NOT NULL DEFAULT 'Usuario',
	PRIMARY KEY(idUsuario)
);

CREATE TABLE Diario(
	idDiario INT AUTO_INCREMENT,
    idUsuario INT NOT NULL,
    nombreDiario VARCHAR(30) NOT NULL,
    fechaCreacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fechaActualizacion TIMESTAMP NULL,
    descripccion TEXT NULL,
    puntoPrimedio FLOAT(2,1) NULL,
    favoritoTotal INT NULL,
    visible TINYINT(1) DEFAULT '1',
    PRIMARY KEY(idDiario),
    FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
);

CREATE TABLE Capitulo(
	idCapitulo INT AUTO_INCREMENT,
    idDiario INT NOT NULL,
    titulo VARCHAR(30) NULL,
    imagen LONGBLOB NULL,
    parrafo VARCHAR(600) NULL,
    fechaCreacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(idCapitulo),
    FOREIGN KEY(idDiario) REFERENCES diario(idDiario)
);

CREATE TABLE Categoria(
	idCategoria INT AUTO_INCREMENT,
    descripcion VARCHAR(10),
    PRIMARY KEY(idCategoria)
);

CREATE TABLE CategoriaDiario(
	idCategoriaDiario INT AUTO_INCREMENT UNIQUE,
    idDiario INT NOT NULL,
    idCategoria INT NOT NULL,
    PRIMARY KEY(idDiario,idCategoria),
    FOREIGN KEY(idDiario)REFERENCES diario(idDiario),
    FOREIGN KEY(idCategoria)REFERENCES categoria(idCategoria)
);

CREATE TABLE Reporte(
	idReporte INT AUTO_INCREMENT,
    idUsuario INT NOT NULL,
    descripcion VARCHAR(600) NOT NULL,
    fechaReporte TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	lugarReporte VARCHAR(30) NOT NULL,
    PRIMARY KEY(idReporte),
    FOREIGN KEY(idUsuario)REFERENCES usuario(idUsuario)
);

CREATE TABLE Foro(
	idForo INT AUTO_INCREMENT,
    titulo VARCHAR(30) NOT NULL,
    descripcion VARCHAR(600) NULL,
    totalTemas INT NULL,
    totalMensajes INT NULL,
    PRIMARY KEY(idForo)
);

CREATE TABLE Tema(
	idTema INT AUTO_INCREMENT,
    idUsuario INT NOT NULL,
    titulo VARCHAR(30) NOT NULL,
    descripcion VARCHAR(600) NULL,
    totalMensajes INT NULL,
    fechaPublicacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(idTema),
    FOREIGN KEY(idUsuario)REFERENCES usuario(idUsuario)
);


CREATE TABLE Mensaje(
	idMensaje INT AUTO_INCREMENT,
    idUsuario INT NOT NULL,
    descripcion VARCHAR(600) NULL,
    fechaPublicacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(idMensaje),
    FOREIGN KEY(idUsuario)REFERENCES usuario(idUsuario)
);


INSERT INTO categoria(descripcion)VALUES
    ('Acción'),
    ('Aventura'),
    ('Amor'),
    ('Terror'),
    ('Misterio'),
    ('Fantasia'),
    ('Drama'),
    ('Boys Love'),
    ('Girls Love')


