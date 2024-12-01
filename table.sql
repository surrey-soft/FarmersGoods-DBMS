-- Start transaction to ensure changes are grouped
START TRANSACTION;

-- Create `batchcertification` table
CREATE TABLE `batchcertification` (
  `Certification_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Batch_ID` varchar(40) DEFAULT NULL,
  `Warehouse_ID` int(11) DEFAULT NULL,
  `StoredDate` date DEFAULT NULL,
  PRIMARY KEY (`Certification_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `customer` table
CREATE TABLE `customer` (
  `Customer_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `C_Address` varchar(255) DEFAULT NULL,
  `MobileNo` varchar(15) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  PRIMARY KEY (`Customer_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `driver` table
CREATE TABLE `driver` (
  `Driver_ID` int(11) NOT NULL AUTO_INCREMENT,
  `D_FirstName` varchar(50) DEFAULT NULL,
  `D_LastName` varchar(50) DEFAULT NULL,
  `Contact_Info` varchar(100) DEFAULT NULL,
  `D_Address` varchar(255) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  PRIMARY KEY (`Driver_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `farmer` table
CREATE TABLE `farmer` (
  `Farmer_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `DOB` date DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `RoadNo` varchar(50) DEFAULT NULL,
  `HouseNo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Farmer_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `farmercontact` table
CREATE TABLE `farmercontact` (
  `Farmer_ID` int(11) NOT NULL,
  `ContactNo` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`Farmer_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `grade` table
CREATE TABLE `grade` (
  `Grade_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Protein_Content` decimal(5,2) DEFAULT NULL,
  `Nutrition_Level` decimal(5,2) DEFAULT NULL,
  `QCO_ID` int(11) DEFAULT NULL,
  `Size` varchar(50) DEFAULT NULL,
  `Shape` varchar(50) DEFAULT NULL,
  `Color` varchar(50) DEFAULT NULL,
  `Moisture_Content` decimal(5,2) DEFAULT NULL,
  `Ripeness_Level` decimal(5,2) DEFAULT NULL,
  `Physical_Defects` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Grade_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `gradecertification` table
CREATE TABLE `gradecertification` (
  `Certification_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Protein_Content` decimal(5,2) DEFAULT NULL,
  `Nutrition_Level` decimal(5,2) DEFAULT NULL,
  `Warehouse_ID` int(11) DEFAULT NULL,
  `GradedDateCompleted` date DEFAULT NULL,
  PRIMARY KEY (`Certification_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `harvestbatch` table
CREATE TABLE `harvestbatch` (
  `Batch_ID` varchar(40) NOT NULL,
  `BatchName` varchar(100) DEFAULT NULL,
  `BatchType` varchar(50) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Farmer_ID` int(11) DEFAULT NULL,
  `Product_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`Batch_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `ordertable` table
CREATE TABLE `ordertable` (
  `Order_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Order_Status` varchar(50) DEFAULT NULL,
  `Order_Date` date DEFAULT NULL,
  `Order_Pickup` varchar(255) DEFAULT NULL,
  `Order_Destination` varchar(255) DEFAULT NULL,
  `Warehouse_ID` int(11) DEFAULT NULL,
  `Product_ID` int(11) NOT NULL,
  `Customer_ID` int(11) NOT NULL,
  `Driver_ID` int(11) NOT NULL,
  PRIMARY KEY (`Order_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `package` table
CREATE TABLE `package` (
  `Package_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PackageType` varchar(50) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Packaging_Date` date DEFAULT NULL,
  `Order_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`Package_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `packagingstaff` table
CREATE TABLE `packagingstaff` (
  `Staff_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Contact_Info` varchar(100) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  PRIMARY KEY (`Staff_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `product` table
CREATE TABLE `product` (
  `Product_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Product_Name` varchar(100) DEFAULT NULL,
  `Product_Type` varchar(50) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Farmer_ID` int(11) NOT NULL,
  `BatchID` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`Product_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `qcofficer` table
CREATE TABLE `qcofficer` (
  `QCO_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `SIM1` varchar(15) DEFAULT NULL,
  `SIM2` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`QCO_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `qcofficercontact` table
CREATE TABLE `qcofficercontact` (
  `QCO_ID` int(11) NOT NULL,
  `SIM` varchar(15) NOT NULL,
  PRIMARY KEY (`QCO_ID`,`SIM`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `transportation` table
CREATE TABLE `transportation` (
  `Transport_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Shipment_Destination` varchar(255) DEFAULT NULL,
  `Shipment_Dimension` varchar(50) DEFAULT NULL,
  `Shipment_Status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Transport_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `transportationreport` table
CREATE TABLE `transportationreport` (
  `Report_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Package_ID` int(11) DEFAULT NULL,
  `Transport_ID` int(11) DEFAULT NULL,
  `Route_Path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Report_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `vehicle` table
CREATE TABLE `vehicle` (
  `Vehicle_RegNo` varchar(50) NOT NULL,
  `V_Name` varchar(50) DEFAULT NULL,
  `V_Capacity` int(11) DEFAULT NULL,
  `Transport_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`Vehicle_RegNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `vehicletype` table
CREATE TABLE `vehicletype` (
  `VehicleType_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Vehicle_RegNo` varchar(50) DEFAULT NULL,
  `Vehicle_Type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`VehicleType_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `warehouse` table
CREATE TABLE `warehouse` (
  `Warehouse_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Location` varchar(255) DEFAULT NULL,
  `Storage_Capacity` int(11) DEFAULT NULL,
  `MFG` date DEFAULT NULL,
  `EXP` date DEFAULT NULL,
  PRIMARY KEY (`Warehouse_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Commit changes to the database
COMMIT;
