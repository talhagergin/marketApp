-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 22 Eyl 2024, 14:13:41
-- Sunucu sürümü: 10.4.28-MariaDB
-- PHP Sürümü: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `istakip`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `actions`
--

CREATE TABLE `actions` (
  `actionID` int(11) NOT NULL,
  `actionType` varchar(250) NOT NULL,
  `createdDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `amounts`
--

CREATE TABLE `amounts` (
  `amountID` int(11) NOT NULL,
  `shipmentID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `createdDate` date NOT NULL,
  `paidAmount` float NOT NULL,
  `remainingAmount` float NOT NULL,
  `paymentType` varchar(250) NOT NULL,
  `actionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `companies`
--

CREATE TABLE `companies` (
  `companyID` int(11) NOT NULL,
  `companyName` text NOT NULL,
  `companyAddress` text NOT NULL,
  `companyPhone` varchar(50) NOT NULL,
  `createdDate` date NOT NULL,
  `totalAmount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Tablo döküm verisi `companies`
--

INSERT INTO `companies` (`companyID`, `companyName`, `companyAddress`, `companyPhone`, `createdDate`, `totalAmount`) VALUES
(1, 'Ülker', 'Samsun', '123', '2024-09-18', 12.451);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `goods`
--

CREATE TABLE `goods` (
  `goodID` int(11) NOT NULL,
  `shipmentID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `totalPrice` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `productID` int(11) NOT NULL,
  `name` varchar(2500) NOT NULL,
  `barcode` varchar(2500) NOT NULL,
  `unitPrice` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `project_name` text DEFAULT NULL,
  `project_issue` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `shipment`
--

CREATE TABLE `shipment` (
  `shipmentID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `totalPrice` float NOT NULL,
  `paymentType` varchar(250) NOT NULL,
  `paidAmount` float NOT NULL,
  `remainingAmount` float NOT NULL,
  `createdDate` date NOT NULL,
  `actionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Tablo döküm verisi `shipment`
--

INSERT INTO `shipment` (`shipmentID`, `userID`, `totalPrice`, `paymentType`, `paidAmount`, `remainingAmount`, `createdDate`, `actionID`) VALUES
(1, 1, 220, 'NAKİT', 120, 100, '2024-09-17', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `lastname` text NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `name` text NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `user_role` int(11) NOT NULL,
  `totalAmount` float NOT NULL,
  `createdDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`user_id`, `username`, `lastname`, `user_email`, `name`, `user_password`, `user_role`, `totalAmount`, `createdDate`) VALUES
(1, '', '', 'admin@s.com', '', 'admin', 1, 0, '2024-09-17'),
(2, 'talha', 'gergin', 't@s.com', 'talha', 'talha123', 0, 123, '2024-09-18'),
(3, 'test müşteri', 'test müşteri', 'test müşteri@s.com', 'test müşteri', 'test', 0, 1100, '2024-09-18');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`actionID`);

--
-- Tablo için indeksler `amounts`
--
ALTER TABLE `amounts`
  ADD PRIMARY KEY (`amountID`);

--
-- Tablo için indeksler `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`companyID`);

--
-- Tablo için indeksler `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`goodID`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productID`);

--
-- Tablo için indeksler `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `shipment`
--
ALTER TABLE `shipment`
  ADD PRIMARY KEY (`shipmentID`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `actions`
--
ALTER TABLE `actions`
  MODIFY `actionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `amounts`
--
ALTER TABLE `amounts`
  MODIFY `amountID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `companies`
--
ALTER TABLE `companies`
  MODIFY `companyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `goods`
--
ALTER TABLE `goods`
  MODIFY `goodID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `shipment`
--
ALTER TABLE `shipment`
  MODIFY `shipmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
