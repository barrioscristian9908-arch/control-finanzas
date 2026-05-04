-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-05-2026 a las 12:00:39
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
-- Base de datos: `control_finanzas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tipo` enum('ingreso','egreso') NOT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `tipo`, `usuario_id`) VALUES
(1, 'Sueldo', 'ingreso', 5),
(2, 'Comida', 'egreso', 5),
(3, 'Transporte', 'egreso', 5),
(4, 'Compras', 'egreso', 5),
(7, 'pago de pagina web', 'ingreso', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE `cuentas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `saldo` decimal(10,2) DEFAULT 0.00,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`id`, `nombre`, `saldo`, `usuario_id`) VALUES
(1, 'Efectivo', 400000.00, 5),
(2, 'Mercado Pago', 43000.00, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metas`
--

CREATE TABLE `metas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `monto_objetivo` decimal(10,2) NOT NULL,
  `fecha_limite` date DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metas`
--

INSERT INTO `metas` (`id`, `nombre`, `monto_objetivo`, `fecha_limite`, `usuario_id`) VALUES
(1, 'Bicicleta', 200000.00, '2026-12-31', 1),
(2, 'bicicleta', 140000.00, NULL, 5),
(4, 'internet', 80000.00, NULL, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `meta_aportes`
--

CREATE TABLE `meta_aportes` (
  `id` int(11) NOT NULL,
  `meta_id` int(11) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `movimiento_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `meta_aportes`
--

INSERT INTO `meta_aportes` (`id`, `meta_id`, `monto`, `fecha`, `movimiento_id`) VALUES
(1, 1, 10000.00, '2026-04-03 22:24:16', NULL),
(8, 4, 15000.00, '2026-04-27 18:45:14', 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` int(11) NOT NULL,
  `tipo` enum('ingreso','egreso') NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `categoria_id` int(11) DEFAULT NULL,
  `cuenta_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `meta_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id`, `tipo`, `monto`, `descripcion`, `fecha`, `categoria_id`, `cuenta_id`, `usuario_id`, `meta_id`) VALUES
(1, 'ingreso', 50000.00, 'Sueldo mensual', '2026-04-03 22:24:16', 1, 1, 1, NULL),
(2, 'egreso', 5000.00, 'Supermercado', '2026-04-03 22:24:16', 2, 1, 1, NULL),
(3, 'egreso', 2000.00, 'Colectivo', '2026-04-03 22:24:16', 3, 2, 1, NULL),
(4, 'ingreso', 100000.00, 'sueldito jeje', '2026-04-15 17:30:53', 1, 1, 5, NULL),
(6, 'ingreso', 300000.00, 'me pagaron wiii', '2026-04-17 12:08:20', 7, 1, 5, NULL),
(9, 'egreso', 10000.00, 'Aporte a meta: internet', '2026-04-27 16:44:20', NULL, 2, 5, 4),
(11, 'egreso', 30000.00, 'Aporte a meta: internet', '2026-04-27 18:20:31', NULL, 1, 5, 4),
(14, 'egreso', 15000.00, 'Aporte a meta: internet', '2026-04-27 18:45:14', NULL, 1, 5, 4),
(17, 'egreso', 10000.00, 'carga sube', '2026-04-28 22:23:44', 3, 1, 5, NULL),
(18, 'egreso', 2000.00, 'cafesito', '2026-04-28 22:25:33', 2, 1, 5, NULL),
(19, 'egreso', 20000.00, 'Transferencia enviada', '2026-04-30 21:43:24', NULL, 1, 5, NULL),
(20, 'ingreso', 20000.00, 'Transferencia recibida', '2026-04-30 21:43:24', NULL, 2, 5, NULL),
(21, 'egreso', 3000.00, 'Transferencia enviada', '2026-04-30 22:21:43', NULL, 1, 5, NULL),
(22, 'ingreso', 3000.00, 'Transferencia recibida', '2026-04-30 22:21:43', NULL, 2, 5, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`) VALUES
(1, 'admin', '1234'),
(2, 'kevin', '$2y$10$3Vm/mFOq2pew1K1Naq1B6.SjjwB6gzEqs9U0qdVwOUg'),
(3, 'pablo', '$2y$10$z3c14BJ2Vd7nA/ceBVHjiefO7H8EPU7pnGkuGEVu0Tx'),
(5, 'cristian', '$2y$10$lsUbJsHH4KD0tNF29w7roO4ZhBf99x4X5VNbCHQoXui0xPJOvvHZC'),
(6, 'javier', '$2y$10$FRgop5KPVjNrv8A87ZOSceh4zxkbv05KSaHJB/AfeqgHFa33iUDIC'),
(7, 'cristian2', '$2y$10$bWJ.cHpSEkoVZ18o4FdNOe/rAMc2U4lMMsIr5B87PDx6OCv8Y15Hy');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `metas`
--
ALTER TABLE `metas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `meta_aportes`
--
ALTER TABLE `meta_aportes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meta_id` (`meta_id`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `cuenta_id` (`cuenta_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `metas`
--
ALTER TABLE `metas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `meta_aportes`
--
ALTER TABLE `meta_aportes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD CONSTRAINT `cuentas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `metas`
--
ALTER TABLE `metas`
  ADD CONSTRAINT `metas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `meta_aportes`
--
ALTER TABLE `meta_aportes`
  ADD CONSTRAINT `meta_aportes_ibfk_1` FOREIGN KEY (`meta_id`) REFERENCES `metas` (`id`);

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `movimientos_ibfk_2` FOREIGN KEY (`cuenta_id`) REFERENCES `cuentas` (`id`),
  ADD CONSTRAINT `movimientos_ibfk_3` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
