SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `mensajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idEmisor` int(11) NOT NULL,
  `idDestinatario` int(11) DEFAULT NULL,
  `idForo` int(11) DEFAULT NULL,
  `mensaje` varchar(200) NOT NULL,
  `fechaHora` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mensajes_idEmisor` (`idEmisor`),
  KEY `mensajes_idDestinatario` (`idDestinatario`),
  KEY `mensajes_idForo` (`idForo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `foros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(25) NOT NULL,
  `descripcion` varchar(25) NOT NULL,
  `autor_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `pedidos` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `total` float DEFAULT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `pedidos_productos` (
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pedido`,`id_producto`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `pedidos_productos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  CONSTRAINT `pedidos_productos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `productos` (
  `nombre` varchar(30) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `descripcion` varchar(400) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imagen` varchar(40) NOT NULL,
  `valoracion` decimal(4,2) DEFAULT NULL,
  `num_valoraciones` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `archivado` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(70) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `rolUser` int(11) NOT NULL,
  `valoracion` float DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `avatar` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rolUser` (`rolUser`),
  CONSTRAINT `fk_rolUser` FOREIGN KEY (`rolUser`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `seguir` (
  `idUsuario` int(11) NOT NULL,
  `idUsuarioSeguir` int(11) NOT NULL,
  UNIQUE KEY `unique_seguimiento` (`idUsuario`,`idUsuarioSeguir`),
  KEY `fk_usuario_seguir` (`idUsuarioSeguir`),
  CONSTRAINT `fk_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `fk_usuario_seguir` FOREIGN KEY (`idUsuarioSeguir`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `eventos` (
  `idEvento` int(11) NOT NULL AUTO_INCREMENT,
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
  `tasaInscripcion` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`idEvento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `inscritos` (
  `idEvento` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`idEvento`,`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `valoraciones` (
  `id_user` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `valoracion` float NOT NULL,
  `comentario` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

ALTER TABLE `eventos`
  MODIFY `idEvento` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `foros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

COMMIT;
