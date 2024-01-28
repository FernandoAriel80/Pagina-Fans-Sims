SELECT *
FROM usuarios_productos up
INNER JOIN usuarios u ON u.idUsuario = up.idUsuario
INNER JOIN productos p ON p.idProducto = up.idProducto;