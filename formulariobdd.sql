-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-04-2025 a las 18:50:58
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

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
(17, '123312', 'no', 'si', 'si', 6, '2025-03-26 15:03:11', '2025-03-26 15:03:11'),
(18, '23244', 'si', 'si', 'si', 6, '2025-03-26 15:34:53', '2025-03-26 15:34:53'),
(19, '3253453454', 'si', 'si', 'si', 6, '2025-03-26 15:35:09', '2025-03-26 15:35:09'),
(20, '123', 'si', 'si', 'si', 6, '2025-03-26 15:35:23', '2025-03-26 15:35:23'),
(21, '2323', 'si', 'si', 'si', 6, '2025-03-26 15:37:57', '2025-03-26 15:37:57'),
(22, '23232324', 'si', 'si', 'no', 6, '2025-03-26 15:39:56', '2025-03-26 15:39:56'),
(23, '23232324', 'si', 'si', 'no', 6, '2025-03-26 15:40:13', '2025-03-26 15:40:13'),
(24, '23143', 'si', 'si', 'no', 6, '2025-03-26 15:40:51', '2025-03-26 15:40:51'),
(25, '23143445', 'si', 'si', 'no', 6, '2025-03-26 15:42:59', '2025-03-26 15:42:59'),
(26, '343443', 'si', 'si', 'no', 6, '2025-03-26 16:06:22', '2025-03-26 16:06:22'),
(27, '454545', 'si', 'si', 'si', 6, '2025-03-26 16:06:35', '2025-03-26 16:06:35'),
(28, '3534534', 'si', 'si', 'no', 6, '2025-03-26 16:09:04', '2025-03-26 16:09:04'),
(29, '565656', 'si', 'si', 'si', 6, '2025-03-26 16:12:20', '2025-03-26 16:12:20'),
(30, '345345', 'no', 'si', 'si', 6, '2025-03-26 16:19:57', '2025-03-26 16:19:57'),
(31, 'gfjjgfjgf', 'si', 'no', 'si', 6, '2025-03-26 16:32:26', '2025-03-26 16:32:26'),
(32, 'gfjjgfjgf', 'si', 'no', 'si', 6, '2025-03-26 16:32:56', '2025-03-26 16:32:56'),
(33, 'gfjjgfjgfh', 'si', 'no', 'si', 6, '2025-03-26 16:33:09', '2025-03-26 16:33:09'),
(34, 'jhklhj', 'si', 'si', 'si', 6, '2025-03-26 16:33:26', '2025-03-26 16:33:26'),
(35, 'jhklhjj', 'no', 'si', 'si', 6, '2025-03-26 16:33:43', '2025-03-26 16:33:43'),
(36, 'hhghh', 'no', 'no', 'si', 6, '2025-03-26 16:34:15', '2025-03-26 16:34:15'),
(37, 'hhghh', 'no', 'si', 'si', 6, '2025-03-26 16:34:54', '2025-03-26 16:34:54'),
(38, 'hhghhh', 'no', 'si', 'si', 6, '2025-03-26 16:38:06', '2025-03-26 16:38:06'),
(39, 'jjjjj', 'no', 'si', 'si', 6, '2025-03-26 20:14:49', '2025-03-26 20:14:49'),
(40, 'ssss', 'si', 'no', 'si', 6, '2025-03-26 20:15:04', '2025-03-26 20:15:04'),
(41, '555', 'si', 'si', 'si', 6, '2025-03-26 20:16:26', '2025-03-26 20:16:26'),
(42, '555', 'si', 'si', 'si', 6, '2025-03-26 20:18:09', '2025-03-26 20:18:09'),
(43, '5665', 'si', 'si', 'si', 6, '2025-03-26 20:18:27', '2025-03-26 20:18:27'),
(44, '5665hjj', 'si', 'si', 'si', 6, '2025-03-26 20:19:00', '2025-03-26 20:19:00'),
(45, 'Valentìn', 'no', 'no', 'si', 6, '2025-03-26 20:19:25', '2025-03-26 20:19:25'),
(46, 'ivo', 'no', 'si', 'si', 31, '2025-03-26 20:40:02', '2025-03-26 20:40:02'),
(47, '999', 'no', 'si', 'si', 31, '2025-03-26 20:40:13', '2025-03-26 20:40:13'),
(48, 'valentin', 'no', 'si', 'no', 6, '2025-03-28 14:37:57', '2025-03-28 14:37:57'),
(49, '33', 'si', 'no', 'si', 6, '2025-03-28 14:38:07', '2025-03-28 14:38:07'),
(50, '56', 'si', 'si', 'si', 6, '2025-03-28 14:38:14', '2025-03-28 14:38:14'),
(51, 'frangop', 'no', 'si', 'si', 6, '2025-03-28 14:39:01', '2025-03-28 14:39:01'),
(52, 'dfgdfg', 'si', 'si', 'no', 6, '2025-03-28 14:49:25', '2025-03-28 14:49:25'),
(53, 'cdccccc', 'si', 'si', 'si', 6, '2025-03-28 14:52:40', '2025-03-28 14:52:40'),
(54, 'skibididom', 'si', 'si', 'si', 6, '2025-03-28 14:52:52', '2025-03-28 14:52:52'),
(55, '2222222', 'si', 'si', 'si', 6, '2025-03-28 14:53:00', '2025-03-28 14:53:00'),
(56, '33333', 'si', 'si', 'si', 6, '2025-04-01 18:38:49', '2025-04-01 18:38:49'),
(57, 'jajaj', 'no', 'si', 'si', 6, '2025-04-01 18:44:27', '2025-04-01 18:44:27'),
(58, 'ventana cocina', 'si', 'si', 'no', 6, '2025-04-01 18:48:21', '2025-04-01 18:48:21'),
(59, 'ssssss', 'si', 'si', 'si', 6, '2025-04-01 18:51:29', '2025-04-01 18:51:29'),
(60, 'valentin', 'si', 'si', 'si', 6, '2025-04-01 19:10:48', '2025-04-01 19:10:48'),
(61, 'r4', 'no', 'si', 'no', 6, '2025-04-01 19:22:08', '2025-04-01 19:22:08'),
(62, 'fff', 'si', 'si', 'si', 6, '2025-04-01 19:29:46', '2025-04-01 19:29:46'),
(63, 'fffddd', 'si', 'si', 'si', 6, '2025-04-01 19:41:06', '2025-04-01 19:41:06'),
(64, '333333', 'si', 'si', 'si', 6, '2025-04-07 19:21:15', '2025-04-07 19:21:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `idhorario` int(11) NOT NULL,
  `diseno_id` int(11) NOT NULL,
  `ventana_apertura` time DEFAULT NULL,
  `ventana_cierre` time DEFAULT NULL,
  `cortina_apertura` time DEFAULT NULL,
  `cortina_cierre` time DEFAULT NULL,
  `postigon_apertura` time DEFAULT NULL,
  `postigon_cierre` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(15, 'ivo', 'ferrer', 'ivosoloclash1@gmail.com', '$2y$10$IL2QCLhwKmissgivhZoSN.VgNcyHmb1rrvY/COQGk5jLh8sfKrSaC', '2024-09-23 20:59:44', '2024-11-29 19:37:48', '764d891523ed5191d8b4a31a43bc27fa4766b2c1845b146e3fd78dcb193949b10f15da6eb2da585786d737c1a6c0aefc1b1d', '2024-11-29 20:37:48'),
(16, 'bruno', 'cameille', 'brunocameille@alumnos.itr3.edu.ar', '$2y$10$Q22QRi.CCBISg2B1TwnaMOx4OvjwwzAkzNLho5I8.cN5wLyRQ00oy', '2024-09-24 20:53:34', '2024-09-24 20:54:05', '0f772d5d4f3fb465728325fac911dbd5c4a36c52515fc1380e1eccbe16e6086516350034b187ca2242f032bf2e120d9aaf7f', '2024-09-24 21:54:05'),
(17, 'user', 'user', 'user@gmail.com', '$2y$10$diTjE0nSIw9F5B0vDwlhNehlpw6QIwWGxiY/H.Yqc5U.ir..iiaR.', '2024-10-01 22:47:48', '2024-10-01 22:47:48', NULL, NULL),
(18, 'cami', 'godoy', 'cami@gmail.com', '$2y$10$MpA2jjBnCbiSgu83sg5LV..cJIyNed5UvzToh54mpfh8hQOsQ63.G', '2024-10-16 00:03:23', '2024-10-16 00:03:23', NULL, NULL),
(19, 'papu', 'papucho', 'papu@gmail.com', '$2y$10$D4ebngL4dE4cgM0OYNS9uu.ulL4G.DgLuptDmw78ykCMluKrP159i', '2024-10-16 00:44:19', '2024-10-16 00:44:19', NULL, NULL),
(25, 'santiago', 'zerbini', 'zerbian@gmail.com', '$2y$10$piu9T8RDu7lUVMHz84sVYOsjNHzMcQi/e1XAFflj8Az4uFE.MHR8K', '2024-11-12 22:03:08', '2024-11-12 22:03:08', NULL, NULL),
(26, 'Valentìn', 'Quiroga', 'valentinquiroga@alumnos.itr3.edu.ar', '$2y$10$QGjTw8veGwDhOCc4y5VCUeJRSwkriUnyyYAeooVo/dsjlZoHviKti', '2024-11-19 23:43:20', '2024-11-19 23:43:20', NULL, NULL),
(28, 'esopele123', 'esopele123', 'esopele@gmail.com', '$2y$10$ZQnF/X3VDJk44.Rta3ZGluwGNVkIGGmiD4VIxsb7T77M.EcLGBxWS', '2024-11-26 22:02:06', '2024-11-26 22:02:06', NULL, NULL),
(29, 'angel', 'ferrer', 'angelferrer806@gmail.com', '$2y$10$caC5yGu0Kv1js9n/XjrrFuyrweS36UTg9L/nb20dHKV9lKgow/IPC', '2024-12-07 00:22:01', '2024-12-07 00:22:01', NULL, NULL),
(30, 'Wlter', 'Gonzalez', 'walter@gmail.com', '$2y$10$umRwV5/JWFtLIRhJEqI14eE43jk2ytgPvZPOzlN.KtqGDBb9RPFOm', '2024-12-07 00:24:54', '2024-12-07 00:24:54', NULL, NULL),
(31, 'Valentín', 'Quiroga', 'valentinsalomone20000@gmail.com', '$2y$10$FvETpTHGg0s/Vv2zhtIQjOfpBMmW/2yPXoqdrk/g8F29ftnrTgioG', '2025-03-26 17:39:33', '2025-03-26 17:39:33', NULL, NULL);

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
  ADD KEY `fk_horarios_diseno` (`diseno_id`),
  ADD KEY `fk_usuario_id` (`usuario_id`);

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
  MODIFY `id_diseno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `idhorario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `fk_horarios_diseno` FOREIGN KEY (`diseno_id`) REFERENCES `disenos` (`id_diseno`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
