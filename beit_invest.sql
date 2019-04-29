-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2019 at 01:21 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `beit invest`
--
CREATE DATABASE IF NOT EXISTS `beit invest` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `beit invest`;

-- --------------------------------------------------------

--
-- Table structure for table `adminuser`
--

DROP TABLE IF EXISTS `adminuser`;
CREATE TABLE IF NOT EXISTS `adminuser` (
  `UID` text NOT NULL,
  `Name` text NOT NULL,
  `Surname` text NOT NULL,
  `Username` text NOT NULL,
  `Clearance` text NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

DROP TABLE IF EXISTS `deposits`;
CREATE TABLE IF NOT EXISTS `deposits` (
  `AUID` text NOT NULL,
  `TXID` text NOT NULL,
  `TxDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `AmountReceived` text NOT NULL,
  `SenderAddress` text NOT NULL,
  `Currency` text NOT NULL,
  `ExchangeRate` text NOT NULL,
  `Status` text NOT NULL,
  `LoggedBy` text NOT NULL,
  `ConfirmedBy` text NOT NULL,
  `ConfirmDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kyc_aml`
--

DROP TABLE IF EXISTS `kyc_aml`;
CREATE TABLE IF NOT EXISTS `kyc_aml` (
  `AUID` text NOT NULL,
  `NAME` text NOT NULL,
  `SURNAME` text NOT NULL,
  `ID_PASSPORT` text NOT NULL,
  `ID_FRONT` text,
  `ID_BACK` text,
  `BANK_NAME` text,
  `BANK_BRANCH` text,
  `ACCOUNT_NO` text,
  `ACCOUNT_HOLDER` text,
  `BANK_CARD_IMG` text,
  `KYC_STATUS` text NOT NULL,
  `COMMENT` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `passwords`
--

DROP TABLE IF EXISTS `passwords`;
CREATE TABLE IF NOT EXISTS `passwords` (
  `GUID` text NOT NULL,
  `Password` text NOT NULL,
  `passwordHold` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `AUID` int(11) NOT NULL,
  `endTime` text NOT NULL,
  `startTime` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `Name` text NOT NULL,
  `Surname` text NOT NULL,
  `Username` text NOT NULL,
  `Email` text NOT NULL,
  `GUID` text NOT NULL,
  `VerifyEmail` text NOT NULL,
  `VerifyKyc` text NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `verify`
--

DROP TABLE IF EXISTS `verify`;
CREATE TABLE IF NOT EXISTS `verify` (
  `UID` text NOT NULL,
  `VerificationCode` text NOT NULL,
  `VerifyType` text NOT NULL,
  `DateModified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `victa`
--

DROP TABLE IF EXISTS `victa`;
CREATE TABLE IF NOT EXISTS `victa` (
  `AUID` text NOT NULL,
  `TXID` text NOT NULL,
  `TxDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `VictaCode` text NOT NULL,
  `VictaPrice` text NOT NULL,
  `Quantity` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

DROP TABLE IF EXISTS `wallets`;
CREATE TABLE IF NOT EXISTS `wallets` (
  `AUID` text NOT NULL,
  `WalletType` text,
  `WalletAddress` text NOT NULL,
  `ModifyDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `WalletGUID` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

DROP TABLE IF EXISTS `withdrawals`;
CREATE TABLE IF NOT EXISTS `withdrawals` (
  `AUID` text NOT NULL,
  `TXID` text NOT NULL,
  `TxDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `AmountSent` float NOT NULL,
  `ReceiverAddress` text NOT NULL,
  `Currency` text NOT NULL,
  `ExchangeRate` text NOT NULL,
  `ConfirmedBy` text NOT NULL,
  `ConfirmDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
