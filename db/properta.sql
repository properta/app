-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2022 at 04:48 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `properta`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text DEFAULT NULL,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bp_categories`
--

CREATE TABLE `bp_categories` (
  `id` int(11) NOT NULL,
  `code` varchar(15) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `building_type_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bp_items`
--

CREATE TABLE `bp_items` (
  `id` int(11) NOT NULL,
  `code` varchar(15) DEFAULT NULL,
  `bp_master_id` int(11) DEFAULT NULL,
  `occupation_category_id` int(11) DEFAULT NULL,
  `occupation_item_id` int(11) DEFAULT NULL,
  `volume` float DEFAULT NULL,
  `volume_unit_code_id` int(11) DEFAULT NULL,
  `volume_unit_code_str` varchar(100) DEFAULT NULL,
  `price_in_unit` int(11) DEFAULT NULL,
  `price_currency_id` int(11) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bp_masters`
--

CREATE TABLE `bp_masters` (
  `id` int(11) NOT NULL,
  `code` varchar(15) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `bp_category_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `building_types`
--

CREATE TABLE `building_types` (
  `id` int(11) NOT NULL,
  `code` char(15) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `building_area` double DEFAULT NULL,
  `area_unit_code_id` int(11) DEFAULT NULL,
  `area_unit_code_str` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `contractors`
--

CREATE TABLE `contractors` (
  `id` int(11) NOT NULL,
  `code` char(15) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `telp` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `tax_number` varchar(25) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `pic_str` int(255) DEFAULT NULL,
  `pic_phone_number` varchar(16) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contractors`
--

INSERT INTO `contractors` (`id`, `code`, `title`, `desc`, `address`, `telp`, `fax`, `tax_number`, `logo`, `pic_str`, `pic_phone_number`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(9, 'sdf', 'sdf', NULL, 'sdf', 'sdf', 'dsf', 'sdf', '', NULL, NULL, 1, 1646637305, 1, 1646637456, NULL, 1646637456, 1),
(10, 'asd', 'asd', NULL, 'ads', 'asd', 'ads', 'asd', '', NULL, NULL, 1, 1646637424, 1, 1646637460, NULL, 1646637460, 1),
(11, 'asd', 'asd', NULL, 'asd', 'asd', 'asd', 'asd', '', NULL, NULL, 1, 1646637432, 1, 1646637432, NULL, NULL, NULL),
(12, 'asd', 'dfgdfg', NULL, 'ads', '345354354', 'asd', '1212', '', NULL, NULL, 1, 1646637444, 1, 1646637716, 1, NULL, NULL),
(13, 'asads', 'd', NULL, 'asd', 'asd', 'ads', 'asd', 'https://drive.google.com/uc?export=view&id=1PYsoHCpK4-rNCkgzWToTo4AZZGOGEzTk', NULL, NULL, 1, 1646637859, 1, 1646637942, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `table` varchar(255) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `data_before` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data_before`)),
  `data_inserted` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data_inserted`)),
  `time` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `markers`
--

CREATE TABLE `markers` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `marker_type_id` int(11) DEFAULT NULL,
  `code` char(15) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `latitude` decimal(10,0) DEFAULT NULL,
  `longitude` decimal(10,0) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `material_prices`
--

CREATE TABLE `material_prices` (
  `id` int(11) NOT NULL,
  `code` varchar(15) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `m_currencies`
--

CREATE TABLE `m_currencies` (
  `id` int(11) NOT NULL,
  `code` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `m_currencies`
--

INSERT INTO `m_currencies` (`id`, `code`, `title`, `desc`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'ADP', 'Andorran Peseta', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'AED', 'United Arab Emirates Dirham', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'AFA', 'Afghan Afghani (1927–2002)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'AFN', 'Afghan Afghani', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'ALK', 'Albanian Lek (1946–1965)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'ALL', 'Albanian Lek', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'AMD', 'Armenian Dram', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'ANG', 'Netherlands Antillean Guilder', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'AOA', 'Angolan Kwanza', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'AOK', 'Angolan Kwanza (1977–1991)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'AON', 'Angolan New Kwanza (1990–2000)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'AOR', 'Angolan Readjusted Kwanza (1995–1999)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'ARA', 'Argentine Austral', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'ARL', 'Argentine Peso Ley (1970–1983)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'ARM', 'Argentine Peso (1881–1970)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'ARP', 'Argentine Peso (1983–1985)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'ARS', 'Argentine Peso', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'ATS', 'Austrian Schilling', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'AUD', 'Australian Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'AWG', 'Aruban Florin', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'AZM', 'Azerbaijani Manat (1993–2006)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'AZN', 'Azerbaijani Manat', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'BAD', 'Bosnia-Herzegovina Dinar (1992–1994)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'BAM', 'Bosnia-Herzegovina Convertible Mark', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'BAN', 'Bosnia-Herzegovina New Dinar (1994–1997)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'BBD', 'Barbadian Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'BDT', 'Bangladeshi Taka', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'BEC', 'Belgian Franc (convertible)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'BEF', 'Belgian Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'BEL', 'Belgian Franc (financial)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'BGL', 'Bulgarian Hard Lev', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'BGM', 'Bulgarian Socialist Lev', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 'BGN', 'Bulgarian Lev', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 'BGO', 'Bulgarian Lev (1879–1952)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 'BHD', 'Bahraini Dinar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 'BIF', 'Burundian Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 'BMD', 'Bermudan Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 'BND', 'Brunei Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 'BOB', 'Bolivian Boliviano', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 'BOL', 'Bolivian Boliviano (1863–1963)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 'BOP', 'Bolivian Peso', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 'BOV', 'Bolivian Mvdol', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 'BRB', 'Brazilian New Cruzeiro (1967–1986)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 'BRC', 'Brazilian Cruzado (1986–1989)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 'BRE', 'Brazilian Cruzeiro (1990–1993)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 'BRL', 'Бразилиаг реал', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 'BRN', 'Brazilian New Cruzado (1989–1990)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'BRR', 'Brazilian Cruzeiro (1993–1994)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'BRZ', 'Brazilian Cruzeiro (1942–1967)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 'BSD', 'Bahamian Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 'BTN', 'Bhutanese Ngultrum', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 'BUK', 'Burmese Kyat', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 'BWP', 'Botswanan Pula', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 'BYB', 'Belarusian Ruble (1994–1999)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 'BYN', 'Belarusian Ruble', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 'BYR', 'Belarusian Ruble (2000–2016)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 'BZD', 'Belize Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 'CAD', 'Canadian Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 'CDF', 'Congolese Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 'CHE', 'WIR Euro', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 'CHF', 'Swiss Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'CHW', 'WIR Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 'CLE', 'Chilean Escudo', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'CLF', 'Chilean Unit of Account (UF)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 'CLP', 'Chilean Peso', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 'CNX', 'Chinese People’s Bank Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'CNY', 'Chinese Yuan', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 'COP', 'Colombian Peso', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 'COU', 'Colombian Real Value Unit', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 'CRC', 'Costa Rican Colón', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 'CSD', 'Serbian Dinar (2002–2006)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 'CSK', 'Czechoslovak Hard Koruna', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 'CUC', 'Cuban Convertible Peso', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 'CUP', 'Cuban Peso', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 'CVE', 'Cape Verdean Escudo', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 'CYP', 'Cypriot Pound', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 'CZK', 'Czech Koruna', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 'DDM', 'East German Mark', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 'DEM', 'German Mark', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(80, 'DJF', 'Djiboutian Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 'DKK', 'Danish Krone', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(82, 'DOP', 'Dominican Peso', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 'DZD', 'Algerian Dinar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(84, 'ECS', 'Ecuadorian Sucre', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 'ECV', 'Ecuadorian Unit of Constant Value', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(86, 'EEK', 'Estonian Kroon', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(87, 'EGP', 'Egyptian Pound', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(88, 'ERN', 'Eritrean Nakfa', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(89, 'ESA', 'Spanish Peseta (A account)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(90, 'ESB', 'Spanish Peseta (convertible account)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(91, 'ESP', 'Spanish Peseta', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(92, 'ETB', 'Ethiopian Birr', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(93, 'EUR', 'Евро', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(94, 'FIM', 'Finnish Markka', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(95, 'FJD', 'Fijian Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(96, 'FKP', 'Falkland Islands Pound', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(97, 'FRF', 'French Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(98, 'GBP', 'Бритайнаг Фунт', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(99, 'GEK', 'Georgian Kupon Larit', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(100, 'GEL', 'Лар', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(101, 'GHC', 'Ghanaian Cedi (1979–2007)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(102, 'GHS', 'Ghanaian Cedi', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(103, 'GIP', 'Gibraltar Pound', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(104, 'GMD', 'Gambian Dalasi', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(105, 'GNF', 'Guinean Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(106, 'GNS', 'Guinean Syli', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(107, 'GQE', 'Equatorial Guinean Ekwele', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(108, 'GRD', 'Greek Drachma', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(109, 'GTQ', 'Guatemalan Quetzal', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(110, 'GWE', 'Portuguese Guinea Escudo', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(111, 'GWP', 'Guinea-Bissau Peso', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(112, 'GYD', 'Guyanaese Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(113, 'HKD', 'Hong Kong Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(114, 'HNL', 'Honduran Lempira', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(115, 'HRD', 'Croatian Dinar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(116, 'HRK', 'Croatian Kuna', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(117, 'HTG', 'Haitian Gourde', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(118, 'HUF', 'Hungarian Forint', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(119, 'IDR', 'Indonesian Rupiah', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(120, 'IEP', 'Irish Pound', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(121, 'ILP', 'Israeli Pound', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(122, 'ILR', 'Israeli Shekel (1980–1985)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(123, 'ILS', 'Israeli New Shekel', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(124, 'INR', 'Indian Rupee', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(125, 'IQD', 'Iraqi Dinar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(126, 'IRR', 'Iranian Rial', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(127, 'ISJ', 'Icelandic Króna (1918–1981)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(128, 'ISK', 'Icelandic Króna', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(129, 'ITL', 'Italian Lira', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(130, 'JMD', 'Jamaican Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(131, 'JOD', 'Jordanian Dinar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(132, 'JPY', 'Japanese Yen', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(133, 'KES', 'Kenyan Shilling', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(134, 'KGS', 'Kyrgystani Som', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(135, 'KHR', 'Cambodian Riel', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(136, 'KMF', 'Comorian Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(137, 'KPW', 'North Korean Won', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(138, 'KRH', 'South Korean Hwan (1953–1962)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(139, 'KRO', 'South Korean Won (1945–1953)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(140, 'KRW', 'South Korean Won', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(141, 'KWD', 'Kuwaiti Dinar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(142, 'KYD', 'Cayman Islands Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(143, 'KZT', 'Kazakhstani Tenge', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(144, 'LAK', 'Laotian Kip', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(145, 'LBP', 'Lebanese Pound', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(146, 'LKR', 'Sri Lankan Rupee', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(147, 'LRD', 'Liberian Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(148, 'LSL', 'Lesotho Loti', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(149, 'LTL', 'Lithuanian Litas', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(150, 'LTT', 'Lithuanian Talonas', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(151, 'LUC', 'Luxembourgian Convertible Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(152, 'LUF', 'Luxembourgian Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(153, 'LUL', 'Luxembourg Financial Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(154, 'LVL', 'Latvian Lats', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(155, 'LVR', 'Latvian Ruble', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(156, 'LYD', 'Libyan Dinar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(157, 'MAD', 'Moroccan Dirham', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(158, 'MAF', 'Moroccan Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(159, 'MCF', 'Monegasque Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(160, 'MDC', 'Moldovan Cupon', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(161, 'MDL', 'Moldovan Leu', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(162, 'MGA', 'Malagasy Ariary', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(163, 'MGF', 'Malagasy Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(164, 'MKD', 'Macedonian Denar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(165, 'MKN', 'Macedonian Denar (1992–1993)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(166, 'MLF', 'Malian Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(167, 'MMK', 'Myanmar Kyat', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(168, 'MNT', 'Mongolian Tugrik', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(169, 'MOP', 'Macanese Pataca', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(170, 'MRO', 'Mauritanian Ouguiya', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(171, 'MTL', 'Maltese Lira', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(172, 'MTP', 'Maltese Pound', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(173, 'MUR', 'Mauritian Rupee', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(174, 'MVP', 'Maldivian Rupee (1947–1981)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(175, 'MVR', 'Maldivian Rufiyaa', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(176, 'MWK', 'Malawian Kwacha', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(177, 'MXN', 'Mexican Peso', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(178, 'MXP', 'Mexican Silver Peso (1861–1992)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(179, 'MXV', 'Mexican Investment Unit', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(180, 'MYR', 'Malaysian Ringgit', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(181, 'MZE', 'Mozambican Escudo', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(182, 'MZM', 'Mozambican Metical (1980–2006)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(183, 'MZN', 'Mozambican Metical', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(184, 'NAD', 'Namibian Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(185, 'NGN', 'Nigerian Naira', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(186, 'NIC', 'Nicaraguan Córdoba (1988–1991)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(187, 'NIO', 'Nicaraguan Córdoba', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(188, 'NLG', 'Dutch Guilder', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(189, 'NOK', 'Norwegian Krone', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(190, 'NPR', 'Nepalese Rupee', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(191, 'NZD', 'New Zealand Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(192, 'OMR', 'Omani Rial', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(193, 'PAB', 'Panamanian Balboa', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(194, 'PEI', 'Peruvian Inti', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(195, 'PEN', 'Peruvian Sol', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(196, 'PES', 'Peruvian Sol (1863–1965)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(197, 'PGK', 'Papua New Guinean Kina', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(198, 'PHP', 'Philippine Peso', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(199, 'PKR', 'Pakistani Rupee', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(200, 'PLN', 'Polish Zloty', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(201, 'PLZ', 'Polish Zloty (1950–1995)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(202, 'PTE', 'Portuguese Escudo', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(203, 'PYG', 'Paraguayan Guarani', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(204, 'QAR', 'Qatari Rial', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(205, 'RHD', 'Rhodesian Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(206, 'ROL', 'Romanian Leu (1952–2006)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(207, 'RON', 'Romanian Leu', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(208, 'RSD', 'Serbian Dinar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(209, 'RUB', 'Сом', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(210, 'RUR', 'Russian Ruble (1991–1998)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(211, 'RWF', 'Rwandan Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(212, 'SAR', 'Saudi Riyal', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(213, 'SBD', 'Solomon Islands Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(214, 'SCR', 'Seychellois Rupee', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(215, 'SDD', 'Sudanese Dinar (1992–2007)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(216, 'SDG', 'Sudanese Pound', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(217, 'SDP', 'Sudanese Pound (1957–1998)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(218, 'SEK', 'Swedish Krona', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(219, 'SGD', 'Singapore Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(220, 'SHP', 'St. Helena Pound', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(221, 'SIT', 'Slovenian Tolar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(222, 'SKK', 'Slovak Koruna', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(223, 'SLL', 'Sierra Leonean Leone', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(224, 'SOS', 'Somali Shilling', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(225, 'SRD', 'Surinamese Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(226, 'SRG', 'Surinamese Guilder', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(227, 'SSP', 'South Sudanese Pound', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(228, 'STD', 'São Tomé & Príncipe Dobra', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(229, 'SUR', 'Soviet Rouble', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(230, 'SVC', 'Salvadoran Colón', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(231, 'SYP', 'Syrian Pound', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(232, 'SZL', 'Swazi Lilangeni', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(233, 'THB', 'Thai Baht', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(234, 'TJR', 'Tajikistani Ruble', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(235, 'TJS', 'Tajikistani Somoni', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(236, 'TMM', 'Turkmenistani Manat (1993–2009)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(237, 'TMT', 'Turkmenistani Manat', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(238, 'TND', 'Tunisian Dinar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(239, 'TOP', 'Tongan Paʻanga', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(240, 'TPE', 'Timorese Escudo', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(241, 'TRL', 'Turkish Lira (1922–2005)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(242, 'TRY', 'Turkish Lira', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(243, 'TTD', 'Trinidad & Tobago Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(244, 'TWD', 'New Taiwan Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(245, 'TZS', 'Tanzanian Shilling', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(246, 'UAH', 'Ukrainian Hryvnia', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(247, 'UAK', 'Ukrainian Karbovanets', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(248, 'UGS', 'Ugandan Shilling (1966–1987)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(249, 'UGX', 'Ugandan Shilling', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(250, 'USD', 'АИШ-ы Доллар', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(251, 'USN', 'US Dollar (Next day)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(252, 'USS', 'US Dollar (Same day)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(253, 'UYI', 'Uruguayan Peso (Indexed Units)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(254, 'UYP', 'Uruguayan Peso (1975–1993)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(255, 'UYU', 'Uruguayan Peso', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(256, 'UZS', 'Uzbekistani Som', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(257, 'VEB', 'Venezuelan Bolívar (1871–2008)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(258, 'VEF', 'Venezuelan Bolívar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(259, 'VND', 'Vietnamese Dong', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(260, 'VNN', 'Vietnamese Dong (1978–1985)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(261, 'VUV', 'Vanuatu Vatu', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(262, 'WST', 'Samoan Tala', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(263, 'XAF', 'Central African CFA Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(264, 'XCD', 'East Caribbean Dollar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(265, 'XEU', 'European Currency Unit', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(266, 'XFO', 'French Gold Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(267, 'XFU', 'French UIC-Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(268, 'XOF', 'West African CFA Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(269, 'XPF', 'CFP Franc', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(270, 'XRE', 'RINET Funds', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(271, 'YDD', 'Yemeni Dinar', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(272, 'YER', 'Yemeni Rial', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(273, 'YUD', 'Yugoslavian Hard Dinar (1966–1990)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(274, 'YUM', 'Yugoslavian New Dinar (1994–2002)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(275, 'YUN', 'Yugoslavian Convertible Dinar (1990–1992)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(276, 'YUR', 'Yugoslavian Reformed Dinar (1992–1993)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(277, 'ZAL', 'South African Rand (financial)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(278, 'ZAR', 'South African Rand', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(279, 'ZMK', 'Zambian Kwacha (1968–2012)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(280, 'ZMW', 'Zambian Kwacha', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(281, 'ZRN', 'Zairean New Zaire (1993–1998)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(282, 'ZRZ', 'Zairean Zaire (1971–1993)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(283, 'ZWD', 'Zimbabwean Dollar (1980–2008)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(284, 'ZWL', 'Zimbabwean Dollar (2009)', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(285, 'ZWR', 'Zimbabwean Dollar (2008)', '', 1, NULL, 1, 1646474187, 1, NULL, NULL),
(286, 'asd', 'asd', 'asdasd', 1, 1646471742, 1, 1646472914, 1, 1646472914, 1),
(287, 'asd', 'asd', 'asdss', 1, 1646471894, 1, 1646472590, 1, 1646472590, 1),
(288, 'TEST', 'Indonesia', 'asdasd', 1, 1646473210, 1, 1646473248, 1, 1646473248, 1),
(289, 'ABC', 'Imron', 'Hehe', 1, 1657298918, 1, 1657298918, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_materials`
--

CREATE TABLE `m_materials` (
  `id` int(11) NOT NULL,
  `code` varchar(15) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `default_unit_code_id` int(11) DEFAULT NULL,
  `default_unit_code_str` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `m_occupations`
--

CREATE TABLE `m_occupations` (
  `id` int(11) NOT NULL,
  `code` varchar(15) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `proficiencie_id` int(11) DEFAULT NULL,
  `default_unit_code_id` int(11) DEFAULT NULL,
  `default_unit_code_str` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_occupations`
--

INSERT INTO `m_occupations` (`id`, `code`, `title`, `level`, `desc`, `proficiencie_id`, `default_unit_code_id`, `default_unit_code_str`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'HSPP1', '	\r\nHARGA SATUAN PEKERJAAN PERSIAPAN', 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_proficiencies`
--

CREATE TABLE `m_proficiencies` (
  `id` int(11) NOT NULL,
  `code` varchar(15) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `default_unit_code_id` int(11) DEFAULT NULL,
  `default_unit_code_str` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_proficiencies`
--

INSERT INTO `m_proficiencies` (`id`, `code`, `title`, `desc`, `default_unit_code_id`, `default_unit_code_str`, `status`, `created_at`, `created_by`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'PKR', 'Pekerja', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(2, 'TKG', 'Tukang', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(3, 'TKG-GL', 'Tukang Gali', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(4, 'TKG-BT', 'Tukang Batu', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(5, 'TKG-KY', 'Tukang Kayu', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(6, 'TKG-CT', 'Tukang Cat/ Pelitur', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(7, 'TKG-BS', 'Tukang Besi', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(8, 'TKG-PP', 'Tukang Pipa/ Operator Pipa', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(9, 'TKG-BR', 'Tukang Pengayam Bronjong', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(10, 'TKG-TB', 'Tukang Tebas', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(11, 'KPL', 'Kepala Tukang', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(12, 'MND', 'Mandor', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(13, 'JRU', 'Juru Ukur', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(14, 'PJR', 'Pembantu Juru Ukur', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(15, 'AAB', 'Ahli Alat Berat ( Mekanik )', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(16, 'OPR', 'Operator', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(17, 'POP', 'Pembantu Operator', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(18, 'STR', 'Supir Truk', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(19, 'KTR', 'Kernek Truk', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(20, 'PEM', 'Penjaga Malam', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(21, 'JUG', 'Juru Gambar (Drafter)', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(22, 'DEN', 'Design Enginer', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL),
(23, 'OPP', 'Operator Printer/ Plotter', NULL, 12, NULL, 1, 1628006795, NULL, 1628006795, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_unit_codes`
--

CREATE TABLE `m_unit_codes` (
  `id` int(11) NOT NULL,
  `code` char(15) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_unit_codes`
--

INSERT INTO `m_unit_codes` (`id`, `code`, `title`, `desc`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'M2', 'Meter Persegi', NULL, 1, NULL, NULL, 1628006795, NULL, 1628006795, NULL),
(2, 'M3', 'Meter Kubik', NULL, 1, NULL, NULL, 1628006795, NULL, 1628006795, NULL),
(3, 'Tt', 'Titik', NULL, 1, NULL, NULL, 1628006795, NULL, 1628006795, NULL),
(4, 'Zk', 'Zak', NULL, 1, NULL, NULL, 1628006795, NULL, 1628006795, NULL),
(5, 'M', 'Meter', NULL, 1, NULL, NULL, 1628006795, NULL, 1628006795, NULL),
(6, 'Lmb', 'Lembar', NULL, 1, NULL, NULL, 1628006795, NULL, 1628006795, NULL),
(7, 'L', 'Liter', NULL, 1, NULL, NULL, 1628006795, NULL, 1628006795, NULL),
(8, 'Ktk', 'Kotak', NULL, 1, NULL, NULL, 1628006795, NULL, 1628006795, NULL),
(9, 'Kg', 'Kilo Gram', NULL, 1, NULL, NULL, 1628006795, NULL, 1628006795, NULL),
(10, 'Bh', 'Buah', NULL, 1, NULL, NULL, 1628006795, NULL, 1628006795, NULL),
(11, 'Btg', 'Batang', NULL, 1, NULL, NULL, 1628006795, NULL, 1628006795, NULL),
(12, 'OH', 'Orang Harian', NULL, 1, NULL, NULL, 1628006795, NULL, 1628006795, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_wind_directions`
--

CREATE TABLE `m_wind_directions` (
  `id` int(11) NOT NULL,
  `code` char(15) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `m_wupa_items`
--

CREATE TABLE `m_wupa_items` (
  `id` int(11) NOT NULL,
  `code` char(15) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `default_unit_code_id` int(11) DEFAULT NULL,
  `default_unit_code_str` varchar(100) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_wupa_items`
--

INSERT INTO `m_wupa_items` (`id`, `code`, `title`, `desc`, `default_unit_code_id`, `default_unit_code_str`, `level`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(3, 'A.1.1.2', 'Hello Cinto Sayang!', '', NULL, NULL, 1, 1, 1658653829, 1, 1658653838, 1, 1658653838, 1),
(4, 'A.1.1.3', 'Pagar Sementara Dari Seng Gelombang Tinggi 2 Meter (K3)', '', 1, NULL, 1, 1, 1658662068, 1, 1658663525, 1, NULL, NULL),
(5, 'A.1.1.2', 'asdasdasd', '', 1, NULL, 1, 1, 1658663496, 1, 1658663496, NULL, NULL, NULL),
(6, 'A.1.1.4', 'asdkasdasd', '', 1, NULL, 1, 1, 1658663788, 1, 1658663788, NULL, NULL, NULL),
(7, 'asdasd', 'asdasd', '', 1, NULL, 1, 1, 1658663826, 1, 1658667430, 1, 1658667430, 1),
(8, '234', 'asdasd', '', 1, NULL, 2, 1, 1658667410, 1, 1658667587, 1, 1658667587, 1),
(9, 'fdsdff', 'dfgfgdfg', '', NULL, NULL, 2, 1, 1658667425, 1, 1658667688, 1, 1658667688, 1),
(10, '5454', '456456456', '', NULL, NULL, 2, 1, 1658667436, 1, 1658667685, 1, 1658667685, 1),
(11, 'asd', 'asdasdasd', '', 1, NULL, 2, 1, 1658667517, 1, 1658667557, 1, NULL, NULL),
(12, 'asd11', 'asd', '', NULL, NULL, 1, 1, 1658667533, 1, 1658667533, NULL, NULL, NULL),
(13, 'sss', 'asdasdasd', '', 1, NULL, 2, 1, 1658667550, 1, 1658667550, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`roles`)),
  `schools` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`schools`)),
  `year_of_graduates` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`year_of_graduates`)),
  `title` varchar(255) DEFAULT NULL,
  `sort_desc` text DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `read_more_uri` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notification_reads`
--

CREATE TABLE `notification_reads` (
  `id` int(11) NOT NULL,
  `notification_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role_type` varchar(255) DEFAULT NULL,
  `read_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `plot_dimension_types`
--

CREATE TABLE `plot_dimension_types` (
  `id` int(11) NOT NULL,
  `code` char(15) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `length` double DEFAULT NULL,
  `width` double DEFAULT NULL,
  `dimension_unit_code_id` int(11) DEFAULT NULL,
  `dimension_unit_code_id_str` varchar(100) DEFAULT NULL,
  `plot_type_id` int(11) DEFAULT NULL,
  `plot_type_str` varchar(100) DEFAULT NULL,
  `total` int(5) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `creatad_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `plot_of_lands`
--

CREATE TABLE `plot_of_lands` (
  `id` int(11) NOT NULL,
  `code` char(15) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `dimension_id` int(11) DEFAULT NULL,
  `building_permit_number` varchar(100) DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `excess_str` double DEFAULT NULL,
  `excess_desc_id` int(11) DEFAULT NULL,
  `excess_desc_str` varchar(100) DEFAULT NULL,
  `marker_area_id` int(11) DEFAULT NULL,
  `marker_area_str` varchar(100) DEFAULT NULL,
  `wind_direction_id` int(11) DEFAULT NULL,
  `wind_direction_str` varchar(100) DEFAULT NULL,
  `excess_unit_code_id` int(11) DEFAULT NULL,
  `excess_unit_code_str` varchar(100) DEFAULT NULL,
  `latitude` decimal(10,0) DEFAULT NULL,
  `longitude` decimal(10,0) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `code` char(15) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `building_permit_number` varchar(100) DEFAULT NULL,
  `area_code` varchar(15) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `region_str` varchar(255) DEFAULT NULL,
  `pic_id` int(11) DEFAULT NULL,
  `pic_str` varchar(255) DEFAULT NULL,
  `pic_phone_number` varchar(16) DEFAULT NULL,
  `contractor_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `code`, `title`, `desc`, `building_permit_number`, `area_code`, `region_id`, `region_str`, `pic_id`, `pic_str`, `pic_phone_number`, `contractor_id`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'BENISON123', 'PROJEK 123', 'asdasd', 'asdasd', 'PKU', NULL, NULL, NULL, 'Imron Rosadi', '085265279959', NULL, 1, 1646510657, 1, 1657299555, NULL, 1657299555, 1),
(82, '3434', '3434', '3434', '3434', '3434', NULL, NULL, NULL, '3434', '3434', NULL, 1, 1646513201, 1, 1657298959, NULL, 1657298959, 1),
(83, 'sdsd', 'sd', 'sd', 'sd', 'sd', NULL, NULL, NULL, 'sd', 'sd', NULL, 1, 1646513230, 1, 1657299518, NULL, 1657299518, 1),
(84, 'aasd', 'asd', 'asd', 'asd', 'asd', NULL, NULL, NULL, 'asd', 'asd', NULL, 1, 1646513478, 1, 1657299404, NULL, 1657299404, 1),
(85, 'asd', 'asd', 'asds', 'asd', 'asd', NULL, NULL, NULL, 'asd', 'asd', 12, 1, 1646639684, 1, 1657299309, 1, 1657299309, 1),
(86, 'PRJ001', 'Perumahan AURI Jaya', '-', '9900 8765 0099', 'PKU002', NULL, NULL, NULL, 'Imron Rosadi', '085265279959', 13, 1, 1657299208, 1, 1657299355, 1, 1657299355, 1),
(87, 'asd', 'asd', 'asd', 'asdasd', 'asd', NULL, NULL, NULL, 'asd', 'asdasd', 11, 1, 1657299578, 1, 1658244159, 1, 1658244156, 1),
(88, '1213', 'Proyek 123', 'q', '1122', 'sdfsdf', NULL, NULL, NULL, 'Imron Rosadi', '+6285265279959', 11, 1, 1658327787, 1, 1658327787, NULL, NULL, NULL),
(89, '1123', 'PROJEK 123', 'asd', 'asd', 'asd', NULL, NULL, NULL, '123', '3454646', 12, 1, 1658327813, 1, 1658327885, 1, 1658327885, 1),
(90, 'Test 123', 'sdfsdf', 'sdfsdf', 'sdfsdfsdf', 'sdfsdf', NULL, NULL, NULL, 'Imron Rosadi', '45456456', 12, 1, 1658564056, 1, 1658564056, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_settings`
--

CREATE TABLE `project_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `value_` text DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `setting_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_settings`
--

INSERT INTO `project_settings` (`id`, `name`, `value`, `value_`, `project_id`, `setting_id`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(8, 'default_working_hours', '8', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'default_week_start', '0', 'Senin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'default_week_end', '5', 'Sabtu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `value_` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `value_`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(8, 'default_working_hours', '8', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'default_week_start', '0', 'Senin', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'default_week_end', '5', 'Sabtu', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'max_contractors', '1A3.miKWfYIOBFhtoaZO0LK5ThX4slYZooOoXYq3HR6cTtw', '', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'wupa_sub_item_groups', 'A', 'TENAGA', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'wupa_sub_item_groups', 'B', 'BAHAN', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'wupa_sub_item_groups', 'C', 'PERALATAN', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'wupa_overhead', '10', 'percentage', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `full_name` varchar(128) DEFAULT NULL,
  `auth_key` varchar(32) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `register_token` varchar(225) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `status` smallint(10) NOT NULL DEFAULT 9,
  `role` varchar(32) DEFAULT 'user 1',
  `image` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `full_name`, `auth_key`, `password_hash`, `register_token`, `password_reset_token`, `email`, `phone`, `status`, `role`, `image`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'admin@gmail.com', 'EKO SAPUTRA', '', '$2y$13$/VzqYb2VO8xTDYhePD2.3uUanYaurXiqapGFbeQBAfigHIHmsUWgm', NULL, '', 'imronrosadiee@gmail.com', '+62852325244', 10, '', NULL, 0, NULL, 1646477188, 1, NULL, NULL),
(20, 'imronrosadiee@gmail.com', 'IMRON ROSADI', NULL, 'sutGGnH4UiAn5/sF4QODW9X4wop39CEeqeXt1+DvXXE=', NULL, NULL, 'imronrosadiee@gmail.com', '0852325244', 10, 'operator', NULL, 1628006795, NULL, 1628007041, NULL, NULL, NULL),
(21, 'blog.imronrosadi@gmail.com', 'IMRON ROSADI', NULL, 'E6fQU4LvxDOnJLP4AHvof7tRad9ckAuu/NjyoNUCUzA=', NULL, NULL, 'blog.imronrosadi@gmail.com', '085232524499', 10, '', NULL, 1628065665, NULL, 1646476972, 1, NULL, NULL),
(22, 'baimwong', 'IMRON ROSADI', NULL, NULL, NULL, NULL, 'imronrosadiee@gmail.com123', '+62852325244', 9, '0', NULL, 1646477216, NULL, 1646477245, NULL, 1646477245, 1),
(23, 'baimwong', 'IMRON ROSADI', NULL, NULL, NULL, NULL, 'imronrosadiee@gmail.com123', '+62852325244', 9, '0', NULL, 1646477217, NULL, 1646477251, NULL, 1646477251, 1),
(24, 'baimwong', 'IMRON ROSADI', NULL, NULL, NULL, NULL, 'imronrosadiee@gmail.com123', '+62852325244', 9, '0', NULL, 1646477217, NULL, 1646477222, NULL, 1646477222, 1),
(25, 'baimwong', 'IMRON ROSADI', NULL, NULL, NULL, NULL, 'imronrosadiee@gmail.com', '+62852325244', 9, '3', NULL, 1646477261, NULL, 1646477285, NULL, 1646477285, 1),
(26, 'aasd', 'asd', NULL, NULL, NULL, NULL, 'asd', '+62852325244', 9, '0', NULL, 1646509236, NULL, 1646509407, NULL, 1646509407, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wupa_coefficients`
--

CREATE TABLE `wupa_coefficients` (
  `id` int(11) NOT NULL,
  `code` varchar(15) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `sub_item_group_id` int(11) DEFAULT NULL,
  `sub_item_id` int(11) DEFAULT NULL,
  `sub_item_str` varchar(255) DEFAULT NULL,
  `sub_item_table` varchar(255) DEFAULT NULL,
  `coefficient` float DEFAULT NULL,
  `unit_code_id` int(11) DEFAULT NULL,
  `unit_code_str` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wupa_items`
--

CREATE TABLE `wupa_items` (
  `id` int(11) NOT NULL,
  `code` varchar(15) DEFAULT NULL,
  `wupa_master_id` int(11) DEFAULT NULL,
  `occupation_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `divided` float NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wupa_items`
--

INSERT INTO `wupa_items` (`id`, `code`, `wupa_master_id`, `occupation_id`, `item_id`, `divided`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(7, 'ASP001', 2, NULL, 13, 1, 1, 1659160569, 1, 1659160569, NULL, NULL, NULL),
(8, 'ASP002', 2, NULL, 11, 1, 1, 1659160580, 1, 1659160580, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wupa_masters`
--

CREATE TABLE `wupa_masters` (
  `id` int(11) NOT NULL,
  `code` char(15) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wupa_masters`
--

INSERT INTO `wupa_masters` (`id`, `code`, `title`, `desc`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(2, 'Y0HPKv', 'AHSP Pemerintah Tahun 2021', '-', 1, 1658339149, 1, 1659156007, 1, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `auth_assignment_user_id_idx` (`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `bp_categories`
--
ALTER TABLE `bp_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `building_type_id` (`building_type_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `bp_items`
--
ALTER TABLE `bp_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `bp_master_id` (`bp_master_id`),
  ADD KEY `occupation_category_id` (`occupation_category_id`),
  ADD KEY `occupation_item_id` (`occupation_item_id`),
  ADD KEY `price_currency_id` (`price_currency_id`),
  ADD KEY `volume_unit_code_id` (`volume_unit_code_id`);

--
-- Indexes for table `bp_masters`
--
ALTER TABLE `bp_masters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `bp_categories` (`bp_category_id`);

--
-- Indexes for table `building_types`
--
ALTER TABLE `building_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `area_unit_code_id` (`area_unit_code_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `contractors`
--
ALTER TABLE `contractors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `markers`
--
ALTER TABLE `markers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `marker_type_id` (`marker_type_id`);

--
-- Indexes for table `material_prices`
--
ALTER TABLE `material_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `material_id` (`material_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `m_currencies`
--
ALTER TABLE `m_currencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `m_materials`
--
ALTER TABLE `m_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `default_unit_code_id` (`default_unit_code_id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `m_occupations`
--
ALTER TABLE `m_occupations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `default_unit_code_id` (`default_unit_code_id`),
  ADD KEY `proficiencie_id` (`proficiencie_id`);

--
-- Indexes for table `m_proficiencies`
--
ALTER TABLE `m_proficiencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `default_unit_code_id` (`default_unit_code_id`);

--
-- Indexes for table `m_unit_codes`
--
ALTER TABLE `m_unit_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `m_wind_directions`
--
ALTER TABLE `m_wind_directions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `m_wupa_items`
--
ALTER TABLE `m_wupa_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `default_unit_code_id` (`default_unit_code_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `notification_reads`
--
ALTER TABLE `notification_reads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notification_id` (`notification_id`);

--
-- Indexes for table `plot_dimension_types`
--
ALTER TABLE `plot_dimension_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creatad_by` (`creatad_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `dimension_unit_code_id` (`dimension_unit_code_id`),
  ADD KEY `plot_type_id` (`plot_type_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `plot_of_lands`
--
ALTER TABLE `plot_of_lands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `excess_desc_id` (`excess_desc_id`),
  ADD KEY `excess_unit_code_id` (`excess_unit_code_id`),
  ADD KEY `wind_direction_id` (`wind_direction_id`),
  ADD KEY `marker_area_id` (`marker_area_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `pic_id` (`pic_id`);

--
-- Indexes for table `project_settings`
--
ALTER TABLE `project_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `update_by` (`updated_by`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `setting_id` (`setting_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_ibfk_1` (`created_by`),
  ADD KEY `settings_ibfk_2` (`deleted_by`),
  ADD KEY `settings_ibfk_3` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wupa_coefficients`
--
ALTER TABLE `wupa_coefficients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `sub_item_group_id` (`sub_item_group_id`),
  ADD KEY `unit_code_id` (`unit_code_id`),
  ADD KEY `wupa_coefficients_ibfk_4` (`item_id`);

--
-- Indexes for table `wupa_items`
--
ALTER TABLE `wupa_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `wupa_items_ibfk_5` (`wupa_master_id`),
  ADD KEY `occupation_id` (`occupation_id`);

--
-- Indexes for table `wupa_masters`
--
ALTER TABLE `wupa_masters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bp_categories`
--
ALTER TABLE `bp_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_items`
--
ALTER TABLE `bp_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bp_masters`
--
ALTER TABLE `bp_masters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `building_types`
--
ALTER TABLE `building_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contractors`
--
ALTER TABLE `contractors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `markers`
--
ALTER TABLE `markers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_currencies`
--
ALTER TABLE `m_currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=290;

--
-- AUTO_INCREMENT for table `m_materials`
--
ALTER TABLE `m_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_occupations`
--
ALTER TABLE `m_occupations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_proficiencies`
--
ALTER TABLE `m_proficiencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `m_unit_codes`
--
ALTER TABLE `m_unit_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `m_wind_directions`
--
ALTER TABLE `m_wind_directions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_wupa_items`
--
ALTER TABLE `m_wupa_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_reads`
--
ALTER TABLE `notification_reads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plot_dimension_types`
--
ALTER TABLE `plot_dimension_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plot_of_lands`
--
ALTER TABLE `plot_of_lands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `project_settings`
--
ALTER TABLE `project_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `wupa_coefficients`
--
ALTER TABLE `wupa_coefficients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wupa_items`
--
ALTER TABLE `wupa_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wupa_masters`
--
ALTER TABLE `wupa_masters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bp_categories`
--
ALTER TABLE `bp_categories`
  ADD CONSTRAINT `bp_categories_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bp_categories_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bp_categories_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bp_categories_ibfk_4` FOREIGN KEY (`building_type_id`) REFERENCES `building_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bp_categories_ibfk_5` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bp_items`
--
ALTER TABLE `bp_items`
  ADD CONSTRAINT `bp_items_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bp_items_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bp_items_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bp_items_ibfk_4` FOREIGN KEY (`bp_master_id`) REFERENCES `bp_masters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bp_items_ibfk_5` FOREIGN KEY (`occupation_category_id`) REFERENCES `m_occupations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bp_items_ibfk_6` FOREIGN KEY (`occupation_item_id`) REFERENCES `m_occupations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bp_items_ibfk_7` FOREIGN KEY (`price_currency_id`) REFERENCES `m_currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bp_items_ibfk_8` FOREIGN KEY (`volume_unit_code_id`) REFERENCES `m_unit_codes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bp_masters`
--
ALTER TABLE `bp_masters`
  ADD CONSTRAINT `bp_masters_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bp_masters_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bp_masters_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bp_masters_ibfk_4` FOREIGN KEY (`bp_category_id`) REFERENCES `bp_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `building_types`
--
ALTER TABLE `building_types`
  ADD CONSTRAINT `building_types_ibfk_1` FOREIGN KEY (`area_unit_code_id`) REFERENCES `m_unit_codes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `building_types_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `building_types_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `building_types_ibfk_4` FOREIGN KEY (`project_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `building_types_ibfk_5` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contractors`
--
ALTER TABLE `contractors`
  ADD CONSTRAINT `contractors_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contractors_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contractors_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `markers`
--
ALTER TABLE `markers`
  ADD CONSTRAINT `markers_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `markers_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `markers_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `markers_ibfk_4` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `markers_ibfk_5` FOREIGN KEY (`marker_type_id`) REFERENCES `settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `material_prices`
--
ALTER TABLE `material_prices`
  ADD CONSTRAINT `material_prices_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `material_prices_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `material_prices_ibfk_3` FOREIGN KEY (`material_id`) REFERENCES `m_materials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `material_prices_ibfk_4` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `material_prices_ibfk_5` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_currencies`
--
ALTER TABLE `m_currencies`
  ADD CONSTRAINT `m_currencies_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_currencies_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_currencies_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_materials`
--
ALTER TABLE `m_materials`
  ADD CONSTRAINT `m_materials_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_materials_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_materials_ibfk_3` FOREIGN KEY (`default_unit_code_id`) REFERENCES `m_unit_codes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_materials_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_occupations`
--
ALTER TABLE `m_occupations`
  ADD CONSTRAINT `m_occupations_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_occupations_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_occupations_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_occupations_ibfk_4` FOREIGN KEY (`default_unit_code_id`) REFERENCES `m_unit_codes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_occupations_ibfk_5` FOREIGN KEY (`proficiencie_id`) REFERENCES `m_proficiencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_proficiencies`
--
ALTER TABLE `m_proficiencies`
  ADD CONSTRAINT `m_proficiencies_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_proficiencies_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_proficiencies_ibfk_3` FOREIGN KEY (`default_unit_code_id`) REFERENCES `m_unit_codes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_unit_codes`
--
ALTER TABLE `m_unit_codes`
  ADD CONSTRAINT `m_unit_codes_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_unit_codes_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_unit_codes_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_wind_directions`
--
ALTER TABLE `m_wind_directions`
  ADD CONSTRAINT `m_wind_directions_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_wind_directions_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_wind_directions_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_wupa_items`
--
ALTER TABLE `m_wupa_items`
  ADD CONSTRAINT `m_wupa_items_ibfk_1` FOREIGN KEY (`default_unit_code_id`) REFERENCES `m_unit_codes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_wupa_items_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_wupa_items_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_wupa_items_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification_reads`
--
ALTER TABLE `notification_reads`
  ADD CONSTRAINT `notification_reads_ibfk_1` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `plot_dimension_types`
--
ALTER TABLE `plot_dimension_types`
  ADD CONSTRAINT `plot_dimension_types_ibfk_1` FOREIGN KEY (`creatad_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plot_dimension_types_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plot_dimension_types_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plot_dimension_types_ibfk_4` FOREIGN KEY (`dimension_unit_code_id`) REFERENCES `m_unit_codes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plot_dimension_types_ibfk_5` FOREIGN KEY (`plot_type_id`) REFERENCES `settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plot_dimension_types_ibfk_6` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `plot_of_lands`
--
ALTER TABLE `plot_of_lands`
  ADD CONSTRAINT `plot_of_lands_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plot_of_lands_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plot_of_lands_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plot_of_lands_ibfk_4` FOREIGN KEY (`excess_desc_id`) REFERENCES `settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plot_of_lands_ibfk_5` FOREIGN KEY (`excess_unit_code_id`) REFERENCES `m_unit_codes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plot_of_lands_ibfk_6` FOREIGN KEY (`wind_direction_id`) REFERENCES `m_wind_directions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plot_of_lands_ibfk_7` FOREIGN KEY (`marker_area_id`) REFERENCES `markers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_ibfk_4` FOREIGN KEY (`pic_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_settings`
--
ALTER TABLE `project_settings`
  ADD CONSTRAINT `project_settings_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_settings_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_settings_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_settings_ibfk_4` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_settings_ibfk_5` FOREIGN KEY (`setting_id`) REFERENCES `settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `settings_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `settings_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wupa_coefficients`
--
ALTER TABLE `wupa_coefficients`
  ADD CONSTRAINT `wupa_coefficients_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wupa_coefficients_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wupa_coefficients_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wupa_coefficients_ibfk_4` FOREIGN KEY (`item_id`) REFERENCES `wupa_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wupa_coefficients_ibfk_5` FOREIGN KEY (`sub_item_group_id`) REFERENCES `settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wupa_coefficients_ibfk_6` FOREIGN KEY (`unit_code_id`) REFERENCES `m_unit_codes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wupa_items`
--
ALTER TABLE `wupa_items`
  ADD CONSTRAINT `wupa_items_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wupa_items_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wupa_items_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wupa_items_ibfk_4` FOREIGN KEY (`item_id`) REFERENCES `m_wupa_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wupa_items_ibfk_5` FOREIGN KEY (`wupa_master_id`) REFERENCES `wupa_masters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wupa_items_ibfk_6` FOREIGN KEY (`occupation_id`) REFERENCES `m_occupations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wupa_masters`
--
ALTER TABLE `wupa_masters`
  ADD CONSTRAINT `wupa_masters_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wupa_masters_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wupa_masters_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
