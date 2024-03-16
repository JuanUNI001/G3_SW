--esto es recomendacion del profesor pero no tengo muy claro de que hay que hacer aqui
--puede que poner los keys
--creacion de usuario,bd y asignacion de privilegios (correo del profe)

-- Creación de usuario
CREATE USER 'sw'@'localhost' IDENTIFIED BY '';

-- Creación de base de datos
CREATE DATABASE MesaMaestra;

-- Asignación de privilegios al usuario sobre la base de datos
GRANT ALL PRIVILEGES ON productos.* TO 'sw'@'localhost';

-- Actualización de privilegios
FLUSH PRIVILEGES;