/* SELECT *
FROM usuarios_productos up
INNER JOIN usuarios u ON u.idUsuario = up.idUsuario
INNER JOIN productos p ON p.idProducto = up.idProducto;

INSERT INTO categoria(descripcion)VALUES
    ('Acción'),
    ('Aventura'),
    ('Amor'),
    ('Terror'),
    ('Misterio'),
    ('Fantasia'),
    ('Drama'),
    ('Boys Love'),
    ('Girls Love') */


/* DELIMITER //

CREATE PROCEDURE verificarUsuario(
    IN tituloDiario VARCHAR(50),
    IN descripcion VARCHAR(300),
    IN checkDiario TINYINT(1),
    IN correo_electronico VARCHAR(100),
    IN correo_electronico VARCHAR(100),
    IN correo_electronico VARCHAR(100),
    OUT resultado VARCHAR(100)
)
BEGIN
    DECLARE contador INT;

    -- Verifica si el usuario ya existe en la base de datos
    SELECT COUNT(*) INTO contador FROM usuarios WHERE nombre = nombre_usuario AND email = correo_electronico;

    -- Define el resultado en base a la existencia del usuario
    IF contador > 0 THEN
        SET resultado = 'El usuario ya existe en la base de datos.';
    ELSE
        SET resultado = 'El usuario no existe en la base de datos.';
    END IF;
END //

DELIMITER ; */


CREATE TABLE puntajes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_diario INT,
    puntaje INT,
    fecha_puntaje TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_diario) REFERENCES diarios(id)
);

CREATE TABLE favoritos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_diario INT,
    fecha_favorito TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_diario) REFERENCES diarios(id)
);