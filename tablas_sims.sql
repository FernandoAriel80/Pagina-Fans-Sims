CREATE TABLE Usuario(
	idUsuario INT AUTO_INCREMENT,
	usuario VARCHAR(30) NOT NULL UNIQUE,
	token VARCHAR(255) NOT NULL UNIQUE,
	nombre VARCHAR(30) NOT NULL UNIQUE,
    foto LONGBLOB NULL,
    descripcion VARCHAR(600) NULL,
    fechaCreacion DATE NOT NULL,
    activo TINYINT(1) DEFAULT 2,
    correo VARCHAR(150) NOT NULL UNIQUE,
    clave VARCHAR(255) NOT NULL,
    sal VARCHAR(255) NOT NULL,
    rol VARCHAR(10) NOT NULL,
	PRIMARY KEY(idUsuario)
);

CREATE TABLE Diario(
	idDiario INT AUTO_INCREMENT,
    idUsuario INT NOT NULL,
    nombreDiario VARCHAR(30) NOT NULL,
    fechaCreacion DATE NOT NULL,
    fechaActualizacion DATE NULL,
    descripccion VARCHAR(600) NULL,
    puntoPrimedio FLOAT(2,1) NULL,
    favoritoTotal INT NULL,
    visible TINYINT(1) DEFAULT 1,
    PRIMARY KEY(idDiario),
    FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
);

CREATE TABLE Capitulo(
	idCapitulo INT AUTO_INCREMENT,
    idDiario INT NOT NULL,
    titulo VARCHAR(30) NULL,
    imagen LONGBLOB NULL,
    parrafo VARCHAR(600) NULL,
    fechaCreacion DATETIME,
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
    fechaReporte DATETIME NOT NULL,
	logarReporte VARCHAR(30) NOT NULL,
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
    fechaPublicacion DATETIME NOT NULL,
    PRIMARY KEY(idTema),
    FOREIGN KEY(idUsuario)REFERENCES usuario(idUsuario)
);


CREATE TABLE Mensaje(
	idMensaje INT AUTO_INCREMENT,
    idUsuario INT NOT NULL,
    descripcion VARCHAR(600) NULL,
    fechaPublicacion DATETIME NOT NULL,
    PRIMARY KEY(idMensaje),
    FOREIGN KEY(idUsuario)REFERENCES usuario(idUsuario)
);



