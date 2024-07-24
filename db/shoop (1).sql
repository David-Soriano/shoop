-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-07-2024 a las 18:24:53
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `shoop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE `auditoria` (
  `idaud` int(5) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) DEFAULT NULL,
  `evento_descripcion` varchar(255) DEFAULT NULL,
  `detalles` text DEFAULT NULL,
  `tipo_evento` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `idcar` bigint(11) NOT NULL,
  `idusu` int(5) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcat` bigint(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcom` int(11) NOT NULL,
  `tiproduct` varchar(20) DEFAULT NULL,
  `cantidad` varchar(20) DEFAULT NULL,
  `preciocom` varchar(20) DEFAULT NULL,
  `iddell` int(5) DEFAULT NULL,
  `idubi` int(5) DEFAULT NULL,
  `idusu` int(5) DEFAULT NULL,
  `idped` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `idcof` int(5) NOT NULL,
  `nitcof` varchar(255) DEFAULT NULL,
  `titcof` varchar(255) DEFAULT NULL,
  `imgcof` varchar(255) DEFAULT NULL,
  `piecof` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecarrito`
--

CREATE TABLE `detallecarrito` (
  `iddetcar` bigint(11) NOT NULL,
  `idcar` bigint(11) DEFAULT NULL,
  `idpro` int(11) DEFAULT NULL,
  `cantidad` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecompra`
--

CREATE TABLE `detallecompra` (
  `iddell` int(5) NOT NULL,
  `subtotal` float DEFAULT NULL,
  `iva` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `idpro` int(5) DEFAULT NULL,
  `codetcom` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefavoritos`
--

CREATE TABLE `detallefavoritos` (
  `iddetfav` bigint(11) NOT NULL,
  `idfav` bigint(11) DEFAULT NULL,
  `idpro` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `iddet` int(11) NOT NULL,
  `idped` int(11) NOT NULL,
  `idpro` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dominio`
--

CREATE TABLE `dominio` (
  `iddom` int(5) NOT NULL,
  `nomdom` varchar(20) DEFAULT NULL,
  `idval` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `idfav` bigint(11) NOT NULL,
  `idusu` int(5) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE `imagen` (
  `idimag` int(10) NOT NULL,
  `imgpro` varchar(20) DEFAULT NULL,
  `nomimg` varchar(20) DEFAULT NULL,
  `tipimg` varchar(20) DEFAULT NULL,
  `idpro` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `idmen` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `ordmen` int(11) DEFAULT 0,
  `estmen` tinyint(1) DEFAULT NULL,
  `url2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`idmen`, `nombre`, `url`, `ordmen`, `estmen`, `url2`) VALUES
(1, 'Categorías', NULL, 1, NULL, NULL),
(2, 'Nosotros', 'index.php?pg=5', 2, NULL, 'home.php?pg=5'),
(3, 'Ayuda/PQR', 'index.php?pg=8', 0, NULL, 'home.php?pg=8'),
(4, 'Iniciar Sesión', 'views/vwLogin.php', 4, 0, NULL),
(5, 'Productos', '#', 5, 1, NULL),
(6, 'Vender', 'views/vwpanpro.php', 6, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagina`
--

CREATE TABLE `pagina` (
  `idpag` int(5) NOT NULL,
  `nompag` varchar(255) DEFAULT NULL,
  `rutpag` varchar(255) DEFAULT NULL,
  `mospag` tinyint(1) DEFAULT NULL,
  `icopag` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagina`
--

INSERT INTO `pagina` (`idpag`, `nompag`, `rutpag`, `mospag`, `icopag`) VALUES
(1, 'Información del Producto', 'views/vwInfoPrd.php', 0, NULL),
(2, 'Favoritos', 'views/vwFavorito.php', 0, NULL),
(3, 'Carro de Compras', 'views/vwCarrComp.php', 0, NULL),
(4, 'LogIn', 'views/vwLogin.php', 0, NULL),
(5, 'Nosotros', 'views/vwNosotros.php\"', 0, NULL),
(6, 'Preguntas Frecuentes', 'views/vwfaq.php', 0, NULL),
(7, 'Recursos Educativos', 'views/vwRecuredu.php', 0, NULL),
(8, 'Soporte', 'views/vwsoport.php', 0, NULL),
(9, 'Pagos', 'views/vwpagos.php', 0, NULL),
(10, 'Pedido', 'views/vwpedido.php', 0, NULL),
(11, 'Políticas', 'views/vwPoliticas.php', 0, NULL),
(12, 'Tarjeta', 'views/vwtarjeta.php', 0, NULL),
(13, 'Tienda', 'views/vwTienda.php', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `idpag` int(11) NOT NULL,
  `idcom` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecpag` timestamp NOT NULL DEFAULT current_timestamp(),
  `metpag` varchar(50) NOT NULL,
  `estpag` varchar(50) DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagxperfil`
--

CREATE TABLE `pagxperfil` (
  `idpag` int(5) DEFAULT NULL,
  `idpef` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagxperfil`
--

INSERT INTO `pagxperfil` (`idpag`, `idpef`) VALUES
(13, 1),
(1, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `idped` int(11) NOT NULL,
  `idusu` int(5) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `estped` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `idpef` int(5) NOT NULL,
  `nompef` varchar(50) DEFAULT NULL,
  `pagini` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`idpef`, `nompef`, `pagini`) VALUES
(1, 'Cliente', 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pqr`
--

CREATE TABLE `pqr` (
  `idpqr` int(5) NOT NULL,
  `fechacrea` datetime(6) DEFAULT NULL,
  `nomusu` varchar(20) DEFAULT NULL,
  `emausu` varchar(20) DEFAULT NULL,
  `tiopqr` varchar(20) DEFAULT NULL,
  `idprov` int(5) DEFAULT NULL,
  `idusu` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idpro` int(11) NOT NULL,
  `nompro` varchar(20) DEFAULT NULL,
  `precio` int(10) DEFAULT NULL,
  `cantidad` int(10) DEFAULT NULL,
  `tipro` varchar(20) DEFAULT NULL,
  `valorunitario` float DEFAULT NULL,
  `descripcion` varchar(20) DEFAULT NULL,
  `imgpro` varchar(20) DEFAULT NULL,
  `provpro` int(5) DEFAULT NULL,
  `prousu` varchar(255) DEFAULT NULL,
  `idcat` bigint(11) DEFAULT NULL,
  `feccreat` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prodxprov`
--

CREATE TABLE `prodxprov` (
  `idpro` int(5) DEFAULT NULL,
  `idprov` int(5) DEFAULT NULL,
  `valor` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idprov` int(5) NOT NULL,
  `nomprov` varchar(20) DEFAULT NULL,
  `dirrecprov` varchar(20) DEFAULT NULL,
  `url` varchar(20) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `nit` varchar(20) DEFAULT NULL,
  `provpro` int(5) DEFAULT NULL,
  `idpro` int(5) DEFAULT NULL,
  `idubi` int(5) DEFAULT NULL,
  `idusu` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `review`
--

CREATE TABLE `review` (
  `idrev` bigint(11) NOT NULL,
  `idpro` int(5) DEFAULT NULL,
  `idusu` int(5) DEFAULT NULL,
  `rating` bigint(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comentario` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `submenu`
--

CREATE TABLE `submenu` (
  `idsbm` int(5) NOT NULL,
  `nombre` varchar(55) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `url2` varchar(255) DEFAULT NULL,
  `idmen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `submenu`
--

INSERT INTO `submenu` (`idsbm`, `nombre`, `url`, `url2`, `idmen`) VALUES
(1, 'Preguntas Frecuentes', 'index.php?pg=6', 'home.php?pg=6', 3),
(2, 'Recursos Educativos', 'index.php?pg=7', 'home.php?pg=7', 3),
(3, 'Soporte', 'index.php?pg=8', 'home.php?pg=8', 3),
(4, 'Moda', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `idubi` int(5) NOT NULL,
  `departamento` varchar(20) DEFAULT NULL,
  `ciudad` varchar(20) DEFAULT NULL,
  `direccion` varchar(20) DEFAULT NULL,
  `idprov` int(5) DEFAULT NULL,
  `idusu` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusu` int(5) NOT NULL,
  `nomusu` varchar(50) DEFAULT NULL,
  `apeusu` varchar(50) DEFAULT NULL,
  `docusu` int(10) DEFAULT NULL,
  `emausu` varchar(100) DEFAULT NULL,
  `celusu` varchar(10) DEFAULT NULL,
  `genusu` varchar(20) DEFAULT NULL,
  `dirrecusu` varchar(50) DEFAULT NULL,
  `tipdoc` varchar(255) DEFAULT NULL,
  `idval` int(5) DEFAULT NULL,
  `idubi` int(5) DEFAULT NULL,
  `feccreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fotpef` varchar(255) DEFAULT NULL,
  `idpef` int(5) NOT NULL,
  `pasusu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusu`, `nomusu`, `apeusu`, `docusu`, `emausu`, `celusu`, `genusu`, `dirrecusu`, `tipdoc`, `idval`, `idubi`, `feccreate`, `fecupdate`, `fotpef`, `idpef`, `pasusu`) VALUES
(1, 'David', 'Soriano', 123213, 'davidscicua314@gmail.com', '3186274255', 'Masculino', 'Chia', 'CC', NULL, NULL, '2024-07-22 14:57:00', '2024-07-22 15:08:34', NULL, 1, '$2y$10$x.YxpWCplR/9QvsxVAJDsu4ba.U/TOTy6N7ootwlW7b8r27GyRqnW');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valor`
--

CREATE TABLE `valor` (
  `idval` int(5) NOT NULL,
  `nomval` varchar(255) DEFAULT NULL,
  `parval` varchar(255) DEFAULT NULL,
  `act` tinyint(1) DEFAULT NULL,
  `idusu` int(5) DEFAULT NULL,
  `iddom` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`idaud`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`idcar`),
  ADD KEY `idusu` (`idusu`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcat`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcom`),
  ADD KEY `iddell` (`iddell`),
  ADD KEY `idubi` (`idubi`),
  ADD KEY `fk_com_usu` (`idusu`),
  ADD KEY `fk_com_ped` (`idped`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`idcof`);

--
-- Indices de la tabla `detallecarrito`
--
ALTER TABLE `detallecarrito`
  ADD PRIMARY KEY (`iddetcar`),
  ADD KEY `idcar` (`idcar`),
  ADD KEY `idpro` (`idpro`);

--
-- Indices de la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  ADD PRIMARY KEY (`iddell`),
  ADD KEY `idpro` (`idpro`);

--
-- Indices de la tabla `detallefavoritos`
--
ALTER TABLE `detallefavoritos`
  ADD PRIMARY KEY (`iddetfav`),
  ADD KEY `idfav` (`idfav`),
  ADD KEY `idpro` (`idpro`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`iddet`),
  ADD KEY `idped` (`idped`),
  ADD KEY `idpro` (`idpro`);

--
-- Indices de la tabla `dominio`
--
ALTER TABLE `dominio`
  ADD PRIMARY KEY (`iddom`),
  ADD KEY `idval` (`idval`);

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`idfav`),
  ADD KEY `idusu` (`idusu`);

--
-- Indices de la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD PRIMARY KEY (`idimag`),
  ADD KEY `idpro` (`idpro`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idmen`);

--
-- Indices de la tabla `pagina`
--
ALTER TABLE `pagina`
  ADD PRIMARY KEY (`idpag`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`idpag`),
  ADD KEY `idcom` (`idcom`);

--
-- Indices de la tabla `pagxperfil`
--
ALTER TABLE `pagxperfil`
  ADD KEY `idpef` (`idpef`),
  ADD KEY `idpag` (`idpag`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idped`),
  ADD KEY `idusu` (`idusu`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`idpef`);

--
-- Indices de la tabla `pqr`
--
ALTER TABLE `pqr`
  ADD PRIMARY KEY (`idpqr`),
  ADD KEY `idprov` (`idprov`),
  ADD KEY `idusu` (`idusu`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idpro`);

--
-- Indices de la tabla `prodxprov`
--
ALTER TABLE `prodxprov`
  ADD KEY `idpro` (`idpro`),
  ADD KEY `idprov` (`idprov`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idprov`),
  ADD KEY `idusu` (`idusu`),
  ADD KEY `idubi` (`idubi`);

--
-- Indices de la tabla `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`idrev`),
  ADD KEY `idpro` (`idpro`),
  ADD KEY `idusu` (`idusu`);

--
-- Indices de la tabla `submenu`
--
ALTER TABLE `submenu`
  ADD PRIMARY KEY (`idsbm`),
  ADD KEY `fk_men_sbm` (`idmen`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`idubi`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusu`),
  ADD KEY `fk_ubi_usu` (`idubi`),
  ADD KEY `fk_usu_pef` (`idpef`);

--
-- Indices de la tabla `valor`
--
ALTER TABLE `valor`
  ADD PRIMARY KEY (`idval`),
  ADD KEY `idusu` (`idusu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `idcar` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcat` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcom` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `idcof` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detallecarrito`
--
ALTER TABLE `detallecarrito`
  MODIFY `iddetcar` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  MODIFY `iddell` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detallefavoritos`
--
ALTER TABLE `detallefavoritos`
  MODIFY `iddetfav` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `iddet` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `dominio`
--
ALTER TABLE `dominio`
  MODIFY `iddom` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `idfav` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `idimag` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `idmen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `pagina`
--
ALTER TABLE `pagina`
  MODIFY `idpag` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `idpag` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idped` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `idpef` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pqr`
--
ALTER TABLE `pqr`
  MODIFY `idpqr` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idpro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idprov` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `review`
--
ALTER TABLE `review`
  MODIFY `idrev` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `submenu`
--
ALTER TABLE `submenu`
  MODIFY `idsbm` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `idubi` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusu` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `valor`
--
ALTER TABLE `valor`
  MODIFY `idval` int(5) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`);

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`iddell`) REFERENCES `detallecompra` (`iddell`),
  ADD CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`idubi`) REFERENCES `ubicacion` (`idubi`),
  ADD CONSTRAINT `fk_com_ped` FOREIGN KEY (`idped`) REFERENCES `pedido` (`idped`),
  ADD CONSTRAINT `fk_com_usu` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`);

--
-- Filtros para la tabla `detallecarrito`
--
ALTER TABLE `detallecarrito`
  ADD CONSTRAINT `detallecarrito_ibfk_1` FOREIGN KEY (`idcar`) REFERENCES `carrito` (`idcar`),
  ADD CONSTRAINT `detallecarrito_ibfk_2` FOREIGN KEY (`idpro`) REFERENCES `producto` (`idpro`);

--
-- Filtros para la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  ADD CONSTRAINT `detallecompra_ibfk_1` FOREIGN KEY (`idpro`) REFERENCES `producto` (`idpro`);

--
-- Filtros para la tabla `detallefavoritos`
--
ALTER TABLE `detallefavoritos`
  ADD CONSTRAINT `detallefavoritos_ibfk_1` FOREIGN KEY (`idfav`) REFERENCES `favoritos` (`idfav`),
  ADD CONSTRAINT `detallefavoritos_ibfk_2` FOREIGN KEY (`idpro`) REFERENCES `producto` (`idpro`);

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`idped`) REFERENCES `pedido` (`idped`),
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`idpro`) REFERENCES `producto` (`idpro`);

--
-- Filtros para la tabla `dominio`
--
ALTER TABLE `dominio`
  ADD CONSTRAINT `dominio_ibfk_1` FOREIGN KEY (`idval`) REFERENCES `valor` (`idval`);

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`);

--
-- Filtros para la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD CONSTRAINT `imagen_ibfk_1` FOREIGN KEY (`idpro`) REFERENCES `producto` (`idpro`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`idcom`) REFERENCES `compra` (`idcom`);

--
-- Filtros para la tabla `pagxperfil`
--
ALTER TABLE `pagxperfil`
  ADD CONSTRAINT `pagxperfil_ibfk_1` FOREIGN KEY (`idpef`) REFERENCES `perfil` (`idpef`),
  ADD CONSTRAINT `pagxperfil_ibfk_2` FOREIGN KEY (`idpag`) REFERENCES `pagina` (`idpag`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`);

--
-- Filtros para la tabla `pqr`
--
ALTER TABLE `pqr`
  ADD CONSTRAINT `pqr_ibfk_1` FOREIGN KEY (`idprov`) REFERENCES `proveedor` (`idprov`),
  ADD CONSTRAINT `pqr_ibfk_2` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`idcat`) REFERENCES `categoria` (`idcat`);

--
-- Filtros para la tabla `prodxprov`
--
ALTER TABLE `prodxprov`
  ADD CONSTRAINT `prodxprov_ibfk_1` FOREIGN KEY (`idpro`) REFERENCES `producto` (`idpro`),
  ADD CONSTRAINT `prodxprov_ibfk_2` FOREIGN KEY (`idprov`) REFERENCES `proveedor` (`idprov`);

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`),
  ADD CONSTRAINT `proveedor_ibfk_2` FOREIGN KEY (`idubi`) REFERENCES `ubicacion` (`idubi`);

--
-- Filtros para la tabla `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`idpro`) REFERENCES `producto` (`idpro`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`);

--
-- Filtros para la tabla `submenu`
--
ALTER TABLE `submenu`
  ADD CONSTRAINT `fk_men_sbm` FOREIGN KEY (`idmen`) REFERENCES `menu` (`idmen`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_ubi_usu` FOREIGN KEY (`idubi`) REFERENCES `ubicacion` (`idubi`),
  ADD CONSTRAINT `fk_usu_pef` FOREIGN KEY (`idpef`) REFERENCES `perfil` (`idpef`);

--
-- Filtros para la tabla `valor`
--
ALTER TABLE `valor`
  ADD CONSTRAINT `valor_ibfk_1` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
