-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-09-2021 a las 19:32:06
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agrogestion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades_empresas`
--

CREATE TABLE `actividades_empresas` (
  `idactividad_empresa` int(11) NOT NULL,
  `idactividad` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `actividades_empresas`
--

INSERT INTO `actividades_empresas` (`idactividad_empresa`, `idactividad`, `idempresa`, `total`) VALUES
(114, 137, 37, '195.00'),
(115, 137, 41, '195.00'),
(116, 138, 37, '130.00'),
(117, 138, 41, '137.50'),
(118, 138, 43, '7.50'),
(119, 139, 37, '2365.00'),
(120, 140, 37, '110.00'),
(121, 142, 37, '480.00'),
(123, 143, 37, '204.00'),
(124, 143, 41, '204.00'),
(125, 146, 37, '115.00'),
(126, 147, 37, '165.00'),
(127, 148, 37, '235.00'),
(128, 149, 37, '95.00'),
(129, 149, 62, '95.00'),
(130, 150, 37, '155.00'),
(131, 150, 62, '155.00'),
(132, 151, 37, '112.50'),
(133, 151, 62, '112.50'),
(134, 152, 37, '200.00'),
(135, 152, 62, '200.00'),
(136, 153, 37, '170.00'),
(137, 153, 62, '170.00'),
(138, 154, 37, '110.00'),
(139, 155, 37, '200.00'),
(140, 155, 62, '200.00'),
(141, 156, 37, '170.00'),
(142, 156, 62, '170.00'),
(143, 157, 37, '115.00'),
(144, 158, 37, '165.00'),
(145, 159, 37, '235.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades_insumos`
--

CREATE TABLE `actividades_insumos` (
  `idactividad_insumo` int(11) NOT NULL,
  `idactividad` int(11) NOT NULL,
  `idinsumo` int(11) NOT NULL,
  `cantidadHa` decimal(7,2) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidadTotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `actividades_insumos`
--

INSERT INTO `actividades_insumos` (`idactividad_insumo`, `idactividad`, `idinsumo`, `cantidadHa`, `precio`, `cantidadTotal`) VALUES
(189, 137, 73, '0.20', '4.00', '15.60'),
(191, 138, 73, '0.20', '4.00', '11.00'),
(192, 139, 80, '60.00', '0.85', '3300.00'),
(194, 140, 79, '0.45', '83.00', '9.90'),
(195, 140, 75, '2.50', '7.35', '55.00'),
(196, 141, 67, '2.50', '300.00', '362.50'),
(197, 142, 75, '1.00', '7.35', '80.00'),
(199, 143, 75, '1.00', '7.35', '68.00'),
(203, 140, 65, '2.00', '5.00', '44.00'),
(204, 140, 78, '5.00', '5.50', '110.00'),
(205, 145, 65, '100.00', '5.00', '15000.00'),
(206, 140, 82, '1.20', '12.00', '26.40'),
(207, 146, 72, '0.02', '13.00', '0.46'),
(208, 146, 75, '2.00', '7.35', '46.00'),
(209, 146, 76, '1.20', '6.50', '27.60'),
(210, 146, 77, '0.20', '14.50', '4.60'),
(211, 147, 72, '0.02', '13.00', '0.66'),
(212, 147, 75, '2.00', '7.35', '66.00'),
(213, 147, 76, '1.20', '6.50', '39.60'),
(214, 147, 77, '0.20', '14.50', '6.60'),
(215, 148, 72, '0.02', '13.00', '0.94'),
(216, 148, 75, '2.00', '7.35', '94.00'),
(217, 148, 76, '1.20', '6.50', '56.40'),
(218, 148, 77, '0.20', '14.50', '9.40'),
(219, 149, 72, '0.05', '13.00', '1.90'),
(220, 149, 88, '1.00', '3.00', '38.00'),
(221, 149, 75, '2.00', '7.35', '76.00'),
(222, 149, 76, '1.50', '6.50', '57.00'),
(223, 149, 77, '0.20', '14.50', '7.60'),
(224, 150, 72, '0.05', '13.00', '3.10'),
(225, 150, 88, '1.00', '3.00', '62.00'),
(226, 150, 75, '2.00', '7.35', '124.00'),
(227, 150, 76, '1.50', '6.50', '93.00'),
(228, 150, 77, '0.20', '14.50', '12.40'),
(229, 151, 72, '0.05', '13.00', '2.25'),
(230, 151, 88, '1.00', '3.00', '45.00'),
(231, 151, 75, '2.00', '7.35', '90.00'),
(232, 151, 76, '1.50', '6.50', '67.50'),
(233, 151, 77, '0.20', '14.50', '9.00'),
(234, 152, 72, '0.04', '13.00', '3.20'),
(235, 152, 75, '2.00', '7.35', '160.00'),
(236, 152, 76, '1.50', '6.50', '120.00'),
(237, 152, 88, '1.00', '3.00', '80.00'),
(238, 152, 77, '0.20', '14.50', '16.00'),
(239, 153, 72, '0.04', '13.00', '2.72'),
(240, 153, 75, '2.00', '7.35', '136.00'),
(241, 153, 76, '1.50', '6.50', '102.00'),
(242, 153, 88, '1.00', '3.00', '68.00'),
(243, 153, 77, '0.20', '14.50', '13.60'),
(245, 155, 72, '0.04', '13.00', '3.20'),
(246, 155, 75, '2.00', '7.35', '160.00'),
(247, 155, 76, '1.50', '6.50', '120.00'),
(248, 155, 88, '1.00', '3.00', '80.00'),
(249, 155, 77, '0.20', '14.50', '16.00'),
(250, 156, 72, '0.04', '13.00', '2.72'),
(251, 156, 75, '2.00', '7.35', '136.00'),
(252, 156, 76, '1.50', '6.50', '102.00'),
(253, 156, 88, '1.00', '3.00', '68.00'),
(254, 156, 77, '0.20', '14.50', '13.60'),
(255, 157, 72, '0.02', '13.00', '0.46'),
(256, 157, 75, '2.00', '7.35', '46.00'),
(257, 157, 76, '1.20', '6.50', '27.60'),
(258, 157, 77, '0.20', '14.50', '4.60'),
(259, 158, 72, '0.02', '13.00', '0.66'),
(260, 158, 75, '2.00', '7.35', '66.00'),
(261, 158, 76, '1.20', '6.50', '39.60'),
(262, 158, 77, '0.20', '14.50', '6.60'),
(263, 159, 72, '0.02', '13.00', '0.94'),
(264, 159, 75, '2.00', '7.35', '94.00'),
(265, 159, 76, '1.20', '6.50', '56.40'),
(266, 159, 77, '0.20', '14.50', '9.40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades_lotes`
--

CREATE TABLE `actividades_lotes` (
  `idactividad` int(11) NOT NULL,
  `idloteCampana` int(11) NOT NULL,
  `idlabor` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `superficie` decimal(10,2) NOT NULL,
  `precioha` decimal(10,2) NOT NULL,
  `maquinaria` int(11) NOT NULL DEFAULT 0 COMMENT '0-nada 1-contratada 2-propia',
  `observaciones` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `actividades_lotes`
--

INSERT INTO `actividades_lotes` (`idactividad`, `idloteCampana`, `idlabor`, `fecha`, `superficie`, `precioha`, `maquinaria`, `observaciones`) VALUES
(137, 63, 24, '2021-09-15', '78.00', '5.00', 2, NULL),
(138, 64, 24, '2021-09-15', '55.00', '5.00', 2, NULL),
(139, 64, 25, '2021-09-15', '55.00', '43.00', 1, ''),
(140, 65, 24, '2021-09-16', '22.00', '5.00', 1, ''),
(141, 66, 23, '2021-09-16', '145.00', '40.00', 0, ''),
(142, 63, 24, '2021-09-18', '80.00', '6.00', 2, NULL),
(143, 67, 24, '2021-09-18', '68.00', '6.00', 2, NULL),
(145, 68, 24, '2021-09-18', '150.00', '5.00', 0, ''),
(146, 69, 24, '2021-09-17', '23.00', '5.00', 2, NULL),
(147, 70, 24, '2021-09-17', '33.00', '5.00', 2, NULL),
(148, 71, 24, '2021-09-17', '47.00', '5.00', 2, NULL),
(149, 72, 24, '2021-09-18', '38.00', '5.00', 2, NULL),
(150, 73, 24, '2021-09-18', '62.00', '5.00', 2, NULL),
(151, 74, 24, '2021-09-18', '45.00', '5.00', 2, NULL),
(152, 63, 24, '2021-09-17', '80.00', '5.00', 2, NULL),
(153, 67, 24, '2021-09-17', '68.00', '5.00', 2, NULL),
(154, 65, 24, '2021-09-19', '22.00', '5.00', 0, NULL),
(155, 63, 24, '2021-09-17', '80.00', '5.00', 2, NULL),
(156, 67, 24, '2021-09-17', '68.00', '5.00', 2, NULL),
(157, 69, 24, '2021-09-17', '23.00', '5.00', 2, NULL),
(158, 70, 24, '2021-09-17', '33.00', '5.00', 2, NULL),
(159, 71, 24, '2021-09-17', '47.00', '5.00', 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades_personales`
--

CREATE TABLE `actividades_personales` (
  `idactividad_personal` int(11) NOT NULL,
  `idactividad` int(11) NOT NULL,
  `idpersonal` int(11) NOT NULL,
  `precioHa` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `actividades_personales`
--

INSERT INTO `actividades_personales` (`idactividad_personal`, `idactividad`, `idpersonal`, `precioHa`) VALUES
(52, 137, 20, '77.00'),
(53, 138, 20, '77.00'),
(54, 142, 4, '55.00'),
(55, 143, 4, '55.00'),
(56, 146, 6, '49.00'),
(57, 147, 6, '49.00'),
(58, 148, 6, '49.00'),
(59, 149, 21, '10.00'),
(60, 149, 6, '49.00'),
(61, 150, 21, '10.00'),
(62, 150, 6, '49.00'),
(63, 151, 21, '10.00'),
(64, 151, 6, '49.00'),
(65, 152, 21, '10.00'),
(66, 152, 6, '49.00'),
(67, 153, 21, '10.00'),
(68, 153, 6, '49.00'),
(69, 155, 21, '10.00'),
(70, 155, 6, '49.00'),
(71, 156, 21, '10.00'),
(72, 156, 6, '49.00'),
(73, 157, 6, '49.00'),
(74, 158, 6, '49.00'),
(75, 159, 6, '49.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades_terceros`
--

CREATE TABLE `actividades_terceros` (
  `idactividad_tercero` int(11) NOT NULL,
  `idactividad` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL,
  `precioHa` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `actividades_terceros`
--

INSERT INTO `actividades_terceros` (`idactividad_tercero`, `idactividad`, `idempresa`, `precioHa`) VALUES
(34, 139, 55, '43.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `beneficiarios`
--

CREATE TABLE `beneficiarios` (
  `idbeneficiario` int(11) NOT NULL,
  `beneficiario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `beneficiarios`
--

INSERT INTO `beneficiarios` (`idbeneficiario`, `beneficiario`) VALUES
(1, 'Piasco'),
(2, 'Ferro Sur');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campanas`
--

CREATE TABLE `campanas` (
  `idcampana` int(11) NOT NULL,
  `campana` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `campanas`
--

INSERT INTO `campanas` (`idcampana`, `campana`) VALUES
(3, '19-20'),
(1, '20-21'),
(4, '21-22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campos`
--

CREATE TABLE `campos` (
  `idcampo` int(11) NOT NULL,
  `campo` varchar(45) NOT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `campos`
--

INSERT INTO `campos` (`idcampo`, `campo`, `idusuario`) VALUES
(53, 'Don Beto', 1),
(54, 'El Destino', 2),
(56, 'El Wenuy', 1),
(57, 'El Parejito', 1),
(58, 'Doña Rosa', 1),
(61, 'Don Miguel', 1),
(62, 'La Felisa', 1),
(63, 'Don Eduardo', 1),
(64, 'Pipiolo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE `cuentas` (
  `idcuenta` int(11) NOT NULL,
  `idempresaActiva` int(11) NOT NULL,
  `cuenta` varchar(50) NOT NULL,
  `numero` int(11) NOT NULL,
  `idmoneda` int(11) NOT NULL,
  `idtipo` int(11) NOT NULL,
  `idpersonal` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`idcuenta`, `idempresaActiva`, `cuenta`, `numero`, `idmoneda`, `idtipo`, `idpersonal`, `idempresa`) VALUES
(1, 37, 'Banco Galicia CA', 0, 1, 1, 0, 0),
(3, 37, 'Banco Cordoba', 0, 1, 1, 0, 0),
(4, 48, 'Banco Cordoba CA', 0, 1, 4, 0, 0),
(5, 37, 'Efectivo', 0, 1, 2, 0, 0),
(6, 37, 'Cartera de Cheques', 123456789, 8, 8, 0, 0),
(7, 37, 'Tosquita', 0, 1, 6, 0, 49),
(8, 37, 'AGD', 0, 1, 6, 0, 50),
(9, 37, 'Fondo FIMA', 0, 1, 9, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cultivos`
--

CREATE TABLE `cultivos` (
  `idcultivo` int(11) NOT NULL,
  `cultivo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cultivos`
--

INSERT INTO `cultivos` (`idcultivo`, `cultivo`) VALUES
(4, 'GIRASOL'),
(2, 'MAIZ'),
(3, 'MANI'),
(1, 'SIN DEFINIR'),
(6, 'SOJA'),
(5, 'TRIGO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `depositos`
--

CREATE TABLE `depositos` (
  `iddeposito` int(11) NOT NULL,
  `deposito` varchar(50) NOT NULL,
  `idempresa` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `depositos`
--

INSERT INTO `depositos` (`iddeposito`, `deposito`, `idempresa`, `idproveedor`) VALUES
(37, 'Deposito Principal', 37, 37),
(38, 'Deposito Principal', 41, 41),
(39, 'Deposito Principal', 55, 55),
(40, 'Deposito AGD', 37, 50),
(41, 'Deposito Principal', 56, 56),
(46, 'Deposito Principal', 61, 61),
(47, 'Deposito Principal', 62, 62),
(48, 'Deposito Tosquita Cereales', 37, 49);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `depositos_insumos`
--

CREATE TABLE `depositos_insumos` (
  `iddeposito_insumo` int(11) NOT NULL,
  `iddeposito` int(11) NOT NULL,
  `idinsumo` int(11) NOT NULL,
  `stock` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `depositos_insumos`
--

INSERT INTO `depositos_insumos` (`iddeposito_insumo`, `iddeposito`, `idinsumo`, `stock`) VALUES
(86, 37, 70, 394.00),
(87, 38, 70, -56.50),
(88, 37, 73, 87.70),
(89, 38, 73, -13.30),
(90, 38, 80, -3300.00),
(91, 40, 70, -200.00),
(92, 40, 73, 400.00),
(93, 40, 87, 20.00),
(94, 40, 79, 20.00),
(95, 40, 74, 30.00),
(96, 37, 79, -9.90),
(97, 37, 75, -982.00),
(98, 38, 75, -74.00),
(99, 40, 65, 200.00),
(100, 37, 65, 300.00),
(101, 37, 82, -26.40),
(102, 37, 72, -13.66),
(103, 37, 76, -577.95),
(104, 37, 77, -85.30),
(105, 47, 72, -9.54),
(106, 37, 88, -220.50),
(107, 47, 88, -220.50),
(108, 47, 75, -441.00),
(109, 47, 76, -330.75),
(110, 47, 77, -44.10),
(111, 40, 108, -3.00),
(112, 37, 108, 3.00),
(113, 40, 106, -1.00),
(114, 37, 106, 1.00),
(115, 40, 109, -1.00),
(116, 37, 109, 1.00),
(117, 48, 69, 150.00),
(118, 48, 83, 100.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `idempresa` int(11) NOT NULL,
  `empresa` varchar(45) NOT NULL,
  `cuit` bigint(12) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `productor` tinyint(1) NOT NULL,
  `contratista` tinyint(1) NOT NULL,
  `proveedor` tinyint(1) NOT NULL,
  `otro` tinyint(1) NOT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`idempresa`, `empresa`, `cuit`, `direccion`, `productor`, `contratista`, `proveedor`, `otro`, `idusuario`) VALUES
(37, 'Jose Luis Giantomassi', 20268133985, 'Amado Giantomassi', 1, 1, 0, 0, 1),
(41, 'Soteras Raul', 0, '', 1, 0, 0, 0, 1),
(43, 'Liceaga Agustin', 0, '', 1, 0, 0, 0, 1),
(48, 'Mario Soteras', 0, '', 1, 0, 0, 0, 1),
(49, 'Tosquita Cereales', 0, '', 0, 0, 1, 0, 1),
(50, 'AGD', 0, '', 0, 0, 1, 0, 1),
(54, 'capitani', 0, '', 0, 1, 0, 0, 1),
(55, 'Leysa', 0, '', 0, 1, 0, 0, 1),
(56, 'gfds', 0, '', 0, 0, 0, 0, 1),
(61, 'Jose Luis Giantomass', 0, 'Amado Giantomassi', 1, 0, 0, 0, 2),
(62, 'Abrate Sandra', 12346579, '', 1, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `idfactura` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `idempresa` int(11) NOT NULL,
  `vencimiento` date NOT NULL,
  `idproveedor` int(11) NOT NULL DEFAULT 50,
  `numero` varchar(20) NOT NULL,
  `importe` decimal(10,2) NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `importeTotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`idfactura`, `fecha`, `idempresa`, `vencimiento`, `idproveedor`, `numero`, `importe`, `iva`, `importeTotal`) VALUES
(49, '2021-09-20', 37, '2021-09-20', 50, '', '4.00', '0.84', '4.84'),
(50, '2021-09-23', 37, '2021-09-23', 50, '', '2000.00', '420.00', '2420.00'),
(51, '2021-09-20', 37, '2021-09-20', 49, '', '1650.00', '346.50', '1996.50'),
(52, '2021-06-01', 37, '2021-09-20', 49, '', '1300.00', '273.00', '1573.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_descripcion`
--

CREATE TABLE `facturas_descripcion` (
  `idfactura_descripcion` int(11) NOT NULL,
  `idfactura` int(11) NOT NULL,
  `idinsumo` int(11) NOT NULL,
  `precioUn` decimal(10,2) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `importeTotal` decimal(10,2) NOT NULL,
  `importe` decimal(10,2) NOT NULL,
  `iva` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `facturas_descripcion`
--

INSERT INTO `facturas_descripcion` (`idfactura_descripcion`, `idfactura`, `idinsumo`, `precioUn`, `cantidad`, `importeTotal`, `importe`, `iva`) VALUES
(73, 49, 73, '4.00', '1.00', '4.84', '4.00', '0.84'),
(74, 50, 73, '4.00', '500.00', '2420.00', '2000.00', '420.00'),
(75, 51, 69, '11.00', '150.00', '1996.50', '1650.00', '346.50'),
(76, 52, 83, '13.00', '100.00', '1573.00', '1300.00', '273.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_detalles`
--

CREATE TABLE `facturas_detalles` (
  `idfactura_detalle` int(11) NOT NULL,
  `idfactura` int(11) NOT NULL,
  `detalle` varchar(50) NOT NULL,
  `precioUn` decimal(10,2) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `importe` decimal(10,2) NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `importeTotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumos`
--

CREATE TABLE `insumos` (
  `idinsumo` int(11) NOT NULL,
  `insumo` varchar(45) NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `idunidad` int(11) DEFAULT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `insumos`
--

INSERT INTO `insumos` (`idinsumo`, `insumo`, `precio`, `idunidad`, `idusuario`) VALUES
(65, 'Dimetoato', '5.00', 3, 1),
(66, 'Dimetoato', '160.00', 3, 2),
(67, 'soja', '300.00', 5, 2),
(68, 'Glifosato', '3.50', 3, 1),
(69, 'Dual', '11.00', 3, 1),
(71, 'Dual', '11.00', 3, 2),
(72, 'Corrector', '13.00', 3, 1),
(73, 'Adherente', '4.00', 4, 1),
(75, 'Sulfosato', '7.35', 3, 1),
(76, 'Voleris', '6.50', 3, 1),
(77, 'Rizo Extremo', '14.50', 3, 1),
(78, 'Paraquat', '5.50', 3, 1),
(79, 'Fierce', '83.00', 3, 1),
(80, 'Soja DM52R19', '0.85', 1, 1),
(81, 'SPS', '0.28', 1, 1),
(82, 'Flex', '12.00', 3, 1),
(83, 'Ecorizospray', '13.00', 3, 1),
(84, 'Miravis Duo', '42.00', 3, 1),
(85, 'Verdict', '26.00', 3, 1),
(88, 'Sulfato de Amonio', '3.00', 4, 1),
(107, 'bbbb', '0.00', NULL, 1),
(110, 'Tuken', '42.00', 1, 1),
(111, 'uno nuevo', '160.00', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumos_empresas`
--

CREATE TABLE `insumos_empresas` (
  `idinsumo_empresa` int(11) NOT NULL,
  `idactividad_insumo` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `insumos_empresas`
--

INSERT INTO `insumos_empresas` (`idinsumo_empresa`, `idactividad_insumo`, `idempresa`, `total`, `cantidad`) VALUES
(137, 189, 37, '31.20', '7.80'),
(138, 189, 41, '31.20', '7.80'),
(141, 191, 37, '22.00', '5.50'),
(142, 191, 41, '22.00', '5.50'),
(143, 192, 41, '2805.00', '3300.00'),
(145, 194, 37, '821.70', '9.90'),
(146, 195, 37, '404.25', '55.00'),
(147, 197, 37, '294.00', '40.00'),
(148, 197, 41, '294.00', '40.00'),
(151, 199, 37, '249.90', '34.00'),
(152, 199, 41, '249.90', '34.00'),
(157, 206, 37, '316.80', '26.40'),
(158, 207, 37, '5.98', '0.46'),
(159, 208, 37, '338.10', '46.00'),
(160, 209, 37, '179.40', '27.60'),
(161, 210, 37, '66.70', '4.60'),
(162, 211, 37, '8.58', '0.66'),
(163, 212, 37, '485.10', '66.00'),
(164, 213, 37, '257.40', '39.60'),
(165, 214, 37, '95.70', '6.60'),
(166, 215, 37, '12.22', '0.94'),
(167, 216, 37, '690.90', '94.00'),
(168, 217, 37, '366.60', '56.40'),
(169, 218, 37, '136.30', '9.40'),
(170, 219, 37, '12.35', '0.95'),
(171, 219, 62, '12.35', '0.95'),
(172, 220, 37, '57.00', '19.00'),
(173, 220, 62, '57.00', '19.00'),
(174, 221, 37, '279.30', '38.00'),
(175, 221, 62, '279.30', '38.00'),
(176, 222, 37, '185.25', '28.50'),
(177, 222, 62, '185.25', '28.50'),
(178, 223, 37, '55.10', '3.80'),
(179, 223, 62, '55.10', '3.80'),
(180, 224, 37, '20.15', '1.55'),
(181, 224, 62, '20.15', '1.55'),
(182, 225, 37, '93.00', '31.00'),
(183, 225, 62, '93.00', '31.00'),
(184, 226, 37, '455.70', '62.00'),
(185, 226, 62, '455.70', '62.00'),
(186, 227, 37, '302.25', '46.50'),
(187, 227, 62, '302.25', '46.50'),
(188, 228, 37, '89.90', '6.20'),
(189, 228, 62, '89.90', '6.20'),
(190, 229, 37, '14.63', '1.13'),
(191, 229, 62, '14.63', '1.13'),
(192, 230, 37, '67.50', '22.50'),
(193, 230, 62, '67.50', '22.50'),
(194, 231, 37, '330.75', '45.00'),
(195, 231, 62, '330.75', '45.00'),
(196, 232, 37, '219.38', '33.75'),
(197, 232, 62, '219.38', '33.75'),
(198, 233, 37, '65.25', '4.50'),
(199, 233, 62, '65.25', '4.50'),
(200, 234, 37, '20.80', '1.60'),
(201, 234, 62, '20.80', '1.60'),
(202, 235, 37, '588.00', '80.00'),
(203, 235, 62, '588.00', '80.00'),
(204, 236, 37, '390.00', '60.00'),
(205, 236, 62, '390.00', '60.00'),
(206, 237, 37, '120.00', '40.00'),
(207, 237, 62, '120.00', '40.00'),
(208, 238, 37, '116.00', '8.00'),
(209, 238, 62, '116.00', '8.00'),
(210, 239, 37, '17.68', '1.36'),
(211, 239, 62, '17.68', '1.36'),
(212, 240, 37, '499.80', '68.00'),
(213, 240, 62, '499.80', '68.00'),
(214, 241, 37, '331.50', '51.00'),
(215, 241, 62, '331.50', '51.00'),
(216, 242, 37, '102.00', '34.00'),
(217, 242, 62, '102.00', '34.00'),
(218, 243, 37, '98.60', '6.80'),
(219, 243, 62, '98.60', '6.80'),
(221, 245, 37, '20.80', '1.60'),
(222, 245, 62, '20.80', '1.60'),
(223, 246, 37, '588.00', '80.00'),
(224, 246, 62, '588.00', '80.00'),
(225, 247, 37, '390.00', '60.00'),
(226, 247, 62, '390.00', '60.00'),
(227, 248, 37, '120.00', '40.00'),
(228, 248, 62, '120.00', '40.00'),
(229, 249, 37, '116.00', '8.00'),
(230, 249, 62, '116.00', '8.00'),
(231, 250, 37, '17.68', '1.36'),
(232, 250, 62, '17.68', '1.36'),
(233, 251, 37, '499.80', '68.00'),
(234, 251, 62, '499.80', '68.00'),
(235, 252, 37, '331.50', '51.00'),
(236, 252, 62, '331.50', '51.00'),
(237, 253, 37, '102.00', '34.00'),
(238, 253, 62, '102.00', '34.00'),
(239, 254, 37, '98.60', '6.80'),
(240, 254, 62, '98.60', '6.80'),
(241, 255, 37, '5.98', '0.46'),
(242, 256, 37, '338.10', '46.00'),
(243, 257, 37, '179.40', '27.60'),
(244, 258, 37, '66.70', '4.60'),
(245, 259, 37, '8.58', '0.66'),
(246, 260, 37, '485.10', '66.00'),
(247, 261, 37, '257.40', '39.60'),
(248, 262, 37, '95.70', '6.60'),
(249, 263, 37, '12.22', '0.94'),
(250, 264, 37, '690.90', '94.00'),
(251, 265, 37, '366.60', '56.40'),
(252, 266, 37, '136.30', '9.40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `labores`
--

CREATE TABLE `labores` (
  `idlabor` int(11) NOT NULL,
  `labor` varchar(45) NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `labores`
--

INSERT INTO `labores` (`idlabor`, `labor`, `precio`, `idusuario`) VALUES
(21, 'Cosecha Soja', '65.00', 1),
(22, 'cincel', '43.00', 1),
(23, 'Siembra', '40.00', 2),
(24, 'Pulverizacion', '5.00', 1),
(25, 'Siembra', '43.00', 1),
(26, 'Fertilizacion', '10.00', 1),
(27, 'Alquiler', '304.00', 1),
(28, 'Estructura', '20.00', 1),
(29, 'Conduccion Tecnica', '15.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes`
--

CREATE TABLE `lotes` (
  `idlote` int(11) NOT NULL,
  `lote` varchar(45) NOT NULL,
  `idcampo` int(11) NOT NULL,
  `superficie` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `lotes`
--

INSERT INTO `lotes` (`idlote`, `lote`, `idcampo`, `superficie`) VALUES
(75, 'L1', 53, '22.00'),
(76, 'L3', 54, '145.00'),
(77, 'L3', 53, '65.00'),
(78, 'L4', 53, '122.00'),
(80, 'L14', 53, '65.00'),
(81, 'L15', 53, '65.00'),
(82, 'L18', 53, '98.00'),
(83, 'L1', 57, '98.00'),
(84, 'L25', 53, '65.00'),
(85, 'L30', 53, '98.00'),
(86, 'L1', 56, '80.00'),
(87, 'L3', 56, '55.00'),
(88, 'L1', 58, '122.00'),
(89, 'L2', 53, '24.00'),
(90, 'L5', 53, '78.00'),
(91, 'L10', 53, '59.00'),
(92, 'L11-13', 53, '42.00'),
(94, 'L19', 53, '44.00'),
(95, 'L2', 57, '23.00'),
(96, 'L3', 57, '33.00'),
(97, 'L4', 57, '47.00'),
(98, 'L2', 56, '68.00'),
(99, 'L20', 53, '150.00'),
(100, 'L1', 61, '38.00'),
(101, 'L2', 61, '62.00'),
(102, 'L3', 61, '45.00'),
(103, 'L1', 62, '82.00'),
(104, 'L2', 62, '56.00'),
(105, 'L1', 63, '61.00'),
(106, 'L2', 63, '33.00'),
(107, 'L1', 64, '45.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotescampanas`
--

CREATE TABLE `lotescampanas` (
  `idloteCampana` int(11) NOT NULL,
  `idlote` int(11) NOT NULL,
  `idcampana` int(11) NOT NULL,
  `idcultivo` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `capitalizacion` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `lotescampanas`
--

INSERT INTO `lotescampanas` (`idloteCampana`, `idlote`, `idcampana`, `idcultivo`, `idusuario`, `capitalizacion`) VALUES
(63, 86, 1, 6, 1, 1),
(64, 87, 1, 2, 1, 1),
(65, 75, 1, 2, 1, 1),
(66, 76, 1, 2, 2, 0),
(67, 98, 1, 1, 1, 0),
(68, 99, 1, 2, 1, 0),
(69, 95, 1, 1, 1, 0),
(70, 96, 1, 1, 1, 0),
(71, 97, 1, 1, 1, 0),
(72, 100, 1, 1, 1, 0),
(73, 101, 1, 1, 1, 0),
(74, 102, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monedas`
--

CREATE TABLE `monedas` (
  `idmoneda` int(11) NOT NULL,
  `moneda` varchar(20) NOT NULL,
  `cambio` decimal(10,2) NOT NULL,
  `idempresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `monedas`
--

INSERT INTO `monedas` (`idmoneda`, `moneda`, `cambio`, `idempresa`) VALUES
(1, 'Peso Argentino', '1.00', 37),
(2, 'Dolar EEUU', '103.00', 37),
(7, 'euro', '0.00', 37),
(8, 'ether', '0.00', 37);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `idmovimiento` bigint(20) NOT NULL,
  `idcuenta` int(11) NOT NULL,
  `idbeneficiario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `numero` int(11) NOT NULL,
  `debito` decimal(10,2) NOT NULL,
  `credito` decimal(10,2) NOT NULL,
  `estado` enum('sin confirmar','confirmado','conciliado') NOT NULL,
  `detalle` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`idmovimiento`, `idcuenta`, `idbeneficiario`, `fecha`, `numero`, `debito`, `credito`, `estado`, `detalle`) VALUES
(1, 1, 1, '2021-09-01', 0, '1000.00', '0.00', 'sin confirmar', 'pago'),
(2, 1, 2, '2021-09-09', 0, '23500.00', '0.00', 'sin confirmar', ''),
(3, 3, 2, '2021-09-01', 0, '13200.00', '0.00', 'sin confirmar', ''),
(4, 1, 1, '2021-08-10', 0, '6520.00', '0.00', 'confirmado', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordentrabajos`
--

CREATE TABLE `ordentrabajos` (
  `idordentrabajo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `idlabor` int(11) NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  `superficie` decimal(10,2) NOT NULL,
  `realizado` tinyint(1) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idcampana` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ordentrabajos`
--

INSERT INTO `ordentrabajos` (`idordentrabajo`, `fecha`, `idlabor`, `precio`, `observaciones`, `superficie`, `realizado`, `idusuario`, `idcampana`) VALUES
(116, '2021-09-15', 24, '5.00', '', '133.00', 1, 1, 1),
(118, '2021-09-17', 24, '5.00', 'aplicar con Temp > 17ºC y HR > 40%', '103.00', 1, 1, 1),
(119, '2021-09-04', 24, '5.00', 'Aplicar con Temp > 15ºC y HR > 40%. ', '203.00', 1, 1, 1),
(120, '2021-09-17', 24, '5.00', 'Aplicar con temp >17ºC - HR > 40%- CUIDADO CON DERIVA HACIA LOS VECINOS', '148.00', 1, 1, 1),
(121, '2021-09-18', 24, '6.00', '', '148.00', 1, 1, 1),
(122, '2021-09-18', 24, '5.00', 'Aplicar con temp >17ºC y HR > 40%', '145.00', 1, 1, 1),
(123, '2021-09-19', 24, '5.00', '', '22.00', 1, 1, 1),
(124, '2021-09-21', 24, '5.00', 'Temp > 17ºC HR > 40%', '138.00', 0, 1, 1),
(125, '2021-09-25', 24, '5.00', '', '61.00', 0, 1, 1),
(126, '2021-09-25', 24, '5.00', '', '61.00', 0, 1, 1),
(127, '2021-09-25', 24, '5.00', '', '33.00', 0, 1, 1),
(128, '2021-09-25', 24, '5.00', '', '45.00', 0, 1, 1),
(129, '2021-09-25', 24, '5.00', '', '22.00', 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_insumos`
--

CREATE TABLE `orden_insumos` (
  `idordeninsumo` int(11) NOT NULL,
  `idordentrabajo` int(11) NOT NULL,
  `idinsumo` int(11) NOT NULL,
  `cantidadHa` decimal(10,2) NOT NULL,
  `cantidadTotal` decimal(10,2) NOT NULL,
  `precioUn` decimal(10,2) DEFAULT NULL,
  `precioTotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `orden_insumos`
--

INSERT INTO `orden_insumos` (`idordeninsumo`, `idordentrabajo`, `idinsumo`, `cantidadHa`, `cantidadTotal`, `precioUn`, `precioTotal`) VALUES
(69, 116, 73, '0.20', '26.60', '4.00', '106.40'),
(73, 118, 72, '0.02', '2.06', '13.00', '26.78'),
(74, 118, 75, '2.00', '206.00', '7.35', '1514.10'),
(75, 118, 76, '1.20', '123.60', '6.50', '803.40'),
(76, 118, 77, '0.20', '20.60', '14.50', '298.70'),
(77, 119, 72, '0.02', '4.06', '13.00', '52.78'),
(78, 119, 75, '2.00', '406.00', '7.35', '2984.10'),
(79, 119, 76, '1.50', '304.50', '6.50', '1979.25'),
(80, 119, 77, '0.20', '40.60', '14.50', '588.70'),
(81, 120, 72, '0.04', '5.18', '13.00', '67.34'),
(82, 120, 75, '2.00', '296.00', '7.35', '2175.60'),
(83, 120, 76, '1.50', '222.00', '6.50', '1443.00'),
(84, 120, 88, '1.00', '148.00', '3.00', '444.00'),
(85, 120, 77, '0.20', '29.60', '14.50', '429.20'),
(86, 121, 75, '1.00', '148.00', '7.35', '1087.80'),
(88, 122, 72, '0.05', '7.25', '13.00', '94.25'),
(89, 122, 88, '1.00', '145.00', '3.00', '435.00'),
(90, 122, 75, '2.00', '290.00', '7.35', '2131.50'),
(91, 122, 76, '1.50', '217.50', '6.50', '1413.75'),
(92, 122, 77, '0.20', '29.00', '14.50', '420.50'),
(94, 124, 72, '0.05', '6.90', '13.00', '89.70'),
(95, 124, 75, '2.00', '276.00', '7.35', '2028.60'),
(96, 124, 76, '1.50', '207.00', '6.50', '1345.50'),
(97, 124, 88, '1.00', '138.00', '3.00', '414.00'),
(98, 124, 77, '0.02', '2.76', '14.50', '40.02'),
(99, 125, 72, '0.05', '3.05', '13.00', '39.65'),
(100, 125, 75, '1.70', '103.70', '7.35', '762.20'),
(102, 126, 72, '0.05', '3.05', '13.00', '39.65'),
(103, 126, 75, '1.70', '103.70', '7.35', '762.20'),
(104, 126, 110, '0.20', '12.20', '42.00', '512.40'),
(105, 126, 76, '0.60', '36.60', '6.50', '237.90'),
(106, 126, 77, '0.20', '12.20', '14.50', '176.90'),
(107, 127, 72, '0.05', '1.65', '13.00', '21.45'),
(108, 127, 75, '1.70', '56.10', '7.35', '412.34'),
(109, 127, 110, '0.20', '6.60', '42.00', '277.20'),
(110, 127, 76, '0.80', '26.40', '6.50', '171.60'),
(111, 127, 77, '0.20', '6.60', '14.50', '95.70'),
(112, 128, 72, '0.50', '22.50', '13.00', '292.50'),
(113, 129, 111, '3.00', '66.00', '160.00', '10560.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_lotes`
--

CREATE TABLE `orden_lotes` (
  `idordenlote` int(11) NOT NULL,
  `idordentrabajo` int(11) NOT NULL,
  `idlote` int(11) NOT NULL,
  `superficie` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `orden_lotes`
--

INSERT INTO `orden_lotes` (`idordenlote`, `idordentrabajo`, `idlote`, `superficie`) VALUES
(130, 116, 86, '78.00'),
(131, 116, 87, '55.00'),
(135, 118, 95, '23.00'),
(136, 118, 96, '33.00'),
(137, 118, 97, '47.00'),
(138, 119, 90, '78.00'),
(139, 119, 89, '24.00'),
(140, 119, 91, '59.00'),
(141, 119, 92, '42.00'),
(142, 120, 86, '80.00'),
(143, 120, 98, '68.00'),
(144, 121, 86, '80.00'),
(145, 121, 98, '68.00'),
(146, 122, 100, '38.00'),
(147, 122, 101, '62.00'),
(148, 122, 102, '45.00'),
(149, 123, 75, '22.00'),
(150, 124, 103, '82.00'),
(151, 124, 104, '56.00'),
(152, 125, 105, '61.00'),
(153, 126, 105, '61.00'),
(154, 127, 106, '33.00'),
(155, 128, 107, '45.00'),
(156, 129, 75, '22.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_personales`
--

CREATE TABLE `orden_personales` (
  `idordenpersonal` int(11) NOT NULL,
  `idordentrabajo` int(11) NOT NULL,
  `idpersonal` int(11) NOT NULL,
  `superficie` decimal(7,2) NOT NULL,
  `precioHa` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `orden_personales`
--

INSERT INTO `orden_personales` (`idordenpersonal`, `idordentrabajo`, `idpersonal`, `superficie`, `precioHa`) VALUES
(12, 116, 20, '133.00', '77.00'),
(14, 118, 6, '103.00', '49.00'),
(15, 119, 6, '203.00', '49.00'),
(16, 119, 21, '203.00', '10.00'),
(17, 120, 21, '148.00', '10.00'),
(18, 120, 6, '148.00', '49.00'),
(19, 121, 4, '148.00', '55.00'),
(20, 122, 21, '145.00', '10.00'),
(21, 122, 6, '145.00', '49.00'),
(22, 124, 21, '138.00', '10.00'),
(23, 124, 6, '138.00', '49.00'),
(24, 125, 21, '61.00', '10.00'),
(25, 125, 6, '61.00', '49.00'),
(26, 126, 21, '61.00', '10.00'),
(27, 126, 6, '61.00', '49.00'),
(28, 127, 21, '33.00', '10.00'),
(29, 127, 6, '33.00', '49.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_productores`
--

CREATE TABLE `orden_productores` (
  `idordenproductores` int(11) NOT NULL,
  `idordentrabajo` int(11) NOT NULL,
  `idproductor` int(11) NOT NULL,
  `superficie` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `orden_productores`
--

INSERT INTO `orden_productores` (`idordenproductores`, `idordentrabajo`, `idproductor`, `superficie`) VALUES
(115, 116, 37, '66.50'),
(116, 116, 41, '66.50'),
(118, 118, 37, '103.00'),
(119, 119, 37, '203.00'),
(120, 120, 37, '74.00'),
(121, 120, 62, '74.00'),
(122, 121, 37, '74.00'),
(123, 121, 41, '74.00'),
(124, 122, 37, '72.50'),
(125, 122, 62, '72.50'),
(126, 123, 37, '22.00'),
(127, 124, 37, '69.00'),
(128, 124, 41, '69.00'),
(129, 125, 37, '61.00'),
(130, 126, 37, '61.00'),
(131, 127, 37, '33.00'),
(132, 128, 37, '45.00'),
(133, 129, 37, '22.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_terceros`
--

CREATE TABLE `orden_terceros` (
  `idordenterceros` int(11) NOT NULL,
  `idordentrabajo` int(11) NOT NULL,
  `idtercero` int(11) NOT NULL,
  `precioHa` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personales`
--

CREATE TABLE `personales` (
  `idpersonal` int(11) NOT NULL,
  `personal` varchar(30) NOT NULL,
  `cuil` varchar(15) DEFAULT NULL,
  `precioHa` decimal(10,2) NOT NULL DEFAULT 0.00,
  `idempresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `personales`
--

INSERT INTO `personales` (`idpersonal`, `personal`, `cuil`, `precioHa`, `idempresa`) VALUES
(4, 'Liti', '20268133985', '55.00', 37),
(6, 'tole', '123456', '60.00', 37),
(20, 'Lelo', '', '77.00', 37),
(21, 'Arce', '', '3.00', 37);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remitos`
--

CREATE TABLE `remitos` (
  `idremito` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `idempresa` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `remitos`
--

INSERT INTO `remitos` (`idremito`, `numero`, `fecha`, `idempresa`, `idproveedor`) VALUES
(16, 0, '2021-09-15', 37, 50),
(17, 0, '2021-09-18', 37, 50),
(18, 0, '2021-09-20', 37, 50),
(19, 0, '2021-09-20', 37, 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remitos_descripcion`
--

CREATE TABLE `remitos_descripcion` (
  `idremito_descripcion` int(11) NOT NULL,
  `idremito` int(11) NOT NULL,
  `idinsumo` int(11) NOT NULL,
  `cantidad` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `remitos_descripcion`
--

INSERT INTO `remitos_descripcion` (`idremito_descripcion`, `idremito`, `idinsumo`, `cantidad`) VALUES
(26, 16, 70, 500.00),
(27, 16, 73, 100.00),
(28, 17, 65, 300.00),
(29, 18, 108, 3.00),
(30, 19, 106, 1.00),
(31, 19, 73, 1.00),
(32, 19, 109, 1.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocuentas`
--

CREATE TABLE `tipocuentas` (
  `idtipocuenta` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `idempresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipocuentas`
--

INSERT INTO `tipocuentas` (`idtipocuenta`, `tipo`, `idempresa`) VALUES
(1, 'Bancarias', 37),
(2, 'Efectivos', 37),
(3, 'Proveedores', 37),
(4, 'Bancarias', 48),
(6, 'empresas', 37),
(8, 'Carteras', 37),
(9, 'Inversiones', 37);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transferencias`
--

CREATE TABLE `transferencias` (
  `idtransferencia` bigint(20) NOT NULL,
  `idcuenta` int(11) NOT NULL,
  `idcuentadestino` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `numero` int(11) NOT NULL,
  `importe` float(10,2) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `estadodestino` tinyint(1) NOT NULL,
  `detalle` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transferencias`
--

INSERT INTO `transferencias` (`idtransferencia`, `idcuenta`, `idcuentadestino`, `fecha`, `numero`, `importe`, `estado`, `estadodestino`, `detalle`) VALUES
(1, 1, 7, '2021-09-01', 0, 125000.00, 0, 0, 'pago a tosquita'),
(2, 7, 1, '2021-09-17', 0, 450000.00, 0, 0, 'transf recibida de tosquita');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `idunidad` int(11) NOT NULL,
  `unidad` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`idunidad`, `unidad`) VALUES
(1, 'kgs'),
(2, 'grs'),
(3, 'lts'),
(4, 'cc'),
(5, 'Tn');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `rol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `pass` varchar(8) NOT NULL,
  `idUltimaEmpresa` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `usuario`, `rol`, `nombre`, `pass`, `idUltimaEmpresa`) VALUES
(1, 'jlgiantomassi', 0, 'Jose Luis Giantomassi', '12345678', 37),
(2, 'leysa', 0, '', '', 63);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades_empresas`
--
ALTER TABLE `actividades_empresas`
  ADD PRIMARY KEY (`idactividad_empresa`),
  ADD KEY `idactiviad` (`idactividad`),
  ADD KEY `idempresa` (`idempresa`);

--
-- Indices de la tabla `actividades_insumos`
--
ALTER TABLE `actividades_insumos`
  ADD PRIMARY KEY (`idactividad_insumo`),
  ADD KEY `idactividad` (`idactividad`),
  ADD KEY `idinsumo` (`idinsumo`);

--
-- Indices de la tabla `actividades_lotes`
--
ALTER TABLE `actividades_lotes`
  ADD PRIMARY KEY (`idactividad`),
  ADD KEY `idlotescampanas` (`idloteCampana`),
  ADD KEY `idlabr` (`idlabor`);

--
-- Indices de la tabla `actividades_personales`
--
ALTER TABLE `actividades_personales`
  ADD PRIMARY KEY (`idactividad_personal`),
  ADD KEY `idactividad` (`idactividad`),
  ADD KEY `idpersonal` (`idpersonal`);

--
-- Indices de la tabla `actividades_terceros`
--
ALTER TABLE `actividades_terceros`
  ADD PRIMARY KEY (`idactividad_tercero`),
  ADD KEY `idactividad` (`idactividad`),
  ADD KEY `idempresa` (`idempresa`) USING BTREE;

--
-- Indices de la tabla `beneficiarios`
--
ALTER TABLE `beneficiarios`
  ADD PRIMARY KEY (`idbeneficiario`);

--
-- Indices de la tabla `campanas`
--
ALTER TABLE `campanas`
  ADD PRIMARY KEY (`idcampana`),
  ADD UNIQUE KEY `campana` (`campana`),
  ADD UNIQUE KEY `campana_2` (`campana`);

--
-- Indices de la tabla `campos`
--
ALTER TABLE `campos`
  ADD PRIMARY KEY (`idcampo`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`idcuenta`),
  ADD KEY `idempresa` (`idempresaActiva`),
  ADD KEY `idmoneda` (`idmoneda`),
  ADD KEY `idtipo` (`idtipo`);

--
-- Indices de la tabla `cultivos`
--
ALTER TABLE `cultivos`
  ADD PRIMARY KEY (`idcultivo`),
  ADD UNIQUE KEY `cultivo` (`cultivo`);

--
-- Indices de la tabla `depositos`
--
ALTER TABLE `depositos`
  ADD PRIMARY KEY (`iddeposito`),
  ADD KEY `idempresa` (`idempresa`),
  ADD KEY `idproveedor` (`idproveedor`);

--
-- Indices de la tabla `depositos_insumos`
--
ALTER TABLE `depositos_insumos`
  ADD PRIMARY KEY (`iddeposito_insumo`),
  ADD KEY `iddeposito` (`iddeposito`),
  ADD KEY `idinsumo` (`idinsumo`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`idempresa`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`idfactura`),
  ADD KEY `idempresa` (`idempresa`),
  ADD KEY `idproveedor` (`idproveedor`);

--
-- Indices de la tabla `facturas_descripcion`
--
ALTER TABLE `facturas_descripcion`
  ADD PRIMARY KEY (`idfactura_descripcion`),
  ADD KEY `idfactura` (`idfactura`),
  ADD KEY `idinsumo` (`idinsumo`);

--
-- Indices de la tabla `facturas_detalles`
--
ALTER TABLE `facturas_detalles`
  ADD PRIMARY KEY (`idfactura_detalle`),
  ADD KEY `idfactura` (`idfactura`);

--
-- Indices de la tabla `insumos`
--
ALTER TABLE `insumos`
  ADD PRIMARY KEY (`idinsumo`),
  ADD KEY `fk_insumo_unidad_idx` (`idunidad`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `insumos_empresas`
--
ALTER TABLE `insumos_empresas`
  ADD PRIMARY KEY (`idinsumo_empresa`),
  ADD KEY `idempresa` (`idempresa`),
  ADD KEY `idactividad_insumo` (`idactividad_insumo`);

--
-- Indices de la tabla `labores`
--
ALTER TABLE `labores`
  ADD PRIMARY KEY (`idlabor`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD PRIMARY KEY (`idlote`),
  ADD KEY `fk_campos_idx` (`idcampo`);

--
-- Indices de la tabla `lotescampanas`
--
ALTER TABLE `lotescampanas`
  ADD PRIMARY KEY (`idloteCampana`),
  ADD KEY `idlote` (`idlote`),
  ADD KEY `idcampana` (`idcampana`),
  ADD KEY `idcultivo` (`idcultivo`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `monedas`
--
ALTER TABLE `monedas`
  ADD PRIMARY KEY (`idmoneda`),
  ADD KEY `idempresa` (`idempresa`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`idmovimiento`),
  ADD KEY `idcuenta` (`idcuenta`),
  ADD KEY `idbeneficiario` (`idbeneficiario`);

--
-- Indices de la tabla `ordentrabajos`
--
ALTER TABLE `ordentrabajos`
  ADD PRIMARY KEY (`idordentrabajo`),
  ADD KEY `fk_labores_idx` (`idlabor`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idcampana` (`idcampana`);

--
-- Indices de la tabla `orden_insumos`
--
ALTER TABLE `orden_insumos`
  ADD PRIMARY KEY (`idordeninsumo`),
  ADD KEY `fk_orden_insumos_idx` (`idinsumo`),
  ADD KEY `fk_ordentrabajo2_idx` (`idordentrabajo`);

--
-- Indices de la tabla `orden_lotes`
--
ALTER TABLE `orden_lotes`
  ADD PRIMARY KEY (`idordenlote`),
  ADD KEY `fk_orden_lotes_idx` (`idlote`),
  ADD KEY `fk_ordentrabajo_idx` (`idordentrabajo`);

--
-- Indices de la tabla `orden_personales`
--
ALTER TABLE `orden_personales`
  ADD PRIMARY KEY (`idordenpersonal`),
  ADD KEY `idordentrabajo` (`idordentrabajo`),
  ADD KEY `idpersonal` (`idpersonal`);

--
-- Indices de la tabla `orden_productores`
--
ALTER TABLE `orden_productores`
  ADD PRIMARY KEY (`idordenproductores`),
  ADD KEY `fk_ordentrabajo3_idx` (`idordentrabajo`),
  ADD KEY `fk_orden_productores_idx` (`idproductor`);

--
-- Indices de la tabla `orden_terceros`
--
ALTER TABLE `orden_terceros`
  ADD PRIMARY KEY (`idordenterceros`),
  ADD KEY `idordentrabajo` (`idordentrabajo`),
  ADD KEY `idtercero` (`idtercero`);

--
-- Indices de la tabla `personales`
--
ALTER TABLE `personales`
  ADD PRIMARY KEY (`idpersonal`),
  ADD KEY `idusuario` (`idempresa`);

--
-- Indices de la tabla `remitos`
--
ALTER TABLE `remitos`
  ADD PRIMARY KEY (`idremito`),
  ADD KEY `idempresa` (`idempresa`),
  ADD KEY `idproveedor` (`idproveedor`);

--
-- Indices de la tabla `remitos_descripcion`
--
ALTER TABLE `remitos_descripcion`
  ADD PRIMARY KEY (`idremito_descripcion`),
  ADD KEY `idremito` (`idremito`),
  ADD KEY `idinsumo` (`idinsumo`);

--
-- Indices de la tabla `tipocuentas`
--
ALTER TABLE `tipocuentas`
  ADD PRIMARY KEY (`idtipocuenta`),
  ADD KEY `idempresa` (`idempresa`);

--
-- Indices de la tabla `transferencias`
--
ALTER TABLE `transferencias`
  ADD PRIMARY KEY (`idtransferencia`),
  ADD KEY `idcuenta` (`idcuenta`),
  ADD KEY `idcuentadestino` (`idcuentadestino`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`idunidad`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `idempresa` (`idUltimaEmpresa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades_empresas`
--
ALTER TABLE `actividades_empresas`
  MODIFY `idactividad_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT de la tabla `actividades_insumos`
--
ALTER TABLE `actividades_insumos`
  MODIFY `idactividad_insumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT de la tabla `actividades_lotes`
--
ALTER TABLE `actividades_lotes`
  MODIFY `idactividad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT de la tabla `actividades_personales`
--
ALTER TABLE `actividades_personales`
  MODIFY `idactividad_personal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de la tabla `actividades_terceros`
--
ALTER TABLE `actividades_terceros`
  MODIFY `idactividad_tercero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `beneficiarios`
--
ALTER TABLE `beneficiarios`
  MODIFY `idbeneficiario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `campanas`
--
ALTER TABLE `campanas`
  MODIFY `idcampana` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `campos`
--
ALTER TABLE `campos`
  MODIFY `idcampo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `idcuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `cultivos`
--
ALTER TABLE `cultivos`
  MODIFY `idcultivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `depositos`
--
ALTER TABLE `depositos`
  MODIFY `iddeposito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `depositos_insumos`
--
ALTER TABLE `depositos_insumos`
  MODIFY `iddeposito_insumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `idempresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `idfactura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `facturas_descripcion`
--
ALTER TABLE `facturas_descripcion`
  MODIFY `idfactura_descripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de la tabla `facturas_detalles`
--
ALTER TABLE `facturas_detalles`
  MODIFY `idfactura_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `insumos`
--
ALTER TABLE `insumos`
  MODIFY `idinsumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT de la tabla `insumos_empresas`
--
ALTER TABLE `insumos_empresas`
  MODIFY `idinsumo_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT de la tabla `labores`
--
ALTER TABLE `labores`
  MODIFY `idlabor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `lotes`
--
ALTER TABLE `lotes`
  MODIFY `idlote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `lotescampanas`
--
ALTER TABLE `lotescampanas`
  MODIFY `idloteCampana` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `monedas`
--
ALTER TABLE `monedas`
  MODIFY `idmoneda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `idmovimiento` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ordentrabajos`
--
ALTER TABLE `ordentrabajos`
  MODIFY `idordentrabajo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT de la tabla `orden_insumos`
--
ALTER TABLE `orden_insumos`
  MODIFY `idordeninsumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT de la tabla `orden_lotes`
--
ALTER TABLE `orden_lotes`
  MODIFY `idordenlote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT de la tabla `orden_personales`
--
ALTER TABLE `orden_personales`
  MODIFY `idordenpersonal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `orden_productores`
--
ALTER TABLE `orden_productores`
  MODIFY `idordenproductores` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT de la tabla `orden_terceros`
--
ALTER TABLE `orden_terceros`
  MODIFY `idordenterceros` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `personales`
--
ALTER TABLE `personales`
  MODIFY `idpersonal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `remitos`
--
ALTER TABLE `remitos`
  MODIFY `idremito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `remitos_descripcion`
--
ALTER TABLE `remitos_descripcion`
  MODIFY `idremito_descripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `tipocuentas`
--
ALTER TABLE `tipocuentas`
  MODIFY `idtipocuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `transferencias`
--
ALTER TABLE `transferencias`
  MODIFY `idtransferencia` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `idunidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades_empresas`
--
ALTER TABLE `actividades_empresas`
  ADD CONSTRAINT `actividades_empresas_ibfk_1` FOREIGN KEY (`idactividad`) REFERENCES `actividades_lotes` (`idactividad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `actividades_empresas_ibfk_2` FOREIGN KEY (`idempresa`) REFERENCES `empresas` (`idempresa`);

--
-- Filtros para la tabla `actividades_insumos`
--
ALTER TABLE `actividades_insumos`
  ADD CONSTRAINT `actividades_insumos_ibfk_1` FOREIGN KEY (`idactividad`) REFERENCES `actividades_lotes` (`idactividad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `actividades_insumos_ibfk_2` FOREIGN KEY (`idinsumo`) REFERENCES `insumos` (`idinsumo`);

--
-- Filtros para la tabla `actividades_lotes`
--
ALTER TABLE `actividades_lotes`
  ADD CONSTRAINT `actividades_lotes_ibfk_1` FOREIGN KEY (`idloteCampana`) REFERENCES `lotescampanas` (`idloteCampana`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `actividades_lotes_ibfk_2` FOREIGN KEY (`idlabor`) REFERENCES `labores` (`idlabor`);

--
-- Filtros para la tabla `actividades_personales`
--
ALTER TABLE `actividades_personales`
  ADD CONSTRAINT `actividades_personales_ibfk_1` FOREIGN KEY (`idactividad`) REFERENCES `actividades_lotes` (`idactividad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `actividades_personales_ibfk_2` FOREIGN KEY (`idpersonal`) REFERENCES `personales` (`idpersonal`);

--
-- Filtros para la tabla `actividades_terceros`
--
ALTER TABLE `actividades_terceros`
  ADD CONSTRAINT `actividades_terceros_ibfk_1` FOREIGN KEY (`idactividad`) REFERENCES `actividades_lotes` (`idactividad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `campos`
--
ALTER TABLE `campos`
  ADD CONSTRAINT `campos_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD CONSTRAINT `cuentas_ibfk_1` FOREIGN KEY (`idempresaActiva`) REFERENCES `empresas` (`idempresa`),
  ADD CONSTRAINT `cuentas_ibfk_2` FOREIGN KEY (`idtipo`) REFERENCES `tipocuentas` (`idtipocuenta`),
  ADD CONSTRAINT `cuentas_ibfk_3` FOREIGN KEY (`idmoneda`) REFERENCES `monedas` (`idmoneda`);

--
-- Filtros para la tabla `depositos`
--
ALTER TABLE `depositos`
  ADD CONSTRAINT `depositos_ibfk_1` FOREIGN KEY (`idempresa`) REFERENCES `empresas` (`idempresa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `depositos_ibfk_2` FOREIGN KEY (`idproveedor`) REFERENCES `empresas` (`idempresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `depositos_insumos`
--
ALTER TABLE `depositos_insumos`
  ADD CONSTRAINT `depositos_insumos_ibfk_1` FOREIGN KEY (`iddeposito`) REFERENCES `depositos` (`iddeposito`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD CONSTRAINT `empresas_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`idempresa`) REFERENCES `empresas` (`idempresa`),
  ADD CONSTRAINT `facturas_ibfk_2` FOREIGN KEY (`idproveedor`) REFERENCES `empresas` (`idempresa`);

--
-- Filtros para la tabla `facturas_descripcion`
--
ALTER TABLE `facturas_descripcion`
  ADD CONSTRAINT `facturas_descripcion_ibfk_1` FOREIGN KEY (`idfactura`) REFERENCES `facturas` (`idfactura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `facturas_descripcion_ibfk_2` FOREIGN KEY (`idinsumo`) REFERENCES `insumos` (`idinsumo`);

--
-- Filtros para la tabla `facturas_detalles`
--
ALTER TABLE `facturas_detalles`
  ADD CONSTRAINT `facturas_detalles_ibfk_1` FOREIGN KEY (`idfactura`) REFERENCES `facturas` (`idfactura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `insumos`
--
ALTER TABLE `insumos`
  ADD CONSTRAINT `fk_insumo_unidad` FOREIGN KEY (`idunidad`) REFERENCES `unidades` (`idunidad`),
  ADD CONSTRAINT `insumos_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`);

--
-- Filtros para la tabla `insumos_empresas`
--
ALTER TABLE `insumos_empresas`
  ADD CONSTRAINT `insumos_empresas_ibfk_1` FOREIGN KEY (`idempresa`) REFERENCES `empresas` (`idempresa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `insumos_empresas_ibfk_2` FOREIGN KEY (`idactividad_insumo`) REFERENCES `actividades_insumos` (`idactividad_insumo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `labores`
--
ALTER TABLE `labores`
  ADD CONSTRAINT `labores_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD CONSTRAINT `fk_campos` FOREIGN KEY (`idcampo`) REFERENCES `campos` (`idcampo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `lotescampanas`
--
ALTER TABLE `lotescampanas`
  ADD CONSTRAINT `lotescampanas_ibfk_1` FOREIGN KEY (`idlote`) REFERENCES `lotes` (`idlote`),
  ADD CONSTRAINT `lotescampanas_ibfk_2` FOREIGN KEY (`idcampana`) REFERENCES `campanas` (`idcampana`),
  ADD CONSTRAINT `lotescampanas_ibfk_3` FOREIGN KEY (`idcultivo`) REFERENCES `cultivos` (`idcultivo`),
  ADD CONSTRAINT `lotescampanas_ibfk_4` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `monedas`
--
ALTER TABLE `monedas`
  ADD CONSTRAINT `monedas_ibfk_1` FOREIGN KEY (`idempresa`) REFERENCES `empresas` (`idempresa`);

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`idbeneficiario`) REFERENCES `beneficiarios` (`idbeneficiario`),
  ADD CONSTRAINT `movimientos_ibfk_2` FOREIGN KEY (`idcuenta`) REFERENCES `cuentas` (`idcuenta`);

--
-- Filtros para la tabla `ordentrabajos`
--
ALTER TABLE `ordentrabajos`
  ADD CONSTRAINT `fk_labores` FOREIGN KEY (`idlabor`) REFERENCES `labores` (`idlabor`),
  ADD CONSTRAINT `fk_orden_campana` FOREIGN KEY (`idcampana`) REFERENCES `campanas` (`idcampana`),
  ADD CONSTRAINT `ordentrabajos_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `orden_insumos`
--
ALTER TABLE `orden_insumos`
  ADD CONSTRAINT `fk_orden_insumos` FOREIGN KEY (`idinsumo`) REFERENCES `insumos` (`idinsumo`),
  ADD CONSTRAINT `fk_ordentrabajo1` FOREIGN KEY (`idordentrabajo`) REFERENCES `ordentrabajos` (`idordentrabajo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `orden_lotes`
--
ALTER TABLE `orden_lotes`
  ADD CONSTRAINT `fk_orden_lotes` FOREIGN KEY (`idlote`) REFERENCES `lotes` (`idlote`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ordentrabajo` FOREIGN KEY (`idordentrabajo`) REFERENCES `ordentrabajos` (`idordentrabajo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `orden_personales`
--
ALTER TABLE `orden_personales`
  ADD CONSTRAINT `fk_orden_personal` FOREIGN KEY (`idpersonal`) REFERENCES `personales` (`idpersonal`),
  ADD CONSTRAINT `fk_ordentrabajo4` FOREIGN KEY (`idordentrabajo`) REFERENCES `ordentrabajos` (`idordentrabajo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `orden_productores`
--
ALTER TABLE `orden_productores`
  ADD CONSTRAINT `fk_orden_productores` FOREIGN KEY (`idproductor`) REFERENCES `empresas` (`idempresa`),
  ADD CONSTRAINT `fk_ordentrabajo3` FOREIGN KEY (`idordentrabajo`) REFERENCES `ordentrabajos` (`idordentrabajo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `orden_terceros`
--
ALTER TABLE `orden_terceros`
  ADD CONSTRAINT `fk_orden_tercero` FOREIGN KEY (`idtercero`) REFERENCES `empresas` (`idempresa`),
  ADD CONSTRAINT `fk_ordentrabajo5` FOREIGN KEY (`idordentrabajo`) REFERENCES `ordentrabajos` (`idordentrabajo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `personales`
--
ALTER TABLE `personales`
  ADD CONSTRAINT `personales_ibfk_1` FOREIGN KEY (`idempresa`) REFERENCES `empresas` (`idempresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `remitos`
--
ALTER TABLE `remitos`
  ADD CONSTRAINT `remitos_ibfk_1` FOREIGN KEY (`idempresa`) REFERENCES `empresas` (`idempresa`),
  ADD CONSTRAINT `remitos_ibfk_2` FOREIGN KEY (`idproveedor`) REFERENCES `empresas` (`idempresa`);

--
-- Filtros para la tabla `remitos_descripcion`
--
ALTER TABLE `remitos_descripcion`
  ADD CONSTRAINT `remitos_descripcion_ibfk_1` FOREIGN KEY (`idremito`) REFERENCES `remitos` (`idremito`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tipocuentas`
--
ALTER TABLE `tipocuentas`
  ADD CONSTRAINT `tipocuentas_ibfk_1` FOREIGN KEY (`idempresa`) REFERENCES `empresas` (`idempresa`);

--
-- Filtros para la tabla `transferencias`
--
ALTER TABLE `transferencias`
  ADD CONSTRAINT `transferencias_ibfk_1` FOREIGN KEY (`idcuenta`) REFERENCES `cuentas` (`idcuenta`),
  ADD CONSTRAINT `transferencias_ibfk_2` FOREIGN KEY (`idcuentadestino`) REFERENCES `cuentas` (`idcuenta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
