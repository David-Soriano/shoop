DROP DATABASE IF EXISTS shoop;
CREATE DATABASE shoop;
USE shoop;

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
-- Estructura de tabla para la tabla `busquedas`
--

CREATE TABLE `busquedas` (
  `idbusqueda` int(11) NOT NULL,
  `idusu` int(5) NOT NULL,
  `termino_busqueda` varchar(255) DEFAULT NULL,
  `fecha_busqueda` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `busquedas`
--

INSERT INTO `busquedas` (`idbusqueda`, `idusu`, `termino_busqueda`, `fecha_busqueda`) VALUES
(1, 20, 'Samsung', '2025-02-19 15:02:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caracteristicas`
--

CREATE TABLE `caracteristicas` (
  `idcar` int(11) NOT NULL,
  `idpro` int(11) DEFAULT NULL,
  `descripcioncr` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `caracteristicas`
--

INSERT INTO `caracteristicas` (`idcar`, `idpro`, `descripcioncr`) VALUES
(52, 164, 'Color: beige, naranja, gris'),
(53, 164, 'Es inalámbrico: Si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `idcar` bigint(11) NOT NULL,
  `idusu` int(5) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`idcar`, `idusu`, `fecha_creacion`) VALUES
(2, 20, '2025-02-07 16:42:16'),
(3, 27, '2025-02-20 02:02:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comisiones`
--

CREATE TABLE `comisiones` (
  `idcomis` int(11) NOT NULL,
  `idcom` int(11) NOT NULL,
  `monto_total` decimal(10,2) NOT NULL,
  `comision` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comisiones`
--

INSERT INTO `comisiones` (`idcomis`, `idcom`, `monto_total`, `comision`, `fecha`) VALUES
(2, 20, 30000.00, 2100.00, '2025-03-03 15:24:18'),
(3, 21, 350000.00, 24500.00, '2025-03-04 16:14:53'),
(4, 22, 350000.00, 24500.00, '2025-03-04 16:19:51'),
(5, 23, 30000.00, 2100.00, '2025-03-05 14:53:03'),
(7, 25, 30000.00, 2100.00, '2025-03-06 15:10:13'),
(12, 30, 30000.00, 2100.00, '2025-03-26 14:55:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcom` int(11) NOT NULL,
  `tiproduct` varchar(20) DEFAULT NULL,
  `cantidad` varchar(20) DEFAULT NULL,
  `preciocom` varchar(20) DEFAULT NULL,
  `idubi` int(5) DEFAULT NULL,
  `idusu` int(5) DEFAULT NULL,
  `idped` int(11) DEFAULT NULL,
  `fechareg` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`idcom`, `tiproduct`, `cantidad`, `preciocom`, `idubi`, `idusu`, `idped`, `fechareg`) VALUES
(20, 'Moda', '1', '37800', 47030, 20, 45, '2025-03-03 10:24:18'),
(21, 'Tecnología', '1', '296800', 47030, 20, 46, '2025-03-04 11:14:53'),
(22, 'Tecnología', '1', '296800', 25175, 27, 47, '2025-03-04 11:19:51'),
(23, 'Moda', '1', '37800', 25175, 27, 48, '2025-03-05 09:53:03'),
(25, 'Moda', '1', '37800', 25175, 27, 49, '2025-03-06 10:10:13'),
(30, 'Moda', '1', '37800', 25175, 27, 54, '2025-03-26 09:55:02');

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
  `cantidad` bigint(11) NOT NULL,
  `precar` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallecarrito`
--

INSERT INTO `detallecarrito` (`iddetcar`, `idcar`, `idpro`, `cantidad`, `precar`) VALUES
(25, 2, 164, 1, 296800);

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
  `direccomp` varchar(50) DEFAULT NULL,
  `idcom` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallecompra`
--

INSERT INTO `detallecompra` (`iddell`, `subtotal`, `iva`, `total`, `idpro`, `direccomp`, `idcom`) VALUES
(20, 31764.7, 5700, 37800, 163, 'Vereda la balsa', 20),
(21, 249412, 66500, 296800, 164, 'Vereda la balsa', 21),
(22, 249412, 66500, 296800, 164, 'Vereda la balsa calle 9a Sur', 22),
(23, 31764.7, 5700, 37800, 163, 'Vereda la balsa calle 9a Sur', 23),
(25, 31764.7, 5700, 37800, 163, 'Vereda la balsa calle 9a Sur', 25),
(30, 31764.7, 5700, 37800, 163, 'Vereda la balsa calle 9a Sur', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefavoritos`
--

CREATE TABLE `detallefavoritos` (
  `iddetfav` bigint(11) NOT NULL,
  `idfav` bigint(11) DEFAULT NULL,
  `idpro` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallefavoritos`
--

INSERT INTO `detallefavoritos` (`iddetfav`, `idfav`, `idpro`) VALUES
(50, 50, 163),
(54, 54, 164);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `iddet` int(11) NOT NULL,
  `idped` int(11) NOT NULL,
  `idpro` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `mpago` varchar(100) DEFAULT NULL,
  `npago` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) NOT NULL,
  `idubi` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`iddet`, `idped`, `idpro`, `cantidad`, `precio`, `mpago`, `npago`, `direccion`, `idubi`) VALUES
(43, 45, 163, 1, 37800.00, 'VISA', 'CREDIT_CARD', 'Vereda la balsa', 47030),
(44, 46, 164, 1, 296800.00, 'VISA', 'CREDIT_CARD', 'Vereda la balsa', 47030),
(45, 47, 164, 1, 296800.00, 'VISA', 'CREDIT_CARD', 'Vereda la balsa calle 9a Sur', 25175),
(46, 48, 163, 1, 37800.00, 'VISA', 'CREDIT_CARD', 'Vereda la balsa calle 9a Sur', 25175),
(47, 49, 163, 1, 37800.00, 'VISA', 'CREDIT_CARD', 'Vereda la balsa calle 9a Sur', 25175),
(48, 50, 164, 1, 296800.00, 'VISA', 'CREDIT_CARD', 'Vereda la balsa calle 9a Sur', 25175),
(49, 53, 164, 1, 296800.00, 'VISA', 'CREDIT_CARD', 'Vereda la balsa calle 9a Sur', 25175),
(50, 53, 163, 1, 37800.00, 'VISA', 'CREDIT_CARD', 'Vereda la balsa calle 9a Sur', 25175),
(51, 54, 163, 1, 37800.00, 'VISA', 'CREDIT_CARD', 'Vereda la balsa calle 9a Sur', 25175);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucionreembolso`
--

CREATE TABLE `devolucionreembolso` (
  `iddevo` int(11) NOT NULL,
  `idped` int(11) NOT NULL,
  `idpro` int(11) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `fechasolicitud` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(50) DEFAULT 'Pendiente',
  `fechaprocesamiento` datetime DEFAULT NULL,
  `montoreembolso` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `devolucionreembolso`
--

INSERT INTO `devolucionreembolso` (`iddevo`, `idped`, `idpro`, `motivo`, `fechasolicitud`, `estado`, `fechaprocesamiento`, `montoreembolso`) VALUES
(4, 49, 163, 'Llegó en mal estado', '2025-03-19 15:39:01', 'Devuelto', NULL, 37800);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dominio`
--

CREATE TABLE `dominio` (
  `iddom` int(5) NOT NULL,
  `nomdom` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dominio`
--

INSERT INTO `dominio` (`iddom`, `nomdom`) VALUES
(1, 'Categorías');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `idfav` bigint(11) NOT NULL,
  `idusu` int(5) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `favoritos`
--

INSERT INTO `favoritos` (`idfav`, `idusu`, `fecha_creacion`) VALUES
(50, 27, '2025-03-19 19:19:11'),
(54, 20, '2025-03-20 21:31:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE `imagen` (
  `idimag` int(10) NOT NULL,
  `imgpro` varchar(100) DEFAULT NULL,
  `nomimg` varchar(50) DEFAULT NULL,
  `tipimg` varchar(20) DEFAULT NULL,
  `idpro` int(5) DEFAULT NULL,
  `ordimg` int(1) DEFAULT NULL,
  `lugimg` int(1) DEFAULT NULL,
  `urlimg` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`idimag`, `imgpro`, `nomimg`, `tipimg`, `idpro`, `ordimg`, `lugimg`, `urlimg`) VALUES
(146, 'IMG/Paginas.png', 'Paginas', 'png', NULL, 1, 2, 30),
(148, 'IMG/Usuarios.png', 'Usuarios', 'png', NULL, 2, 2, 31),
(149, 'IMG/Balances.png', 'Balances', 'png', NULL, 3, 2, 32),
(150, 'IMG/Productos.png', 'Productos', 'png', NULL, 4, 2, 33),
(285, 'IMG/publicidad/publicidad_67ba004884f85.jpg', 'publicidad_67ba004884f85.jpg', 'jpg', NULL, 1, 1, NULL),
(286, 'IMG/publicidad/publicidad_67ba0055acc80.jpg', 'publicidad_67ba0055acc80.jpg', 'jpg', NULL, 1, 1, NULL),
(290, 'IMG/publicidad/publicidad_67ba00f4e5c5b.jpg', 'publicidad_67ba00f4e5c5b.jpg', 'jpg', NULL, 1, 1, NULL),
(291, 'IMG/publicidad/publicidad_67ba012e5c66c.jpg', 'publicidad_67ba012e5c66c.jpg', 'jpg', NULL, 1, 1, NULL),
(293, 'IMG/publicidad/publicidad_67ba0297c2697.jpg', 'publicidad_67ba0297c2697.jpg', 'jpg', NULL, 1, 1, NULL),
(383, 'proinf/imagen_67c7265505f93.jpg', 'k68-mechanical-gaming-keyboard-60percent-wireless-', 'image/jpeg', 164, 1, NULL, NULL),
(387, 'proinf/imagen_67c5c23df3c84.webp', 'imagen_67c5c23df3c84', 'proinf/imagen_67c5c2', 163, 1, NULL, NULL);

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
  `url2` varchar(255) DEFAULT NULL,
  `submen` tinyint(1) DEFAULT 0,
  `lugmen` int(1) DEFAULT NULL,
  `icomen` varchar(50) DEFAULT NULL,
  `isUser` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`idmen`, `nombre`, `url`, `ordmen`, `estmen`, `url2`, `submen`, `lugmen`, `icomen`, `isUser`) VALUES
(1, 'Categorías', NULL, 1, NULL, NULL, 1, 0, NULL, NULL),
(2, 'Nosotros', 'index.php?pg=5', 2, NULL, 'home.php?pg=5', 0, 0, NULL, NULL),
(3, 'Ayuda/PQR', NULL, 3, NULL, NULL, 1, 0, NULL, NULL),
(4, 'Iniciar Sesión', 'views/vwLogin.php', 4, 0, 'views/vwLogin.php', 0, 0, NULL, NULL),
(6, 'Vender', NULL, 6, 1, 'views/vwpanpro.php?vw=25', 0, 0, NULL, NULL),
(7, 'Cerrar Sesión', 'views/vwExit.php', 10, 1, NULL, 0, 1, NULL, NULL),
(8, 'Perfil', 'home.php?pg=15', 7, 1, NULL, 0, 1, NULL, NULL),
(9, 'Tus Pedidos', 'home.php?pg=17', 8, 1, NULL, 0, 1, NULL, 1),
(10, 'Tus Compras', 'home.php?pg=16', 9, 1, NULL, 0, 1, NULL, 1),
(11, 'Favoritos', 'index.php?pg=002', 11, NULL, 'home.php?pg=002', 0, 2, 'bi bi-heart', NULL),
(12, 'Carro Compras', 'index.php?pg=003', 12, NULL, 'home.php?pg=003', 0, 2, 'bi bi-basket3', NULL),
(13, 'Icono User', NULL, 0, NULL, NULL, 0, 3, 'bi bi-person-circle', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_temporales`
--

CREATE TABLE `ordenes_temporales` (
  `idord` int(11) NOT NULL,
  `idusu` int(11) NOT NULL,
  `productos` text NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagina`
--

CREATE TABLE `pagina` (
  `idpag` int(5) NOT NULL,
  `nompag` varchar(255) DEFAULT NULL,
  `rutpag` varchar(255) DEFAULT NULL,
  `mospag` tinyint(1) DEFAULT NULL,
  `icopag` varchar(100) DEFAULT NULL,
  `lugpag` int(4) DEFAULT NULL,
  `estpagn` varchar(20) DEFAULT 'Activo',
  `actpag` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagina`
--

INSERT INTO `pagina` (`idpag`, `nompag`, `rutpag`, `mospag`, `icopag`, `lugpag`, `estpagn`, `actpag`) VALUES
(1, 'Información del Producto', 'views/vwInfoPrd.php', 0, NULL, NULL, 'Activo', 1),
(2, 'Favoritos', 'views/vwFavorito.php', 0, 'bi bi-heart', 1, 'Activo', 1),
(3, 'Carro de Compras', 'views/vwCarrComp.php', 0, 'bi bi-basket3', 1, 'Activo', 1),
(4, 'LogIn', 'views/vwLogin.php', 0, NULL, NULL, 'Activo', 1),
(5, 'Nosotros', 'views/vwNosotros.php\"', 0, NULL, NULL, 'Activo', 1),
(6, 'Preguntas Frecuentes', 'views/vwfaq.php', 0, NULL, NULL, 'Activo', 1),
(7, 'Recursos Educativos', 'views/vwRecuredu.php', 0, NULL, NULL, 'Activo', 1),
(8, 'Soporte', 'views/vwsoport.php', 0, NULL, NULL, 'Activo', 1),
(9, 'Pagos', 'views/vwpagos.php', 0, NULL, NULL, 'Activo', 1),
(10, 'Pedido', 'views/vwpedido.php', 0, NULL, NULL, 'Activo', 1),
(11, 'Políticas', 'views/vwPoliticas.php', 0, NULL, NULL, 'Activo', 1),
(12, 'Tarjeta', 'views/vwtarjeta.php', 0, NULL, NULL, 'Activo', 1),
(13, 'Tienda', 'views/vwTienda.php', 0, NULL, NULL, 'Activo', 1),
(14, 'Bienvenida', 'views/vwTienda.php', 0, NULL, NULL, 'Activo', 1),
(15, 'Perfil', 'views/vwPerfil.php', 0, 'bi bi-person-circle', 1, 'Activo', 1),
(16, 'Tus Compras', 'views/vwTuscompras.php', 0, NULL, NULL, 'Activo', 1),
(17, 'Tus Pedidos', 'views/vwTusPedidos.php', NULL, NULL, NULL, 'Activo', 1),
(18, 'Productos Añadidos', 'views/vwPrdAnd.php', 0, NULL, NULL, 'Activo', 1),
(19, 'Ofertas', 'views/vwOfer.php', NULL, NULL, NULL, 'Activo', 1),
(20, 'Más vendido', 'views/vwMVen.php', NULL, NULL, NULL, 'Activo', 1),
(21, 'Categorías', 'views/vwCatego.php', NULL, NULL, NULL, 'Activo', 1),
(22, 'Administrador', 'views/admin.php', NULL, NULL, NULL, 'Activo', 1),
(23, 'Almacén', 'views/vwTable.php', NULL, NULL, 2, 'Activo', 1),
(24, 'Subir Productos', 'views/vwven.php', NULL, NULL, 2, 'Activo', 1),
(25, 'Lista de pedidos', 'views/vwListPed.php', NULL, NULL, 2, 'Activo', 1),
(26, 'Panel Control WC', 'views/vwDefPan.php', NULL, NULL, 2, 'Activo', 1),
(27, 'Balances Prv', 'views/vwBalPrv.php', NULL, NULL, 2, 'Activo', 1),
(28, 'Seguir Envío', 'views/vwSeguirenv.php', NULL, NULL, NULL, 'Activo', 1),
(30, 'Ver paginas', 'views/vwCpag.php', NULL, NULL, NULL, 'Activo', 1),
(31, 'Lista Usuarios', 'views/vwUserT.php', NULL, NULL, NULL, 'Activo', 1),
(32, 'Balances', 'views/vwBal.php', NULL, NULL, NULL, 'Activo', 1),
(33, 'Control Productos', 'views/vwProdC.php', NULL, NULL, NULL, 'Activo', 1),
(34, 'Página Prueba', 'views/vwpáginaprueba.php', NULL, 'bi bi-123', 0, 'Activo', 1),
(36, 'Perfil Proveedor', 'views/vwPerfilTienda.php', NULL, NULL, 2, 'Activo', 1),
(37, 'Calificar', 'views/vwCalPrd.php', NULL, NULL, NULL, 'Activo', 1),
(38, 'Devolución', 'views/vwDevolv.php', NULL, NULL, NULL, 'Activo', 1),
(39, 'Lista Reembolsos', 'views/vwListDev.php', NULL, NULL, 2, 'Activo', 1);

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
  `idpef` int(5) DEFAULT NULL,
  `idperpf` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagxperfil`
--

INSERT INTO `pagxperfil` (`idpag`, `idpef`, `idperpf`) VALUES
(30, 2, 1),
(31, 2, 2),
(22, 2, 3),
(32, 2, 4),
(33, 2, 5),
(1, 1, 6),
(2, 1, 7),
(3, 1, 8),
(4, 1, 9),
(5, 1, 10),
(6, 1, 11),
(7, 1, 12),
(8, 1, 13),
(9, 1, 14),
(10, 1, 15),
(11, 1, 16),
(12, 1, 17),
(13, 1, 18),
(14, 1, 19),
(15, 1, 20),
(16, 1, 21),
(17, 1, 22),
(18, 1, 23),
(19, 1, 24),
(20, 1, 25),
(21, 1, 26),
(23, 1, 27),
(24, 1, 28),
(25, 1, 29),
(26, 1, 30),
(27, 1, 31),
(28, 1, 35),
(36, 1, 36),
(37, 1, 37),
(38, 1, 38),
(39, 1, 39);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `idped` int(11) NOT NULL,
  `idusu` int(5) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `estped` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`idped`, `idusu`, `total`, `fecha`, `estped`) VALUES
(45, 20, 37800.00, '2025-03-03 15:23:43', 'Enviado'),
(46, 20, 296800.00, '2025-03-04 16:13:44', 'Recibido'),
(47, 27, 296800.00, '2025-03-04 16:18:42', 'Recibido'),
(48, 27, 37800.00, '2025-03-05 14:05:12', 'Recibido'),
(49, 27, 37800.00, '2025-03-05 17:01:13', 'Devuelto'),
(50, 27, 296800.00, '2025-03-07 12:48:09', 'En Tránsito'),
(53, 27, 334600.00, '2025-03-08 14:32:07', 'Enviado'),
(54, 27, 37800.00, '2025-03-26 14:36:35', 'Recibido');

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
(1, 'Cliente', 13),
(2, 'Administrador', 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pqr`
--

CREATE TABLE `pqr` (
  `idpqr` int(11) NOT NULL,
  `fechacrea` datetime DEFAULT current_timestamp(),
  `emausu` varchar(255) NOT NULL,
  `tippqr` enum('Queja','Reclamo','Sugerencia','Felicitación') NOT NULL,
  `idprov` int(11) DEFAULT NULL,
  `idusu` int(11) DEFAULT NULL,
  `mensaje` text NOT NULL,
  `estado` enum('Pendiente','En proceso','Resuelto','Cerrado') DEFAULT 'Pendiente',
  `nomusu` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pqr`
--

INSERT INTO `pqr` (`idpqr`, `fechacrea`, `emausu`, `tippqr`, `idprov`, `idusu`, `mensaje`, `estado`, `nomusu`) VALUES
(3, '2025-02-25 10:05:53', 'davidscicua314@gmail.com', 'Felicitación', NULL, NULL, 'Para felicitarlos por el proyecto', 'Resuelto', 'Juan David Soriano'),
(4, '2025-02-25 10:11:53', 'davidscicua314@gmail.com', 'Sugerencia', NULL, NULL, 'Mejorar en el diseño', 'Resuelto', 'Juan David Soriano'),
(5, '2025-02-25 10:17:53', 'davidscicua314@gmail.com', 'Reclamo', NULL, NULL, 'No a llegado el pedido', 'Resuelto', 'Juan David Soriano'),
(17, '2025-02-25 16:13:19', 'davidscicua314@gmail.com', 'Queja', NULL, 20, 'prueba', 'Resuelto', 'Juan David Soriano'),
(18, '2025-02-25 18:22:26', 'davidscicua314@gmail.com', 'Queja', NULL, NULL, 'prueba', 'Resuelto', 'Juan David Soriano'),
(19, '2025-02-25 18:36:07', 'davidscicua314@gmail.com', 'Queja', NULL, NULL, 'dfghsfdhsdhsdfhxcvfgbcdfh', 'Resuelto', 'Juan David Soriano'),
(20, '2025-02-25 18:38:41', 'davidscicua314@gmail.com', 'Queja', NULL, NULL, 'jkz<sgfkjasdkgfkj<sbhdsbjvg', 'Resuelto', 'Juan David Soriano'),
(21, '2025-02-25 18:45:53', 'cicua1994@gmail.com', 'Sugerencia', NULL, NULL, 'Me parece que no es viable esta página.', 'Resuelto', 'Edison Ferney Soriano');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idpro` int(11) NOT NULL,
  `nompro` varchar(255) DEFAULT NULL,
  `precio` int(10) DEFAULT NULL,
  `cantidad` int(10) DEFAULT NULL,
  `tipro` varchar(20) DEFAULT NULL,
  `valorunitario` float DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `feccreat` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fechiniofer` timestamp NULL DEFAULT NULL,
  `fechfinofer` timestamp NULL DEFAULT NULL,
  `estado` enum('activo','inactivo','pendiente') DEFAULT 'activo',
  `pordescu` float DEFAULT 0,
  `idval` int(5) DEFAULT NULL,
  `productvend` int(10) DEFAULT 0,
  `temporada` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idpro`, `nompro`, `precio`, `cantidad`, `tipro`, `valorunitario`, `descripcion`, `feccreat`, `fecupdate`, `fechiniofer`, `fechfinofer`, `estado`, `pordescu`, `idval`, `productvend`, `temporada`) VALUES
(160, 'Camisa Selección Argentina Año 2024 Hombre', 25200, 7, NULL, 20000, 'Camisa deportiva', '2025-03-01 13:37:42', '2025-03-01 13:42:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'inactivo', 0, 1, 0, NULL),
(161, 'Camisa Selección Argentina Año 2024 Hombre', 37800, 2, NULL, 30000, 'Camisa de algodón deportiva año 2024', '2025-03-03 14:50:58', '2025-03-03 14:52:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'inactivo', 0, 1, 0, NULL),
(162, 'Camisa Selección Argentina Año 2024 Hombre', 37800, 2, NULL, 30000, 'Camisa de algodón deportiva año 2024', '2025-03-03 14:50:58', '2025-03-03 14:51:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'inactivo', 0, 1, 0, NULL),
(163, 'Camisa Selección Argentina Año 2024 Hombre', 37800, 8, NULL, 30000, 'Camisa de algodón ', '2025-03-03 14:52:46', '2025-03-26 14:55:02', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'activo', 0, 1, 10, NULL),
(164, 'Teclado Mecánico K68', 371000, 4, NULL, 350000, 'Teclado con switches red color combinado inalámbrico. ', '2025-03-04 16:12:05', '2025-03-08 14:32:07', '2025-03-04 05:00:00', '2025-03-04 05:00:00', 'activo', 20, 2, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prodxprov`
--

CREATE TABLE `prodxprov` (
  `idpro` int(5) DEFAULT NULL,
  `idprov` int(5) DEFAULT NULL,
  `idprodprv` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prodxprov`
--

INSERT INTO `prodxprov` (`idpro`, `idprov`, `idprodprv`) VALUES
(160, 82, 91),
(161, 82, 92),
(162, 82, 93),
(163, 82, 94),
(164, 82, 95);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idprov` int(5) NOT NULL,
  `nomprov` varchar(20) DEFAULT NULL,
  `dirrecprov` varchar(20) DEFAULT NULL,
  `urlt` varchar(100) DEFAULT NULL,
  `nit` varchar(20) DEFAULT NULL,
  `idubi` int(5) DEFAULT NULL,
  `idusu` int(5) DEFAULT NULL,
  `desprv` varchar(100) DEFAULT NULL,
  `saldo` decimal(10,2) DEFAULT 0.00,
  `estprv` varchar(15) DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`idprov`, `nomprov`, `dirrecprov`, `urlt`, `nit`, `idubi`, `idusu`, `desprv`, `saldo`, `estprv`) VALUES
(82, 'DavidX', 'Calle 34 Bloque 4', 'shoop.com', '454112', 15001, 20, 'Todo lo que quieres a tu alcance y en un solo lugar', 501600.00, 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas_pqr`
--

CREATE TABLE `respuestas_pqr` (
  `idrespuesta` int(11) NOT NULL,
  `idpqr` int(11) NOT NULL,
  `fecha_respuesta` datetime DEFAULT current_timestamp(),
  `respuesta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respuestas_pqr`
--

INSERT INTO `respuestas_pqr` (`idrespuesta`, `idpqr`, `fecha_respuesta`, `respuesta`) VALUES
(7, 3, '2025-02-25 15:58:53', 'gracias'),
(8, 4, '2025-02-25 16:02:13', 'estamos en eso'),
(9, 4, '2025-02-25 16:03:56', 'estamos en eso'),
(10, 5, '2025-02-25 16:04:55', 'lastima chamo'),
(11, 17, '2025-02-25 18:30:35', 'respuesta'),
(12, 18, '2025-02-25 18:34:18', 'pruevbaaa'),
(13, 19, '2025-02-25 18:37:18', 'kjsdhgadlsf hsairf vjakd'),
(14, 20, '2025-02-25 18:39:07', 'dsfgnhjdgrfnbfdzxn'),
(15, 21, '2025-02-25 18:47:29', 'Lo invitamos a que conozca mejor nuestra página y compre algo primero');

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

--
-- Volcado de datos para la tabla `review`
--

INSERT INTO `review` (`idrev`, `idpro`, `idusu`, `rating`, `comentario`, `fecha`) VALUES
(2, 163, 27, 5, 'Buena calidad y envío rápido. Recomendado', '2025-03-11 16:58:18');

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
(4, 'Moda', 'index.php?pg=21&cg=Moda', 'home.php?pg=21&cg=Moda', 1),
(5, 'Tecnología', 'index.php?pg=21&cg=Tecnología', 'home.php?pg=21&cg=Tecnología', 1),
(6, 'Accesorios', 'index.php?pg=21&cg=Accesorios', 'home.php?pg=21&cg=Accesorios', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `idubi` int(5) NOT NULL,
  `nomubi` varchar(50) DEFAULT NULL,
  `depenubi` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`idubi`, `nomubi`, `depenubi`) VALUES
(5, 'ANTIOQUIA', 0),
(8, 'ATLANTICO', 0),
(11, 'BOGOTÁ D.C.', 0),
(13, 'BOLIVAR', 0),
(15, 'BOYACA', 0),
(17, 'CALDAS', 0),
(18, 'CAQUETA', 0),
(19, 'CAUCA', 0),
(20, 'CESAR', 0),
(23, 'CORDOBA', 0),
(25, 'CUNDINAMARCA', 0),
(27, 'CHOCO', 0),
(41, 'HUILA', 0),
(44, 'LA GUAJIRA', 0),
(47, 'MAGDALENA', 0),
(50, 'META', 0),
(52, 'NARIÑO', 0),
(54, 'NORTE DE SANTANDER', 0),
(63, 'QUINDIO', 0),
(66, 'RISALDA', 0),
(68, 'SANTANDER', 0),
(70, 'SUCRE', 0),
(73, 'TOLIMA', 0),
(76, 'VALLE DEL CAUCA', 0),
(81, 'ARAUCA', 0),
(85, 'CASANARE', 0),
(86, 'PUTUMAYO', 0),
(88, 'SAN ANDRES Y PROVIDE', 0),
(91, 'AMAZONAS', 0),
(94, 'GUAINIA', 0),
(95, 'GUAVIARE', 0),
(97, 'VAUPES', 0),
(99, 'VICHADA', 0),
(5001, 'Medellin', 5),
(5002, 'Abejorral', 5),
(5004, 'Abriaqui', 5),
(5021, 'Alejandria', 5),
(5030, 'Amaga', 5),
(5031, 'Amalfi', 5),
(5034, 'Andes', 5),
(5036, 'Angelopolis', 5),
(5038, 'Angostura', 5),
(5040, 'Anori', 5),
(5042, 'Antioquia', 5),
(5044, 'Anza', 5),
(5045, 'Apartado', 5),
(5051, 'Arboletes', 5),
(5055, 'Argelia', 5),
(5059, 'Armenia', 5),
(5079, 'Barbosa', 5),
(5086, 'Belmira', 5),
(5088, 'Bello', 5),
(5091, 'Betania', 5),
(5093, 'Betulia', 5),
(5101, 'Bolivar', 5),
(5107, 'Briceno', 5),
(5113, 'Buritica', 5),
(5120, 'Caceres', 5),
(5125, 'Caicedo', 5),
(5129, 'Caldas', 5),
(5134, 'Campamento', 5),
(5138, 'CaÃ±asgordas', 5),
(5142, 'Caracoli', 5),
(5145, 'Caramanta', 5),
(5147, 'Carepa', 5),
(5148, 'Carmen de Viboral', 5),
(5150, 'Carolina', 5),
(5154, 'Caucasia', 5),
(5172, 'Chigorodo', 5),
(5190, 'Cisneros', 5),
(5197, 'Cocorna', 5),
(5206, 'Concepcion', 5),
(5209, 'Concordia', 5),
(5212, 'Copacabana', 5),
(5234, 'Dabeiba', 5),
(5237, 'Don Matias', 5),
(5240, 'Ebejico', 5),
(5250, 'El Bagre', 5),
(5264, 'Entrerrios', 5),
(5266, 'Envigado', 5),
(5282, 'Fredonia', 5),
(5284, 'Frontino', 5),
(5306, 'Giraldo', 5),
(5308, 'Girardota', 5),
(5310, 'Gomez Plata', 5),
(5313, 'Granada', 5),
(5315, 'Guadalupe', 5),
(5318, 'Guarne', 5),
(5321, 'Guatape', 5),
(5347, 'Heliconia', 5),
(5353, 'Hispania', 5),
(5360, 'Itagui', 5),
(5361, 'Ituango', 5),
(5364, 'Jardin', 5),
(5368, 'Jerico', 5),
(5376, 'La Ceja', 5),
(5380, 'La Estrella', 5),
(5390, 'La Pintada', 5),
(5400, 'La Union', 5),
(5411, 'Liborina', 5),
(5425, 'Maceo', 5),
(5440, 'Marinilla', 5),
(5467, 'Montebello', 5),
(5475, 'Murindo', 5),
(5480, 'Mutata', 5),
(5483, 'NariÃ±o', 5),
(5490, 'Necocli', 5),
(5495, 'Nechi', 5),
(5501, 'Olaya', 5),
(5541, 'PeÃ±ol', 5),
(5543, 'Peque', 5),
(5576, 'Pueblorrico', 5),
(5579, 'Puerto Berrio', 5),
(5585, 'Puerto Nare (La Magd', 5),
(5591, 'Puerto Triunfo', 5),
(5604, 'Remedios', 5),
(5607, 'Retiro', 5),
(5615, 'Rionegro', 5),
(5628, 'Sabanalarga', 5),
(5631, 'Sabaneta', 5),
(5642, 'Salgar', 5),
(5647, 'San Andres', 5),
(5649, 'San Carlos', 5),
(5652, 'San Francisco', 5),
(5656, 'San Jeronimo', 5),
(5658, 'San Jose de la Monta', 5),
(5659, 'San Juan de Uraba', 5),
(5660, 'San Luis', 5),
(5664, 'San Pedro', 5),
(5665, 'San Pedro de Uraba', 5),
(5667, 'San Rafael', 5),
(5670, 'San Roque', 5),
(5674, 'San Vicente', 5),
(5679, 'Santa Barbara', 5),
(5686, 'Santa Rosa de Osos', 5),
(5690, 'Santo Domingo', 5),
(5697, 'Santuario', 5),
(5736, 'Segovia', 5),
(5756, 'Sonson', 5),
(5761, 'Sopetran', 5),
(5789, 'Tamesis', 5),
(5790, 'Taraza', 5),
(5792, 'Tarso', 5),
(5809, 'Titiribi', 5),
(5819, 'Toledo', 5),
(5837, 'Turbo', 5),
(5842, 'Uramita', 5),
(5847, 'Urrao', 5),
(5854, 'Valdivia', 5),
(5856, 'Valparaiso', 5),
(5858, 'Vegachi', 5),
(5861, 'Venecia', 5),
(5873, 'Vigia del Fuerte', 5),
(5885, 'Yali', 5),
(5887, 'Yarumal', 5),
(5890, 'Yolombo', 5),
(5893, 'Yondo (Casabe)', 5),
(5895, 'Zaragoza', 5),
(8001, 'Barranquilla', 8),
(8078, 'Baranoa', 8),
(8137, 'Campo de la Cruz', 8),
(8141, 'Candelaria', 8),
(8296, 'Galapa', 8),
(8372, 'Juan de Acosta', 8),
(8421, 'Luruaco', 8),
(8433, 'Malambo', 8),
(8436, 'Manati', 8),
(8520, 'Palmar de Varela', 8),
(8549, 'Piojo', 8),
(8558, 'Polo Nuevo', 8),
(8560, 'Ponedera', 8),
(8573, 'Puerto Colombia', 8),
(8606, 'Repelon', 8),
(8634, 'Sabanagrande', 8),
(8638, 'Sabanalarga', 8),
(8675, 'Santa Lucia', 8),
(8685, 'Santo Tomas', 8),
(8758, 'Soledad', 8),
(8770, 'Suan', 8),
(8832, 'Tubara', 8),
(8849, 'Usiacuri', 8),
(11001, 'Bogota', 11),
(13001, 'Cartagena', 13),
(13006, 'Achi', 13),
(13030, 'Altos del Rosario', 13),
(13042, 'Arenal', 13),
(13052, 'Arjona', 13),
(13062, 'Arroyohondo', 13),
(13074, 'Barranco de Loba', 13),
(13140, 'Calamar', 13),
(13160, 'Cantagallo', 13),
(13188, 'Cicuco', 13),
(13212, 'Cordoba', 13),
(13222, 'Clemencia', 13),
(13244, 'El Carmen de Bolivar', 13),
(13248, 'El Guamo', 13),
(13268, 'El PeÃ±on', 13),
(13300, 'Hatillo de Loba', 13),
(13430, 'Magangue', 13),
(13433, 'Mahates', 13),
(13440, 'Margarita', 13),
(13442, 'Maria La Baja', 13),
(13458, 'Montecristo', 13),
(13468, 'Mompos', 13),
(13473, 'Morales', 13),
(13490, 'Norosi', 13),
(13549, 'Pinillos', 13),
(13580, 'Regidor', 13),
(13600, 'Rio Viejo', 13),
(13620, 'San Cristobal', 13),
(13647, 'San Estanislao', 13),
(13650, 'San Fernando', 13),
(13654, 'San Jacinto', 13),
(13655, 'San Jacinto del Cauca', 13),
(13657, 'San Juan Nepomuceno', 13),
(13667, 'San Martin de Loba', 13),
(13670, 'San Pablo', 13),
(13673, 'Santa Catalina', 13),
(13683, 'Santa Rosa', 13),
(13688, 'Santa Rosa del Sur', 13),
(13744, 'Simiti', 13),
(13760, 'Soplaviento', 13),
(13780, 'Talaigua NUevo', 13),
(13810, 'Tiquisio (Puerto Ric', 13),
(13836, 'Turbaco', 13),
(13838, 'Turbana', 13),
(13873, 'Villanueva', 13),
(13894, 'Zambrano', 13),
(14001, 'Cartagena', 14),
(15001, 'Tunja', 15),
(15022, 'Almeida', 15),
(15047, 'Aquitania', 15),
(15051, 'Arcabuco', 15),
(15087, 'Belen', 15),
(15090, 'Berbeo', 15),
(15092, 'Beteitiva', 15),
(15097, 'Boavita', 15),
(15104, 'Boyaca', 15),
(15106, 'Briceno', 15),
(15109, 'Buenavista', 15),
(15114, 'Busbanza', 15),
(15131, 'Caldas', 15),
(15135, 'Campohermoso', 15),
(15162, 'Cerinza', 15),
(15172, 'Chinavita', 15),
(15176, 'Chiquinquira', 15),
(15180, 'Chiscas', 15),
(15183, 'Chita', 15),
(15185, 'Chitaraque', 15),
(15187, 'Chivata', 15),
(15189, 'Cienega', 15),
(15204, 'Combita', 15),
(15212, 'Coper', 15),
(15215, 'Corrales', 15),
(15218, 'Covarachia', 15),
(15223, 'Cubara', 15),
(15224, 'Cucaita', 15),
(15226, 'Cuitiva', 15),
(15232, 'Chiquiza', 15),
(15236, 'Chivor', 15),
(15238, 'Duitama', 15),
(15244, 'El Cocuy', 15),
(15248, 'El Espino', 15),
(15272, 'Firavitoba', 15),
(15276, 'Floresta', 15),
(15293, 'Gachantiva', 15),
(15296, 'Gameza', 15),
(15299, 'Garagoa', 15),
(15317, 'Guacamayas', 15),
(15322, 'Guateque', 15),
(15325, 'Guayata', 15),
(15332, 'Guican', 15),
(15362, 'Iza', 15),
(15367, 'Jenesano', 15),
(15368, 'Jerico', 15),
(15377, 'Labranzagrande', 15),
(15380, 'La Capilla', 15),
(15401, 'La Victoria', 15),
(15403, 'La Uvita', 15),
(15407, 'VIlla de Leyva', 15),
(15425, 'Macanal', 15),
(15442, 'Maripi', 15),
(15455, 'Miraflores', 15),
(15464, 'Mongua', 15),
(15466, 'Mongui', 15),
(15469, 'Moniquira', 15),
(15476, 'Motavita', 15),
(15480, 'Muzo', 15),
(15491, 'Nobsa', 15),
(15494, 'Nuevo Colon', 15),
(15500, 'Oicata', 15),
(15507, 'Otanche', 15),
(15511, 'Pachavita', 15),
(15514, 'Paez', 15),
(15516, 'Paipa', 15),
(15518, 'Pajarito', 15),
(15522, 'Panqueba', 15),
(15531, 'Pauna', 15),
(15533, 'Paya', 15),
(15537, 'Paz de Rio', 15),
(15542, 'Pesca', 15),
(15550, 'Pisba', 15),
(15572, 'Puerto Boyaca', 15),
(15580, 'Quipama', 15),
(15599, 'Ramiriqui', 15),
(15600, 'Raquira', 15),
(15621, 'Rondon', 15),
(15632, 'Saboya', 15),
(15638, 'Sachica', 15),
(15646, 'Samaca', 15),
(15660, 'San Eduardo', 15),
(15664, 'San Jose de Pare', 15),
(15667, 'San Luis de Gaceno', 15),
(15673, 'San Mateo', 15),
(15676, 'San Miguel de Sema', 15),
(15681, 'San Pablo de Borbur', 15),
(15686, 'Santana', 15),
(15690, 'Santa Maria', 15),
(15693, 'Santa Rosa de Viterb', 15),
(15696, 'Santa Sofia', 15),
(15720, 'Sativanorte', 15),
(15723, 'Sativasur', 15),
(15740, 'Siachoque', 15),
(15753, 'Soata', 15),
(15755, 'Socota', 15),
(15757, 'Socha', 15),
(15759, 'Sogamoso', 15),
(15761, 'Somondoco', 15),
(15762, 'Sora', 15),
(15763, 'Sotaquira', 15),
(15764, 'Soraca', 15),
(15774, 'Susacon', 15),
(15776, 'Sutamarchan', 15),
(15778, 'Sutatenza', 15),
(15790, 'Tasco', 15),
(15798, 'Tenza', 15),
(15804, 'Tibana', 15),
(15806, 'Tibasosa', 15),
(15808, 'Tinjaca', 15),
(15810, 'Tipacoque', 15),
(15814, 'Toca', 15),
(15816, 'Togui', 15),
(15820, 'Topaga', 15),
(15822, 'Tota', 15),
(15832, 'Tunungua', 15),
(15835, 'Turmeque', 15),
(15837, 'Tuta', 15),
(15839, 'Tutaza', 15),
(15842, 'Umbita', 15),
(15861, 'Ventaquemada', 15),
(15879, 'Viracacha', 15),
(15897, 'Zetaquira', 15),
(17001, 'Manizales', 17),
(17013, 'Aguadas', 17),
(17042, 'Anserma', 17),
(17050, 'Aranzazu', 17),
(17088, 'Belalcazar', 17),
(17174, 'Chinchina', 17),
(17272, 'Filadelfia', 17),
(17380, 'La Dorada', 17),
(17388, 'La Merced', 17),
(17433, 'Manzanares', 17),
(17442, 'Marmato', 17),
(17444, 'Marquetalia', 17),
(17446, 'Marulanda', 17),
(17486, 'Neira', 17),
(17495, 'Norcasia', 17),
(17513, 'Pacora', 17),
(17524, 'Palestina', 17),
(17541, 'Pensilvania', 17),
(17614, 'Riosucio', 17),
(17616, 'Risaralda', 17),
(17653, 'Salamina', 17),
(17662, 'Samana', 17),
(17665, 'San Jose', 17),
(17777, 'Supia', 17),
(17867, 'Victoria', 17),
(17873, 'Villamaria', 17),
(17877, 'Viterbo', 17),
(18001, 'Florencia', 18),
(18029, 'Albania', 18),
(18094, 'Belen de los Andaqui', 18),
(18150, 'Cartagena del Chaira', 18),
(18205, 'Curillo', 18),
(18247, 'El Doncello', 18),
(18256, 'El Paujil', 18),
(18410, 'La Montanita', 18),
(18460, 'Milan', 18),
(18479, 'Morelia', 18),
(18592, 'Puerto Rico', 18),
(18610, 'San Jose del Fragua', 18),
(18753, 'San Vicente del Cagu', 18),
(18756, 'Solano', 18),
(18785, 'Solita', 18),
(18860, 'Valparaiso', 18),
(19001, 'Popayan', 19),
(19022, 'Almaguer', 19),
(19050, 'Argelia', 19),
(19075, 'Balboa', 19),
(19100, 'Bolivar', 19),
(19110, 'Buenos Aires', 19),
(19130, 'Cajibio', 19),
(19137, 'Caldono', 19),
(19142, 'Caloto', 19),
(19212, 'Corinto', 19),
(19256, 'El Tambo', 19),
(19290, 'Florencia', 19),
(19318, 'Guapi', 19),
(19355, 'Inza', 19),
(19364, 'Jambalo', 19),
(19392, 'La Sierra', 19),
(19397, 'La Vega', 19),
(19418, 'Lopez (Micay)', 19),
(19450, 'Mercaderes', 19),
(19455, 'Miranda', 19),
(19473, 'Morales', 19),
(19513, 'Padilla', 19),
(19517, 'Paez', 19),
(19532, 'Patia (EL Bordo)', 19),
(19533, 'Piamonte', 19),
(19548, 'Piendamo', 19),
(19573, 'Puerto Tejada', 19),
(19585, 'Purace', 19),
(19622, 'Rosas', 19),
(19693, 'San Sebastian', 19),
(19698, 'Santander de Quilich', 19),
(19701, 'Santa Rosa', 19),
(19743, 'Silvia', 19),
(19760, 'Sotara', 19),
(19780, 'Suarez', 19),
(19785, 'Sucre', 19),
(19807, 'Timbio', 19),
(19809, 'Timbiqui', 19),
(19821, 'Toribio', 19),
(19824, 'ToToro', 19),
(19845, 'Villarica', 19),
(20001, 'Valledupar', 20),
(20011, 'Aguachica', 20),
(20013, 'Agustin Codazzi', 20),
(20032, 'Astrea', 20),
(20045, 'Becerril', 20),
(20060, 'Bosconia', 20),
(20175, 'Chimichagua', 20),
(20178, 'Chiriguana', 20),
(20228, 'Curumani', 20),
(20238, 'El Copey', 20),
(20250, 'El Paso', 20),
(20295, 'Gamarra', 20),
(20310, 'Gonzalez', 20),
(20383, 'La Gloria', 20),
(20400, 'La Jagua de Ibirico', 20),
(20443, 'Manaure Balcon del C', 20),
(20517, 'Pailitas', 20),
(20550, 'Pelaya', 20),
(20570, 'Pueblo Bello', 20),
(20614, 'Rio de Oro', 20),
(20621, 'Robles (La Paz)', 20),
(20710, 'San Alberto', 20),
(20750, 'San Diego', 20),
(20770, 'San Martin', 20),
(20787, 'Tamalameque', 20),
(23001, 'Monteria', 23),
(23068, 'Ayapel', 23),
(23079, 'Buenavista', 23),
(23090, 'Canalete', 23),
(23162, 'Cerete', 23),
(23168, 'Chima', 23),
(23182, 'Chinu', 23),
(23189, 'Cienaga de Oro', 23),
(23300, 'Cotorra', 23),
(23350, 'La Apartada', 23),
(23417, 'Lorica', 23),
(23419, 'Los Cordobas', 23),
(23464, 'Momil', 23),
(23466, 'Montelibano', 23),
(23500, 'MoÃ±itos', 23),
(23555, 'Planeta Rica', 23),
(23570, 'Pueblo Nuevo', 23),
(23574, 'Puerto Escondido', 23),
(23580, 'Puerto Libertador', 23),
(23586, 'Purisima', 23),
(23660, 'Sahagun', 23),
(23670, 'San Andres Sotavento', 23),
(23672, 'San Antero', 23),
(23675, 'San Bernardo del Vie', 23),
(23678, 'San Carlos', 23),
(23686, 'San Pelayo', 23),
(23807, 'Tierralta', 23),
(23855, 'Valencia', 23),
(25001, 'Agua de Dios', 25),
(25019, 'Alban', 25),
(25035, 'Anapoima', 25),
(25040, 'Anolaima', 25),
(25053, 'Arbelaez', 25),
(25086, 'Beltran', 25),
(25095, 'Bituima', 25),
(25099, 'Bojaca', 25),
(25120, 'Cabrera', 25),
(25123, 'Cachipay', 25),
(25126, 'CajicÃ¡', 25),
(25148, 'Caparrapi', 25),
(25151, 'Caqueza', 25),
(25154, 'Carmen de Carupa', 25),
(25168, 'Chaguani', 25),
(25175, 'Chí­a', 25),
(25178, 'Chipaque', 25),
(25181, 'Choachi', 25),
(25183, 'Choconta', 25),
(25200, 'Cogua', 25),
(25214, 'Cota', 25),
(25224, 'Cucunuba', 25),
(25245, 'El Colegio', 25),
(25258, 'El PeÃ±on', 25),
(25260, 'El Rosal', 25),
(25269, 'Facatativa', 25),
(25279, 'Fomeque', 25),
(25281, 'Fosca', 25),
(25286, 'Funza', 25),
(25288, 'Fuquene', 25),
(25290, 'Fusagasuga', 25),
(25293, 'Gachala', 25),
(25295, 'Gachancipa', 25),
(25297, 'Gacheta', 25),
(25299, 'Gama', 25),
(25307, 'Girardot', 25),
(25312, 'Granada', 25),
(25317, 'Guacheta', 25),
(25320, 'Guaduas', 25),
(25322, 'Guasca', 25),
(25324, 'Guataqui', 25),
(25326, 'Guatavita', 25),
(25328, 'Guayabal de Siquima', 25),
(25335, 'Guayabetal', 25),
(25339, 'Gutierrez', 25),
(25368, 'Jerusalen', 25),
(25372, 'Junin', 25),
(25377, 'La Calera', 25),
(25386, 'La Mesa', 25),
(25394, 'La Palma', 25),
(25398, 'La PeÃ±a', 25),
(25402, 'La Vega', 25),
(25407, 'Lenguazaque', 25),
(25426, 'Macheta', 25),
(25430, 'Madrid', 25),
(25436, 'Manta', 25),
(25438, 'Medina', 25),
(25473, 'Mosquera', 25),
(25483, 'NariÃ±o', 25),
(25486, 'Nemocon', 25),
(25488, 'Nilo', 25),
(25489, 'Nimaima', 25),
(25491, 'Nocaima', 25),
(25506, 'Venecia', 25),
(25513, 'Pacho', 25),
(25518, 'Paime', 25),
(25524, 'Pandi', 25),
(25530, 'Paratebueno', 25),
(25535, 'Pasca', 25),
(25572, 'Puerto Salgar', 25),
(25580, 'Puli', 25),
(25592, 'Quebradanegra', 25),
(25594, 'Quetame', 25),
(25596, 'Quipile', 25),
(25599, 'Apulo', 25),
(25612, 'Ricaurte', 25),
(25645, 'San Antonio del Tequendama', 25),
(25649, 'San Bernardo', 25),
(25653, 'San Cayetano', 25),
(25658, 'San Francisco', 25),
(25662, 'San Juan de Rio Seco', 25),
(25718, 'Sasaima', 25),
(25736, 'Sesquile', 25),
(25740, 'Sibate', 25),
(25743, 'Silvania', 25),
(25745, 'Simijaca', 25),
(25754, 'Soacha', 25),
(25758, 'Sopo', 25),
(25769, 'Subachoque', 25),
(25772, 'Suesca', 25),
(25777, 'Supata', 25),
(25779, 'Susa', 25),
(25781, 'Sutatausa', 25),
(25785, 'Tabio', 25),
(25793, 'Tausa', 25),
(25797, 'Tena', 25),
(25799, 'Tenjo', 25),
(25805, 'Tibacuy', 25),
(25807, 'Tibirita', 25),
(25815, 'Tocaima', 25),
(25817, 'TocancipÃ¡', 25),
(25823, 'Topaipi', 25),
(25839, 'Ubala', 25),
(25841, 'Ubaque', 25),
(25843, 'Villa de San Diego de Ubate', 25),
(25845, 'Une', 25),
(25851, 'Utica', 25),
(25862, 'Vergara', 25),
(25867, 'Viani', 25),
(25871, 'Villagomez', 25),
(25873, 'Villapinzon', 25),
(25875, 'Villeta', 25),
(25878, 'Viota', 25),
(25885, 'Yacopi', 25),
(25898, 'Zipacon', 25),
(25899, 'Zipaquirá', 25),
(27001, 'Quibdo', 27),
(27006, 'Acandi', 27),
(27025, 'Alto Baudo (Pie de P', 27),
(27050, 'Atrato', 27),
(27073, 'Bagado', 27),
(27075, 'Bahia Solano (Mutis)', 27),
(27077, 'Bajo Baudo (Pizarro)', 27),
(27099, 'Bojaya (Bellavista)', 27),
(27135, 'El Canton del San Pablo ', 27),
(27150, 'Carmen del Darien', 27),
(27160, 'Certegui', 27),
(27205, 'Condoto', 27),
(27245, 'El Carmen de Atrato', 27),
(27250, 'Litoral del Bajo San', 27),
(27361, 'Itsmina', 27),
(27372, 'Jurado', 27),
(27413, 'Lloro', 27),
(27425, 'Medio Atrato', 27),
(27430, 'Medio Baudo (Boca de', 27),
(27450, 'Medio San Juan', 27),
(27491, 'Novita', 27),
(27495, 'Nuqui', 27),
(27580, 'Rio Iro', 27),
(27600, 'Rioquito', 27),
(27615, 'Riosucio', 27),
(27660, 'San Jose del Palmar', 27),
(27745, 'Sipi', 27),
(27787, 'Tado', 27),
(27800, 'Unguia', 27),
(27810, 'Union Panamericana', 27),
(41001, 'Neiva', 41),
(41006, 'Acevedo', 41),
(41013, 'Agrado', 41),
(41016, 'Aipe', 41),
(41020, 'Algeciras', 41),
(41026, 'Altamira', 41),
(41078, 'Baraya', 41),
(41132, 'Campoalegre', 41),
(41206, 'Colombia', 41),
(41244, 'Elias', 41),
(41298, 'Garzon', 41),
(41306, 'Gigante', 41),
(41319, 'Guadalupe', 41),
(41349, 'Hobo', 41),
(41357, 'Iquira', 41),
(41359, 'Isnos (San Jose de I', 41),
(41378, 'La Argentina', 41),
(41396, 'La Plata', 41),
(41483, 'Nataga', 41),
(41503, 'Oporapa', 41),
(41518, 'Paicol', 41),
(41524, 'Palermo', 41),
(41530, 'Palestina', 41),
(41548, 'Pital', 41),
(41551, 'Pitalito', 41),
(41615, 'Rivera', 41),
(41660, 'Saladoblanco', 41),
(41668, 'San Agustin', 41),
(41676, 'Santa Maria', 41),
(41770, 'Suaza', 41),
(41791, 'Tarqui', 41),
(41797, 'Tesalia', 41),
(41799, 'Tello', 41),
(41801, 'Teruel', 41),
(41807, 'Timana', 41),
(41872, 'Villavieja', 41),
(41885, 'Yaguara', 41),
(44001, 'Riohacha', 44),
(44035, 'Albania', 44),
(44078, 'Barrancas', 44),
(44090, 'Dibulla', 44),
(44098, 'Distraccion', 44),
(44110, 'El Molino', 44),
(44279, 'Fonseca', 44),
(44378, 'Hatonuevo', 44),
(44420, 'La Jagua del Pilar', 44),
(44430, 'Maicao', 44),
(44560, 'Manaure', 44),
(44650, 'San Juan del Cesar', 44),
(44847, 'Uribia', 44),
(44855, 'Urumita', 44),
(44874, 'Villanueva', 44),
(47001, 'Santa Marta', 47),
(47030, 'Algarrobo', 47),
(47053, 'Aracataca', 47),
(47058, 'Ariguani (El Dificil', 47),
(47161, 'Cerro San Antonio', 47),
(47170, 'Chivolo', 47),
(47189, 'Cienaga', 47),
(47205, 'Concordia', 47),
(47245, 'El Banco', 47),
(47258, 'El PiÃ±on', 47),
(47268, 'El Reten', 47),
(47288, 'Fundacion', 47),
(47318, 'Guamal', 47),
(47460, 'Nueva Granada', 47),
(47541, 'Pedraza', 47),
(47545, 'PijiÃ±o del Carmen (P', 47),
(47551, 'Pivijay', 47),
(47555, 'Plato', 47),
(47570, 'Puebloviejo', 47),
(47605, 'Remolino', 47),
(47660, 'Sabanas de San Angel', 47),
(47675, 'Salamina', 47),
(47692, 'San Sebastian de Bue', 47),
(47703, 'San Zenon', 47),
(47707, 'Santa Ana', 47),
(47720, 'Santa Barbara de Pin', 47),
(47745, 'Sitio Nuevo', 47),
(47798, 'Tenerife', 47),
(47960, 'Zapayan', 47),
(47980, 'Zona Bananera', 47),
(47983, 'Bordo', 19),
(50001, 'Villavicencio', 50),
(50006, 'Acacias', 50),
(50110, 'Barranca de Upia', 50),
(50124, 'Cabuyaro', 50),
(50150, 'Castilla La Nueva', 50),
(50223, 'Cubarral', 50),
(50226, 'Cumaral', 50),
(50245, 'El Calvario', 50),
(50251, 'El Castillo', 50),
(50270, 'El Dorado', 50),
(50287, 'Fuente de Oro', 50),
(50313, 'Granada', 50),
(50318, 'Guamal', 50),
(50325, 'Mapiripan', 50),
(50330, 'Mesetas', 50),
(50350, 'La Macarena', 50),
(50370, 'La Uribe', 50),
(50400, 'Lejanias', 50),
(50450, 'Puerto Concordia', 50),
(50568, 'Puerto Gaitan', 50),
(50573, 'Puerto Lopez', 50),
(50577, 'Puerto Lleras', 50),
(50590, 'Puerto Rico', 50),
(50606, 'Restrepo', 50),
(50680, 'San Carlos de Guaroa', 50),
(50683, 'San Juan de Arama', 50),
(50686, 'San Juanito', 50),
(50689, 'San Martin', 50),
(50711, 'Vistahermosa', 50),
(52001, 'Pasto', 52),
(52019, 'Alban (San Jose)', 52),
(52022, 'Aldana', 52),
(52036, 'Ancuya', 52),
(52051, 'Arboleda (Berruecos)', 52),
(52079, 'Barbacoas', 52),
(52083, 'Belen', 52),
(52110, 'Buesaco', 52),
(52203, 'Colon (Genova)', 52),
(52207, 'Consaca', 52),
(52210, 'Contadero', 52),
(52215, 'Cordoba', 52),
(52224, 'Cuaspud (Carlosama)', 52),
(52227, 'Cumbal', 52),
(52233, 'Cumbitara', 52),
(52240, 'Chachagui', 52),
(52250, 'El Charco', 52),
(52254, 'El PeÃ±ol', 52),
(52256, 'El Rosario', 52),
(52258, 'El Tablon', 52),
(52260, 'El Tambo', 52),
(52287, 'Funes', 52),
(52317, 'Guachucal', 52),
(52320, 'Guaitarilla', 52),
(52323, 'Gualmatan', 52),
(52352, 'Iles', 52),
(52354, 'Imues', 52),
(52356, 'Ipiales', 52),
(52378, 'La Cruz', 52),
(52381, 'La Florida', 52),
(52385, 'La Llanada', 52),
(52390, 'La Tola', 52),
(52399, 'La Union', 52),
(52405, 'Leiva', 52),
(52411, 'Linares', 52),
(52418, 'Los Andes (Sotomayor', 52),
(52427, 'Magui (Payan)', 52),
(52435, 'Mallama (Piedrancha)', 52),
(52473, 'Mosquera', 52),
(52480, 'NariÃ±o', 52),
(52490, 'Olaya Herrera(Bocas ', 52),
(52506, 'Ospina', 52),
(52520, 'Francisco Pizarro (S', 52),
(52540, 'Policarpa', 52),
(52560, 'Potosi', 52),
(52565, 'Providencia', 52),
(52573, 'Puerres', 52),
(52585, 'Pupiales', 52),
(52612, 'Ricaurte', 52),
(52621, 'Roberto Payan (San J', 52),
(52678, 'Samaniego', 52),
(52683, 'Sandona', 52),
(52685, 'San Bernardo', 52),
(52687, 'San Lorenzo', 52),
(52693, 'San Pablo', 52),
(52694, 'San Pedro de Cartago', 52),
(52696, 'Santa Barbara (Iscua', 52),
(52699, 'Santa Cruz (Guachave', 52),
(52720, 'Sapuyes', 52),
(52786, 'Taminango', 52),
(52788, 'Tangua', 52),
(52835, 'Tumaco', 52),
(52838, 'Tuquerres', 52),
(52885, 'Yacuanquer', 52),
(54001, 'Cucuta', 54),
(54003, 'Abrego', 54),
(54051, 'Arboledas', 54),
(54099, 'Bochalema', 54),
(54109, 'Bucarasica', 54),
(54125, 'Cacota', 54),
(54128, 'Cachira', 54),
(54172, 'Chinacota', 54),
(54174, 'Chitaga', 54),
(54206, 'Convencion', 54),
(54223, 'Cucutilla', 54),
(54239, 'Durania', 54),
(54245, 'El Carmen', 54),
(54250, 'El Tarra', 54),
(54261, 'El Zulia', 54),
(54313, 'Gramalote', 54),
(54344, 'Hacari', 54),
(54347, 'Herran', 54),
(54377, 'Labateca', 54),
(54385, 'La Esperanza', 54),
(54398, 'La Playa', 54),
(54405, 'Los Patios', 54),
(54418, 'Lourdes', 54),
(54480, 'Mutiscua', 54),
(54498, 'OcaÃ±a', 54),
(54518, 'Pamplona', 54),
(54520, 'Pamplonita', 54),
(54553, 'Puerto Santander', 54),
(54599, 'Ragonvalia', 54),
(54660, 'Salazar', 54),
(54670, 'San Calixto', 54),
(54673, 'San Cayetano', 54),
(54680, 'Santiago', 54),
(54720, 'Sardinata', 54),
(54743, 'Silos', 54),
(54800, 'Teorama', 54),
(54810, 'Tibu', 54),
(54820, 'Toledo', 54),
(54871, 'Villa Caro', 54),
(54874, 'Villa del Rosario', 54),
(63001, 'Armenia', 63),
(63111, 'Buenavista', 63),
(63130, 'Calarca', 63),
(63190, 'Circasia', 63),
(63212, 'Cordoba', 63),
(63272, 'Filandia', 63),
(63302, 'Genova', 63),
(63401, 'La Tebaida', 63),
(63470, 'Montenegro', 63),
(63548, 'Pijao', 63),
(63594, 'Quimbaya', 63),
(63690, 'Salento', 63),
(66001, 'Pereira', 66),
(66045, 'Apia', 66),
(66075, 'Balboa', 66),
(66088, 'Belen de Umbria', 66),
(66170, 'Dosquebradas', 66),
(66318, 'Guatica', 66),
(66383, 'La Celia', 66),
(66400, 'La Virginia', 66),
(66440, 'Marsella', 66),
(66456, 'Mistrato', 66),
(66572, 'Pueblo Rico', 66),
(66594, 'Quinchia', 66),
(66682, 'Santa Rosa de Cabal', 66),
(66687, 'Santuario', 66),
(68001, 'Bucaramanga', 68),
(68013, 'Aguada', 68),
(68020, 'Albania', 68),
(68051, 'Aratoca', 68),
(68077, 'Barbosa', 68),
(68079, 'Barichara', 68),
(68081, 'Barrancabermeja', 68),
(68092, 'Betulia', 68),
(68101, 'Bolivar', 68),
(68121, 'Cabrera', 68),
(68132, 'California', 68),
(68147, 'Capitanejo', 68),
(68152, 'Carcasi', 68),
(68160, 'Cepita', 68),
(68162, 'Cerrito', 68),
(68167, 'Charala', 68),
(68169, 'Charta', 68),
(68176, 'Chima', 68),
(68179, 'Chipata', 68),
(68190, 'Cimitarra', 68),
(68207, 'Concepcion', 68),
(68209, 'Confines', 68),
(68211, 'Contratacion', 68),
(68217, 'Coromoro', 68),
(68229, 'Curiti', 68),
(68235, 'El Carmen de Chucuri', 68),
(68245, 'El Guacamayo', 68),
(68250, 'El PeÃ±on', 68),
(68255, 'El Playon', 68),
(68264, 'Encino', 68),
(68266, 'Enciso', 68),
(68271, 'Florian', 68),
(68276, 'Floridablanca', 68),
(68296, 'Galan', 68),
(68298, 'Gambita', 68),
(68307, 'Giron', 68),
(68318, 'Guaca', 68),
(68320, 'Guadalupe', 68),
(68322, 'Guapota', 68),
(68324, 'Guavata', 68),
(68327, 'Guepsa', 68),
(68344, 'Hato', 68),
(68368, 'Jesus Maria', 68),
(68370, 'Jordan', 68),
(68377, 'La Belleza', 68),
(68385, 'Landazuri', 68),
(68397, 'La Paz', 68),
(68406, 'Lebrija', 68),
(68418, 'Los Santos', 68),
(68425, 'Macaravita', 68),
(68432, 'Malaga', 68),
(68444, 'Matanza', 68),
(68464, 'Mogotes', 68),
(68468, 'Molagavita', 68),
(68498, 'Ocamonte', 68),
(68500, 'Oiba', 68),
(68502, 'Onzaga', 68),
(68522, 'Palmar', 68),
(68524, 'Palmas Socorro', 68),
(68533, 'Paramo', 68),
(68547, 'Piedecuesta', 68),
(68549, 'Pinchote', 68),
(68572, 'Puente Nacional', 68),
(68573, 'Puerto Parra', 68),
(68575, 'Puerto Wilches', 68),
(68615, 'Rionegro', 68),
(68655, 'Sabana de Torres', 68),
(68669, 'San Andres', 68),
(68673, 'San Benito', 68),
(68679, 'San Gil', 68),
(68682, 'San Joaquin', 68),
(68684, 'San Jose de Miranda', 68),
(68686, 'San Miguel', 68),
(68689, 'San Vicente de Chucu', 68),
(68705, 'Santa Barbara', 68),
(68720, 'Santa Helena del Opo', 68),
(68745, 'Simacota', 68),
(68755, 'Socorro', 68),
(68770, 'Suaita', 68),
(68773, 'Sucre', 68),
(68780, 'Surata', 68),
(68820, 'Tona', 68),
(68855, 'Valle de San Jose', 68),
(68861, 'Velez', 68),
(68867, 'Vetas', 68),
(68872, 'Villanueva', 68),
(68895, 'Zapatoca', 68),
(70001, 'Sincelejo', 70),
(70110, 'Buenavista', 70),
(70124, 'Caimito', 70),
(70204, 'Coloso (Ricaurte)', 70),
(70215, 'Corozal', 70),
(70221, 'CoveÃ±as', 70),
(70230, 'Chalan', 70),
(70233, 'El Roble', 70),
(70235, 'Galeras (Nueva Grana', 70),
(70265, 'Guaranda', 70),
(70400, 'La Union', 70),
(70418, 'Los Palmitos', 70),
(70429, 'Majagual', 70),
(70473, 'Morroa', 70),
(70508, 'Ovejas', 70),
(70523, 'Palmito', 70),
(70670, 'Sampues', 70),
(70678, 'San Benito Abad', 70),
(70702, 'San Juan de Betulia', 70),
(70708, 'San Marcos', 70),
(70713, 'San Onofre', 70),
(70717, 'San Pedro', 70),
(70742, 'Since', 70),
(70771, 'Sucre', 70),
(70820, 'Tolu', 70),
(70823, 'Toluviejo', 70),
(73001, 'Ibague', 73),
(73024, 'Alpujarra', 73),
(73026, 'Alvarado', 73),
(73030, 'Ambalema', 73),
(73043, 'Anzoategui', 73),
(73055, 'Armero (Guayabal)', 73),
(73067, 'Ataco', 73),
(73124, 'Cajamarca', 73),
(73148, 'Carmen de Apicala', 73),
(73152, 'Casabianca', 73),
(73168, 'Chaparral', 73),
(73200, 'Coello', 73),
(73217, 'Coyaima', 73),
(73226, 'Cunday', 73),
(73236, 'Dolores', 73),
(73268, 'Espinal', 73),
(73270, 'Falan', 73),
(73275, 'Flandes', 73),
(73283, 'Fresno', 73),
(73319, 'Guamo', 73),
(73347, 'Herveo', 73),
(73349, 'Honda', 73),
(73352, 'Icononzo', 73),
(73408, 'Lerida', 73),
(73411, 'Libano', 73),
(73443, 'Mariquita', 73),
(73449, 'Melgar', 73),
(73461, 'Murillo', 73),
(73483, 'Natagaima', 73),
(73504, 'Ortega', 73),
(73520, 'Palocabildo', 73),
(73547, 'Piedras', 73),
(73555, 'Planadas', 73),
(73563, 'Prado', 73),
(73585, 'Purificacion', 73),
(73616, 'Rioblanco', 73),
(73622, 'Roncesvalles', 73),
(73624, 'Rovira', 73),
(73671, 'SaldaÃ±a', 73),
(73675, 'San Antonio', 73),
(73678, 'San Luis', 73),
(73686, 'Santa Isabel', 73),
(73770, 'Suarez', 73),
(73854, 'Valle de San Juan', 73),
(73861, 'Venadillo', 73),
(73870, 'Villahermosa', 73),
(73873, 'Villarica', 73),
(76001, 'Cali', 76),
(76020, 'Alcala', 76),
(76036, 'Andalucia', 76),
(76041, 'Ansermanuevo', 76),
(76054, 'Argelia', 76),
(76100, 'Bolivar', 76),
(76109, 'Buenaventura', 76),
(76111, 'Buga', 76),
(76113, 'Bugalagrande', 76),
(76122, 'Caicedonia', 76),
(76126, 'Darien', 76),
(76130, 'Candelaria', 76),
(76147, 'Cartago', 76),
(76233, 'Dagua', 76),
(76243, 'El Aguila', 76),
(76246, 'El Cairo', 76),
(76248, 'El Cerrito', 76),
(76250, 'El Dovio', 76),
(76275, 'Florida', 76),
(76306, 'Ginebra', 76),
(76318, 'Guacari', 76),
(76364, 'Jamundi', 76),
(76377, 'La Cumbre', 76),
(76400, 'La Union', 76),
(76403, 'La Victoria', 76),
(76497, 'Obando', 76),
(76520, 'Palmira', 76),
(76563, 'Pradera', 76),
(76606, 'Restrepo', 76),
(76616, 'Riofrio', 76),
(76622, 'Roldanillo', 76),
(76670, 'San Pedro', 76),
(76736, 'Sevilla', 76),
(76823, 'Toro', 76),
(76828, 'Trujillo', 76),
(76834, 'Tulua', 76),
(76845, 'Ulloa', 76),
(76863, 'Versalles', 76),
(76869, 'Vijes', 76),
(76890, 'Yotoco', 76),
(76892, 'Yumbo', 76),
(76895, 'Zarzal', 76),
(81001, 'Arauca', 81),
(81065, 'Arauquita', 81),
(81220, 'Cravo Norte', 81),
(81300, 'Fortul', 81),
(81591, 'Puerto Rondon', 81),
(81736, 'Saravena', 81),
(81794, 'Tame', 81),
(85001, 'Yopal', 85),
(85010, 'Aguazul', 85),
(85015, 'Chameza', 85),
(85125, 'Hato Corozal', 85),
(85136, 'La Salina', 85),
(85139, 'Mani', 85),
(85162, 'Monterrey', 85),
(85225, 'Nunchia', 85),
(85230, 'Orocue', 85),
(85250, 'Paz de Ariporo', 85),
(85263, 'Pore', 85),
(85279, 'Recetor', 85),
(85300, 'Sabanalarga', 85),
(85315, 'Sacama', 85),
(85325, 'San Luis de Palenque', 85),
(85400, 'Tamara', 85),
(85410, 'Tauramena', 85),
(85430, 'Trinidad', 85),
(85440, 'Villanueva', 85),
(86001, 'Mocoa', 86),
(86219, 'Colon', 86),
(86320, 'Orito', 86),
(86568, 'Puerto Asis', 86),
(86569, 'Puerto Caicedo', 86),
(86571, 'Puerto Guzman', 86),
(86573, 'Puerto Leguizamo', 86),
(86749, 'Sibundoy', 86),
(86755, 'San Francisco', 86),
(86757, 'San Miguel (La Dorad', 86),
(86760, 'Santiago', 86),
(86865, 'Valle del Guamuez', 86),
(86885, 'Villagarzon', 86),
(88001, 'San Andres', 88),
(88564, 'Providencia', 88),
(91001, 'Leticia', 91),
(91263, 'El Encanto (CD)', 91),
(91405, 'La Chorrera (CD)', 91),
(91407, 'La Pedrera (CD)', 91),
(91430, 'La Victoria (CD)', 91),
(91460, 'Miriti Parana (CD)', 91),
(91530, 'Puerto Alegria (CD)', 91),
(91536, 'Puerto Arica (CD)', 91),
(91540, 'Puerto Nariño', 91),
(91669, 'Puerto Santander (CD', 91),
(91798, 'Tarapaca (CD)', 91),
(94001, 'Puerto Inirida', 94),
(94343, 'Barranco Minas', 94),
(94663, 'Mapiripana', 94),
(94883, 'San Felipe', 94),
(94884, 'Puerto Colombia', 94),
(94885, 'La Guadalupe', 94),
(94886, 'Cacahual', 94),
(94887, 'Pana Pana', 94),
(94888, 'Morichal', 94),
(95001, 'San Jose del Guaviare', 95),
(95015, 'Calamar', 95),
(95025, 'El Retorno', 95),
(95200, 'Miraflores', 95),
(97001, 'Mitu', 97),
(97161, 'Caruru', 97),
(97511, 'Pacoa (CD)', 97),
(97666, 'Taraira', 97),
(97777, 'Papunaua (Morichal) ', 97),
(97889, 'Yavarate (CD)', 97),
(99001, 'Puerto Carreño', 99),
(99524, 'La Primavera', 99),
(99624, 'Santa Rosalia', 99),
(99773, 'Cumaribo', 99),
(99774, NULL, NULL);

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
  `tipdoc` varchar(4) DEFAULT NULL,
  `idval` int(5) DEFAULT NULL,
  `idubi` int(5) DEFAULT NULL,
  `feccreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fotpef` varchar(255) DEFAULT NULL,
  `idpef` int(5) NOT NULL,
  `pasusu` varchar(300) NOT NULL,
  `estusu` varchar(10) DEFAULT 'Activo',
  `token_recuperacion` varchar(255) DEFAULT NULL,
  `token_expira` datetime DEFAULT NULL,
  `esteli` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusu`, `nomusu`, `apeusu`, `docusu`, `emausu`, `celusu`, `genusu`, `dirrecusu`, `tipdoc`, `idval`, `idubi`, `feccreate`, `fecupdate`, `fotpef`, `idpef`, `pasusu`, `estusu`, `token_recuperacion`, `token_expira`, `esteli`) VALUES
(16, 'David', 'Soriano', 101564, 'admin@gmail.com', '3186274255', 'M', NULL, 'CC', NULL, 15322, '2024-11-27 21:20:01', '2025-02-13 02:21:53', NULL, 2, '$2y$10$aGcbgN7SK.mxZRsTEfI3jeOcW7sueH9H4d.vRli3ouesWF6NG.SS6', 'Activo', NULL, NULL, 0),
(20, 'DavidX', 'ss', 104544, 'davidx@gmail.com', '45674658', 'M', 'Vereda la balsa', 'CC', NULL, 47030, '2024-12-13 23:20:35', '2025-03-03 14:47:38', NULL, 1, '$2y$10$rkzjvt6ZirdI5g2OKCyyeONzPP9T1vd0oTb3iJXoaWDh3AyA.ajnG', 'Activo', '89fc8200fefff72640e1770ae9050ced307e8e6fe4d1253d93d5dc1e3d4e2bbff1196eef608d6e2333763e263f765ada1598', '2025-02-17 10:38:43', 1),
(27, 'Juan David', 'Soriano Cicua', 1049794389, 'davidscicua314@gmail.com', '3186274255', 'M', 'Vereda la balsa calle 9a Sur', 'CC', NULL, 25175, '2025-02-17 14:41:33', '2025-03-12 12:50:06', NULL, 1, '$2y$10$/9So.AzckXsDGT3q/jvKZeBcom9Pgt.CP9OIBEuSP6xWV7TeuL19C', 'Activo', '0e531ff392b9cc636fab49e55a76b30a9c3e9013bb9666b48dedc016059b730f67552ce69140f0fe4e41e77a4aeb1df26de8', '2025-03-12 08:50:06', 0),
(30, 'David', 'Soriano', 1049794389, 'toshoop2024@gmail.com', '3111111111', 'M', 'vereda la balsa', 'CC', NULL, 25175, '2025-03-08 01:35:53', '2025-03-08 01:39:17', NULL, 1, '$2y$10$cdQ2QD2WzMU7JrHZ3iZcpOB1LtZMr0BIZ4ywO23kZz4QnbuP1PHWS', 'Activo', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valor`
--

CREATE TABLE `valor` (
  `idval` int(5) NOT NULL,
  `nomval` varchar(255) DEFAULT NULL,
  `act` tinyint(1) DEFAULT NULL,
  `idusu` int(5) DEFAULT NULL,
  `iddom` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `valor`
--

INSERT INTO `valor` (`idval`, `nomval`, `act`, `idusu`, `iddom`) VALUES
(1, 'Moda', NULL, NULL, 1),
(2, 'Tecnología', NULL, NULL, 1),
(3, 'Accesorios', NULL, NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`idaud`);

--
-- Indices de la tabla `busquedas`
--
ALTER TABLE `busquedas`
  ADD PRIMARY KEY (`idbusqueda`),
  ADD KEY `idusu` (`idusu`);

--
-- Indices de la tabla `caracteristicas`
--
ALTER TABLE `caracteristicas`
  ADD PRIMARY KEY (`idcar`),
  ADD KEY `idpro` (`idpro`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`idcar`),
  ADD KEY `idusu` (`idusu`);

--
-- Indices de la tabla `comisiones`
--
ALTER TABLE `comisiones`
  ADD PRIMARY KEY (`idcomis`),
  ADD KEY `idcom` (`idcom`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcom`),
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
  ADD KEY `idpro` (`idpro`),
  ADD KEY `idx_idcom` (`idcom`);

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
  ADD KEY `idpro` (`idpro`),
  ADD KEY `idx_idubi` (`idubi`);

--
-- Indices de la tabla `devolucionreembolso`
--
ALTER TABLE `devolucionreembolso`
  ADD PRIMARY KEY (`iddevo`),
  ADD KEY `idped` (`idped`),
  ADD KEY `idpro` (`idpro`);

--
-- Indices de la tabla `dominio`
--
ALTER TABLE `dominio`
  ADD PRIMARY KEY (`iddom`);

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
  ADD KEY `idpro` (`idpro`),
  ADD KEY `fk_imagen_pagina` (`urlimg`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idmen`);

--
-- Indices de la tabla `ordenes_temporales`
--
ALTER TABLE `ordenes_temporales`
  ADD PRIMARY KEY (`idord`),
  ADD KEY `fk_ordenes_usuarios` (`idusu`);

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
  ADD PRIMARY KEY (`idperpf`),
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
  ADD PRIMARY KEY (`idpro`),
  ADD KEY `fk_producto_valor` (`idval`);

--
-- Indices de la tabla `prodxprov`
--
ALTER TABLE `prodxprov`
  ADD PRIMARY KEY (`idprodprv`),
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
-- Indices de la tabla `respuestas_pqr`
--
ALTER TABLE `respuestas_pqr`
  ADD PRIMARY KEY (`idrespuesta`),
  ADD KEY `idpqr` (`idpqr`);

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
  ADD KEY `idusu` (`idusu`),
  ADD KEY `fk_valor_dominio` (`iddom`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `busquedas`
--
ALTER TABLE `busquedas`
  MODIFY `idbusqueda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `caracteristicas`
--
ALTER TABLE `caracteristicas`
  MODIFY `idcar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `idcar` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `comisiones`
--
ALTER TABLE `comisiones`
  MODIFY `idcomis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `idcof` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detallecarrito`
--
ALTER TABLE `detallecarrito`
  MODIFY `iddetcar` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  MODIFY `iddell` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `detallefavoritos`
--
ALTER TABLE `detallefavoritos`
  MODIFY `iddetfav` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `iddet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `devolucionreembolso`
--
ALTER TABLE `devolucionreembolso`
  MODIFY `iddevo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `dominio`
--
ALTER TABLE `dominio`
  MODIFY `iddom` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `idfav` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `idimag` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=388;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `idmen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `ordenes_temporales`
--
ALTER TABLE `ordenes_temporales`
  MODIFY `idord` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pagina`
--
ALTER TABLE `pagina`
  MODIFY `idpag` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `idpag` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagxperfil`
--
ALTER TABLE `pagxperfil`
  MODIFY `idperpf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idped` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `idpef` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pqr`
--
ALTER TABLE `pqr`
  MODIFY `idpqr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idpro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT de la tabla `prodxprov`
--
ALTER TABLE `prodxprov`
  MODIFY `idprodprv` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idprov` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `respuestas_pqr`
--
ALTER TABLE `respuestas_pqr`
  MODIFY `idrespuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `review`
--
ALTER TABLE `review`
  MODIFY `idrev` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `submenu`
--
ALTER TABLE `submenu`
  MODIFY `idsbm` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `idubi` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99775;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusu` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `valor`
--
ALTER TABLE `valor`
  MODIFY `idval` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `busquedas`
--
ALTER TABLE `busquedas`
  ADD CONSTRAINT `busquedas_ibfk_1` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`);

--
-- Filtros para la tabla `caracteristicas`
--
ALTER TABLE `caracteristicas`
  ADD CONSTRAINT `caracteristicas_ibfk_1` FOREIGN KEY (`idpro`) REFERENCES `producto` (`idpro`) ON DELETE CASCADE;

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`);

--
-- Filtros para la tabla `comisiones`
--
ALTER TABLE `comisiones`
  ADD CONSTRAINT `comisiones_ibfk_1` FOREIGN KEY (`idcom`) REFERENCES `compra` (`idcom`) ON DELETE CASCADE;

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`idubi`) REFERENCES `ubicacion` (`idubi`),
  ADD CONSTRAINT `fk_com_ped` FOREIGN KEY (`idped`) REFERENCES `pedido` (`idped`),
  ADD CONSTRAINT `fk_com_usu` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`);

--
-- Filtros para la tabla `detallecarrito`
--
ALTER TABLE `detallecarrito`
  ADD CONSTRAINT `detallecarrito_ibfk_1` FOREIGN KEY (`idcar`) REFERENCES `carrito` (`idcar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detallecarrito_ibfk_2` FOREIGN KEY (`idpro`) REFERENCES `producto` (`idpro`);

--
-- Filtros para la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  ADD CONSTRAINT `detallecompra_ibfk_1` FOREIGN KEY (`idpro`) REFERENCES `producto` (`idpro`),
  ADD CONSTRAINT `detallecompra_ibfk_2` FOREIGN KEY (`idcom`) REFERENCES `compra` (`idcom`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detallefavoritos`
--
ALTER TABLE `detallefavoritos`
  ADD CONSTRAINT `detallefavoritos_ibfk_1` FOREIGN KEY (`idfav`) REFERENCES `favoritos` (`idfav`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detallefavoritos_ibfk_2` FOREIGN KEY (`idpro`) REFERENCES `producto` (`idpro`);

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`idped`) REFERENCES `pedido` (`idped`),
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`idpro`) REFERENCES `producto` (`idpro`),
  ADD CONSTRAINT `detalle_pedido_ibfk_3` FOREIGN KEY (`idubi`) REFERENCES `ubicacion` (`idubi`);

--
-- Filtros para la tabla `devolucionreembolso`
--
ALTER TABLE `devolucionreembolso`
  ADD CONSTRAINT `devolucionreembolso_ibfk_1` FOREIGN KEY (`idped`) REFERENCES `pedido` (`idped`),
  ADD CONSTRAINT `devolucionreembolso_ibfk_2` FOREIGN KEY (`idpro`) REFERENCES `producto` (`idpro`);

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`);

--
-- Filtros para la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD CONSTRAINT `fk_imagen_pagina` FOREIGN KEY (`urlimg`) REFERENCES `pagina` (`idpag`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `imagen_ibfk_1` FOREIGN KEY (`idpro`) REFERENCES `producto` (`idpro`);

--
-- Filtros para la tabla `ordenes_temporales`
--
ALTER TABLE `ordenes_temporales`
  ADD CONSTRAINT `fk_ordenes_usuarios` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `fk_producto_valor` FOREIGN KEY (`idval`) REFERENCES `valor` (`idval`);

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
-- Filtros para la tabla `respuestas_pqr`
--
ALTER TABLE `respuestas_pqr`
  ADD CONSTRAINT `respuestas_pqr_ibfk_1` FOREIGN KEY (`idpqr`) REFERENCES `pqr` (`idpqr`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `fk_valor_dominio` FOREIGN KEY (`iddom`) REFERENCES `dominio` (`iddom`),
  ADD CONSTRAINT `valor_ibfk_1` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
