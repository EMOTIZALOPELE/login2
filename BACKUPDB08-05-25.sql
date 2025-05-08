-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-05-2025 a las 14:47:45
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
-- Base de datos: `formulario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disenos`
--

CREATE TABLE `disenos` (
  `id_diseno` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cortina` enum('si','no') NOT NULL,
  `ventana` enum('si','no') NOT NULL,
  `postigon` enum('si','no') NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `disenos`
--

INSERT INTO `disenos` (`id_diseno`, `nombre`, `cortina`, `ventana`, `postigon`, `usuario_id`, `created_at`, `updated_at`) VALUES
(71, 'gagaggg', 'si', 'si', 'si', 6, '2025-04-07 20:42:03', '2025-04-07 20:42:03'),
(72, '3434', 'no', 'no', 'no', 6, '2025-04-07 20:46:56', '2025-04-07 20:46:56'),
(73, '4444444', 'si', 'si', 'no', 6, '2025-04-07 20:47:11', '2025-04-07 20:47:11'),
(74, 'tralaliro lalala', 'si', 'si', 'si', 6, '2025-04-07 20:53:47', '2025-04-07 20:53:47'),
(75, 'esotilin182', 'no', 'si', 'si', 6, '2025-04-07 20:54:07', '2025-04-07 20:54:07'),
(76, 'esogerson18', 'no', 'si', 'si', 15, '2025-04-07 20:54:42', '2025-04-07 20:54:42'),
(77, 'esogerson18', 'si', 'si', 'si', 15, '2025-04-07 20:55:03', '2025-04-07 20:55:03'),
(78, 'esogerson18', 'si', 'si', 'no', 15, '2025-04-07 20:55:09', '2025-04-07 20:55:09'),
(79, 'lavacacalculacalculos', 'si', 'si', 'no', 15, '2025-04-07 21:08:04', '2025-04-07 21:08:04'),
(80, 'dddddd', 'si', 'si', 'si', 6, '2025-04-07 21:10:21', '2025-04-07 21:10:21'),
(81, 'fgfgfggffgfgfgfg', 'si', 'si', 'si', 15, '2025-04-07 21:11:42', '2025-04-07 21:11:42'),
(82, '324334', 'si', 'no', 'si', 6, '2025-04-08 14:27:48', '2025-04-08 14:27:48'),
(83, '444444 esopeel', 'si', 'si', 'no', 6, '2025-04-08 14:30:12', '2025-04-08 14:30:12'),
(84, 'tralalero lalala', 'si', 'si', 'si', 6, '2025-04-08 14:54:58', '2025-04-08 14:54:58'),
(85, 'bombardilo cocodrilo', 'no', 'si', 'si', 6, '2025-04-08 14:57:13', '2025-04-08 14:57:13'),
(86, '435454353453', 'si', 'si', 'no', 6, '2025-04-08 14:59:47', '2025-04-08 14:59:47'),
(87, 'lirililarila', 'no', 'si', 'no', 6, '2025-04-08 15:00:44', '2025-04-08 15:00:44'),
(88, '5235324sdf', 'si', 'si', 'si', 15, '2025-04-10 08:33:12', '2025-04-10 08:33:12'),
(89, '32523rfsed', 'si', 'si', 'si', 15, '2025-04-10 08:34:34', '2025-04-10 08:34:34'),
(90, 'ivo', 'si', 'si', 'no', 15, '2025-04-10 08:37:22', '2025-04-10 08:37:22'),
(91, 'holasasas', 'si', 'si', 'si', 15, '2025-04-10 08:51:15', '2025-04-10 08:51:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `idhorario` int(11) NOT NULL,
  `diseno_id` int(11) DEFAULT NULL,
  `ventana_apertura` time DEFAULT NULL,
  `ventana_cierre` time DEFAULT NULL,
  `cortina_apertura` time DEFAULT NULL,
  `cortina_cierre` time DEFAULT NULL,
  `postigon_apertura` time DEFAULT NULL,
  `postigon_cierre` time DEFAULT NULL,
  `dias_semana` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `nombre_tarjeta` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`idhorario`, `diseno_id`, `ventana_apertura`, `ventana_cierre`, `cortina_apertura`, `cortina_cierre`, `postigon_apertura`, `postigon_cierre`, `dias_semana`, `created_at`, `updated_at`, `usuario_id`, `nombre_tarjeta`) VALUES
(25, NULL, '15:12:00', '12:12:00', '15:23:00', '12:12:00', '15:12:00', '00:12:00', 0, '2025-04-10 12:39:31', '2025-04-10 12:39:31', 32, NULL),
(26, NULL, '12:31:00', '15:12:00', '12:12:00', '12:31:00', '15:12:00', '15:23:00', 0, '2025-04-11 12:28:21', '2025-04-11 12:28:21', 15, NULL),
(30, NULL, '16:23:00', '16:23:00', '15:23:00', '14:34:00', '16:23:00', '16:23:00', 0, '2025-04-11 12:31:32', '2025-04-11 12:31:32', 32, NULL),
(31, NULL, '11:11:00', '11:11:00', '11:11:00', '11:11:00', '11:11:00', '11:11:00', 0, '2025-04-11 12:32:00', '2025-04-11 12:32:00', 15, NULL),
(34, NULL, '15:12:00', '12:31:00', '15:12:00', '12:31:00', '12:31:00', '12:31:00', 0, '2025-05-07 13:36:04', '2025-05-07 13:36:04', 15, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `password`, `created_at`, `updated_at`, `reset_token`, `reset_expires`) VALUES
(1, '', 'Quiroga', 'malditamadre@gmail.com', '$2y$10$pFkgPHauyJwOAM6CaCgdD.y6AmhliY9wqyT4EUYA4ZibB2nb1.VGS', '2024-09-13 18:15:50', '2024-09-13 18:15:50', NULL, NULL),
(2, '', 'cameille', 'asas@gmail.com', '$2y$10$NZMYY1ilGKx.s9qAoQQH8.u8zq/M0Ildukk9SSuNq9AjCnGj6qlPS', '2024-09-13 18:17:30', '2024-09-13 18:17:30', NULL, NULL),
(3, 'frann', 'rissone', 'esogerson18@gmail.com', '$2y$10$fK.EtkabynXbHUGqQVihAemcVGbeVq2pOZ3s8ETQwZcNvRfdW6rES', '2024-09-13 18:19:00', '2024-09-13 18:19:00', NULL, NULL),
(4, 'Ari', 'Gomez', 'arigomez727@gmail.com', '$2y$10$PsldDxLBSyLAh/UxzHII3.xaWYUxXoHBfYotBbdvjhuH7/4PkCZlu', '2024-09-13 22:13:27', '2024-10-04 17:38:02', '4aa5c502f67c6fb91031a626104f3820748c7b21bfdf532b429411d030288162196134341a8a02b4dd7193104f244b12b5d7', '2024-10-04 18:38:02'),
(5, 'ches', 'pirito', 'chepitito@gmail.com', '$2y$10$84mvKPcC/570sNLu1flnn.bQaJyurFldUeH5X7B84BWMjTqBR05.a', '2024-09-16 21:48:00', '2024-09-16 21:48:00', NULL, NULL),
(6, 'valentin', 'salomone', 'valentinsalomone2007@gmail.com', '$2y$10$mQrqXZ9aitTwK0hFP6YskuuDELGXjfWM8v4ySqiT42YXX6uTvY/D.', '2024-09-16 21:53:53', '2024-11-29 19:42:11', NULL, NULL),
(11, 'asd', 'asfdaf', 'asdasd@gmail.com', '$2y$10$JWLIIpz1F/S1CvUGS04io.vQdezpMeI.ar1abUuSpEoJPF2eZye9e', '2024-09-17 22:41:25', '2024-09-17 22:41:25', NULL, NULL),
(12, 'Valentìn', 'Quiroga', 'zerbini@gmail.com', '$2y$10$tVqTzoYyY2unwyxltbcU5Ohb3SydtQRdAdwdWS/l1qkpcKApeQkce', '2024-09-17 22:46:49', '2024-09-17 22:46:49', NULL, NULL),
(13, 'dasdasd', 'sadasdasd', 'asdasdasd@gmail.com', '$2y$10$W5eG7l9eHdw.LWpN9j2FVOVDmZWefy/KkrjYuZOmos14qt3u3Qmgu', '2024-09-17 23:49:17', '2024-09-17 23:49:17', NULL, NULL),
(14, 'camila', 'godoy', 'camiii@gmail.com', '$2y$10$YFGjwpGHGJt3WrdGmcSKYO0fBunkqBdHbG/3/KtNthoBMkjO/fzPy', '2024-09-18 00:14:36', '2024-09-18 00:14:36', NULL, NULL),
(15, 'ivo', 'ferrer', 'ivosoloclash1@gmail.com', '$2y$10$IL2QCLhwKmissgivhZoSN.VgNcyHmb1rrvY/COQGk5jLh8sfKrSaC', '2024-09-23 20:59:44', '2025-04-11 11:07:44', 'a776e6fca55e56915d657c79ef7dc8e39f1892dc903e0f1bb0c752ebb156cb47d253d96c0eebb0df3cf41013d277be1e16eb', '2025-04-11 12:07:44'),
(16, 'bruno', 'cameille', 'brunocameille@alumnos.itr3.edu.ar', '$2y$10$Q22QRi.CCBISg2B1TwnaMOx4OvjwwzAkzNLho5I8.cN5wLyRQ00oy', '2024-09-24 20:53:34', '2024-09-24 20:54:05', '0f772d5d4f3fb465728325fac911dbd5c4a36c52515fc1380e1eccbe16e6086516350034b187ca2242f032bf2e120d9aaf7f', '2024-09-24 21:54:05'),
(17, 'user', 'user', 'user@gmail.com', '$2y$10$diTjE0nSIw9F5B0vDwlhNehlpw6QIwWGxiY/H.Yqc5U.ir..iiaR.', '2024-10-01 22:47:48', '2024-10-01 22:47:48', NULL, NULL),
(18, 'cami', 'godoy', 'cami@gmail.com', '$2y$10$MpA2jjBnCbiSgu83sg5LV..cJIyNed5UvzToh54mpfh8hQOsQ63.G', '2024-10-16 00:03:23', '2024-10-16 00:03:23', NULL, NULL),
(19, 'papu', 'papucho', 'papu@gmail.com', '$2y$10$D4ebngL4dE4cgM0OYNS9uu.ulL4G.DgLuptDmw78ykCMluKrP159i', '2024-10-16 00:44:19', '2024-10-16 00:44:19', NULL, NULL),
(25, 'santiago', 'zerbini', 'zerbian@gmail.com', '$2y$10$piu9T8RDu7lUVMHz84sVYOsjNHzMcQi/e1XAFflj8Az4uFE.MHR8K', '2024-11-12 22:03:08', '2024-11-12 22:03:08', NULL, NULL),
(26, 'Valentìn', 'Quiroga', 'valentinquiroga@alumnos.itr3.edu.ar', '$2y$10$QGjTw8veGwDhOCc4y5VCUeJRSwkriUnyyYAeooVo/dsjlZoHviKti', '2024-11-19 23:43:20', '2024-11-19 23:43:20', NULL, NULL),
(28, 'esopele123', 'esopele123', 'esopele@gmail.com', '$2y$10$ZQnF/X3VDJk44.Rta3ZGluwGNVkIGGmiD4VIxsb7T77M.EcLGBxWS', '2024-11-26 22:02:06', '2024-11-26 22:02:06', NULL, NULL),
(29, 'angel', 'ferrer', 'angelferrer806@gmail.com', '$2y$10$caC5yGu0Kv1js9n/XjrrFuyrweS36UTg9L/nb20dHKV9lKgow/IPC', '2024-12-07 00:22:01', '2024-12-07 00:22:01', NULL, NULL),
(30, 'Wlter', 'Gonzalez', 'walter@gmail.com', '$2y$10$umRwV5/JWFtLIRhJEqI14eE43jk2ytgPvZPOzlN.KtqGDBb9RPFOm', '2024-12-07 00:24:54', '2024-12-07 00:24:54', NULL, NULL),
(31, 'Valentín', 'Quiroga', 'valentinsalomone20000@gmail.com', '$2y$10$FvETpTHGg0s/Vv2zhtIQjOfpBMmW/2yPXoqdrk/g8F29ftnrTgioG', '2025-03-26 17:39:33', '2025-03-26 17:39:33', NULL, NULL),
(32, 'prueba', 'prueba', 'prueba@gmail.com', '$2y$10$x8A0yp.C9L9fHUkEIVmRGuDMDpwTDfn2or9zsPWneKXJlkdkk5Yu.', '2025-04-10 01:07:44', '2025-04-10 01:07:44', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `disenos`
--
ALTER TABLE `disenos`
  ADD PRIMARY KEY (`id_diseno`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`idhorario`),
  ADD KEY `fk_diseno` (`diseno_id`),
  ADD KEY `idx_usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `disenos`
--
ALTER TABLE `disenos`
  MODIFY `id_diseno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `idhorario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `fk_diseno` FOREIGN KEY (`diseno_id`) REFERENCES `disenos` (`id_diseno`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_horarios_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
