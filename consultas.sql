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


/* 
SELECT * FROM diario JOIN
Usuario ON Usuario.idUsuario = Diario.idUsuario JOIN
CategoriaDiario ON CategoriaDiario.idDiario = Diario.idDiario
WHERE diario.visible = 1
GROUP BY diario.idDiario
ORDER BY diario.fechaActualizacion DESC */