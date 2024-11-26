CREATE DATABASE dbms-farmers-goods;
-- FARMER TABLE
CREATE TABLE Farmer (
    Farmer_ID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    Password VARCHAR(255) NOT NULL, -- Password field added
    DOB DATE,
    City VARCHAR(50),
    RoadNo VARCHAR(50),
    HouseNo VARCHAR(50)
);

-- PRODUCT TABLE
CREATE TABLE Product (
    Product_ID INT AUTO_INCREMENT PRIMARY KEY,
    Product_Name VARCHAR(100),
    Product_Type VARCHAR(50),
    Date DATE
    Farmer_ID INT,
);

-- QC OFFICER TABLE
CREATE TABLE QCOfficer (
    QCO_ID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    Password VARCHAR(255) NOT NULL, -- Password field added
    SIM1 VARCHAR(15),
    SIM2 VARCHAR(15)
);

-- WAREHOUSE TABLE
CREATE TABLE Warehouse (
    Warehouse_ID INT AUTO_INCREMENT PRIMARY KEY,
    Location VARCHAR(255),
    Storage_Capacity INT,
    MFG DATE,
    EXP DATE
);

-- FARMER CONTACT TABLE
CREATE TABLE FarmerContact (
    Farmer_ID INT PRIMARY KEY,
    ContactNo VARCHAR(15),
    FOREIGN KEY (Farmer_ID) REFERENCES Farmer(Farmer_ID)
);

-- QC OFFICER CONTACT TABLE
CREATE TABLE QCOfficerContact (
    Contact_ID INT AUTO_INCREMENT PRIMARY KEY,
    QCO_ID INT,
    SIM VARCHAR(15),
    FOREIGN KEY (QCO_ID) REFERENCES QCOfficer(QCO_ID)
);

-- HARVEST BATCH TABLE
CREATE TABLE HarvestBatch (
    Batch_ID INT AUTO_INCREMENT PRIMARY KEY,
    BatchName VARCHAR(100),
    BatchType VARCHAR(50),
    Date DATE,
    Farmer_ID INT,
    Product_ID INT,
    FOREIGN KEY (Farmer_ID) REFERENCES Farmer(Farmer_ID),
    FOREIGN KEY (Product_ID) REFERENCES Product(Product_ID)
);

-- GRADE TABLE
CREATE TABLE Grade (
    Grade_ID INT AUTO_INCREMENT PRIMARY KEY,
    Protein_Content DECIMAL(5, 2),
    Nutrition_Level DECIMAL(5, 2),
    QCO_ID INT,
    Size VARCHAR(50),
    Shape VARCHAR(50),
    Color VARCHAR(50),
    Moisture_Content DECIMAL(5, 2),
    Ripeness_Level DECIMAL(5, 2),
    Physical_Defects VARCHAR(255),
    FOREIGN KEY (QCO_ID) REFERENCES QCOfficer(QCO_ID)
);

-- GRADE CERTIFICATION TABLE
CREATE TABLE GradeCertification (
    Certification_ID INT AUTO_INCREMENT PRIMARY KEY,
    Protein_Content DECIMAL(5, 2),
    Nutrition_Level DECIMAL(5, 2),
    Warehouse_ID INT,
    GradedDateCompleted DATE,
    FOREIGN KEY (Warehouse_ID) REFERENCES Warehouse(Warehouse_ID)
);

-- BATCH CERTIFICATION TABLE
CREATE TABLE BatchCertification (
    Certification_ID INT AUTO_INCREMENT PRIMARY KEY,
    Batch_ID INT,
    Warehouse_ID INT,
    StoredDate DATE,
    FOREIGN KEY (Batch_ID) REFERENCES HarvestBatch(Batch_ID),
    FOREIGN KEY (Warehouse_ID) REFERENCES Warehouse(Warehouse_ID)
);

-- CUSTOMER TABLE
CREATE TABLE Customer (
    Customer_ID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    C_Address VARCHAR(255),
    MobileNo VARCHAR(15),
    Email VARCHAR(100),
    Password VARCHAR(255) NOT NULL, -- Password field added
    Order_ID INT
);

-- ORDER TABLE
CREATE TABLE OrderTable (
    Order_ID INT AUTO_INCREMENT PRIMARY KEY,
    Order_Status VARCHAR(50),
    Order_Date DATE,
    Order_Pickup VARCHAR(255),
    Order_Destination VARCHAR(255),
    Warehouse_ID INT,
    FOREIGN KEY (Warehouse_ID) REFERENCES Warehouse(Warehouse_ID)
);

-- PACKAGE TABLE
CREATE TABLE Package (
    Package_ID INT AUTO_INCREMENT PRIMARY KEY,
    PackageType VARCHAR(50),
    Description VARCHAR(255),
    Packaging_Date DATE,
    Order_ID INT,
    FOREIGN KEY (Order_ID) REFERENCES OrderTable(Order_ID)
);

-- PACKAGING STAFF TABLE
CREATE TABLE PackagingStaff (
    Staff_ID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    Address VARCHAR(255),
    DOB DATE,
    Contact_Info VARCHAR(100),
    Password VARCHAR(255) NOT NULL -- Password field added
);

-- TRANSPORTATION TABLE
CREATE TABLE Transportation (
    Transport_ID INT AUTO_INCREMENT PRIMARY KEY,
    Shipment_Destination VARCHAR(255),
    Shipment_Dimension VARCHAR(50),
    Shipment_Status VARCHAR(50)
);

-- TRANSPORTATION REPORT TABLE
CREATE TABLE TransportationReport (
    Report_ID INT AUTO_INCREMENT PRIMARY KEY,
    Package_ID INT,
    Transport_ID INT,
    Route_Path VARCHAR(255),
    FOREIGN KEY (Package_ID) REFERENCES Package(Package_ID),
    FOREIGN KEY (Transport_ID) REFERENCES Transportation(Transport_ID)
);

-- VEHICLE TABLE
CREATE TABLE Vehicle (
    Vehicle_RegNo VARCHAR(50) PRIMARY KEY,
    V_Name VARCHAR(50),
    V_Capacity INT,
    Transport_ID INT,
    FOREIGN KEY (Transport_ID) REFERENCES Transportation(Transport_ID)
);

-- VEHICLE TYPE TABLE
CREATE TABLE VehicleType (
    VehicleType_ID INT AUTO_INCREMENT PRIMARY KEY,
    Vehicle_RegNo VARCHAR(50),
    Vehicle_Type VARCHAR(50), -- Example: Bike, Van, Truck
    FOREIGN KEY (Vehicle_RegNo) REFERENCES Vehicle(Vehicle_RegNo)
);

-- DRIVER TABLE
CREATE TABLE Driver (
    Driver_ID INT AUTO_INCREMENT PRIMARY KEY,
    D_FirstName VARCHAR(50),
    D_LastName VARCHAR(50),
    Contact_Info VARCHAR(100),
    D_Address VARCHAR(255),
    Password VARCHAR(255) NOT NULL -- Password field added
);
