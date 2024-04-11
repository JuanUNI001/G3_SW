-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 11-04-2024 a las 10:18:07
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
-- Base de datos: `mesamaestra`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `idEvento` int(11) NOT NULL,
  `inscritos` int(11) DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `numJugadores` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `lugar` varchar(255) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `premio` varchar(255) DEFAULT NULL,
  `ganador` varchar(255) DEFAULT NULL,
  `tasaInscripcion` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`idEvento`, `inscritos`, `categoria`, `numJugadores`, `nombre`, `descripcion`, `fecha`, `lugar`, `estado`, `premio`, `ganador`, `tasaInscripcion`) VALUES
(1, 10, 'Deportes', 50, 'Ajedrez', 'Torneo de ajedrez', '2024-04-10', 'Estadio Municipal', 'Abierto', 'Play station 5', NULL, 20.00),
(2, 5, 'Cultura', 50, 'Quizz cultura general', 'Quizz y Concierto de jazz en vivo', '2024-05-15', 'Teatro Municipal', 'Abierto', 'Entradas VIP a Karol G', NULL, 10.00),
(3, 50, 'Deportes', 100, 'Circo del Sol', 'Torneo de monopoli del circo del sol', '2024-06-20', 'Gran Carpa', 'Terminado', 'Switch', 'Juan Pérez', 50.00),
(4, 8, 'Deportes', 40, 'En busca del tesoro', 'Ginkana por madrid', '2024-07-05', 'Plaza de Sol', 'Abierto', 'Premio en efectivo', NULL, 15.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `idEmisor` int(11) NOT NULL,
  `idDestinatario` int(11) DEFAULT NULL,
  `idForo` int(11) DEFAULT NULL,
  `mensaje` varchar(200) NOT NULL,
  `fechaHora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `idEmisor`, `idDestinatario`, `idForo`, `mensaje`, `fechaHora`) VALUES
(1, 32, 51, NULL, 'Hola Jaime', '2024-03-10 12:29:58'),
(2, 51, 32, NULL, 'Hola Paula', '2024-03-10 12:31:00'),
(3, 32, 51, NULL, 'mensaje de prueba', '2024-03-10 12:31:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foros`
--

CREATE TABLE `foros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(25) NOT NULL,
  `autor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `foros`
--

INSERT INTO `foros` (`id`, `titulo`, `autor`) VALUES
(1, 'Foro sobre Poker', 'Paula'),
(2, 'Los locos por el Catan', 'jaime');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `total` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_user`, `estado`, `fecha`, `total`) VALUES
(1, 32, 'comprado', '2024-03-27', 19.99),
(2, 32, 'comprado', '2024-03-27', 39.39),
(7, 32, 'comprado', '2024-03-27', 15.75),
(8, 32, 'comprado', '2024-03-27', 111.75),
(9, 32, 'comprado', '2024-03-27', -19.99),
(14, 32, 'comprado', '2024-04-02', 208.8),
(15, 32, 'comprado', '2024-04-02', 661.04),
(16, 32, 'comprado', '2024-04-02', 31.5),
(17, 32, 'comprado', '2024-04-02', 362.4),
(18, 32, 'comprado', '2024-04-02', 167.4),
(19, 32, 'comprado', '2024-04-03', 119.94),
(20, 32, 'comprado', '2024-04-04', 223.2),
(22, 32, 'comprado', '2024-04-05', 457.58),
(23, 32, 'comprado', '2024-04-05', 55.8),
(26, 32, 'comprado', '2024-04-07', 116.4),
(27, 32, 'comprado', '2024-04-09', 236.34);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_productos`
--

CREATE TABLE `pedidos_productos` (
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos_productos`
--

INSERT INTO `pedidos_productos` (`id_pedido`, `id_producto`, `cantidad`) VALUES
(0, 1, 3),
(0, 2, 1),
(0, 3, 2),
(1, 1, 2),
(2, 2, 4),
(2, 6, 1),
(7, 3, 1),
(8, 7, 5),
(14, 5, 3),
(15, 2, 5),
(15, 5, 1),
(15, 6, 6),
(16, 3, 1),
(17, 4, 2),
(17, 5, 2),
(18, 4, 3),
(19, 1, 3),
(20, 4, 4),
(22, 1, 1),
(22, 5, 3),
(23, 4, 1),
(26, 6, 3),
(27, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `nombre` varchar(30) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `descripcion` varchar(400) NOT NULL,
  `id` int(11) NOT NULL,
  `imagen` varchar(40) NOT NULL,
  `valoracion` decimal(4,2) DEFAULT NULL,
  `num_valoraciones` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`nombre`, `precio`, `descripcion`, `id`, `imagen`, `valoracion`, `num_valoraciones`, `cantidad`) VALUES
('Parchís y Oca, 2 en 1', 19.99, 'Juego de parchís por un lateral y la oca por el otro. Genial juego para disfrutar en familia o con amigos', 1, 'images/parchis_oca.png', 4.50, 451, 536),
('Preguntados', 19.99, 'Juego de mesa Preguntados. El juego viral de móvil ya tiene juego físico. Disfruta con tus amigos con las nuevas preguntas del momento.\r\n', 2, 'images/preguntados.png', 4.76, 124, 0),
('Quién es quién', 15.75, 'Juego Quién es quién. ¿Sabrías adivinar qué personaje es tu oponente con solo preguntas de si y no? \r\nPonte a prueba', 3, 'images/quien.png', 3.75, 45, 0),
('Érase una vez', 27.90, 'Juego Érase una vez. Perfecto para rememorar la famosa serie infantil y aprender en el proceso.', 4, 'images/erase.png', 0.00, 458, 46),
('Laberinto', 34.80, 'Juego de mesa Laberinto.\r\nRecorre el laberinto en busca de los tesoros más preciados… pero atención: ¡encontrar la via d\'uscita no será nada fácil.\r\nMateriales de óptima calidad; el juego contiene: 1 tablero, 34 piezas móviles de laberinto, 24 cartas de objetivo «día», 4 peones, 12 cartas de objetivo cuadradas «noche»\r\n', 5, 'images/laberinto.png', 4.20, 4523, 589),
('Exploding Kittens', 19.40, 'Exploding Kittens es un juego rápido y divertido en el que tienes que asegurar tu supervivencia ante los temibles ¡gatos explosivos! Un juego de cartas en el que hasta cinco jugadores hacen todo lo posible por fastidiar a los rivales hasta conseguir que caigan eliminados', 6, 'images/explodingKittens.png', 3.85, 4789, 13),
('Cluedo', 22.35, 'Divertido juego familiar: ¿Recuerdas jugar el clásico juego Cluedo cuando era un niño? Saca el juego Cluedo Liars Edition para la noche de juego familiar, citas de juego y entretenimiento en días lluviosos. A partir de 8 años', 7, 'images/cluedo.png', 4.63, 89654, 73);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'admin'),
(2, 'user'),
(3, 'profesor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `password` varchar(70) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `rolUser` int(11) NOT NULL,
  `valoracion` float DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `avatar` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `password`, `nombre`, `correo`, `rolUser`, `valoracion`, `precio`, `avatar`) VALUES
(1, '$2y$10$O3c1kBFa2yDK5F47IUqusOJmIANjHP6EiPyke5dD18ldJEow.e0eS', 'Administrador', 'admin@gmail.com', 1, NULL, NULL, NULL),
(2, '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user', 'user@gmail.com', 2, NULL, NULL, NULL),
(32, '$2y$10$q32AJBCGnO/WSjvkolrkxuJ8UeuQlE0kaKV7cXTqTk9OUsxe/bSVm', 'Paula', 'p@ucm.es', 2, NULL, NULL, NULL),
(50, '$2y$10$r4tKx.VndaEsQiMnkJ9A2.sgo5BEHgSN4d1ARu.f6JGXfzzAj5bRe', 'Josh Tyler', 'joshTyler@gmail.com', 3, 4.75, 34.55, 'images/JoshTyler.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`idEvento`);
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mensajes_idEmisor` (`idEmisor`),
  ADD KEY `mensajes_idDestinatario` (`idDestinatario`),
  ADD KEY `mensajes_idForo` (`idForo`);

--
-- Indices de la tabla `foros`
--
ALTER TABLE `foros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `pedidos_productos`
--
ALTER TABLE `pedidos_productos`
  ADD PRIMARY KEY (`id_pedido`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rolUser` (`rolUser`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `foros`
--
ALTER TABLE `foros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mensajes`
--

ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_idEmisor` FOREIGN KEY (`idEmisor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mensajes_idDestinatario` FOREIGN KEY (`idDestinatario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mensajes_idForo` FOREIGN KEY (`idForo`) REFERENCES `foros` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_rolUser` FOREIGN KEY (`rolUser`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
