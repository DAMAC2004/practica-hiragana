-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 22-08-2025 a las 03:30:52
-- Versión del servidor: 8.4.3
-- Versión de PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hiragana_practice`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hiraganacharater`
--

CREATE TABLE `hiraganacharater` (
  `Hcid` int NOT NULL,
  `HCCharater` varchar(3) NOT NULL,
  `HCromaji` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `hiraganacharater`
--

INSERT INTO `hiraganacharater` (`Hcid`, `HCCharater`, `HCromaji`) VALUES
(1, 'あ', 'a'),
(2, 'い', 'i'),
(3, 'う', 'u'),
(4, 'え', 'e'),
(5, 'お', 'o'),
(6, 'か', 'ka'),
(7, 'き', 'ki'),
(8, 'く', 'ku'),
(9, 'け', 'ke'),
(10, 'こ', 'ko'),
(11, 'さ', 'sa'),
(12, 'し', 'shi'),
(13, 'す', 'su'),
(14, 'せ', 'se'),
(15, 'そ', 'so'),
(16, 'た', 'ta'),
(17, 'ち', 'chi'),
(18, 'つ', 'tsu'),
(19, 'て', 'te'),
(20, 'と', 'to'),
(21, 'な', 'na'),
(22, 'に', 'ni'),
(23, 'ぬ', 'nu'),
(24, 'ね', 'ne'),
(25, 'の', 'no'),
(26, 'は', 'ha'),
(27, 'ひ', 'hi'),
(28, 'ふ', 'fu'),
(29, 'へ', 'he'),
(30, 'ほ', 'ho'),
(31, 'ま', 'ma'),
(32, 'み', 'mi'),
(33, 'む', 'mu'),
(34, 'め', 'me'),
(35, 'も', 'mo'),
(36, 'や', 'ya'),
(37, 'ゆ', 'yu'),
(38, 'よ', 'yo'),
(39, 'ら', 'ra'),
(40, 'り', 'ri'),
(41, 'る', 'ru'),
(42, 'れ', 're'),
(43, 'ろ', 'ro'),
(44, 'わ', 'wa'),
(45, 'を', 'wo'),
(46, 'ん', 'n'),
(47, 'が', 'ga'),
(48, 'ぎ', 'gi'),
(49, 'ぐ', 'gu'),
(50, 'げ', 'ge'),
(51, 'ご', 'go'),
(52, 'ざ', 'za'),
(53, 'じ', 'ji'),
(54, 'ず', 'zu'),
(55, 'ぜ', 'ze'),
(56, 'ぞ', 'zo'),
(57, 'だ', 'da'),
(58, 'ぢ', 'ji'),
(59, 'づ', 'zu'),
(60, 'で', 'de'),
(61, 'ど', 'do'),
(62, 'ば', 'ba'),
(63, 'び', 'bi'),
(64, 'ぶ', 'bu'),
(65, 'べ', 'be'),
(66, 'ぼ', 'bo'),
(67, 'ぱ', 'pa'),
(68, 'ぴ', 'pi'),
(69, 'ぷ', 'pu'),
(70, 'ぺ', 'pe'),
(71, 'ぽ', 'po');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `hiraganacharater`
--
ALTER TABLE `hiraganacharater`
  ADD PRIMARY KEY (`Hcid`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `hiraganacharater`
--
ALTER TABLE `hiraganacharater`
  MODIFY `Hcid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
