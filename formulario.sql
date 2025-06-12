-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-06-2025 a las 15:01:13
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
(91, 'holasasas', 'si', 'si', 'si', 15, '2025-04-10 08:51:15', '2025-04-10 08:51:15'),
(92, '324fsdf', 'si', 'si', 'si', 15, '2025-05-14 14:55:25', '2025-05-14 14:55:25'),
(93, 'ivo', 'si', 'si', 'si', 15, '2025-05-16 16:18:33', '2025-05-16 16:18:33'),
(94, '458945964564', 'no', 'si', 'no', 15, '2025-05-16 18:53:41', '2025-05-16 18:53:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dispositivos`
--

CREATE TABLE `dispositivos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(100) NOT NULL,
  `Nombre_tarjeta` varchar(30) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `esta_usado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dispositivos`
--

INSERT INTO `dispositivos` (`id`, `codigo`, `Nombre_tarjeta`, `usuario_id`, `created_at`, `updated_at`, `esta_usado`) VALUES
(3, '9C:B6:D0:8E:5A:E1', '', 15, '2025-06-12 09:01:03', '2025-06-12 12:05:28', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcional`
--

CREATE TABLE `funcional` (
  `id` int(11) NOT NULL,
  `Estado` varchar(25) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `funcional`
--

INSERT INTO `funcional` (`id`, `Estado`, `created_at`, `updated_at`) VALUES
(1, 'CERRADO', '2025-06-12 12:51:22', '2025-06-12 12:51:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `idhorario` int(11) NOT NULL,
  `dispositivo_id` int(11) DEFAULT NULL,
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

INSERT INTO `horarios` (`idhorario`, `dispositivo_id`, `diseno_id`, `ventana_apertura`, `ventana_cierre`, `cortina_apertura`, `cortina_cierre`, `postigon_apertura`, `postigon_cierre`, `dias_semana`, `created_at`, `updated_at`, `usuario_id`, `nombre_tarjeta`) VALUES
(25, NULL, NULL, '15:12:00', '12:12:00', '15:23:00', '12:12:00', '15:12:00', '00:12:00', 0, '2025-04-10 12:39:31', '2025-04-10 12:39:31', 32, NULL),
(30, NULL, NULL, '16:23:00', '16:23:00', '15:23:00', '14:34:00', '16:23:00', '16:23:00', 0, '2025-04-11 12:31:32', '2025-04-11 12:31:32', 32, NULL),
(35, NULL, NULL, '12:31:00', '00:31:00', '02:31:00', '14:12:00', '12:12:00', '15:12:00', 0, '2025-05-08 15:52:06', '2025-05-08 15:52:06', 33, NULL),
(36, NULL, NULL, '11:11:00', '11:11:00', '11:11:00', '11:11:00', '11:11:00', '11:11:00', 0, '2025-05-08 15:54:29', '2025-05-08 15:54:29', 6, NULL),
(41, 1, NULL, '12:12:00', '00:12:00', '14:12:00', '00:12:00', '14:12:00', '12:12:00', 0, '2025-05-16 13:07:36', '2025-06-12 12:28:28', 15, 'hola mundo'),
(49, NULL, NULL, '07:00:00', '20:00:00', '07:00:00', '20:00:00', '07:00:00', '20:00:00', 0, '2025-06-12 12:05:28', '2025-06-12 12:05:28', 15, 'Dispositivo 5A:E1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL COMMENT 'ID de la orden de PayPal',
  `email` varchar(255) DEFAULT NULL COMMENT 'Email del pagador',
  `monto` decimal(10,2) NOT NULL COMMENT 'Monto del pago',
  `moneda` varchar(10) NOT NULL DEFAULT 'USD' COMMENT 'Código de moneda (ej: USD)',
  `fecha` datetime NOT NULL COMMENT 'Fecha y hora del pago',
  `estado` varchar(50) NOT NULL COMMENT 'Estado del pago (ej: completed, pending)',
  `detalles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Detalles completos de la respuesta de PayPal en formato JSON' CHECK (json_valid(`detalles`)),
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `order_id`, `email`, `monto`, `moneda`, `fecha`, `estado`, `detalles`, `created_at`, `updated_at`) VALUES
(1, '2XD69434WB4945849', 'sb-ioug541667209@personal.example.com', 0.00, 'USD', '2025-05-16 11:33:13', 'completed', '{\"id\":\"2XD69434WB4945849\",\"status\":\"COMPLETED\",\"payment_source\":{\"paypal\":{\"email_address\":\"sb-ioug541667209@personal.example.com\",\"account_id\":\"9R7FQFEQMZKN4\",\"account_status\":\"VERIFIED\",\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"address\":{\"country_code\":\"AR\"}}},\"purchase_units\":[{\"reference_id\":\"default\",\"shipping\":{\"name\":{\"full_name\":\"John Doe\"},\"address\":{\"address_line_1\":\"Free Trade Zone\",\"admin_area_2\":\"Buenos Aires\",\"admin_area_1\":\"Buenos Aires\",\"postal_code\":\"B1675\",\"country_code\":\"AR\"}},\"payments\":{\"captures\":[{\"id\":\"0M584067W40087239\",\"status\":\"COMPLETED\",\"amount\":{\"currency_code\":\"USD\",\"value\":\"19.99\"},\"final_capture\":true,\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"seller_receivable_breakdown\":{\"gross_amount\":{\"currency_code\":\"USD\",\"value\":\"19.99\"},\"paypal_fee\":{\"currency_code\":\"USD\",\"value\":\"1.38\"},\"net_amount\":{\"currency_code\":\"USD\",\"value\":\"18.61\"}},\"links\":[{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/payments\\/captures\\/0M584067W40087239\",\"rel\":\"self\",\"method\":\"GET\"},{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/payments\\/captures\\/0M584067W40087239\\/refund\",\"rel\":\"refund\",\"method\":\"POST\"},{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/checkout\\/orders\\/2XD69434WB4945849\",\"rel\":\"up\",\"method\":\"GET\"}],\"create_time\":\"2025-05-16T11:33:12Z\",\"update_time\":\"2025-05-16T11:33:12Z\"}]}}],\"payer\":{\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"email_address\":\"sb-ioug541667209@personal.example.com\",\"payer_id\":\"9R7FQFEQMZKN4\",\"address\":{\"country_code\":\"AR\"}},\"links\":[{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/checkout\\/orders\\/2XD69434WB4945849\",\"rel\":\"self\",\"method\":\"GET\"}]}', '2025-05-16 08:33:13', '2025-05-16 08:33:13'),
(2, '4H8497015K033093C', 'sb-ioug541667209@personal.example.com', 0.00, 'USD', '2025-05-16 15:46:11', 'completed', '{\"id\":\"4H8497015K033093C\",\"status\":\"COMPLETED\",\"payment_source\":{\"paypal\":{\"email_address\":\"sb-ioug541667209@personal.example.com\",\"account_id\":\"9R7FQFEQMZKN4\",\"account_status\":\"VERIFIED\",\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"address\":{\"country_code\":\"AR\"}}},\"purchase_units\":[{\"reference_id\":\"default\",\"shipping\":{\"name\":{\"full_name\":\"John Doe\"},\"address\":{\"address_line_1\":\"Free Trade Zone\",\"admin_area_2\":\"Buenos Aires\",\"admin_area_1\":\"Buenos Aires\",\"postal_code\":\"B1675\",\"country_code\":\"AR\"}},\"payments\":{\"captures\":[{\"id\":\"441854674S116945X\",\"status\":\"COMPLETED\",\"amount\":{\"currency_code\":\"USD\",\"value\":\"19.99\"},\"final_capture\":true,\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"seller_receivable_breakdown\":{\"gross_amount\":{\"currency_code\":\"USD\",\"value\":\"19.99\"},\"paypal_fee\":{\"currency_code\":\"USD\",\"value\":\"1.38\"},\"net_amount\":{\"currency_code\":\"USD\",\"value\":\"18.61\"}},\"links\":[{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/payments\\/captures\\/441854674S116945X\",\"rel\":\"self\",\"method\":\"GET\"},{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/payments\\/captures\\/441854674S116945X\\/refund\",\"rel\":\"refund\",\"method\":\"POST\"},{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/checkout\\/orders\\/4H8497015K033093C\",\"rel\":\"up\",\"method\":\"GET\"}],\"create_time\":\"2025-05-16T15:46:10Z\",\"update_time\":\"2025-05-16T15:46:10Z\"}]}}],\"payer\":{\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"email_address\":\"sb-ioug541667209@personal.example.com\",\"payer_id\":\"9R7FQFEQMZKN4\",\"address\":{\"country_code\":\"AR\"}},\"links\":[{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/checkout\\/orders\\/4H8497015K033093C\",\"rel\":\"self\",\"method\":\"GET\"}]}', '2025-05-16 12:46:11', '2025-05-16 12:46:11'),
(3, '7DN469118G565331L', 'sb-ioug541667209@personal.example.com', 0.00, 'USD', '2025-05-16 15:48:19', 'completed', '{\"id\":\"7DN469118G565331L\",\"status\":\"COMPLETED\",\"payment_source\":{\"paypal\":{\"email_address\":\"sb-ioug541667209@personal.example.com\",\"account_id\":\"9R7FQFEQMZKN4\",\"account_status\":\"VERIFIED\",\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"address\":{\"country_code\":\"AR\"}}},\"purchase_units\":[{\"reference_id\":\"default\",\"shipping\":{\"name\":{\"full_name\":\"John Doe\"},\"address\":{\"address_line_1\":\"Free Trade Zone\",\"admin_area_2\":\"Buenos Aires\",\"admin_area_1\":\"Buenos Aires\",\"postal_code\":\"B1675\",\"country_code\":\"AR\"}},\"payments\":{\"captures\":[{\"id\":\"0FY52877W93331816\",\"status\":\"COMPLETED\",\"amount\":{\"currency_code\":\"USD\",\"value\":\"99.99\"},\"final_capture\":true,\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"seller_receivable_breakdown\":{\"gross_amount\":{\"currency_code\":\"USD\",\"value\":\"99.99\"},\"paypal_fee\":{\"currency_code\":\"USD\",\"value\":\"5.70\"},\"net_amount\":{\"currency_code\":\"USD\",\"value\":\"94.29\"}},\"links\":[{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/payments\\/captures\\/0FY52877W93331816\",\"rel\":\"self\",\"method\":\"GET\"},{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/payments\\/captures\\/0FY52877W93331816\\/refund\",\"rel\":\"refund\",\"method\":\"POST\"},{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/checkout\\/orders\\/7DN469118G565331L\",\"rel\":\"up\",\"method\":\"GET\"}],\"create_time\":\"2025-05-16T15:48:18Z\",\"update_time\":\"2025-05-16T15:48:18Z\"}]}}],\"payer\":{\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"email_address\":\"sb-ioug541667209@personal.example.com\",\"payer_id\":\"9R7FQFEQMZKN4\",\"address\":{\"country_code\":\"AR\"}},\"links\":[{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/checkout\\/orders\\/7DN469118G565331L\",\"rel\":\"self\",\"method\":\"GET\"}]}', '2025-05-16 12:48:19', '2025-05-16 12:48:19'),
(4, '9N156128SN015482X', 'sb-ioug541667209@personal.example.com', 0.00, 'USD', '2025-05-21 12:35:55', 'completed', '{\"id\":\"9N156128SN015482X\",\"status\":\"COMPLETED\",\"payment_source\":{\"paypal\":{\"email_address\":\"sb-ioug541667209@personal.example.com\",\"account_id\":\"9R7FQFEQMZKN4\",\"account_status\":\"VERIFIED\",\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"address\":{\"country_code\":\"AR\"}}},\"purchase_units\":[{\"reference_id\":\"default\",\"shipping\":{\"name\":{\"full_name\":\"John Doe\"},\"address\":{\"address_line_1\":\"Free Trade Zone\",\"admin_area_2\":\"Buenos Aires\",\"admin_area_1\":\"Buenos Aires\",\"postal_code\":\"B1675\",\"country_code\":\"AR\"}},\"payments\":{\"captures\":[{\"id\":\"4B848695J79249003\",\"status\":\"COMPLETED\",\"amount\":{\"currency_code\":\"USD\",\"value\":\"19.99\"},\"final_capture\":true,\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"seller_receivable_breakdown\":{\"gross_amount\":{\"currency_code\":\"USD\",\"value\":\"19.99\"},\"paypal_fee\":{\"currency_code\":\"USD\",\"value\":\"1.38\"},\"net_amount\":{\"currency_code\":\"USD\",\"value\":\"18.61\"}},\"links\":[{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/payments\\/captures\\/4B848695J79249003\",\"rel\":\"self\",\"method\":\"GET\"},{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/payments\\/captures\\/4B848695J79249003\\/refund\",\"rel\":\"refund\",\"method\":\"POST\"},{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/checkout\\/orders\\/9N156128SN015482X\",\"rel\":\"up\",\"method\":\"GET\"}],\"create_time\":\"2025-05-21T12:35:54Z\",\"update_time\":\"2025-05-21T12:35:54Z\"}]}}],\"payer\":{\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"email_address\":\"sb-ioug541667209@personal.example.com\",\"payer_id\":\"9R7FQFEQMZKN4\",\"address\":{\"country_code\":\"AR\"}},\"links\":[{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/checkout\\/orders\\/9N156128SN015482X\",\"rel\":\"self\",\"method\":\"GET\"}]}', '2025-05-21 09:35:55', '2025-05-21 09:35:55'),
(5, '48477728NL280741D', 'sb-ioug541667209@personal.example.com', 0.00, 'USD', '2025-05-29 11:51:45', 'completed', '{\"id\":\"48477728NL280741D\",\"status\":\"COMPLETED\",\"payment_source\":{\"paypal\":{\"email_address\":\"sb-ioug541667209@personal.example.com\",\"account_id\":\"9R7FQFEQMZKN4\",\"account_status\":\"VERIFIED\",\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"address\":{\"country_code\":\"AR\"}}},\"purchase_units\":[{\"reference_id\":\"default\",\"shipping\":{\"name\":{\"full_name\":\"John Doe\"},\"address\":{\"address_line_1\":\"Free Trade Zone\",\"admin_area_2\":\"Buenos Aires\",\"admin_area_1\":\"Buenos Aires\",\"postal_code\":\"B1675\",\"country_code\":\"AR\"}},\"payments\":{\"captures\":[{\"id\":\"0C405778D1876702N\",\"status\":\"COMPLETED\",\"amount\":{\"currency_code\":\"USD\",\"value\":\"19.99\"},\"final_capture\":true,\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"seller_receivable_breakdown\":{\"gross_amount\":{\"currency_code\":\"USD\",\"value\":\"19.99\"},\"paypal_fee\":{\"currency_code\":\"USD\",\"value\":\"1.38\"},\"net_amount\":{\"currency_code\":\"USD\",\"value\":\"18.61\"}},\"links\":[{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/payments\\/captures\\/0C405778D1876702N\",\"rel\":\"self\",\"method\":\"GET\"},{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/payments\\/captures\\/0C405778D1876702N\\/refund\",\"rel\":\"refund\",\"method\":\"POST\"},{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/checkout\\/orders\\/48477728NL280741D\",\"rel\":\"up\",\"method\":\"GET\"}],\"create_time\":\"2025-05-29T11:51:44Z\",\"update_time\":\"2025-05-29T11:51:44Z\"}]}}],\"payer\":{\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"email_address\":\"sb-ioug541667209@personal.example.com\",\"payer_id\":\"9R7FQFEQMZKN4\",\"address\":{\"country_code\":\"AR\"}},\"links\":[{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/checkout\\/orders\\/48477728NL280741D\",\"rel\":\"self\",\"method\":\"GET\"}]}', '2025-05-29 08:51:45', '2025-05-29 08:51:45'),
(6, '7BC00926YE4667946', 'sb-ioug541667209@personal.example.com', 0.00, 'USD', '2025-05-29 11:52:09', 'completed', '{\"id\":\"7BC00926YE4667946\",\"status\":\"COMPLETED\",\"payment_source\":{\"paypal\":{\"email_address\":\"sb-ioug541667209@personal.example.com\",\"account_id\":\"9R7FQFEQMZKN4\",\"account_status\":\"VERIFIED\",\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"address\":{\"country_code\":\"AR\"}}},\"purchase_units\":[{\"reference_id\":\"default\",\"shipping\":{\"name\":{\"full_name\":\"John Doe\"},\"address\":{\"address_line_1\":\"Free Trade Zone\",\"admin_area_2\":\"Buenos Aires\",\"admin_area_1\":\"Buenos Aires\",\"postal_code\":\"B1675\",\"country_code\":\"AR\"}},\"payments\":{\"captures\":[{\"id\":\"72937302JW067653U\",\"status\":\"COMPLETED\",\"amount\":{\"currency_code\":\"USD\",\"value\":\"19.99\"},\"final_capture\":true,\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"seller_receivable_breakdown\":{\"gross_amount\":{\"currency_code\":\"USD\",\"value\":\"19.99\"},\"paypal_fee\":{\"currency_code\":\"USD\",\"value\":\"1.38\"},\"net_amount\":{\"currency_code\":\"USD\",\"value\":\"18.61\"}},\"links\":[{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/payments\\/captures\\/72937302JW067653U\",\"rel\":\"self\",\"method\":\"GET\"},{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/payments\\/captures\\/72937302JW067653U\\/refund\",\"rel\":\"refund\",\"method\":\"POST\"},{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/checkout\\/orders\\/7BC00926YE4667946\",\"rel\":\"up\",\"method\":\"GET\"}],\"create_time\":\"2025-05-29T11:52:08Z\",\"update_time\":\"2025-05-29T11:52:08Z\"}]}}],\"payer\":{\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"email_address\":\"sb-ioug541667209@personal.example.com\",\"payer_id\":\"9R7FQFEQMZKN4\",\"address\":{\"country_code\":\"AR\"}},\"links\":[{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/checkout\\/orders\\/7BC00926YE4667946\",\"rel\":\"self\",\"method\":\"GET\"}]}', '2025-05-29 08:52:09', '2025-05-29 08:52:09');

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
(15, 'ivo', 'ferrer', 'ivosoloclash1@gmail.com', '$2y$10$IL2QCLhwKmissgivhZoSN.VgNcyHmb1rrvY/COQGk5jLh8sfKrSaC', '2024-09-23 20:59:44', '2025-06-10 16:07:42', '984448a07461164bdebe01783e0dd31dc7b2668fcd409d3c4e0539e2de9382295c452ce9e9de10a87e5ab1a04c08b7209368', '2025-06-10 17:07:42'),
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
(32, 'prueba', 'prueba', 'prueba@gmail.com', '$2y$10$x8A0yp.C9L9fHUkEIVmRGuDMDpwTDfn2or9zsPWneKXJlkdkk5Yu.', '2025-04-10 01:07:44', '2025-04-10 01:07:44', NULL, NULL),
(33, 'valentin', 'Quiroga', 'valentinquiroga@gmail.com', '$2y$10$GeSrm8STfPx7IHzhqhxCHulQVB/HTgrO3W.9blShGtdSYgao7vZr2', '2025-05-08 15:50:05', '2025-05-08 15:50:05', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `disenos`
--
ALTER TABLE `disenos`
  ADD PRIMARY KEY (`id_diseno`);

--
-- Indices de la tabla `dispositivos`
--
ALTER TABLE `dispositivos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `funcional`
--
ALTER TABLE `funcional`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`idhorario`),
  ADD KEY `fk_diseno` (`diseno_id`),
  ADD KEY `idx_usuario_id` (`usuario_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`);

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
  MODIFY `id_diseno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT de la tabla `dispositivos`
--
ALTER TABLE `dispositivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `funcional`
--
ALTER TABLE `funcional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `idhorario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
