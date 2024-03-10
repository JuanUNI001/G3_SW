/*
  Recuerda que deshabilitar la opción "Enable foreign key checks" para evitar problemas a la hora de importar el script.
*/
DROP TABLE IF EXISTS `RolesUsuario`;
DROP TABLE IF EXISTS `Mensajes`;
DROP TABLE IF EXISTS `Roles`;
DROP TABLE IF EXISTS `Usuarios`;

CREATE TABLE IF NOT EXISTS `Roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `RolesUsuario` (
  `usuario` int(11) NOT NULL,
  `rol` int(11) NOT NULL,
  PRIMARY KEY (`usuario`,`rol`),
  KEY `rol` (`rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombreUsuario` varchar(30) COLLATE utf8mb4_general_ci NOT NULL UNIQUE,
  `password` varchar(70) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Mensajes` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `autor` int(11) NOT NULL,
      `mensaje` varchar(140) NOT NULL,
      `fechaHora` DATETIME NOT NULL,
      `idMensajePadre` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4  COLLATE=utf8mb4_general_ci;

ALTER TABLE `RolesUsuario`
  ADD CONSTRAINT `RolesUsuario_usuario` FOREIGN KEY (`usuario`) REFERENCES `Usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `RolesUsuario_rol` FOREIGN KEY (`rol`) REFERENCES `Roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Mensajes`
  ADD CONSTRAINT `Mensajes_mensaje` FOREIGN KEY (`idMensajePadre`) REFERENCES `Mensajes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Mensajes_autor` FOREIGN KEY (`autor`) REFERENCES `Usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;






-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 04-03-2024 a las 18:19:50
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `productos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `nombre` varchar(30) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `descripción` varchar(400) NOT NULL,
  `id` int(11) NOT NULL,
  `imagen` varchar(40) NOT NULL,
  `valoración` decimal(4,2) DEFAULT NULL,
  `num_valoraciones` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
