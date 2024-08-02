-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-08-2024 a las 04:18:12
-- Versión del servidor: 11.3.2-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `farmacia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `idCarrido` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `idFactura` int(11) NOT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `cantidadFactura` int(11) NOT NULL,
  `fechaFactura` date NOT NULL,
  `totalFactura` decimal(10,2) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`idFactura`, `idProducto`, `cantidadFactura`, `fechaFactura`, `totalFactura`, `idUsuario`) VALUES
(1, 1, 5, '2024-08-01', 250.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funciones`
--

CREATE TABLE `funciones` (
  `idFuncion` int(11) NOT NULL,
  `nombreFuncion` varchar(100) NOT NULL,
  `estadoRol` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionesroles`
--

CREATE TABLE `funcionesroles` (
  `idFuncion` int(11) NOT NULL,
  `idRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `idPago` int(11) NOT NULL,
  `idFactura` int(11) DEFAULT NULL,
  `metodoPago` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `nombreProducto` varchar(100) NOT NULL,
  `precioProducto` decimal(10,2) NOT NULL,
  `cantidadProducto` int(11) NOT NULL,
  `imagenProducto` varchar(255) DEFAULT NULL,
  `estadoProducto` varchar(3) NOT NULL,
  `cant` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `nombreProducto`, `precioProducto`, `cantidadProducto`, `imagenProducto`, `estadoProducto`, `cant`) VALUES
(1, 'Acetaminofen 160mg', 25.00, 10, 'https://i0.wp.com/farmaciaseconomicas.com.gt/wp-content/uploads/2022/03/acetaminofen-500mg-gt.webp', 'ACT', 0),
(2, 'Jarabe Tosan 120ml', 30.00, 8, 'https://www.infarma.hn/images/productos/tosan-tripe-accion.png', 'ACT', 0),
(3, 'Vick Vaporub 120g', 35.00, 6, 'https://farmaciaacosta.com.ar/wp-content/uploads/sites/49/2023/06/401.png', 'ACT', 0),
(4, 'Aspirina 650mg', 25.00, 6, 'https://www.fybeca.com/dw/image/v2/BDPM_PRD/on/demandware.static/-/Sites-masterCatalog_FybecaEcuador/default/dw3322136e/images/large/213964_1.jpg?sw=1000&sh=1000', 'ACT', 0),
(5, 'Panadol 500g', 30.00, 6, 'https://static.salcobrandonline.cl/spree/products/59461/large/579405-1.jpeg?1641329036', 'ACT', 0),
(7, 'Tabcin 12 Capsulas', 29.00, 10, 'https://th.bing.com/th/id/OIP.MHdMVU0k9GQNjj-sQswZfgHaHa?rs=1&pid=ImgDetMain', 'ACT', 0),
(8, 'Vick 120g', 35.00, 2, 'https://res.cloudinary.com/walmart-labs/image/upload/d_default.jpg/w_960,dpr_auto,f_auto,q_auto:best/gr/images/product-images/img_large/00750100111618L.jpg', 'ACT', 0),
(9, 'Loratadina 250g', 25.00, 5, 'https://th.bing.com/th/id/R.2c84c9b84eb06de0b05612b968f53b46?rik=bw1pDHGpZA%2bHAw&riu=http%3a%2f%2fquefarmacia.com%2fwp-content%2fuploads%2f2017%2f04%2f209.jpg&ehk=BoX%2beMjAiiNrgo1FkAmdXrhmRdw7ExTyrLBhuuyEufk%3d&risl=&pid=ImgRaw&r=0', 'ACT', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRol` int(11) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `estadoRol` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idRol`, `rol`, `estadoRol`) VALUES
(1, 'Admin', 'ACT'),
(2, 'Cliente', 'ACT'),

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariorol`
--

CREATE TABLE `usuariorol` (
  `idUsuario` int(11) NOT NULL,
  `idRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuariorol`
--

INSERT INTO `usuariorol` (`idUsuario`, `idRol`) VALUES
(1, 1),
(5, 1),
(9, 1),
(15, 1),
(16, 1),
(2, 2),
(3, 2),
(4, 2),
(6, 2),
(7, 2),
(8, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `nombreUsuario` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `estadoUsuario` varchar(3) NOT NULL,
  `contra` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nombreUsuario`, `correo`, `telefono`, `estadoUsuario`, `contra`) VALUES
(1, 'admin', 'admin@correo.com', '65322154', 'ACT', '$2y$10$69nzb3VbrvG5t19fcyvPZenR3qCDkxhdnQj1Xy9JAME/tTyvmLyXC'),
(2, 'harvey', 'harvey@correo.com', '65322154', 'ACT', '$2y$10$69nzb3VbrvG5t19fcyvPZenR3qCDkxhdnQj1Xy9JAME/tTyvmLyXC'),
(3, 'armando', 'armando@correo.com', '65985487', 'ACT', '$2y$10$69nzb3VbrvG5t19fcyvPZenR3qCDkxhdnQj1Xy9JAME/tTyvmLyXC'),
(4, 'olivia', 'olivia@correo.com', '54875421', 'ACT', '$2y$10$69nzb3VbrvG5t19fcyvPZenR3qCDkxhdnQj1Xy9JAME/tTyvmLyXC'),
(5, 'admin2', 'admin2@correo.com', '65887744', 'ACT', '$2y$10$W1.uQEcq3.zUqLm0/hFZGuE3//pP//.Jk4QPlJYWZ1ylDsifHZUky'),
(6, 'dona', 'dona@correo.com', '65542211', 'ACT', '$2y$10$HH33./aoQI5NJB4LwkIzXuUH9XITknxMFa9NxTzHwQGDbTd.4rgX.'),
(7, 'louis', 'louis@correo.com', '65548754', 'ACT', '$2y$10$/fOUREyTKZW0AT7SD6eMP.y12UKql/Jlk3wYtt3xX342mXFLC/vGy'),
(8, 'arturo', 'arturo@correo.com', '65321122', 'ACT', '$2y$10$HH33./aoQI5NJB4LwkIzXuUH9XITknxMFa9NxTzHwQGDbTd.4rgX.'),
(9, 'davis', 'davis@correo.com', '11223366', 'ACT', 'davis@correo.com'),
(10, 'marcos', 'marcos@correo.com', '54875421', 'ACT', '$2y$10$K1fXWuO4eK6UpEF6Cw6FQegDHHqhU37lS5OoRXUqIPlDAfPA62CKS'),
(11, 'red', 'red@correo.com', '65548754', 'ACT', '$2y$10$Ic17FQok3GGTHhx/ozyay.Q.dWbrQLcTG18Irsb269LD0DCik/enW'),
(12, 'chloe', 'chloe@correo.com', '45874521', 'ACT', '$2y$10$3X3ePvkUTB0NvimDLcWWkOalgWUjEOUuh0J.yybhQEl1ORpFxWIu.'),
(13, 'blue', 'blue@correo.com', '54875421', 'ACT', '$2y$10$EOFNyKh/bSIOdq9.XKpmfOo3jp1IrCqCHeB6ozEL0d1WDOGJEefM.'),
(14, 'tommy', 'tommy@correo.com', '54875421', 'ACT', '$2y$10$M/P86L9Rs/LPOaDqwKjSAOfrgxG08K6hNZZH/fKze5we9fdP2/qtK'),
(15, 'admin3', 'admin3@correo.com', '65548754', 'ACT', '$2y$10$69nzb3VbrvG5t19fcyvPZenR3qCDkxhdnQj1Xy9JAME/tTyvmLyXC'),
(16, 'carlos', 'carlos@correo.com', '65548999', 'ACT', '$2y$10$7qJfvleTHzVAGDWEIKDjkuHfaZIFzCxH3RztaCV1MttNm0cYXz7D6');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`idCarrido`),
  ADD KEY `carretilla_user_key` (`idProducto`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`idFactura`),
  ADD KEY `idProducto` (`idProducto`),
  ADD KEY `factura_ibfk_2` (`idUsuario`);

--
-- Indices de la tabla `funciones`
--
ALTER TABLE `funciones`
  ADD PRIMARY KEY (`idFuncion`);

--
-- Indices de la tabla `funcionesroles`
--
ALTER TABLE `funcionesroles`
  ADD PRIMARY KEY (`idFuncion`,`idRol`),
  ADD KEY `idRol` (`idRol`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`idPago`),
  ADD KEY `idFactura` (`idFactura`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD PRIMARY KEY (`idUsuario`,`idRol`),
  ADD KEY `idRol` (`idRol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `idCarrido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `idFactura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `funciones`
--
ALTER TABLE `funciones`
  MODIFY `idFuncion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `idPago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carretilla_user_key` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`),
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`);

--
-- Filtros para la tabla `funcionesroles`
--
ALTER TABLE `funcionesroles`
  ADD CONSTRAINT `funcionesroles_ibfk_1` FOREIGN KEY (`idFuncion`) REFERENCES `funciones` (`idFuncion`),
  ADD CONSTRAINT `funcionesroles_ibfk_2` FOREIGN KEY (`idRol`) REFERENCES `roles` (`idRol`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`idFactura`) REFERENCES `factura` (`idFactura`);

--
-- Filtros para la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD CONSTRAINT `usuariorol_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `usuariorol_ibfk_2` FOREIGN KEY (`idRol`) REFERENCES `roles` (`idRol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
