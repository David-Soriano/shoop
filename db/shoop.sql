DROP DATABASE IF EXISTS shoop;
CREATE DATABASE shoop;
USE shoop;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `shoop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `idadmin` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecharegistro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Estructura de tabla para la tabla `caracteristicas`
--

CREATE TABLE `caracteristicas` (
  `idcar` int(11) NOT NULL,
  `idpro` int(11) DEFAULT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `caracteristicas`
--

INSERT INTO `caracteristicas` (`idcar`, `idpro`, `descripcion`) VALUES
(1, 3, 'Composición: 100% algodón'),
(2, 3, 'Color: Blanco'),
(3, 3, 'Tamaño: M'),
(4, 3, 'Tipo de cuello: Redondo'),
(5, 3, 'Manga corta'),
(6, 3, 'Estilo: Casual'),
(7, 3, 'Tejido suave y cómodo'),
(8, 3, 'Lavable a máquina'),
(9, 3, 'Ideal para climas cálidos'),
(10, 3, 'Ajuste regular');

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

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`iddet`, `idped`, `idpro`, `cantidad`, `precio`) VALUES
(1, 1, 7, 5, 30000.00);

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
  `fechaprocesamiento` timestamp NULL DEFAULT NULL,
  `montoreembolso` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `lugimg` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`idimag`, `imgpro`, `nomimg`, `tipimg`, `idpro`, `ordimg`, `lugimg`) VALUES
(1, 'proinf/camiseta.png', 'Camiseta de algodón', 'png', 3, 1, NULL),
(11, 'proinf/jeans.png', 'Pantalón vaquero', 'png', 4, 1, NULL),
(12, 'proinf/zapatos.png', 'Zapatos deportivos', 'png', 5, 1, NULL),
(13, 'proinf/bolso.png', 'Bolso de cuero', 'png', 6, 1, NULL),
(14, 'proinf/reloj.png', 'Reloj digital', 'png', 7, 1, NULL),
(15, 'proinf/gorra.png', 'Gorra de béisbol', 'png', 8, 1, NULL),
(16, 'proinf/sudadera.png', 'Sudadera con capucha', 'png', 9, 1, NULL),
(17, 'proinf/bufanda.png', 'Bufanda de lana', 'png', 10, 1, NULL),
(18, 'proinf/cartera.png', 'Cartera pequeña', 'png', 11, 1, NULL),
(19, 'proinf/sombrero.png', 'Sombrero de paja', 'png', 12, 1, NULL),
(21, 'proinf/camiseta-min.png', 'Camiseta Colombia', 'png', 3, 2, NULL),
(22, 'IMG/publicidad4.jpg', 'Sport', 'jpg', NULL, 1, 1),
(23, 'IMG/publicidad7.jpg', 'Mac Mini', 'jpg', NULL, 3, 1),
(24, 'IMG/publicidad3.jpg', 'Yu Na', 'jpg', NULL, 2, 1);

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
(3, 'Ayuda/PQR', 'index.php?pg=8', 3, NULL, 'home.php?pg=8', 1, 0, NULL, NULL),
(4, 'Iniciar Sesión', 'views/vwLogin.php', 4, 0, 'views/vwLogin.php', 0, 0, NULL, NULL),
(5, 'Productos', '#', 5, 1, NULL, 0, 0, NULL, NULL),
(6, 'Vender', NULL, 6, 1, 'views/vwpanpro.php', 0, 0, NULL, NULL),
(7, 'Cerrar Sesión', 'views/vwExit.php', 10, 1, NULL, 0, 1, NULL, NULL),
(8, 'Perfil', 'home.php?pg=15', 7, 1, NULL, 0, 1, NULL, NULL),
(9, 'Tus Pedidos', 'home.php?pg=17', 8, 1, NULL, 0, 1, NULL, 1),
(10, 'Tus Compras', 'home.php?pg=16', 9, 1, NULL, 0, 1, NULL, 1),
(11, 'Favoritos', 'index.php?pg=002', 11, NULL, 'home.php?pg=002', 0, 2, 'bi bi-heart', NULL),
(12, 'Carro Compras', 'index.php?pg=003', 12, NULL, 'home.php?pg=003', 0, 2, 'bi bi-basket3', NULL),
(13, 'Icono User', NULL, 0, NULL, NULL, 0, 3, 'bi bi-person-circle', NULL);

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
  `lugpag` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagina`
--

INSERT INTO `pagina` (`idpag`, `nompag`, `rutpag`, `mospag`, `icopag`, `lugpag`) VALUES
(1, 'Información del Producto', 'views/vwInfoPrd.php', 0, NULL, NULL),
(2, 'Favoritos', 'views/vwFavorito.php', 0, 'bi bi-heart', 1),
(3, 'Carro de Compras', 'views/vwCarrComp.php', 0, 'bi bi-basket3', 1),
(4, 'LogIn', 'views/vwLogin.php', 0, NULL, NULL),
(5, 'Nosotros', 'views/vwNosotros.php\"', 0, NULL, NULL),
(6, 'Preguntas Frecuentes', 'views/vwfaq.php', 0, NULL, NULL),
(7, 'Recursos Educativos', 'views/vwRecuredu.php', 0, NULL, NULL),
(8, 'Soporte', 'views/vwsoport.php', 0, NULL, NULL),
(9, 'Pagos', 'views/vwpagos.php', 0, NULL, NULL),
(10, 'Pedido', 'views/vwpedido.php', 0, NULL, NULL),
(11, 'Políticas', 'views/vwPoliticas.php', 0, NULL, NULL),
(12, 'Tarjeta', 'views/vwtarjeta.php', 0, NULL, NULL),
(13, 'Tienda', 'views/vwTienda.php', 0, NULL, NULL),
(14, 'Bienvenida', 'views/vwTienda.php', 0, NULL, NULL),
(15, 'Perfil', 'views/vwPerfil.php', 0, 'bi bi-person-circle', 1),
(16, 'Tus Compras', 'views/vwTuscompras.php', 0, NULL, NULL),
(17, 'Tus Pedidos', 'views/vwTusPedidos.php', NULL, NULL, NULL);

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
(2, 1),
(14, 2),
(14, 1);

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

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`idped`, `idusu`, `total`, `fecha`, `estped`) VALUES
(1, 1, 30000.00, '2024-11-13 01:36:56', 'Enviado');

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
(2, 'Invitado', 14);

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
  `descripcion` varchar(255) DEFAULT NULL,
  `provpro` int(5) DEFAULT NULL,
  `prousu` varchar(255) DEFAULT NULL,
  `idcat` bigint(11) DEFAULT NULL,
  `feccreat` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `enofer` tinyint(1) DEFAULT 0,
  `precofer` float DEFAULT NULL,
  `fechiniofer` timestamp NULL DEFAULT NULL,
  `fechfinofer` timestamp NULL DEFAULT NULL,
  `estado` enum('activo','descontinuado','pendiente') DEFAULT 'activo',
  `pordescu` float DEFAULT 0,
  `idval` int(5) DEFAULT NULL,
  `productvend` int(10) DEFAULT 0,
  `temporada` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idpro`, `nompro`, `precio`, `cantidad`, `tipro`, `valorunitario`, `descripcion`, `provpro`, `prousu`, `idcat`, `feccreat`, `fecupdate`, `enofer`, `precofer`, `fechiniofer`, `fechfinofer`, `estado`, `pordescu`, `idval`, `productvend`, `temporada`) VALUES
(3, 'Camiseta de algodón', 25000, 100, 'Ropa', 20000, 'Disfruta de la comodidad de nuestra camisa de algodón 100%. Ideal para cualquier ocasión, brinda suavidad y frescura todo el día. Recomendaciones: Lavar con colores similares y a máquina en ciclo suave. Cuimedia.', 0, 'admin', NULL, '2024-11-05 06:14:03', '2024-11-13 00:51:00', 0, 20000, '2024-11-05 20:00:00', '2024-11-20 20:00:00', 'activo', 15, 1, 0, NULL),
(4, 'Pantalón vaquero', 60000, 50, 'Ropa', 50000, NULL, 0, 'admin', NULL, '2024-11-06 16:14:25', '2024-11-13 00:58:01', 0, 45000, '2024-11-01 20:00:00', '2024-11-10 20:00:00', 'activo', NULL, 1, 0, NULL),
(5, 'Zapatos deportivos', 90000, 80, 'Calzado', 85000, 'Zapatos deportivos c', 0, 'admin', NULL, '2024-11-06 16:14:25', '2024-11-13 00:58:45', 0, 80000, '2024-11-10 20:00:00', '2024-11-30 20:00:00', 'activo', 5, 1, 0, NULL),
(6, 'Bolso de cuero', 120000, 30, 'Accesorios', 110000, 'Bolso de cuero genui', 0, 'admin', NULL, '2024-11-06 16:14:25', '2024-11-13 00:58:55', 0, 100000, '2024-11-15 20:00:00', '2024-12-01 20:00:00', 'activo', 12, 3, 0, NULL),
(7, 'Reloj digital', 50000, 60, 'Accesorios', 45000, 'Reloj digital resist', 0, 'admin', NULL, '2024-11-06 16:14:25', '2024-11-13 00:59:04', 0, 40000, '2024-11-05 20:00:00', '2024-11-25 20:00:00', 'activo', 20, 2, 0, NULL),
(8, 'Gorra de béisbol', 15000, 120, 'Accesorios', 12000, 'Gorra de béisbol aju', 0, 'admin', NULL, '2024-11-06 16:14:25', '2024-11-13 00:59:33', 0, 11000, '2024-11-02 20:00:00', '2024-11-18 20:00:00', 'activo', 10, 3, 0, NULL),
(9, 'Sudadera con capucha', 45000, 70, 'Ropa', 42000, 'Sudadera con capucha', 0, 'admin', NULL, '2024-11-06 16:14:25', '2024-11-13 01:38:38', 0, 40000, '2024-11-12 20:00:00', '2024-11-28 20:00:00', 'activo', 8, 1, 0, NULL),
(10, 'Bufanda de lana', 30000, 100, 'Accesorios', 25000, 'Bufanda de lana para', 0, 'admin', NULL, '2024-11-06 16:14:25', '2024-11-13 01:38:56', 0, 24000, '2024-11-01 20:00:00', '2024-11-15 20:00:00', 'activo', 20, 3, 0, NULL),
(11, 'Cartera pequeña', 20000, 90, 'Accesorios', 18000, 'Cartera de mano pequ', 0, 'admin', NULL, '2024-11-06 16:14:25', '2024-11-13 01:39:15', 0, 17000, '2024-11-04 20:00:00', '2024-11-18 20:00:00', 'activo', 15, 3, 0, NULL),
(12, 'Sombrero de paja', 22000, 60, 'Accesorios', 20000, 'Sombrero de paja ide', 0, 'admin', NULL, '2024-11-06 16:14:25', '2024-11-13 01:39:33', 0, 19000, '2024-11-10 20:00:00', '2024-11-24 20:00:00', 'activo', 12, 3, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prodxprov`
--

CREATE TABLE `prodxprov` (
  `idpro` int(5) DEFAULT NULL,
  `idprov` int(5) DEFAULT NULL,
  `valor` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prodxprov`
--

INSERT INTO `prodxprov` (`idpro`, `idprov`, `valor`) VALUES
(3, 2, 20000),
(7, 3, 45000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idprov` int(5) NOT NULL,
  `nomprov` varchar(20) DEFAULT NULL,
  `dirrecprov` varchar(20) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `nit` varchar(20) DEFAULT NULL,
  `idubi` int(5) DEFAULT NULL,
  `idusu` int(5) DEFAULT NULL,
  `desprv` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`idprov`, `nomprov`, `dirrecprov`, `url`, `estado`, `nit`, `idubi`, `idusu`, `desprv`) VALUES
(1, 'Tienda A', 'Calle 123 #45-67', 'http://www.tiendaA.c', 'activo', '900123456', 5, 1, NULL),
(2, 'Tienda B', 'Carrera 5 #10-20', 'http://www.tiendaB.c', 'activo', '900789012', 8, 13, 'Tienda de ropa y textiles'),
(3, 'Tienda C', 'Avenida 9 #8-15', 'http://www.tiendaC.c', 'inactivo', '900345678', 11, 14, NULL),
(4, 'Tienda D', 'Transversal 25 #50-6', 'http://www.tiendaD.c', 'activo', '900456789', 15, 15, NULL),
(5, 'Tienda E', 'Diagonal 45 #67-89', 'http://www.tiendaE.c', 'activo', '900567890', 17, 12, NULL);

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
  `nomubi` varchar(50) DEFAULT NULL,
  `depenubi` int(4) DEFAULT NULL,
  `direccion` varchar(20) DEFAULT NULL,
  `idprov` int(5) DEFAULT NULL,
  `idusu` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`idubi`, `nomubi`, `depenubi`, `direccion`, `idprov`, `idusu`) VALUES
(5, 'ANTIOQUIA', 0, NULL, NULL, NULL),
(8, 'ATLANTICO', 0, NULL, NULL, NULL),
(11, 'BOGOTÁ D.C.', 0, NULL, NULL, NULL),
(13, 'BOLIVAR', 0, NULL, NULL, NULL),
(15, 'BOYACA', 0, NULL, NULL, NULL),
(17, 'CALDAS', 0, NULL, NULL, NULL),
(18, 'CAQUETA', 0, NULL, NULL, NULL),
(19, 'CAUCA', 0, NULL, NULL, NULL),
(20, 'CESAR', 0, NULL, NULL, NULL),
(23, 'CORDOBA', 0, NULL, NULL, NULL),
(25, 'CUNDINAMARCA', 0, NULL, NULL, NULL),
(27, 'CHOCO', 0, NULL, NULL, NULL),
(41, 'HUILA', 0, NULL, NULL, NULL),
(44, 'LA GUAJIRA', 0, NULL, NULL, NULL),
(47, 'MAGDALENA', 0, NULL, NULL, NULL),
(50, 'META', 0, NULL, NULL, NULL),
(52, 'NARIÑO', 0, NULL, NULL, NULL),
(54, 'NORTE DE SANTANDER', 0, NULL, NULL, NULL),
(63, 'QUINDIO', 0, NULL, NULL, NULL),
(66, 'RISALDA', 0, NULL, NULL, NULL),
(68, 'SANTANDER', 0, NULL, NULL, NULL),
(70, 'SUCRE', 0, NULL, NULL, NULL),
(73, 'TOLIMA', 0, NULL, NULL, NULL),
(76, 'VALLE DEL CAUCA', 0, NULL, NULL, NULL),
(81, 'ARAUCA', 0, NULL, NULL, NULL),
(85, 'CASANARE', 0, NULL, NULL, NULL),
(86, 'PUTUMAYO', 0, NULL, NULL, NULL),
(88, 'SAN ANDRES Y PROVIDE', 0, NULL, NULL, NULL),
(91, 'AMAZONAS', 0, NULL, NULL, NULL),
(94, 'GUAINIA', 0, NULL, NULL, NULL),
(95, 'GUAVIARE', 0, NULL, NULL, NULL),
(97, 'VAUPES', 0, NULL, NULL, NULL),
(99, 'VICHADA', 0, NULL, NULL, NULL),
(5001, 'Medellin', 5, NULL, NULL, NULL),
(5002, 'Abejorral', 5, NULL, NULL, NULL),
(5004, 'Abriaqui', 5, NULL, NULL, NULL),
(5021, 'Alejandria', 5, NULL, NULL, NULL),
(5030, 'Amaga', 5, NULL, NULL, NULL),
(5031, 'Amalfi', 5, NULL, NULL, NULL),
(5034, 'Andes', 5, NULL, NULL, NULL),
(5036, 'Angelopolis', 5, NULL, NULL, NULL),
(5038, 'Angostura', 5, NULL, NULL, NULL),
(5040, 'Anori', 5, NULL, NULL, NULL),
(5042, 'Antioquia', 5, NULL, NULL, NULL),
(5044, 'Anza', 5, NULL, NULL, NULL),
(5045, 'Apartado', 5, NULL, NULL, NULL),
(5051, 'Arboletes', 5, NULL, NULL, NULL),
(5055, 'Argelia', 5, NULL, NULL, NULL),
(5059, 'Armenia', 5, NULL, NULL, NULL),
(5079, 'Barbosa', 5, NULL, NULL, NULL),
(5086, 'Belmira', 5, NULL, NULL, NULL),
(5088, 'Bello', 5, NULL, NULL, NULL),
(5091, 'Betania', 5, NULL, NULL, NULL),
(5093, 'Betulia', 5, NULL, NULL, NULL),
(5101, 'Bolivar', 5, NULL, NULL, NULL),
(5107, 'Briceno', 5, NULL, NULL, NULL),
(5113, 'Buritica', 5, NULL, NULL, NULL),
(5120, 'Caceres', 5, NULL, NULL, NULL),
(5125, 'Caicedo', 5, NULL, NULL, NULL),
(5129, 'Caldas', 5, NULL, NULL, NULL),
(5134, 'Campamento', 5, NULL, NULL, NULL),
(5138, 'CaÃ±asgordas', 5, NULL, NULL, NULL),
(5142, 'Caracoli', 5, NULL, NULL, NULL),
(5145, 'Caramanta', 5, NULL, NULL, NULL),
(5147, 'Carepa', 5, NULL, NULL, NULL),
(5148, 'Carmen de Viboral', 5, NULL, NULL, NULL),
(5150, 'Carolina', 5, NULL, NULL, NULL),
(5154, 'Caucasia', 5, NULL, NULL, NULL),
(5172, 'Chigorodo', 5, NULL, NULL, NULL),
(5190, 'Cisneros', 5, NULL, NULL, NULL),
(5197, 'Cocorna', 5, NULL, NULL, NULL),
(5206, 'Concepcion', 5, NULL, NULL, NULL),
(5209, 'Concordia', 5, NULL, NULL, NULL),
(5212, 'Copacabana', 5, NULL, NULL, NULL),
(5234, 'Dabeiba', 5, NULL, NULL, NULL),
(5237, 'Don Matias', 5, NULL, NULL, NULL),
(5240, 'Ebejico', 5, NULL, NULL, NULL),
(5250, 'El Bagre', 5, NULL, NULL, NULL),
(5264, 'Entrerrios', 5, NULL, NULL, NULL),
(5266, 'Envigado', 5, NULL, NULL, NULL),
(5282, 'Fredonia', 5, NULL, NULL, NULL),
(5284, 'Frontino', 5, NULL, NULL, NULL),
(5306, 'Giraldo', 5, NULL, NULL, NULL),
(5308, 'Girardota', 5, NULL, NULL, NULL),
(5310, 'Gomez Plata', 5, NULL, NULL, NULL),
(5313, 'Granada', 5, NULL, NULL, NULL),
(5315, 'Guadalupe', 5, NULL, NULL, NULL),
(5318, 'Guarne', 5, NULL, NULL, NULL),
(5321, 'Guatape', 5, NULL, NULL, NULL),
(5347, 'Heliconia', 5, NULL, NULL, NULL),
(5353, 'Hispania', 5, NULL, NULL, NULL),
(5360, 'Itagui', 5, NULL, NULL, NULL),
(5361, 'Ituango', 5, NULL, NULL, NULL),
(5364, 'Jardin', 5, NULL, NULL, NULL),
(5368, 'Jerico', 5, NULL, NULL, NULL),
(5376, 'La Ceja', 5, NULL, NULL, NULL),
(5380, 'La Estrella', 5, NULL, NULL, NULL),
(5390, 'La Pintada', 5, NULL, NULL, NULL),
(5400, 'La Union', 5, NULL, NULL, NULL),
(5411, 'Liborina', 5, NULL, NULL, NULL),
(5425, 'Maceo', 5, NULL, NULL, NULL),
(5440, 'Marinilla', 5, NULL, NULL, NULL),
(5467, 'Montebello', 5, NULL, NULL, NULL),
(5475, 'Murindo', 5, NULL, NULL, NULL),
(5480, 'Mutata', 5, NULL, NULL, NULL),
(5483, 'NariÃ±o', 5, NULL, NULL, NULL),
(5490, 'Necocli', 5, NULL, NULL, NULL),
(5495, 'Nechi', 5, NULL, NULL, NULL),
(5501, 'Olaya', 5, NULL, NULL, NULL),
(5541, 'PeÃ±ol', 5, NULL, NULL, NULL),
(5543, 'Peque', 5, NULL, NULL, NULL),
(5576, 'Pueblorrico', 5, NULL, NULL, NULL),
(5579, 'Puerto Berrio', 5, NULL, NULL, NULL),
(5585, 'Puerto Nare (La Magd', 5, NULL, NULL, NULL),
(5591, 'Puerto Triunfo', 5, NULL, NULL, NULL),
(5604, 'Remedios', 5, NULL, NULL, NULL),
(5607, 'Retiro', 5, NULL, NULL, NULL),
(5615, 'Rionegro', 5, NULL, NULL, NULL),
(5628, 'Sabanalarga', 5, NULL, NULL, NULL),
(5631, 'Sabaneta', 5, NULL, NULL, NULL),
(5642, 'Salgar', 5, NULL, NULL, NULL),
(5647, 'San Andres', 5, NULL, NULL, NULL),
(5649, 'San Carlos', 5, NULL, NULL, NULL),
(5652, 'San Francisco', 5, NULL, NULL, NULL),
(5656, 'San Jeronimo', 5, NULL, NULL, NULL),
(5658, 'San Jose de la Monta', 5, NULL, NULL, NULL),
(5659, 'San Juan de Uraba', 5, NULL, NULL, NULL),
(5660, 'San Luis', 5, NULL, NULL, NULL),
(5664, 'San Pedro', 5, NULL, NULL, NULL),
(5665, 'San Pedro de Uraba', 5, NULL, NULL, NULL),
(5667, 'San Rafael', 5, NULL, NULL, NULL),
(5670, 'San Roque', 5, NULL, NULL, NULL),
(5674, 'San Vicente', 5, NULL, NULL, NULL),
(5679, 'Santa Barbara', 5, NULL, NULL, NULL),
(5686, 'Santa Rosa de Osos', 5, NULL, NULL, NULL),
(5690, 'Santo Domingo', 5, NULL, NULL, NULL),
(5697, 'Santuario', 5, NULL, NULL, NULL),
(5736, 'Segovia', 5, NULL, NULL, NULL),
(5756, 'Sonson', 5, NULL, NULL, NULL),
(5761, 'Sopetran', 5, NULL, NULL, NULL),
(5789, 'Tamesis', 5, NULL, NULL, NULL),
(5790, 'Taraza', 5, NULL, NULL, NULL),
(5792, 'Tarso', 5, NULL, NULL, NULL),
(5809, 'Titiribi', 5, NULL, NULL, NULL),
(5819, 'Toledo', 5, NULL, NULL, NULL),
(5837, 'Turbo', 5, NULL, NULL, NULL),
(5842, 'Uramita', 5, NULL, NULL, NULL),
(5847, 'Urrao', 5, NULL, NULL, NULL),
(5854, 'Valdivia', 5, NULL, NULL, NULL),
(5856, 'Valparaiso', 5, NULL, NULL, NULL),
(5858, 'Vegachi', 5, NULL, NULL, NULL),
(5861, 'Venecia', 5, NULL, NULL, NULL),
(5873, 'Vigia del Fuerte', 5, NULL, NULL, NULL),
(5885, 'Yali', 5, NULL, NULL, NULL),
(5887, 'Yarumal', 5, NULL, NULL, NULL),
(5890, 'Yolombo', 5, NULL, NULL, NULL),
(5893, 'Yondo (Casabe)', 5, NULL, NULL, NULL),
(5895, 'Zaragoza', 5, NULL, NULL, NULL),
(8001, 'Barranquilla', 8, NULL, NULL, NULL),
(8078, 'Baranoa', 8, NULL, NULL, NULL),
(8137, 'Campo de la Cruz', 8, NULL, NULL, NULL),
(8141, 'Candelaria', 8, NULL, NULL, NULL),
(8296, 'Galapa', 8, NULL, NULL, NULL),
(8372, 'Juan de Acosta', 8, NULL, NULL, NULL),
(8421, 'Luruaco', 8, NULL, NULL, NULL),
(8433, 'Malambo', 8, NULL, NULL, NULL),
(8436, 'Manati', 8, NULL, NULL, NULL),
(8520, 'Palmar de Varela', 8, NULL, NULL, NULL),
(8549, 'Piojo', 8, NULL, NULL, NULL),
(8558, 'Polo Nuevo', 8, NULL, NULL, NULL),
(8560, 'Ponedera', 8, NULL, NULL, NULL),
(8573, 'Puerto Colombia', 8, NULL, NULL, NULL),
(8606, 'Repelon', 8, NULL, NULL, NULL),
(8634, 'Sabanagrande', 8, NULL, NULL, NULL),
(8638, 'Sabanalarga', 8, NULL, NULL, NULL),
(8675, 'Santa Lucia', 8, NULL, NULL, NULL),
(8685, 'Santo Tomas', 8, NULL, NULL, NULL),
(8758, 'Soledad', 8, NULL, NULL, NULL),
(8770, 'Suan', 8, NULL, NULL, NULL),
(8832, 'Tubara', 8, NULL, NULL, NULL),
(8849, 'Usiacuri', 8, NULL, NULL, NULL),
(11001, 'Bogota', 11, NULL, NULL, NULL),
(13001, 'Cartagena', 13, NULL, NULL, NULL),
(13006, 'Achi', 13, NULL, NULL, NULL),
(13030, 'Altos del Rosario', 13, NULL, NULL, NULL),
(13042, 'Arenal', 13, NULL, NULL, NULL),
(13052, 'Arjona', 13, NULL, NULL, NULL),
(13062, 'Arroyohondo', 13, NULL, NULL, NULL),
(13074, 'Barranco de Loba', 13, NULL, NULL, NULL),
(13140, 'Calamar', 13, NULL, NULL, NULL),
(13160, 'Cantagallo', 13, NULL, NULL, NULL),
(13188, 'Cicuco', 13, NULL, NULL, NULL),
(13212, 'Cordoba', 13, NULL, NULL, NULL),
(13222, 'Clemencia', 13, NULL, NULL, NULL),
(13244, 'El Carmen de Bolivar', 13, NULL, NULL, NULL),
(13248, 'El Guamo', 13, NULL, NULL, NULL),
(13268, 'El PeÃ±on', 13, NULL, NULL, NULL),
(13300, 'Hatillo de Loba', 13, NULL, NULL, NULL),
(13430, 'Magangue', 13, NULL, NULL, NULL),
(13433, 'Mahates', 13, NULL, NULL, NULL),
(13440, 'Margarita', 13, NULL, NULL, NULL),
(13442, 'Maria La Baja', 13, NULL, NULL, NULL),
(13458, 'Montecristo', 13, NULL, NULL, NULL),
(13468, 'Mompos', 13, NULL, NULL, NULL),
(13473, 'Morales', 13, NULL, NULL, NULL),
(13490, 'Norosi', 13, NULL, NULL, NULL),
(13549, 'Pinillos', 13, NULL, NULL, NULL),
(13580, 'Regidor', 13, NULL, NULL, NULL),
(13600, 'Rio Viejo', 13, NULL, NULL, NULL),
(13620, 'San Cristobal', 13, NULL, NULL, NULL),
(13647, 'San Estanislao', 13, NULL, NULL, NULL),
(13650, 'San Fernando', 13, NULL, NULL, NULL),
(13654, 'San Jacinto', 13, NULL, NULL, NULL),
(13655, 'San Jacinto del Cauca', 13, NULL, NULL, NULL),
(13657, 'San Juan Nepomuceno', 13, NULL, NULL, NULL),
(13667, 'San Martin de Loba', 13, NULL, NULL, NULL),
(13670, 'San Pablo', 13, NULL, NULL, NULL),
(13673, 'Santa Catalina', 13, NULL, NULL, NULL),
(13683, 'Santa Rosa', 13, NULL, NULL, NULL),
(13688, 'Santa Rosa del Sur', 13, NULL, NULL, NULL),
(13744, 'Simiti', 13, NULL, NULL, NULL),
(13760, 'Soplaviento', 13, NULL, NULL, NULL),
(13780, 'Talaigua NUevo', 13, NULL, NULL, NULL),
(13810, 'Tiquisio (Puerto Ric', 13, NULL, NULL, NULL),
(13836, 'Turbaco', 13, NULL, NULL, NULL),
(13838, 'Turbana', 13, NULL, NULL, NULL),
(13873, 'Villanueva', 13, NULL, NULL, NULL),
(13894, 'Zambrano', 13, NULL, NULL, NULL),
(14001, 'Cartagena', 14, NULL, NULL, NULL),
(15001, 'Tunja', 15, NULL, NULL, NULL),
(15022, 'Almeida', 15, NULL, NULL, NULL),
(15047, 'Aquitania', 15, NULL, NULL, NULL),
(15051, 'Arcabuco', 15, NULL, NULL, NULL),
(15087, 'Belen', 15, NULL, NULL, NULL),
(15090, 'Berbeo', 15, NULL, NULL, NULL),
(15092, 'Beteitiva', 15, NULL, NULL, NULL),
(15097, 'Boavita', 15, NULL, NULL, NULL),
(15104, 'Boyaca', 15, NULL, NULL, NULL),
(15106, 'Briceno', 15, NULL, NULL, NULL),
(15109, 'Buenavista', 15, NULL, NULL, NULL),
(15114, 'Busbanza', 15, NULL, NULL, NULL),
(15131, 'Caldas', 15, NULL, NULL, NULL),
(15135, 'Campohermoso', 15, NULL, NULL, NULL),
(15162, 'Cerinza', 15, NULL, NULL, NULL),
(15172, 'Chinavita', 15, NULL, NULL, NULL),
(15176, 'Chiquinquira', 15, NULL, NULL, NULL),
(15180, 'Chiscas', 15, NULL, NULL, NULL),
(15183, 'Chita', 15, NULL, NULL, NULL),
(15185, 'Chitaraque', 15, NULL, NULL, NULL),
(15187, 'Chivata', 15, NULL, NULL, NULL),
(15189, 'Cienega', 15, NULL, NULL, NULL),
(15204, 'Combita', 15, NULL, NULL, NULL),
(15212, 'Coper', 15, NULL, NULL, NULL),
(15215, 'Corrales', 15, NULL, NULL, NULL),
(15218, 'Covarachia', 15, NULL, NULL, NULL),
(15223, 'Cubara', 15, NULL, NULL, NULL),
(15224, 'Cucaita', 15, NULL, NULL, NULL),
(15226, 'Cuitiva', 15, NULL, NULL, NULL),
(15232, 'Chiquiza', 15, NULL, NULL, NULL),
(15236, 'Chivor', 15, NULL, NULL, NULL),
(15238, 'Duitama', 15, NULL, NULL, NULL),
(15244, 'El Cocuy', 15, NULL, NULL, NULL),
(15248, 'El Espino', 15, NULL, NULL, NULL),
(15272, 'Firavitoba', 15, NULL, NULL, NULL),
(15276, 'Floresta', 15, NULL, NULL, NULL),
(15293, 'Gachantiva', 15, NULL, NULL, NULL),
(15296, 'Gameza', 15, NULL, NULL, NULL),
(15299, 'Garagoa', 15, NULL, NULL, NULL),
(15317, 'Guacamayas', 15, NULL, NULL, NULL),
(15322, 'Guateque', 15, NULL, NULL, NULL),
(15325, 'Guayata', 15, NULL, NULL, NULL),
(15332, 'Guican', 15, NULL, NULL, NULL),
(15362, 'Iza', 15, NULL, NULL, NULL),
(15367, 'Jenesano', 15, NULL, NULL, NULL),
(15368, 'Jerico', 15, NULL, NULL, NULL),
(15377, 'Labranzagrande', 15, NULL, NULL, NULL),
(15380, 'La Capilla', 15, NULL, NULL, NULL),
(15401, 'La Victoria', 15, NULL, NULL, NULL),
(15403, 'La Uvita', 15, NULL, NULL, NULL),
(15407, 'VIlla de Leyva', 15, NULL, NULL, NULL),
(15425, 'Macanal', 15, NULL, NULL, NULL),
(15442, 'Maripi', 15, NULL, NULL, NULL),
(15455, 'Miraflores', 15, NULL, NULL, NULL),
(15464, 'Mongua', 15, NULL, NULL, NULL),
(15466, 'Mongui', 15, NULL, NULL, NULL),
(15469, 'Moniquira', 15, NULL, NULL, NULL),
(15476, 'Motavita', 15, NULL, NULL, NULL),
(15480, 'Muzo', 15, NULL, NULL, NULL),
(15491, 'Nobsa', 15, NULL, NULL, NULL),
(15494, 'Nuevo Colon', 15, NULL, NULL, NULL),
(15500, 'Oicata', 15, NULL, NULL, NULL),
(15507, 'Otanche', 15, NULL, NULL, NULL),
(15511, 'Pachavita', 15, NULL, NULL, NULL),
(15514, 'Paez', 15, NULL, NULL, NULL),
(15516, 'Paipa', 15, NULL, NULL, NULL),
(15518, 'Pajarito', 15, NULL, NULL, NULL),
(15522, 'Panqueba', 15, NULL, NULL, NULL),
(15531, 'Pauna', 15, NULL, NULL, NULL),
(15533, 'Paya', 15, NULL, NULL, NULL),
(15537, 'Paz de Rio', 15, NULL, NULL, NULL),
(15542, 'Pesca', 15, NULL, NULL, NULL),
(15550, 'Pisba', 15, NULL, NULL, NULL),
(15572, 'Puerto Boyaca', 15, NULL, NULL, NULL),
(15580, 'Quipama', 15, NULL, NULL, NULL),
(15599, 'Ramiriqui', 15, NULL, NULL, NULL),
(15600, 'Raquira', 15, NULL, NULL, NULL),
(15621, 'Rondon', 15, NULL, NULL, NULL),
(15632, 'Saboya', 15, NULL, NULL, NULL),
(15638, 'Sachica', 15, NULL, NULL, NULL),
(15646, 'Samaca', 15, NULL, NULL, NULL),
(15660, 'San Eduardo', 15, NULL, NULL, NULL),
(15664, 'San Jose de Pare', 15, NULL, NULL, NULL),
(15667, 'San Luis de Gaceno', 15, NULL, NULL, NULL),
(15673, 'San Mateo', 15, NULL, NULL, NULL),
(15676, 'San Miguel de Sema', 15, NULL, NULL, NULL),
(15681, 'San Pablo de Borbur', 15, NULL, NULL, NULL),
(15686, 'Santana', 15, NULL, NULL, NULL),
(15690, 'Santa Maria', 15, NULL, NULL, NULL),
(15693, 'Santa Rosa de Viterb', 15, NULL, NULL, NULL),
(15696, 'Santa Sofia', 15, NULL, NULL, NULL),
(15720, 'Sativanorte', 15, NULL, NULL, NULL),
(15723, 'Sativasur', 15, NULL, NULL, NULL),
(15740, 'Siachoque', 15, NULL, NULL, NULL),
(15753, 'Soata', 15, NULL, NULL, NULL),
(15755, 'Socota', 15, NULL, NULL, NULL),
(15757, 'Socha', 15, NULL, NULL, NULL),
(15759, 'Sogamoso', 15, NULL, NULL, NULL),
(15761, 'Somondoco', 15, NULL, NULL, NULL),
(15762, 'Sora', 15, NULL, NULL, NULL),
(15763, 'Sotaquira', 15, NULL, NULL, NULL),
(15764, 'Soraca', 15, NULL, NULL, NULL),
(15774, 'Susacon', 15, NULL, NULL, NULL),
(15776, 'Sutamarchan', 15, NULL, NULL, NULL),
(15778, 'Sutatenza', 15, NULL, NULL, NULL),
(15790, 'Tasco', 15, NULL, NULL, NULL),
(15798, 'Tenza', 15, NULL, NULL, NULL),
(15804, 'Tibana', 15, NULL, NULL, NULL),
(15806, 'Tibasosa', 15, NULL, NULL, NULL),
(15808, 'Tinjaca', 15, NULL, NULL, NULL),
(15810, 'Tipacoque', 15, NULL, NULL, NULL),
(15814, 'Toca', 15, NULL, NULL, NULL),
(15816, 'Togui', 15, NULL, NULL, NULL),
(15820, 'Topaga', 15, NULL, NULL, NULL),
(15822, 'Tota', 15, NULL, NULL, NULL),
(15832, 'Tunungua', 15, NULL, NULL, NULL),
(15835, 'Turmeque', 15, NULL, NULL, NULL),
(15837, 'Tuta', 15, NULL, NULL, NULL),
(15839, 'Tutaza', 15, NULL, NULL, NULL),
(15842, 'Umbita', 15, NULL, NULL, NULL),
(15861, 'Ventaquemada', 15, NULL, NULL, NULL),
(15879, 'Viracacha', 15, NULL, NULL, NULL),
(15897, 'Zetaquira', 15, NULL, NULL, NULL),
(17001, 'Manizales', 17, NULL, NULL, NULL),
(17013, 'Aguadas', 17, NULL, NULL, NULL),
(17042, 'Anserma', 17, NULL, NULL, NULL),
(17050, 'Aranzazu', 17, NULL, NULL, NULL),
(17088, 'Belalcazar', 17, NULL, NULL, NULL),
(17174, 'Chinchina', 17, NULL, NULL, NULL),
(17272, 'Filadelfia', 17, NULL, NULL, NULL),
(17380, 'La Dorada', 17, NULL, NULL, NULL),
(17388, 'La Merced', 17, NULL, NULL, NULL),
(17433, 'Manzanares', 17, NULL, NULL, NULL),
(17442, 'Marmato', 17, NULL, NULL, NULL),
(17444, 'Marquetalia', 17, NULL, NULL, NULL),
(17446, 'Marulanda', 17, NULL, NULL, NULL),
(17486, 'Neira', 17, NULL, NULL, NULL),
(17495, 'Norcasia', 17, NULL, NULL, NULL),
(17513, 'Pacora', 17, NULL, NULL, NULL),
(17524, 'Palestina', 17, NULL, NULL, NULL),
(17541, 'Pensilvania', 17, NULL, NULL, NULL),
(17614, 'Riosucio', 17, NULL, NULL, NULL),
(17616, 'Risaralda', 17, NULL, NULL, NULL),
(17653, 'Salamina', 17, NULL, NULL, NULL),
(17662, 'Samana', 17, NULL, NULL, NULL),
(17665, 'San Jose', 17, NULL, NULL, NULL),
(17777, 'Supia', 17, NULL, NULL, NULL),
(17867, 'Victoria', 17, NULL, NULL, NULL),
(17873, 'Villamaria', 17, NULL, NULL, NULL),
(17877, 'Viterbo', 17, NULL, NULL, NULL),
(18001, 'Florencia', 18, NULL, NULL, NULL),
(18029, 'Albania', 18, NULL, NULL, NULL),
(18094, 'Belen de los Andaqui', 18, NULL, NULL, NULL),
(18150, 'Cartagena del Chaira', 18, NULL, NULL, NULL),
(18205, 'Curillo', 18, NULL, NULL, NULL),
(18247, 'El Doncello', 18, NULL, NULL, NULL),
(18256, 'El Paujil', 18, NULL, NULL, NULL),
(18410, 'La Montanita', 18, NULL, NULL, NULL),
(18460, 'Milan', 18, NULL, NULL, NULL),
(18479, 'Morelia', 18, NULL, NULL, NULL),
(18592, 'Puerto Rico', 18, NULL, NULL, NULL),
(18610, 'San Jose del Fragua', 18, NULL, NULL, NULL),
(18753, 'San Vicente del Cagu', 18, NULL, NULL, NULL),
(18756, 'Solano', 18, NULL, NULL, NULL),
(18785, 'Solita', 18, NULL, NULL, NULL),
(18860, 'Valparaiso', 18, NULL, NULL, NULL),
(19001, 'Popayan', 19, NULL, NULL, NULL),
(19022, 'Almaguer', 19, NULL, NULL, NULL),
(19050, 'Argelia', 19, NULL, NULL, NULL),
(19075, 'Balboa', 19, NULL, NULL, NULL),
(19100, 'Bolivar', 19, NULL, NULL, NULL),
(19110, 'Buenos Aires', 19, NULL, NULL, NULL),
(19130, 'Cajibio', 19, NULL, NULL, NULL),
(19137, 'Caldono', 19, NULL, NULL, NULL),
(19142, 'Caloto', 19, NULL, NULL, NULL),
(19212, 'Corinto', 19, NULL, NULL, NULL),
(19256, 'El Tambo', 19, NULL, NULL, NULL),
(19290, 'Florencia', 19, NULL, NULL, NULL),
(19318, 'Guapi', 19, NULL, NULL, NULL),
(19355, 'Inza', 19, NULL, NULL, NULL),
(19364, 'Jambalo', 19, NULL, NULL, NULL),
(19392, 'La Sierra', 19, NULL, NULL, NULL),
(19397, 'La Vega', 19, NULL, NULL, NULL),
(19418, 'Lopez (Micay)', 19, NULL, NULL, NULL),
(19450, 'Mercaderes', 19, NULL, NULL, NULL),
(19455, 'Miranda', 19, NULL, NULL, NULL),
(19473, 'Morales', 19, NULL, NULL, NULL),
(19513, 'Padilla', 19, NULL, NULL, NULL),
(19517, 'Paez', 19, NULL, NULL, NULL),
(19532, 'Patia (EL Bordo)', 19, NULL, NULL, NULL),
(19533, 'Piamonte', 19, NULL, NULL, NULL),
(19548, 'Piendamo', 19, NULL, NULL, NULL),
(19573, 'Puerto Tejada', 19, NULL, NULL, NULL),
(19585, 'Purace', 19, NULL, NULL, NULL),
(19622, 'Rosas', 19, NULL, NULL, NULL),
(19693, 'San Sebastian', 19, NULL, NULL, NULL),
(19698, 'Santander de Quilich', 19, NULL, NULL, NULL),
(19701, 'Santa Rosa', 19, NULL, NULL, NULL),
(19743, 'Silvia', 19, NULL, NULL, NULL),
(19760, 'Sotara', 19, NULL, NULL, NULL),
(19780, 'Suarez', 19, NULL, NULL, NULL),
(19785, 'Sucre', 19, NULL, NULL, NULL),
(19807, 'Timbio', 19, NULL, NULL, NULL),
(19809, 'Timbiqui', 19, NULL, NULL, NULL),
(19821, 'Toribio', 19, NULL, NULL, NULL),
(19824, 'ToToro', 19, NULL, NULL, NULL),
(19845, 'Villarica', 19, NULL, NULL, NULL),
(20001, 'Valledupar', 20, NULL, NULL, NULL),
(20011, 'Aguachica', 20, NULL, NULL, NULL),
(20013, 'Agustin Codazzi', 20, NULL, NULL, NULL),
(20032, 'Astrea', 20, NULL, NULL, NULL),
(20045, 'Becerril', 20, NULL, NULL, NULL),
(20060, 'Bosconia', 20, NULL, NULL, NULL),
(20175, 'Chimichagua', 20, NULL, NULL, NULL),
(20178, 'Chiriguana', 20, NULL, NULL, NULL),
(20228, 'Curumani', 20, NULL, NULL, NULL),
(20238, 'El Copey', 20, NULL, NULL, NULL),
(20250, 'El Paso', 20, NULL, NULL, NULL),
(20295, 'Gamarra', 20, NULL, NULL, NULL),
(20310, 'Gonzalez', 20, NULL, NULL, NULL),
(20383, 'La Gloria', 20, NULL, NULL, NULL),
(20400, 'La Jagua de Ibirico', 20, NULL, NULL, NULL),
(20443, 'Manaure Balcon del C', 20, NULL, NULL, NULL),
(20517, 'Pailitas', 20, NULL, NULL, NULL),
(20550, 'Pelaya', 20, NULL, NULL, NULL),
(20570, 'Pueblo Bello', 20, NULL, NULL, NULL),
(20614, 'Rio de Oro', 20, NULL, NULL, NULL),
(20621, 'Robles (La Paz)', 20, NULL, NULL, NULL),
(20710, 'San Alberto', 20, NULL, NULL, NULL),
(20750, 'San Diego', 20, NULL, NULL, NULL),
(20770, 'San Martin', 20, NULL, NULL, NULL),
(20787, 'Tamalameque', 20, NULL, NULL, NULL),
(23001, 'Monteria', 23, NULL, NULL, NULL),
(23068, 'Ayapel', 23, NULL, NULL, NULL),
(23079, 'Buenavista', 23, NULL, NULL, NULL),
(23090, 'Canalete', 23, NULL, NULL, NULL),
(23162, 'Cerete', 23, NULL, NULL, NULL),
(23168, 'Chima', 23, NULL, NULL, NULL),
(23182, 'Chinu', 23, NULL, NULL, NULL),
(23189, 'Cienaga de Oro', 23, NULL, NULL, NULL),
(23300, 'Cotorra', 23, NULL, NULL, NULL),
(23350, 'La Apartada', 23, NULL, NULL, NULL),
(23417, 'Lorica', 23, NULL, NULL, NULL),
(23419, 'Los Cordobas', 23, NULL, NULL, NULL),
(23464, 'Momil', 23, NULL, NULL, NULL),
(23466, 'Montelibano', 23, NULL, NULL, NULL),
(23500, 'MoÃ±itos', 23, NULL, NULL, NULL),
(23555, 'Planeta Rica', 23, NULL, NULL, NULL),
(23570, 'Pueblo Nuevo', 23, NULL, NULL, NULL),
(23574, 'Puerto Escondido', 23, NULL, NULL, NULL),
(23580, 'Puerto Libertador', 23, NULL, NULL, NULL),
(23586, 'Purisima', 23, NULL, NULL, NULL),
(23660, 'Sahagun', 23, NULL, NULL, NULL),
(23670, 'San Andres Sotavento', 23, NULL, NULL, NULL),
(23672, 'San Antero', 23, NULL, NULL, NULL),
(23675, 'San Bernardo del Vie', 23, NULL, NULL, NULL),
(23678, 'San Carlos', 23, NULL, NULL, NULL),
(23686, 'San Pelayo', 23, NULL, NULL, NULL),
(23807, 'Tierralta', 23, NULL, NULL, NULL),
(23855, 'Valencia', 23, NULL, NULL, NULL),
(25001, 'Agua de Dios', 25, NULL, NULL, NULL),
(25019, 'Alban', 25, NULL, NULL, NULL),
(25035, 'Anapoima', 25, NULL, NULL, NULL),
(25040, 'Anolaima', 25, NULL, NULL, NULL),
(25053, 'Arbelaez', 25, NULL, NULL, NULL),
(25086, 'Beltran', 25, NULL, NULL, NULL),
(25095, 'Bituima', 25, NULL, NULL, NULL),
(25099, 'Bojaca', 25, NULL, NULL, NULL),
(25120, 'Cabrera', 25, NULL, NULL, NULL),
(25123, 'Cachipay', 25, NULL, NULL, NULL),
(25126, 'CajicÃ¡', 25, NULL, NULL, NULL),
(25148, 'Caparrapi', 25, NULL, NULL, NULL),
(25151, 'Caqueza', 25, NULL, NULL, NULL),
(25154, 'Carmen de Carupa', 25, NULL, NULL, NULL),
(25168, 'Chaguani', 25, NULL, NULL, NULL),
(25175, 'Chí­a', 25, NULL, NULL, NULL),
(25178, 'Chipaque', 25, NULL, NULL, NULL),
(25181, 'Choachi', 25, NULL, NULL, NULL),
(25183, 'Choconta', 25, NULL, NULL, NULL),
(25200, 'Cogua', 25, NULL, NULL, NULL),
(25214, 'Cota', 25, NULL, NULL, NULL),
(25224, 'Cucunuba', 25, NULL, NULL, NULL),
(25245, 'El Colegio', 25, NULL, NULL, NULL),
(25258, 'El PeÃ±on', 25, NULL, NULL, NULL),
(25260, 'El Rosal', 25, NULL, NULL, NULL),
(25269, 'Facatativa', 25, NULL, NULL, NULL),
(25279, 'Fomeque', 25, NULL, NULL, NULL),
(25281, 'Fosca', 25, NULL, NULL, NULL),
(25286, 'Funza', 25, NULL, NULL, NULL),
(25288, 'Fuquene', 25, NULL, NULL, NULL),
(25290, 'Fusagasuga', 25, NULL, NULL, NULL),
(25293, 'Gachala', 25, NULL, NULL, NULL),
(25295, 'Gachancipa', 25, NULL, NULL, NULL),
(25297, 'Gacheta', 25, NULL, NULL, NULL),
(25299, 'Gama', 25, NULL, NULL, NULL),
(25307, 'Girardot', 25, NULL, NULL, NULL),
(25312, 'Granada', 25, NULL, NULL, NULL),
(25317, 'Guacheta', 25, NULL, NULL, NULL),
(25320, 'Guaduas', 25, NULL, NULL, NULL),
(25322, 'Guasca', 25, NULL, NULL, NULL),
(25324, 'Guataqui', 25, NULL, NULL, NULL),
(25326, 'Guatavita', 25, NULL, NULL, NULL),
(25328, 'Guayabal de Siquima', 25, NULL, NULL, NULL),
(25335, 'Guayabetal', 25, NULL, NULL, NULL),
(25339, 'Gutierrez', 25, NULL, NULL, NULL),
(25368, 'Jerusalen', 25, NULL, NULL, NULL),
(25372, 'Junin', 25, NULL, NULL, NULL),
(25377, 'La Calera', 25, NULL, NULL, NULL),
(25386, 'La Mesa', 25, NULL, NULL, NULL),
(25394, 'La Palma', 25, NULL, NULL, NULL),
(25398, 'La PeÃ±a', 25, NULL, NULL, NULL),
(25402, 'La Vega', 25, NULL, NULL, NULL),
(25407, 'Lenguazaque', 25, NULL, NULL, NULL),
(25426, 'Macheta', 25, NULL, NULL, NULL),
(25430, 'Madrid', 25, NULL, NULL, NULL),
(25436, 'Manta', 25, NULL, NULL, NULL),
(25438, 'Medina', 25, NULL, NULL, NULL),
(25473, 'Mosquera', 25, NULL, NULL, NULL),
(25483, 'NariÃ±o', 25, NULL, NULL, NULL),
(25486, 'Nemocon', 25, NULL, NULL, NULL),
(25488, 'Nilo', 25, NULL, NULL, NULL),
(25489, 'Nimaima', 25, NULL, NULL, NULL),
(25491, 'Nocaima', 25, NULL, NULL, NULL),
(25506, 'Venecia', 25, NULL, NULL, NULL),
(25513, 'Pacho', 25, NULL, NULL, NULL),
(25518, 'Paime', 25, NULL, NULL, NULL),
(25524, 'Pandi', 25, NULL, NULL, NULL),
(25530, 'Paratebueno', 25, NULL, NULL, NULL),
(25535, 'Pasca', 25, NULL, NULL, NULL),
(25572, 'Puerto Salgar', 25, NULL, NULL, NULL),
(25580, 'Puli', 25, NULL, NULL, NULL),
(25592, 'Quebradanegra', 25, NULL, NULL, NULL),
(25594, 'Quetame', 25, NULL, NULL, NULL),
(25596, 'Quipile', 25, NULL, NULL, NULL),
(25599, 'Apulo', 25, NULL, NULL, NULL),
(25612, 'Ricaurte', 25, NULL, NULL, NULL),
(25645, 'San Antonio del Tequendama', 25, NULL, NULL, NULL),
(25649, 'San Bernardo', 25, NULL, NULL, NULL),
(25653, 'San Cayetano', 25, NULL, NULL, NULL),
(25658, 'San Francisco', 25, NULL, NULL, NULL),
(25662, 'San Juan de Rio Seco', 25, NULL, NULL, NULL),
(25718, 'Sasaima', 25, NULL, NULL, NULL),
(25736, 'Sesquile', 25, NULL, NULL, NULL),
(25740, 'Sibate', 25, NULL, NULL, NULL),
(25743, 'Silvania', 25, NULL, NULL, NULL),
(25745, 'Simijaca', 25, NULL, NULL, NULL),
(25754, 'Soacha', 25, NULL, NULL, NULL),
(25758, 'Sopo', 25, NULL, NULL, NULL),
(25769, 'Subachoque', 25, NULL, NULL, NULL),
(25772, 'Suesca', 25, NULL, NULL, NULL),
(25777, 'Supata', 25, NULL, NULL, NULL),
(25779, 'Susa', 25, NULL, NULL, NULL),
(25781, 'Sutatausa', 25, NULL, NULL, NULL),
(25785, 'Tabio', 25, NULL, NULL, NULL),
(25793, 'Tausa', 25, NULL, NULL, NULL),
(25797, 'Tena', 25, NULL, NULL, NULL),
(25799, 'Tenjo', 25, NULL, NULL, NULL),
(25805, 'Tibacuy', 25, NULL, NULL, NULL),
(25807, 'Tibirita', 25, NULL, NULL, NULL),
(25815, 'Tocaima', 25, NULL, NULL, NULL),
(25817, 'TocancipÃ¡', 25, NULL, NULL, NULL),
(25823, 'Topaipi', 25, NULL, NULL, NULL),
(25839, 'Ubala', 25, NULL, NULL, NULL),
(25841, 'Ubaque', 25, NULL, NULL, NULL),
(25843, 'Villa de San Diego de Ubate', 25, NULL, NULL, NULL),
(25845, 'Une', 25, NULL, NULL, NULL),
(25851, 'Utica', 25, NULL, NULL, NULL),
(25862, 'Vergara', 25, NULL, NULL, NULL),
(25867, 'Viani', 25, NULL, NULL, NULL),
(25871, 'Villagomez', 25, NULL, NULL, NULL),
(25873, 'Villapinzon', 25, NULL, NULL, NULL),
(25875, 'Villeta', 25, NULL, NULL, NULL),
(25878, 'Viota', 25, NULL, NULL, NULL),
(25885, 'Yacopi', 25, NULL, NULL, NULL),
(25898, 'Zipacon', 25, NULL, NULL, NULL),
(25899, 'Zipaquirá', 25, NULL, NULL, NULL),
(27001, 'Quibdo', 27, NULL, NULL, NULL),
(27006, 'Acandi', 27, NULL, NULL, NULL),
(27025, 'Alto Baudo (Pie de P', 27, NULL, NULL, NULL),
(27050, 'Atrato', 27, NULL, NULL, NULL),
(27073, 'Bagado', 27, NULL, NULL, NULL),
(27075, 'Bahia Solano (Mutis)', 27, NULL, NULL, NULL),
(27077, 'Bajo Baudo (Pizarro)', 27, NULL, NULL, NULL),
(27099, 'Bojaya (Bellavista)', 27, NULL, NULL, NULL),
(27135, 'El Canton del San Pablo ', 27, NULL, NULL, NULL),
(27150, 'Carmen del Darien', 27, NULL, NULL, NULL),
(27160, 'Certegui', 27, NULL, NULL, NULL),
(27205, 'Condoto', 27, NULL, NULL, NULL),
(27245, 'El Carmen de Atrato', 27, NULL, NULL, NULL),
(27250, 'Litoral del Bajo San', 27, NULL, NULL, NULL),
(27361, 'Itsmina', 27, NULL, NULL, NULL),
(27372, 'Jurado', 27, NULL, NULL, NULL),
(27413, 'Lloro', 27, NULL, NULL, NULL),
(27425, 'Medio Atrato', 27, NULL, NULL, NULL),
(27430, 'Medio Baudo (Boca de', 27, NULL, NULL, NULL),
(27450, 'Medio San Juan', 27, NULL, NULL, NULL),
(27491, 'Novita', 27, NULL, NULL, NULL),
(27495, 'Nuqui', 27, NULL, NULL, NULL),
(27580, 'Rio Iro', 27, NULL, NULL, NULL),
(27600, 'Rioquito', 27, NULL, NULL, NULL),
(27615, 'Riosucio', 27, NULL, NULL, NULL),
(27660, 'San Jose del Palmar', 27, NULL, NULL, NULL),
(27745, 'Sipi', 27, NULL, NULL, NULL),
(27787, 'Tado', 27, NULL, NULL, NULL),
(27800, 'Unguia', 27, NULL, NULL, NULL),
(27810, 'Union Panamericana', 27, NULL, NULL, NULL),
(41001, 'Neiva', 41, NULL, NULL, NULL),
(41006, 'Acevedo', 41, NULL, NULL, NULL),
(41013, 'Agrado', 41, NULL, NULL, NULL),
(41016, 'Aipe', 41, NULL, NULL, NULL),
(41020, 'Algeciras', 41, NULL, NULL, NULL),
(41026, 'Altamira', 41, NULL, NULL, NULL),
(41078, 'Baraya', 41, NULL, NULL, NULL),
(41132, 'Campoalegre', 41, NULL, NULL, NULL),
(41206, 'Colombia', 41, NULL, NULL, NULL),
(41244, 'Elias', 41, NULL, NULL, NULL),
(41298, 'Garzon', 41, NULL, NULL, NULL),
(41306, 'Gigante', 41, NULL, NULL, NULL),
(41319, 'Guadalupe', 41, NULL, NULL, NULL),
(41349, 'Hobo', 41, NULL, NULL, NULL),
(41357, 'Iquira', 41, NULL, NULL, NULL),
(41359, 'Isnos (San Jose de I', 41, NULL, NULL, NULL),
(41378, 'La Argentina', 41, NULL, NULL, NULL),
(41396, 'La Plata', 41, NULL, NULL, NULL),
(41483, 'Nataga', 41, NULL, NULL, NULL),
(41503, 'Oporapa', 41, NULL, NULL, NULL),
(41518, 'Paicol', 41, NULL, NULL, NULL),
(41524, 'Palermo', 41, NULL, NULL, NULL),
(41530, 'Palestina', 41, NULL, NULL, NULL),
(41548, 'Pital', 41, NULL, NULL, NULL),
(41551, 'Pitalito', 41, NULL, NULL, NULL),
(41615, 'Rivera', 41, NULL, NULL, NULL),
(41660, 'Saladoblanco', 41, NULL, NULL, NULL),
(41668, 'San Agustin', 41, NULL, NULL, NULL),
(41676, 'Santa Maria', 41, NULL, NULL, NULL),
(41770, 'Suaza', 41, NULL, NULL, NULL),
(41791, 'Tarqui', 41, NULL, NULL, NULL),
(41797, 'Tesalia', 41, NULL, NULL, NULL),
(41799, 'Tello', 41, NULL, NULL, NULL),
(41801, 'Teruel', 41, NULL, NULL, NULL),
(41807, 'Timana', 41, NULL, NULL, NULL),
(41872, 'Villavieja', 41, NULL, NULL, NULL),
(41885, 'Yaguara', 41, NULL, NULL, NULL),
(44001, 'Riohacha', 44, NULL, NULL, NULL),
(44035, 'Albania', 44, NULL, NULL, NULL),
(44078, 'Barrancas', 44, NULL, NULL, NULL),
(44090, 'Dibulla', 44, NULL, NULL, NULL),
(44098, 'Distraccion', 44, NULL, NULL, NULL),
(44110, 'El Molino', 44, NULL, NULL, NULL),
(44279, 'Fonseca', 44, NULL, NULL, NULL),
(44378, 'Hatonuevo', 44, NULL, NULL, NULL),
(44420, 'La Jagua del Pilar', 44, NULL, NULL, NULL),
(44430, 'Maicao', 44, NULL, NULL, NULL),
(44560, 'Manaure', 44, NULL, NULL, NULL),
(44650, 'San Juan del Cesar', 44, NULL, NULL, NULL),
(44847, 'Uribia', 44, NULL, NULL, NULL),
(44855, 'Urumita', 44, NULL, NULL, NULL),
(44874, 'Villanueva', 44, NULL, NULL, NULL),
(47001, 'Santa Marta', 47, NULL, NULL, NULL),
(47030, 'Algarrobo', 47, NULL, NULL, NULL),
(47053, 'Aracataca', 47, NULL, NULL, NULL),
(47058, 'Ariguani (El Dificil', 47, NULL, NULL, NULL),
(47161, 'Cerro San Antonio', 47, NULL, NULL, NULL),
(47170, 'Chivolo', 47, NULL, NULL, NULL),
(47189, 'Cienaga', 47, NULL, NULL, NULL),
(47205, 'Concordia', 47, NULL, NULL, NULL),
(47245, 'El Banco', 47, NULL, NULL, NULL),
(47258, 'El PiÃ±on', 47, NULL, NULL, NULL),
(47268, 'El Reten', 47, NULL, NULL, NULL),
(47288, 'Fundacion', 47, NULL, NULL, NULL),
(47318, 'Guamal', 47, NULL, NULL, NULL),
(47460, 'Nueva Granada', 47, NULL, NULL, NULL),
(47541, 'Pedraza', 47, NULL, NULL, NULL),
(47545, 'PijiÃ±o del Carmen (P', 47, NULL, NULL, NULL),
(47551, 'Pivijay', 47, NULL, NULL, NULL),
(47555, 'Plato', 47, NULL, NULL, NULL),
(47570, 'Puebloviejo', 47, NULL, NULL, NULL),
(47605, 'Remolino', 47, NULL, NULL, NULL),
(47660, 'Sabanas de San Angel', 47, NULL, NULL, NULL),
(47675, 'Salamina', 47, NULL, NULL, NULL),
(47692, 'San Sebastian de Bue', 47, NULL, NULL, NULL),
(47703, 'San Zenon', 47, NULL, NULL, NULL),
(47707, 'Santa Ana', 47, NULL, NULL, NULL),
(47720, 'Santa Barbara de Pin', 47, NULL, NULL, NULL),
(47745, 'Sitio Nuevo', 47, NULL, NULL, NULL),
(47798, 'Tenerife', 47, NULL, NULL, NULL),
(47960, 'Zapayan', 47, NULL, NULL, NULL),
(47980, 'Zona Bananera', 47, NULL, NULL, NULL),
(47983, 'Bordo', 19, NULL, NULL, NULL),
(50001, 'Villavicencio', 50, NULL, NULL, NULL),
(50006, 'Acacias', 50, NULL, NULL, NULL),
(50110, 'Barranca de Upia', 50, NULL, NULL, NULL),
(50124, 'Cabuyaro', 50, NULL, NULL, NULL),
(50150, 'Castilla La Nueva', 50, NULL, NULL, NULL),
(50223, 'Cubarral', 50, NULL, NULL, NULL),
(50226, 'Cumaral', 50, NULL, NULL, NULL),
(50245, 'El Calvario', 50, NULL, NULL, NULL),
(50251, 'El Castillo', 50, NULL, NULL, NULL),
(50270, 'El Dorado', 50, NULL, NULL, NULL),
(50287, 'Fuente de Oro', 50, NULL, NULL, NULL),
(50313, 'Granada', 50, NULL, NULL, NULL),
(50318, 'Guamal', 50, NULL, NULL, NULL),
(50325, 'Mapiripan', 50, NULL, NULL, NULL),
(50330, 'Mesetas', 50, NULL, NULL, NULL),
(50350, 'La Macarena', 50, NULL, NULL, NULL),
(50370, 'La Uribe', 50, NULL, NULL, NULL),
(50400, 'Lejanias', 50, NULL, NULL, NULL),
(50450, 'Puerto Concordia', 50, NULL, NULL, NULL),
(50568, 'Puerto Gaitan', 50, NULL, NULL, NULL),
(50573, 'Puerto Lopez', 50, NULL, NULL, NULL),
(50577, 'Puerto Lleras', 50, NULL, NULL, NULL),
(50590, 'Puerto Rico', 50, NULL, NULL, NULL),
(50606, 'Restrepo', 50, NULL, NULL, NULL),
(50680, 'San Carlos de Guaroa', 50, NULL, NULL, NULL),
(50683, 'San Juan de Arama', 50, NULL, NULL, NULL),
(50686, 'San Juanito', 50, NULL, NULL, NULL),
(50689, 'San Martin', 50, NULL, NULL, NULL),
(50711, 'Vistahermosa', 50, NULL, NULL, NULL),
(52001, 'Pasto', 52, NULL, NULL, NULL),
(52019, 'Alban (San Jose)', 52, NULL, NULL, NULL),
(52022, 'Aldana', 52, NULL, NULL, NULL),
(52036, 'Ancuya', 52, NULL, NULL, NULL),
(52051, 'Arboleda (Berruecos)', 52, NULL, NULL, NULL),
(52079, 'Barbacoas', 52, NULL, NULL, NULL),
(52083, 'Belen', 52, NULL, NULL, NULL),
(52110, 'Buesaco', 52, NULL, NULL, NULL),
(52203, 'Colon (Genova)', 52, NULL, NULL, NULL),
(52207, 'Consaca', 52, NULL, NULL, NULL),
(52210, 'Contadero', 52, NULL, NULL, NULL),
(52215, 'Cordoba', 52, NULL, NULL, NULL),
(52224, 'Cuaspud (Carlosama)', 52, NULL, NULL, NULL),
(52227, 'Cumbal', 52, NULL, NULL, NULL),
(52233, 'Cumbitara', 52, NULL, NULL, NULL),
(52240, 'Chachagui', 52, NULL, NULL, NULL),
(52250, 'El Charco', 52, NULL, NULL, NULL),
(52254, 'El PeÃ±ol', 52, NULL, NULL, NULL),
(52256, 'El Rosario', 52, NULL, NULL, NULL),
(52258, 'El Tablon', 52, NULL, NULL, NULL),
(52260, 'El Tambo', 52, NULL, NULL, NULL),
(52287, 'Funes', 52, NULL, NULL, NULL),
(52317, 'Guachucal', 52, NULL, NULL, NULL),
(52320, 'Guaitarilla', 52, NULL, NULL, NULL),
(52323, 'Gualmatan', 52, NULL, NULL, NULL),
(52352, 'Iles', 52, NULL, NULL, NULL),
(52354, 'Imues', 52, NULL, NULL, NULL),
(52356, 'Ipiales', 52, NULL, NULL, NULL),
(52378, 'La Cruz', 52, NULL, NULL, NULL),
(52381, 'La Florida', 52, NULL, NULL, NULL),
(52385, 'La Llanada', 52, NULL, NULL, NULL),
(52390, 'La Tola', 52, NULL, NULL, NULL),
(52399, 'La Union', 52, NULL, NULL, NULL),
(52405, 'Leiva', 52, NULL, NULL, NULL),
(52411, 'Linares', 52, NULL, NULL, NULL),
(52418, 'Los Andes (Sotomayor', 52, NULL, NULL, NULL),
(52427, 'Magui (Payan)', 52, NULL, NULL, NULL),
(52435, 'Mallama (Piedrancha)', 52, NULL, NULL, NULL),
(52473, 'Mosquera', 52, NULL, NULL, NULL),
(52480, 'NariÃ±o', 52, NULL, NULL, NULL),
(52490, 'Olaya Herrera(Bocas ', 52, NULL, NULL, NULL),
(52506, 'Ospina', 52, NULL, NULL, NULL),
(52520, 'Francisco Pizarro (S', 52, NULL, NULL, NULL),
(52540, 'Policarpa', 52, NULL, NULL, NULL),
(52560, 'Potosi', 52, NULL, NULL, NULL),
(52565, 'Providencia', 52, NULL, NULL, NULL),
(52573, 'Puerres', 52, NULL, NULL, NULL),
(52585, 'Pupiales', 52, NULL, NULL, NULL),
(52612, 'Ricaurte', 52, NULL, NULL, NULL),
(52621, 'Roberto Payan (San J', 52, NULL, NULL, NULL),
(52678, 'Samaniego', 52, NULL, NULL, NULL),
(52683, 'Sandona', 52, NULL, NULL, NULL),
(52685, 'San Bernardo', 52, NULL, NULL, NULL),
(52687, 'San Lorenzo', 52, NULL, NULL, NULL),
(52693, 'San Pablo', 52, NULL, NULL, NULL),
(52694, 'San Pedro de Cartago', 52, NULL, NULL, NULL),
(52696, 'Santa Barbara (Iscua', 52, NULL, NULL, NULL),
(52699, 'Santa Cruz (Guachave', 52, NULL, NULL, NULL),
(52720, 'Sapuyes', 52, NULL, NULL, NULL),
(52786, 'Taminango', 52, NULL, NULL, NULL),
(52788, 'Tangua', 52, NULL, NULL, NULL),
(52835, 'Tumaco', 52, NULL, NULL, NULL),
(52838, 'Tuquerres', 52, NULL, NULL, NULL),
(52885, 'Yacuanquer', 52, NULL, NULL, NULL),
(54001, 'Cucuta', 54, NULL, NULL, NULL),
(54003, 'Abrego', 54, NULL, NULL, NULL),
(54051, 'Arboledas', 54, NULL, NULL, NULL),
(54099, 'Bochalema', 54, NULL, NULL, NULL),
(54109, 'Bucarasica', 54, NULL, NULL, NULL),
(54125, 'Cacota', 54, NULL, NULL, NULL),
(54128, 'Cachira', 54, NULL, NULL, NULL),
(54172, 'Chinacota', 54, NULL, NULL, NULL),
(54174, 'Chitaga', 54, NULL, NULL, NULL),
(54206, 'Convencion', 54, NULL, NULL, NULL),
(54223, 'Cucutilla', 54, NULL, NULL, NULL),
(54239, 'Durania', 54, NULL, NULL, NULL),
(54245, 'El Carmen', 54, NULL, NULL, NULL),
(54250, 'El Tarra', 54, NULL, NULL, NULL),
(54261, 'El Zulia', 54, NULL, NULL, NULL),
(54313, 'Gramalote', 54, NULL, NULL, NULL),
(54344, 'Hacari', 54, NULL, NULL, NULL),
(54347, 'Herran', 54, NULL, NULL, NULL),
(54377, 'Labateca', 54, NULL, NULL, NULL),
(54385, 'La Esperanza', 54, NULL, NULL, NULL),
(54398, 'La Playa', 54, NULL, NULL, NULL),
(54405, 'Los Patios', 54, NULL, NULL, NULL),
(54418, 'Lourdes', 54, NULL, NULL, NULL),
(54480, 'Mutiscua', 54, NULL, NULL, NULL),
(54498, 'OcaÃ±a', 54, NULL, NULL, NULL),
(54518, 'Pamplona', 54, NULL, NULL, NULL),
(54520, 'Pamplonita', 54, NULL, NULL, NULL),
(54553, 'Puerto Santander', 54, NULL, NULL, NULL),
(54599, 'Ragonvalia', 54, NULL, NULL, NULL),
(54660, 'Salazar', 54, NULL, NULL, NULL),
(54670, 'San Calixto', 54, NULL, NULL, NULL),
(54673, 'San Cayetano', 54, NULL, NULL, NULL),
(54680, 'Santiago', 54, NULL, NULL, NULL),
(54720, 'Sardinata', 54, NULL, NULL, NULL),
(54743, 'Silos', 54, NULL, NULL, NULL),
(54800, 'Teorama', 54, NULL, NULL, NULL),
(54810, 'Tibu', 54, NULL, NULL, NULL),
(54820, 'Toledo', 54, NULL, NULL, NULL),
(54871, 'Villa Caro', 54, NULL, NULL, NULL),
(54874, 'Villa del Rosario', 54, NULL, NULL, NULL),
(63001, 'Armenia', 63, NULL, NULL, NULL),
(63111, 'Buenavista', 63, NULL, NULL, NULL),
(63130, 'Calarca', 63, NULL, NULL, NULL),
(63190, 'Circasia', 63, NULL, NULL, NULL),
(63212, 'Cordoba', 63, NULL, NULL, NULL),
(63272, 'Filandia', 63, NULL, NULL, NULL),
(63302, 'Genova', 63, NULL, NULL, NULL),
(63401, 'La Tebaida', 63, NULL, NULL, NULL),
(63470, 'Montenegro', 63, NULL, NULL, NULL),
(63548, 'Pijao', 63, NULL, NULL, NULL),
(63594, 'Quimbaya', 63, NULL, NULL, NULL),
(63690, 'Salento', 63, NULL, NULL, NULL),
(66001, 'Pereira', 66, NULL, NULL, NULL),
(66045, 'Apia', 66, NULL, NULL, NULL),
(66075, 'Balboa', 66, NULL, NULL, NULL),
(66088, 'Belen de Umbria', 66, NULL, NULL, NULL),
(66170, 'Dosquebradas', 66, NULL, NULL, NULL),
(66318, 'Guatica', 66, NULL, NULL, NULL),
(66383, 'La Celia', 66, NULL, NULL, NULL),
(66400, 'La Virginia', 66, NULL, NULL, NULL),
(66440, 'Marsella', 66, NULL, NULL, NULL),
(66456, 'Mistrato', 66, NULL, NULL, NULL),
(66572, 'Pueblo Rico', 66, NULL, NULL, NULL),
(66594, 'Quinchia', 66, NULL, NULL, NULL),
(66682, 'Santa Rosa de Cabal', 66, NULL, NULL, NULL),
(66687, 'Santuario', 66, NULL, NULL, NULL),
(68001, 'Bucaramanga', 68, NULL, NULL, NULL),
(68013, 'Aguada', 68, NULL, NULL, NULL),
(68020, 'Albania', 68, NULL, NULL, NULL),
(68051, 'Aratoca', 68, NULL, NULL, NULL),
(68077, 'Barbosa', 68, NULL, NULL, NULL),
(68079, 'Barichara', 68, NULL, NULL, NULL),
(68081, 'Barrancabermeja', 68, NULL, NULL, NULL),
(68092, 'Betulia', 68, NULL, NULL, NULL),
(68101, 'Bolivar', 68, NULL, NULL, NULL),
(68121, 'Cabrera', 68, NULL, NULL, NULL),
(68132, 'California', 68, NULL, NULL, NULL),
(68147, 'Capitanejo', 68, NULL, NULL, NULL),
(68152, 'Carcasi', 68, NULL, NULL, NULL),
(68160, 'Cepita', 68, NULL, NULL, NULL),
(68162, 'Cerrito', 68, NULL, NULL, NULL),
(68167, 'Charala', 68, NULL, NULL, NULL),
(68169, 'Charta', 68, NULL, NULL, NULL),
(68176, 'Chima', 68, NULL, NULL, NULL),
(68179, 'Chipata', 68, NULL, NULL, NULL),
(68190, 'Cimitarra', 68, NULL, NULL, NULL),
(68207, 'Concepcion', 68, NULL, NULL, NULL),
(68209, 'Confines', 68, NULL, NULL, NULL),
(68211, 'Contratacion', 68, NULL, NULL, NULL),
(68217, 'Coromoro', 68, NULL, NULL, NULL),
(68229, 'Curiti', 68, NULL, NULL, NULL),
(68235, 'El Carmen de Chucuri', 68, NULL, NULL, NULL),
(68245, 'El Guacamayo', 68, NULL, NULL, NULL),
(68250, 'El PeÃ±on', 68, NULL, NULL, NULL),
(68255, 'El Playon', 68, NULL, NULL, NULL),
(68264, 'Encino', 68, NULL, NULL, NULL),
(68266, 'Enciso', 68, NULL, NULL, NULL),
(68271, 'Florian', 68, NULL, NULL, NULL),
(68276, 'Floridablanca', 68, NULL, NULL, NULL),
(68296, 'Galan', 68, NULL, NULL, NULL),
(68298, 'Gambita', 68, NULL, NULL, NULL),
(68307, 'Giron', 68, NULL, NULL, NULL),
(68318, 'Guaca', 68, NULL, NULL, NULL),
(68320, 'Guadalupe', 68, NULL, NULL, NULL),
(68322, 'Guapota', 68, NULL, NULL, NULL),
(68324, 'Guavata', 68, NULL, NULL, NULL),
(68327, 'Guepsa', 68, NULL, NULL, NULL),
(68344, 'Hato', 68, NULL, NULL, NULL),
(68368, 'Jesus Maria', 68, NULL, NULL, NULL),
(68370, 'Jordan', 68, NULL, NULL, NULL),
(68377, 'La Belleza', 68, NULL, NULL, NULL),
(68385, 'Landazuri', 68, NULL, NULL, NULL),
(68397, 'La Paz', 68, NULL, NULL, NULL),
(68406, 'Lebrija', 68, NULL, NULL, NULL),
(68418, 'Los Santos', 68, NULL, NULL, NULL),
(68425, 'Macaravita', 68, NULL, NULL, NULL),
(68432, 'Malaga', 68, NULL, NULL, NULL),
(68444, 'Matanza', 68, NULL, NULL, NULL),
(68464, 'Mogotes', 68, NULL, NULL, NULL),
(68468, 'Molagavita', 68, NULL, NULL, NULL),
(68498, 'Ocamonte', 68, NULL, NULL, NULL),
(68500, 'Oiba', 68, NULL, NULL, NULL),
(68502, 'Onzaga', 68, NULL, NULL, NULL),
(68522, 'Palmar', 68, NULL, NULL, NULL),
(68524, 'Palmas Socorro', 68, NULL, NULL, NULL),
(68533, 'Paramo', 68, NULL, NULL, NULL),
(68547, 'Piedecuesta', 68, NULL, NULL, NULL),
(68549, 'Pinchote', 68, NULL, NULL, NULL),
(68572, 'Puente Nacional', 68, NULL, NULL, NULL),
(68573, 'Puerto Parra', 68, NULL, NULL, NULL),
(68575, 'Puerto Wilches', 68, NULL, NULL, NULL),
(68615, 'Rionegro', 68, NULL, NULL, NULL),
(68655, 'Sabana de Torres', 68, NULL, NULL, NULL),
(68669, 'San Andres', 68, NULL, NULL, NULL),
(68673, 'San Benito', 68, NULL, NULL, NULL),
(68679, 'San Gil', 68, NULL, NULL, NULL),
(68682, 'San Joaquin', 68, NULL, NULL, NULL),
(68684, 'San Jose de Miranda', 68, NULL, NULL, NULL),
(68686, 'San Miguel', 68, NULL, NULL, NULL),
(68689, 'San Vicente de Chucu', 68, NULL, NULL, NULL),
(68705, 'Santa Barbara', 68, NULL, NULL, NULL),
(68720, 'Santa Helena del Opo', 68, NULL, NULL, NULL),
(68745, 'Simacota', 68, NULL, NULL, NULL),
(68755, 'Socorro', 68, NULL, NULL, NULL),
(68770, 'Suaita', 68, NULL, NULL, NULL),
(68773, 'Sucre', 68, NULL, NULL, NULL),
(68780, 'Surata', 68, NULL, NULL, NULL),
(68820, 'Tona', 68, NULL, NULL, NULL),
(68855, 'Valle de San Jose', 68, NULL, NULL, NULL),
(68861, 'Velez', 68, NULL, NULL, NULL),
(68867, 'Vetas', 68, NULL, NULL, NULL),
(68872, 'Villanueva', 68, NULL, NULL, NULL),
(68895, 'Zapatoca', 68, NULL, NULL, NULL),
(70001, 'Sincelejo', 70, NULL, NULL, NULL),
(70110, 'Buenavista', 70, NULL, NULL, NULL),
(70124, 'Caimito', 70, NULL, NULL, NULL),
(70204, 'Coloso (Ricaurte)', 70, NULL, NULL, NULL),
(70215, 'Corozal', 70, NULL, NULL, NULL),
(70221, 'CoveÃ±as', 70, NULL, NULL, NULL),
(70230, 'Chalan', 70, NULL, NULL, NULL),
(70233, 'El Roble', 70, NULL, NULL, NULL),
(70235, 'Galeras (Nueva Grana', 70, NULL, NULL, NULL),
(70265, 'Guaranda', 70, NULL, NULL, NULL),
(70400, 'La Union', 70, NULL, NULL, NULL),
(70418, 'Los Palmitos', 70, NULL, NULL, NULL),
(70429, 'Majagual', 70, NULL, NULL, NULL),
(70473, 'Morroa', 70, NULL, NULL, NULL),
(70508, 'Ovejas', 70, NULL, NULL, NULL),
(70523, 'Palmito', 70, NULL, NULL, NULL),
(70670, 'Sampues', 70, NULL, NULL, NULL),
(70678, 'San Benito Abad', 70, NULL, NULL, NULL),
(70702, 'San Juan de Betulia', 70, NULL, NULL, NULL),
(70708, 'San Marcos', 70, NULL, NULL, NULL),
(70713, 'San Onofre', 70, NULL, NULL, NULL),
(70717, 'San Pedro', 70, NULL, NULL, NULL),
(70742, 'Since', 70, NULL, NULL, NULL),
(70771, 'Sucre', 70, NULL, NULL, NULL),
(70820, 'Tolu', 70, NULL, NULL, NULL),
(70823, 'Toluviejo', 70, NULL, NULL, NULL),
(73001, 'Ibague', 73, NULL, NULL, NULL),
(73024, 'Alpujarra', 73, NULL, NULL, NULL),
(73026, 'Alvarado', 73, NULL, NULL, NULL),
(73030, 'Ambalema', 73, NULL, NULL, NULL),
(73043, 'Anzoategui', 73, NULL, NULL, NULL),
(73055, 'Armero (Guayabal)', 73, NULL, NULL, NULL),
(73067, 'Ataco', 73, NULL, NULL, NULL),
(73124, 'Cajamarca', 73, NULL, NULL, NULL),
(73148, 'Carmen de Apicala', 73, NULL, NULL, NULL),
(73152, 'Casabianca', 73, NULL, NULL, NULL),
(73168, 'Chaparral', 73, NULL, NULL, NULL),
(73200, 'Coello', 73, NULL, NULL, NULL),
(73217, 'Coyaima', 73, NULL, NULL, NULL),
(73226, 'Cunday', 73, NULL, NULL, NULL),
(73236, 'Dolores', 73, NULL, NULL, NULL),
(73268, 'Espinal', 73, NULL, NULL, NULL),
(73270, 'Falan', 73, NULL, NULL, NULL),
(73275, 'Flandes', 73, NULL, NULL, NULL),
(73283, 'Fresno', 73, NULL, NULL, NULL),
(73319, 'Guamo', 73, NULL, NULL, NULL),
(73347, 'Herveo', 73, NULL, NULL, NULL),
(73349, 'Honda', 73, NULL, NULL, NULL),
(73352, 'Icononzo', 73, NULL, NULL, NULL),
(73408, 'Lerida', 73, NULL, NULL, NULL),
(73411, 'Libano', 73, NULL, NULL, NULL),
(73443, 'Mariquita', 73, NULL, NULL, NULL),
(73449, 'Melgar', 73, NULL, NULL, NULL),
(73461, 'Murillo', 73, NULL, NULL, NULL),
(73483, 'Natagaima', 73, NULL, NULL, NULL),
(73504, 'Ortega', 73, NULL, NULL, NULL),
(73520, 'Palocabildo', 73, NULL, NULL, NULL),
(73547, 'Piedras', 73, NULL, NULL, NULL),
(73555, 'Planadas', 73, NULL, NULL, NULL),
(73563, 'Prado', 73, NULL, NULL, NULL),
(73585, 'Purificacion', 73, NULL, NULL, NULL),
(73616, 'Rioblanco', 73, NULL, NULL, NULL),
(73622, 'Roncesvalles', 73, NULL, NULL, NULL),
(73624, 'Rovira', 73, NULL, NULL, NULL),
(73671, 'SaldaÃ±a', 73, NULL, NULL, NULL),
(73675, 'San Antonio', 73, NULL, NULL, NULL),
(73678, 'San Luis', 73, NULL, NULL, NULL),
(73686, 'Santa Isabel', 73, NULL, NULL, NULL),
(73770, 'Suarez', 73, NULL, NULL, NULL),
(73854, 'Valle de San Juan', 73, NULL, NULL, NULL),
(73861, 'Venadillo', 73, NULL, NULL, NULL),
(73870, 'Villahermosa', 73, NULL, NULL, NULL),
(73873, 'Villarica', 73, NULL, NULL, NULL),
(76001, 'Cali', 76, NULL, NULL, NULL),
(76020, 'Alcala', 76, NULL, NULL, NULL),
(76036, 'Andalucia', 76, NULL, NULL, NULL),
(76041, 'Ansermanuevo', 76, NULL, NULL, NULL),
(76054, 'Argelia', 76, NULL, NULL, NULL),
(76100, 'Bolivar', 76, NULL, NULL, NULL),
(76109, 'Buenaventura', 76, NULL, NULL, NULL),
(76111, 'Buga', 76, NULL, NULL, NULL),
(76113, 'Bugalagrande', 76, NULL, NULL, NULL),
(76122, 'Caicedonia', 76, NULL, NULL, NULL),
(76126, 'Darien', 76, NULL, NULL, NULL),
(76130, 'Candelaria', 76, NULL, NULL, NULL),
(76147, 'Cartago', 76, NULL, NULL, NULL),
(76233, 'Dagua', 76, NULL, NULL, NULL),
(76243, 'El Aguila', 76, NULL, NULL, NULL),
(76246, 'El Cairo', 76, NULL, NULL, NULL),
(76248, 'El Cerrito', 76, NULL, NULL, NULL),
(76250, 'El Dovio', 76, NULL, NULL, NULL),
(76275, 'Florida', 76, NULL, NULL, NULL),
(76306, 'Ginebra', 76, NULL, NULL, NULL),
(76318, 'Guacari', 76, NULL, NULL, NULL),
(76364, 'Jamundi', 76, NULL, NULL, NULL),
(76377, 'La Cumbre', 76, NULL, NULL, NULL),
(76400, 'La Union', 76, NULL, NULL, NULL),
(76403, 'La Victoria', 76, NULL, NULL, NULL),
(76497, 'Obando', 76, NULL, NULL, NULL),
(76520, 'Palmira', 76, NULL, NULL, NULL),
(76563, 'Pradera', 76, NULL, NULL, NULL),
(76606, 'Restrepo', 76, NULL, NULL, NULL),
(76616, 'Riofrio', 76, NULL, NULL, NULL),
(76622, 'Roldanillo', 76, NULL, NULL, NULL),
(76670, 'San Pedro', 76, NULL, NULL, NULL),
(76736, 'Sevilla', 76, NULL, NULL, NULL),
(76823, 'Toro', 76, NULL, NULL, NULL),
(76828, 'Trujillo', 76, NULL, NULL, NULL),
(76834, 'Tulua', 76, NULL, NULL, NULL),
(76845, 'Ulloa', 76, NULL, NULL, NULL),
(76863, 'Versalles', 76, NULL, NULL, NULL),
(76869, 'Vijes', 76, NULL, NULL, NULL),
(76890, 'Yotoco', 76, NULL, NULL, NULL),
(76892, 'Yumbo', 76, NULL, NULL, NULL),
(76895, 'Zarzal', 76, NULL, NULL, NULL),
(81001, 'Arauca', 81, NULL, NULL, NULL),
(81065, 'Arauquita', 81, NULL, NULL, NULL),
(81220, 'Cravo Norte', 81, NULL, NULL, NULL),
(81300, 'Fortul', 81, NULL, NULL, NULL),
(81591, 'Puerto Rondon', 81, NULL, NULL, NULL),
(81736, 'Saravena', 81, NULL, NULL, NULL),
(81794, 'Tame', 81, NULL, NULL, NULL),
(85001, 'Yopal', 85, NULL, NULL, NULL),
(85010, 'Aguazul', 85, NULL, NULL, NULL),
(85015, 'Chameza', 85, NULL, NULL, NULL),
(85125, 'Hato Corozal', 85, NULL, NULL, NULL),
(85136, 'La Salina', 85, NULL, NULL, NULL),
(85139, 'Mani', 85, NULL, NULL, NULL),
(85162, 'Monterrey', 85, NULL, NULL, NULL),
(85225, 'Nunchia', 85, NULL, NULL, NULL),
(85230, 'Orocue', 85, NULL, NULL, NULL),
(85250, 'Paz de Ariporo', 85, NULL, NULL, NULL),
(85263, 'Pore', 85, NULL, NULL, NULL),
(85279, 'Recetor', 85, NULL, NULL, NULL),
(85300, 'Sabanalarga', 85, NULL, NULL, NULL),
(85315, 'Sacama', 85, NULL, NULL, NULL),
(85325, 'San Luis de Palenque', 85, NULL, NULL, NULL),
(85400, 'Tamara', 85, NULL, NULL, NULL),
(85410, 'Tauramena', 85, NULL, NULL, NULL),
(85430, 'Trinidad', 85, NULL, NULL, NULL),
(85440, 'Villanueva', 85, NULL, NULL, NULL),
(86001, 'Mocoa', 86, NULL, NULL, NULL),
(86219, 'Colon', 86, NULL, NULL, NULL),
(86320, 'Orito', 86, NULL, NULL, NULL),
(86568, 'Puerto Asis', 86, NULL, NULL, NULL),
(86569, 'Puerto Caicedo', 86, NULL, NULL, NULL),
(86571, 'Puerto Guzman', 86, NULL, NULL, NULL),
(86573, 'Puerto Leguizamo', 86, NULL, NULL, NULL),
(86749, 'Sibundoy', 86, NULL, NULL, NULL),
(86755, 'San Francisco', 86, NULL, NULL, NULL),
(86757, 'San Miguel (La Dorad', 86, NULL, NULL, NULL),
(86760, 'Santiago', 86, NULL, NULL, NULL),
(86865, 'Valle del Guamuez', 86, NULL, NULL, NULL),
(86885, 'Villagarzon', 86, NULL, NULL, NULL),
(88001, 'San Andres', 88, NULL, NULL, NULL),
(88564, 'Providencia', 88, NULL, NULL, NULL),
(91001, 'Leticia', 91, NULL, NULL, NULL),
(91263, 'El Encanto (CD)', 91, NULL, NULL, NULL),
(91405, 'La Chorrera (CD)', 91, NULL, NULL, NULL),
(91407, 'La Pedrera (CD)', 91, NULL, NULL, NULL),
(91430, 'La Victoria (CD)', 91, NULL, NULL, NULL),
(91460, 'Miriti Parana (CD)', 91, NULL, NULL, NULL),
(91530, 'Puerto Alegria (CD)', 91, NULL, NULL, NULL),
(91536, 'Puerto Arica (CD)', 91, NULL, NULL, NULL),
(91540, 'Puerto Nariño', 91, NULL, NULL, NULL),
(91669, 'Puerto Santander (CD', 91, NULL, NULL, NULL),
(91798, 'Tarapaca (CD)', 91, NULL, NULL, NULL),
(94001, 'Puerto Inirida', 94, NULL, NULL, NULL),
(94343, 'Barranco Minas', 94, NULL, NULL, NULL),
(94663, 'Mapiripana', 94, NULL, NULL, NULL),
(94883, 'San Felipe', 94, NULL, NULL, NULL),
(94884, 'Puerto Colombia', 94, NULL, NULL, NULL),
(94885, 'La Guadalupe', 94, NULL, NULL, NULL),
(94886, 'Cacahual', 94, NULL, NULL, NULL),
(94887, 'Pana Pana', 94, NULL, NULL, NULL),
(94888, 'Morichal', 94, NULL, NULL, NULL),
(95001, 'San Jose del Guaviare', 95, NULL, NULL, NULL),
(95015, 'Calamar', 95, NULL, NULL, NULL),
(95025, 'El Retorno', 95, NULL, NULL, NULL),
(95200, 'Miraflores', 95, NULL, NULL, NULL),
(97001, 'Mitu', 97, NULL, NULL, NULL),
(97161, 'Caruru', 97, NULL, NULL, NULL),
(97511, 'Pacoa (CD)', 97, NULL, NULL, NULL),
(97666, 'Taraira', 97, NULL, NULL, NULL),
(97777, 'Papunaua (Morichal) ', 97, NULL, NULL, NULL),
(97889, 'Yavarate (CD)', 97, NULL, NULL, NULL),
(99001, 'Puerto Carreño', 99, NULL, NULL, NULL),
(99524, 'La Primavera', 99, NULL, NULL, NULL),
(99624, 'Santa Rosalia', 99, NULL, NULL, NULL),
(99773, 'Cumaribo', 99, NULL, NULL, NULL),
(99774, NULL, NULL, NULL, NULL, NULL);

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
  `pasusu` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusu`, `nomusu`, `apeusu`, `docusu`, `emausu`, `celusu`, `genusu`, `dirrecusu`, `tipdoc`, `idval`, `idubi`, `feccreate`, `fecupdate`, `fotpef`, `idpef`, `pasusu`) VALUES
(1, 'David', 'Soriano', 123213, 'davidscicua314@gmail.com', '3186274255', 'Masculino', 'Chia', 'CC', NULL, NULL, '2024-07-23 15:57:00', '2024-07-23 16:08:34', NULL, 1, '$2y$10$x.YxpWCplR/9QvsxVAJDsu4ba.U/TOTy6N7ootwlW7b8r27GyRqnW'),
(7, 'Diego', 'Sarmiento', 80546098, 'correo@gmail.com', '3186274255', 'M', NULL, NULL, NULL, NULL, '2024-10-31 15:40:34', '2024-10-31 15:40:34', NULL, 1, '456'),
(8, 'Juan', 'Soriano', 80546098, 'correo@gmail.com', '3186274255', 'M', NULL, NULL, NULL, NULL, '2024-10-31 15:40:50', '2024-10-31 15:40:50', NULL, 1, '456'),
(9, 'Juan', 'Soriano', 80546098, 'correo@gmail.com', '3186274255', 'M', NULL, 'CC', NULL, NULL, '2024-10-31 15:46:21', '2024-10-31 15:46:21', NULL, 1, '456'),
(10, 'Angela', 'Soriano', 12345, 'correo@gmail.com', '3186274255', 'F', NULL, 'CC', NULL, NULL, '2024-10-31 15:47:03', '2024-10-31 15:47:03', NULL, 1, '789'),
(11, 'Angela', 'Soriano', 12345, 'correo@gmail.com', '3186274255', 'F', NULL, 'CC', NULL, NULL, '2024-10-31 15:47:39', '2024-10-31 15:47:39', NULL, 1, '789'),
(12, 'Angela', 'Soriano', 12345, 'correo@gmail.com', '3186274255', 'F', NULL, 'CC', NULL, NULL, '2024-10-31 15:50:25', '2024-10-31 15:50:25', NULL, 1, '789'),
(13, 'Omar', 'Soriano', 745253, 'correo@gmail.com', '3186274255', 'M', NULL, 'RC', NULL, NULL, '2024-10-31 15:51:05', '2024-10-31 15:51:05', NULL, 1, '544'),
(14, 'Miguel', 'Gomez', 714546354, 'correo@gmail.com', '7845234', 'M', NULL, 'CC', NULL, NULL, '2024-10-31 15:55:38', '2024-10-31 15:55:38', NULL, 1, '$2y$10$Kl0GUisqCIIGIqimBmSirOCV9v8TXaHepxitwao2.PW0L1YjFS/2y'),
(15, 'Laura', 'Bello', 10468975, 'laura@gmail.com', '3186274255', 'F', NULL, 'TI', NULL, NULL, '2024-10-31 15:59:03', '2024-10-31 15:59:47', NULL, 1, '$2y$10$F.3MJK1bLXoT6aSlVs8IpO549M10DZ56pQIt5jbzDW.u.5TZNfRda');

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
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`idadmin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`idaud`);

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
  ADD PRIMARY KEY (`idpro`),
  ADD KEY `fk_producto_valor` (`idval`);

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
  ADD KEY `idusu` (`idusu`),
  ADD KEY `fk_valor_dominio` (`iddom`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `idadmin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `caracteristicas`
--
ALTER TABLE `caracteristicas`
  MODIFY `idcar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `idcar` bigint(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `iddet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `devolucionreembolso`
--
ALTER TABLE `devolucionreembolso`
  MODIFY `iddevo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `dominio`
--
ALTER TABLE `dominio`
  MODIFY `iddom` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `idfav` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `idimag` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `idmen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `pagina`
--
ALTER TABLE `pagina`
  MODIFY `idpag` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `idpag` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idped` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `idpef` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pqr`
--
ALTER TABLE `pqr`
  MODIFY `idpqr` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idpro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idprov` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `idubi` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99775;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusu` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `valor`
--
ALTER TABLE `valor`
  MODIFY `idval` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

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
