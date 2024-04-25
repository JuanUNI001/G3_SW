/*
  Recuerda que deshabilitar la opción "Enable foreign key checks" para evitar problemas a la hora de importar el script.
*/

TRUNCATE TABLE `Roles`;
TRUNCATE TABLE `Usuarios`;


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
('Cluedo', 22.35, 'Divertido juego familiar: ¿Recuerdas jugar el clásico juego Cluedo cuando era un niño? Saca el juego Cluedo Liars Edition para la noche de juego familiar, citas de juego y entretenimiento en días lluviosos. A partir de 8 años', 7, 'images/cluedo.png', 4.63, 89654, 78),
('Disney Villainous', 52.00, 'Disney Villainous es para 2-6 jugadores y está recomendado para mayores de 10 años. Las dinámicas de juego se adaptan fácilmente a diferentes categorías de jugadores: expertos, principiantes, familias y entusiastas del universo Disney.\r\nDimensiones del producto: ‎27 x 27 x 8 cm; 1 g', 8, 'images/villanous.png', 4.70, 1150, 233),
('7 Wonders: Duel', 26.99, 'En 7 Wonders Duel cada jugador es el líder de una civilización que construirá Estructuras y erigirá Maravillas. Las Estructuras y las Maravillas construidas por cada jugador componen su «ciudad\r\nExisten 3 formas de ganar en 7 Wonders Duel: supremacía militar, supremacía científica y victoria civil\r\nSi al final de la tercera Era nadie ha conseguido ganar, los jugadores sumarán sus puntos de victori', 9, 'images/duel.png', 4.80, 1130, 45),
('Dixit', 26.45, '¡Juego de deducción, bellamente ilustrado, donde tu imaginación crea increíbles historias!\r\nEn este galardonado juego de mesa, los jugadores podrán utilizar la hermosa imaginería de sus cartas para engañar a sus rivales.\r\nDixit es un juego sorprendente, encantador y de reglas fáciles, para disfrutar con amigos y familiares por igual.\r\nDe 3 a 8 jugadores.', 10, 'images/dixit.png', 4.78, 840, 32),
('El impostor', 15.99, 'El impostor\', \'15.99\', \'UN DESTERNILLANTES JUEGO DE MÍMICA Si eres demasiado obvio, el Impostor adivinará fácilmente la palabra secreta y pasar desapercibido, si eres demasiado sutil, te arriesgas a ser acusado.\r\n¿SERÁS CAPAZ DE ENGARÑARLOS A TODOS? En cada ronda una persona, elegida al azar, deberá fingir y mantener la farsa hasta el final para lograr la victoria. ¿Conseguirás pasar desapercibido o el resto del grupo averiguará que eres el impostor?\r\nTIEMPO DE JUEGO ADAPTADO A TODOS LOS GUSTOS ¡Podrás jugar una ronda rápida de solo unos minutos de duración o alargar la diversión durante horas!', 11, 'images/impostor.png', 4.60, 543, 18),
('Unicornios congelados', 14.99, 'DIVERSIÓN EN TODA REGLA PARA TODA LA FAMILIA - Los más pequeños posa como un cangrejo. Mamá como una profesora de kárate. ¡¿El abuelo posando como un superhéroe?! Pero, ¿puedes adivinar de qué pretenden estar congelados? Unicornios Congelados es un juego súper divertido que encanta a todos sin importar la edad.\r\nSÉ CREATIVO Y A MOVERSE - A todos los jugadores se les dice de qué tienen que pretender congelarse en cada ronda, menos a uno de ellos. La habitación se transformará en un museo de estatuas absurdas, mientras que uno de los jugadores adivina de qué están congelados los demás. Con más de 100 cartas diferentes y tres categorías, Unicornios Congelados es el divertidísimo juego que hace ', 12, 'images/unicornios.png', 4.20, 345, 15),
('LITTLE SECRET', 25.99, 'Little Secret es un juego de mesa intuitivo de imaginación, asociación de palabras y código secreto. Cartas para fiestas con amigos o también para jugar en familia, tanto como con adultos como para peques.\r\nEl objetivo del juego de mesa : Tendrás que dar pistas sobre la palabras secreta de las cartas y descubrir a los infiltrados y al periodista de la Organización Secreta\r\n4-9 JUGADORES, 20 min de juego, + 10 años. ¡Descubre a los embusteros!  180 cartas, 300 palabras y 17 misiones', 13, 'images/littleSecret.png', 4.80, 4637, 240),
('Jenga', 22.50, '54 bloques de madera JENGA\r\nSe necesita habilidad, estrategia y suerte\r\nDesafíate a ti mismo o juega con amigos\r\nGanarás si eres el último jugador que quita un bloque sin que la pila se derrumbe\r\nIncluye soporte de montaje', 14, 'images/jenga.png', 4.90, 50392, 5302),
('UNO', 11.99, 'El clásico juego de cartas de emparejar colores y números.\r\nLas cartas especiales y los comodines le dan más diversión al juego.\r\nUsa la carta Intercambio de manos para cambiar todas tus cartas por las de otro jugador.\r\nEscribe tus propias reglas de juego con las cartas personalizables.\r\nLos jugadores se turnan para jugar una carta de su mano que coincida en color o número con la última carta de la pila de descarte.\r\n¡Y no olvides gritar “UNO” cuando te quede una sola carta en la mano!', 15, 'images/uno.png', 4.60, 67382, 3048),
('Dobble Clasico', 16.99, 'Juego de fiesta\r\nUn juego de velocidad, observación y reflejos\r\nEncuentra los símbolos iguales\r\nSin plástico, sin envoltorio\r\n57 símbolos\r\n5 minijuegos\r\n10 minutos de duración', 16, 'images/Dobble.png', 4.74, 10382, 5432),
('Virus', 14.79, 'Adictivo.\r\n Divertido.\r\n Fácil de llevar.\r\n Número de jugadores: 2 a 6 jugadores.', 17, 'images/virus.png', 3.78, 3924, 423),
('UNO All Wild', 11.99, 'Todas las cartas son comodines en UNO All Wild.\r\nEl juego se desarrolla más rápido sin tener que hacer coincidir colores o números como en el clásico UNO.\r\nTambién es más sorprendente gracias a las cartas de acción de la baraja.\r\nNo lo olvidéis, el jugador al que solo le quede una carta tiene que gritar UNO.\r\nEs un regalo perfecto para los fans de UNO a partir de 7 años.', 18, 'images/unoAllWild.png', 4.80, 82923, 28311);

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'admin'),
(2, 'user'),
(3, 'profesor');
--
-- Volcado de datos para la tabla `usuarios`
--
INSERT INTO `usuarios` (`id`, `password`, `nombre`, `correo`, `rolUser`, `valoracion`, `precio`, `avatar`) VALUES
(1, '$2y$10$O3c1kBFa2yDK5F47IUqusOJmIANjHP6EiPyke5dD18ldJEow.e0eS', 'Administrador', 'admin@gmail.com', 1, NULL, NULL, 'images/opcion1.png'),
(2, '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 'user', 'user@gmail.com', 2, NULL, NULL, 'images/opcion2.png'),
(32, '$2y$10$q32AJBCGnO/WSjvkolrkxuJ8UeuQlE0kaKV7cXTqTk9OUsxe/bSVm', 'Paula', 'p@ucm.es', 2, NULL, NULL, 'images/opcion6.png'),
(50, '$2y$10$r4tKx.VndaEsQiMnkJ9A2.sgo5BEHgSN4d1ARu.f6JGXfzzAj5bRe', 'Josh Tyler', 'joshTyler@gmail.com', 3, 4.75, 34.55, 'images/opcion3.png'),
(61, '$2y$10$QZ0Une9VvkzJCb20G7jUPuPLDJi0aVDOwINAuDd6OVQHWtM92Jz5W', 'Mei Wong ', 'mei@hotmail.com', 3, NULL, 15.5, 'images/opcion1.png'),
(62, '$2y$10$HuOjATRyoVgfnEwCO5xEKuAWZVgM1zMdTbsWTm4tlh6UuOwTbxCLa', 'Sarah Johnson', 'sarahJ@gmail.com', 3, NULL, 32.21, 'images/opcion3.png'),
(63, '$2y$10$e6Pzqt2nZ8SNLYvg1aK1Vetfq9k2l/jJV2N3TZq6RV8L6A3N0WY6.', 'Mohammad Ali', 'mAli99@gmail.com', 3, NULL, 25.5, 'images/opcion6.png'),
(64, '$2y$10$tCFohteHLRLXZENKQIVSKO5GEKiEz96oeOujwhWLQzqoKc7QXvMGO', 'Isabella Santos ', 'isaSantos@gmail.com', 3, NULL, 10.5, 'images/opcion1.png'),
(3, '$2y$10$2SSp7WtxlOCu.lMjRfXCWeYUpOVsKo0pek9uzat3yx5nIQ/Z02oQa', 'jaime', 'jaime@ucm.es', 2, NULL, NULL, 'images/opcion2.png'),
(65, '$2y$10$NAzedPnxD1zZhd9vSGu0ducjh3u2RA0jmFjY1IV4.u.MvHGHQb8Ha', 'Juan García ', 'jGarcia089@gmail.com', 3, NULL, 18.9, 'images/opcion2.png');


--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`idEvento`, `inscritos`, `categoria`, `numJugadores`, `nombre`, `descripcion`, `fecha`, `lugar`, `estado`, `premio`, `ganador`, `tasaInscripcion`) VALUES
(1, 10, 'Deportes', 50, 'Ajedrez', 'La jugabilidad de LOL se centra en ser lo más \"imaginativo, inteligente y divertido posible con tus amigos\".1​ El juego es solo multijugador y requiere entre dos y cuatro jugadores para participar. Aunque cada jugador debe tener su propia Nintendo DS, solo se necesita una copia del juego. En el juego, el anfitrión hace una pregunta o les dice a los demás que dibujen algo y todos los jugadores tienen que escribir o dibujar lo que se les pide dentro de un límite de tiempo. Por ejemplo, el anfitrión puede preguntar a los jugadores \"¿Qué significa M.B.E.?\" o \"¿Por qué diablos estamos jugando a este juego?\"1​', '2024-04-10', 'Estadio Municipal', 'Abierto', 'Play station 5', NULL, 20.00),
(2, 5, 'Cultura', 50, 'Quizz cultura general', 'Luego, el anfitrión puede usar una herramienta de copia para comenzar a dibujar o escribir algo, lo que permite a los otros jugadores terminar la imagen parcialmente dibujada o la palabra escrita como respuesta. Después de que todos los jugadores hayan respondido, cada jugador vota sobre qué respuesta o imagen es la más divertida.2​ Cada jugador tiene tres votos y también puede votar una vez por sí mismo. No hay penalización por votar por uno mismo.3', '2024-05-15', 'Teatro Municipal', 'Abierto', 'Entradas VIP a Karol G', NULL, 10.00),
(3, 50, 'Deportes', 100, 'Circo del Sol', 'LOL, conocido en Europa como Bakushow y en Japón como Archime DS (ア ル キ メ ＤＳ, Arukime DS), es un videojuego de Nintendo DS. El juego fue publicado por Skip Ltd. en Japón, Agetec en Norteamérica y Rising Star Games en Europa. Desarrollado por un grupo de cinco personas encabezado por Kenichi Nishi, LOL es un juego multijugador implementado con una interfaz similar a PictoChat en la que un jugador anfitrión hace una pregunta, requiriendo que otros escriban o dibujen sus respuestas en la pantalla táctil de DS.', '2024-06-20', 'Gran Carpa', 'Terminado', 'Switch', 'Juan Pérez', 50.00),
(4, 8, 'Deportes', 40, 'En busca del tesoro', 'LOL fue desarrollado por un grupo de cinco personas en Route24. El juego fue diseñado por el ex vicepresidente de Skip, Kenichi Nishi, mejor conocido por dirigir Giftpia y Chibi-Robo!. LOL fue programado por Fumihiro Kanaya, quien trabajó en dos de los títulos de bit Generations de Skip. La obra de arte del juego fue realizada por hikarin y su música fue compuesta por Hirofumi Taniguchi.4​ El juego fue realizado por los miembros del personal del proyecto con un presupuesto muy bajo, sin que se les pague por ello, aparte de sus trabajos habituales.Error en la cita: La etiqueta de apertura <ref> es incorrecta o tiene el nombre mal Su objetivo era hacer el juego lo más simple posible.', '2024-07-05', 'Plaza de Sol', 'Abierto', 'Premio en efectivo', NULL, 15.00);


--
-- Volcado de datos para la tabla `seguir`
--
INSERT INTO `seguir` (`idUsuario`, `idUsuarioSeguir`) VALUES
(32, 2),
(32, 50);

INSERT INTO `foros` (`id`, `titulo`,`descripcion`, `autor`) VALUES
(1, 'Foro sobre Poker','Debates sobre las mejors estrategias y consejos', 'Paula'),
(2, 'Los amos del Parchís','Chistes sobre el parchís e historias que ya no quedarán en familia', 'jaime'),
(3, 'Los locos por el Catan','Si te gusta el Catan este es tu lugar', 'Juan García');

