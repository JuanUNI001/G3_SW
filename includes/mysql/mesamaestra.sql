-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-03-2024 a las 10:05:30
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
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE IF NOT EXISTS `mensajes`  (
  `id` int(11) NOT NULL,
  `autor` int(11) NOT NULL,
  `mensaje` varchar(140) NOT NULL,
  `fechaHora` datetime NOT NULL,
  `idMensajePadre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `autor`, `mensaje`, `fechaHora`, `idMensajePadre`) VALUES
(1, 1, 'Bienvenido al foro', '2024-03-10 12:29:58', NULL),
(2, 2, 'Muchas gracias', '2024-03-10 12:44:58', 1),
(3, 2, 'Otro mensaje', '2024-03-11 13:44:58', NULL);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_productos`
--

CREATE TABLE `pedidos_productos` (
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('Parchís y Oca, 2 en 1', 19.99, 'Juego de parchís por un lateral y la oca por el otro. Genial juego para disfrutar en familia o con amigos', 1, 'images/parchis_oca.png', 4.50, 451, 565),
('Preguntados', 19.99, 'Juego de mesa Preguntados. El juego viral de móvil ya tiene juego físico. Disfruta con tus amigos con las nuevas preguntas del momento.\r\n', 2, 'images/preguntados.png', 4.76, 124, 12),
('Quién es quién', 15.75, 'Juego Quién es quién. ¿Sabrías adivinar qué personaje es tu oponente con solo preguntas de si y no? \r\nPonte a prueba', 3, 'images/quien.png', 3.75, 45, 2),
('Érase una vez', 27.90, 'Juego Érase una vez. Perfecto para rememorar la famosa serie infantil y aprender en el proceso.', 4, 'images/erase.png', NULL, 458, 56),
('Laberinto', 34.80, 'Juego de mesa Laberinto.\r\nRecorre el laberinto en busca de los tesoros más preciados… pero atención: ¡encontrar la via d\'uscita no será nada fácil.\r\nMateriales de óptima calidad; el juego contiene: 1 tablero, 34 piezas móviles de laberinto, 24 cartas de objetivo «día», 4 peones, 12 cartas de objetivo cuadradas «noche»\r\n', 5, 'images/laberinto.png', 4.20, 4523, 598),
('Exploding Kittens', 19.40, 'Exploding Kittens es un juego rápido y divertido en el que tienes que asegurar tu supervivencia ante los temibles ¡gatos explosivos! Un juego de cartas en el que hasta cinco jugadores hacen todo lo posible por fastidiar a los rivales hasta conseguir que caigan eliminados', 6, 'images/explodingKittens.png', 3.85, 4789, 23),
('Cluedo', 22.35, 'Divertido juego familiar: ¿Recuerdas jugar el clásico juego Cluedo cuando era un niño? Saca el juego Cluedo Liars Edition para la noche de juego familiar, citas de juego y entretenimiento en días lluviosos. A partir de 8 años', 7, 'images/cluedo.png', 4.63, 89654, 78);

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
(3, '$2y$10$l2H/VbMmJMadMfOvL38rVO4rHkOw36S/BRhU4EYrRPwqWxwKn3PJ2', 'Josh Tyler', 'joshTyler@gmail.com', 3, 4.75, 25.25, 'images/JoshTyler.png');



-- --------------------------------------------------------

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Mensajes_mensaje` (`idMensajePadre`),
  ADD KEY `Mensajes_autor` (`autor`);

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
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `Mensajes_autor` FOREIGN KEY (`autor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Mensajes_mensaje` FOREIGN KEY (`idMensajePadre`) REFERENCES `mensajes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `pedidos_productos`
--
ALTER TABLE `pedidos_productos`
  ADD CONSTRAINT `pedidos_productos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  ADD CONSTRAINT `pedidos_productos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 26-03-2024 a las 13:23:08
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
(1, 10, 'Deportes', 50, 'Ajedrez', 'La jugabilidad de LOL se centra en ser lo más \"imaginativo, inteligente y divertido posible con tus amigos\".1​ El juego es solo multijugador y requiere entre dos y cuatro jugadores para participar. Aunque cada jugador debe tener su propia Nintendo DS, solo se necesita una copia del juego. En el juego, el anfitrión hace una pregunta o les dice a los demás que dibujen algo y todos los jugadores tienen que escribir o dibujar lo que se les pide dentro de un límite de tiempo. Por ejemplo, el anfitrión puede preguntar a los jugadores \"¿Qué significa M.B.E.?\" o \"¿Por qué diablos estamos jugando a este juego?\"1​', '2024-04-10', 'Estadio Municipal', 'Abierto', 'Play station 5', NULL, 20.00),
(2, 5, 'Cultura', 50, 'Quizz cultura general', 'Luego, el anfitrión puede usar una herramienta de copia para comenzar a dibujar o escribir algo, lo que permite a los otros jugadores terminar la imagen parcialmente dibujada o la palabra escrita como respuesta. Después de que todos los jugadores hayan respondido, cada jugador vota sobre qué respuesta o imagen es la más divertida.2​ Cada jugador tiene tres votos y también puede votar una vez por sí mismo. No hay penalización por votar por uno mismo.3', '2024-05-15', 'Teatro Municipal', 'Abierto', 'Entradas VIP a Karol G', NULL, 10.00),
(3, 50, 'Deportes', 100, 'Circo del Sol', 'LOL, conocido en Europa como Bakushow y en Japón como Archime DS (ア ル キ メ ＤＳ, Arukime DS), es un videojuego de Nintendo DS. El juego fue publicado por Skip Ltd. en Japón, Agetec en Norteamérica y Rising Star Games en Europa. Desarrollado por un grupo de cinco personas encabezado por Kenichi Nishi, LOL es un juego multijugador implementado con una interfaz similar a PictoChat en la que un jugador anfitrión hace una pregunta, requiriendo que otros escriban o dibujen sus respuestas en la pantalla táctil de DS.', '2024-06-20', 'Gran Carpa', 'Terminado', 'Switch', 'Juan Pérez', 50.00),
(4, 8, 'Deportes', 40, 'En busca del tesoro', 'LOL fue desarrollado por un grupo de cinco personas en Route24. El juego fue diseñado por el ex vicepresidente de Skip, Kenichi Nishi, mejor conocido por dirigir Giftpia y Chibi-Robo!. LOL fue programado por Fumihiro Kanaya, quien trabajó en dos de los títulos de bit Generations de Skip. La obra de arte del juego fue realizada por hikarin y su música fue compuesta por Hirofumi Taniguchi.4​ El juego fue realizado por los miembros del personal del proyecto con un presupuesto muy bajo, sin que se les pague por ello, aparte de sus trabajos habituales.Error en la cita: La etiqueta de apertura <ref> es incorrecta o tiene el nombre mal Su objetivo era hacer el juego lo más simple posible.', '2024-07-05', 'Plaza de Sol', 'Abierto', 'Premio en efectivo', NULL, 15.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`idEvento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

