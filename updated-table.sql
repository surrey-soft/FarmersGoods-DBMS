-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3309
-- Generation Time: Dec 01, 2024 at 09:43 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: `dbms-farmers-goods`
--

-- --------------------------------------------------------

-- Table structure for table `batchcertification`
CREATE TABLE `batchcertification` (
  `Certification_ID` int(11) NOT NULL,
  `Batch_ID` varchar(40) DEFAULT NULL,
  `Warehouse_ID` int(11) DEFAULT NULL,
  `StoredDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `customer`
CREATE TABLE `customer` (
  `Customer_ID` int(11) NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `C_Address` varchar(255) DEFAULT NULL,
  `MobileNo` varchar(15) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `driver`
CREATE TABLE `driver` (
  `Driver_ID` int(11) NOT NULL,
  `D_FirstName` varchar(50) DEFAULT NULL,
  `D_LastName` varchar(50) DEFAULT NULL,
  `Contact_Info` varchar(100) DEFAULT NULL,
  `D_Address` varchar(255) DEFAULT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `farmer`
CREATE TABLE `farmer` (
  `Farmer_ID` int(11) NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `DOB` date DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `RoadNo` varchar(50) DEFAULT NULL,
  `HouseNo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `farmercontact`
CREATE TABLE `farmercontact` (
  `Farmer_ID` int(11) NOT NULL,
  `ContactNo` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `grade`
CREATE TABLE `grade` (
  `Protein_Content` decimal(5,2) DEFAULT NULL,
  `Nutrition_Level` decimal(5,2) DEFAULT NULL,
  `QCO_ID` int(11) DEFAULT NULL,
  `Size` varchar(50) DEFAULT NULL,
  `Shape` varchar(50) DEFAULT NULL,
  `Color` varchar(50) DEFAULT NULL,
  `Moisture_Content` decimal(5,2) DEFAULT NULL,
  `Ripeness_Level` decimal(5,2) DEFAULT NULL,
  `Physical_Defects` varchar(255) DEFAULT NULL,
  `BatchID` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `gradecertification`
CREATE TABLE `gradecertification` (
  `Certification_ID` int(11) NOT NULL,
  `Protein_Content` decimal(5,2) DEFAULT NULL,
  `Nutrition_Level` decimal(5,2) DEFAULT NULL,
  `Warehouse_ID` int(11) DEFAULT NULL,
  `GradedDateCompleted` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `harvestbatch`
CREATE TABLE `harvestbatch` (
  `Batch_ID` varchar(40) NOT NULL,
  `BatchName` varchar(100) DEFAULT NULL,
  `BatchType` varchar(50) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Farmer_ID` int(11) DEFAULT NULL,
  `Product_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `ordertable`
CREATE TABLE `ordertable` (
  `Order_ID` int(11) NOT NULL,
  `Order_Status` varchar(50) DEFAULT NULL,
  `Order_Date` date DEFAULT NULL,
  `Order_Pickup` varchar(255) DEFAULT NULL,
  `Order_Destination` varchar(255) DEFAULT NULL,
  `Warehouse_ID` int(11) DEFAULT NULL,
  `Product_ID` int(11) NOT NULL,
  `Customer_ID` int(11) NOT NULL,
  `Driver_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `package`
CREATE TABLE `package` (
  `Package_ID` int(11) NOT NULL,
  `PackageType` varchar(50) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Packaging_Date` date DEFAULT NULL,
  `Order_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `packagingstaff`
CREATE TABLE `packagingstaff` (
  `Staff_ID` int(11) NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Contact_Info` varchar(100) DEFAULT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `product`
CREATE TABLE `product` (
  `Product_ID` int(11) NOT NULL,
  `Product_Name` varchar(100) DEFAULT NULL,
  `Product_Type` varchar(50) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Farmer_ID` int(11) NOT NULL,
  `BatchID` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `qcofficer`
CREATE TABLE `qcofficer` (
  `QCO_ID` int(11) NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `SIM1` varchar(15) DEFAULT NULL,
  `SIM2` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `qcofficercontact`
CREATE TABLE `qcofficercontact` (
  `QCO_ID` int(11) NOT NULL,
  `SIM` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `transportation`
CREATE TABLE `transportation` (
  `Transport_ID` int(11) NOT NULL,
  `Shipment_Destination` varchar(255) DEFAULT NULL,
  `Shipment_Dimension` varchar(50) DEFAULT NULL,
  `Shipment_Status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `transportationreport`
CREATE TABLE `transportationreport` (
  `Report_ID` int(11) NOT NULL,
  `Package_ID` int(11) DEFAULT NULL,
  `Transport_ID` int(11) DEFAULT NULL,
  `Route_Path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `vehicle`
CREATE TABLE `vehicle` (
  `Vehicle_RegNo` varchar(50) NOT NULL,
  `V_Name` varchar(50) DEFAULT NULL,
  `V_Capacity` int(11) DEFAULT NULL,
  `Transport_ID` int(11) DEFAULT NULL,
  `Driver_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `vehicletype`
CREATE TABLE `vehicletype` (
  `VehicleType_ID` int(11) NOT NULL,
  `Vehicle_RegNo` varchar(50) DEFAULT NULL,
  `Vehicle_Type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `warehouse`
CREATE TABLE `warehouse` (
  `Warehouse_ID` int(11) NOT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `Storage_Capacity` int(11) DEFAULT NULL,
  `MFG` date DEFAULT NULL,
  `EXP` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;
