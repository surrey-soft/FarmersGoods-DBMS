-- Table for Farmer
CREATE TABLE Farmer (
    Farmer_ID VARCHAR(255) PRIMARY KEY, -- Unique identifier for the farmer
    Name VARCHAR(255) NOT NULL,         -- Name of the farmer
    Contact_Info VARCHAR(255),         -- Contact details
    Farm_Location VARCHAR(255)         -- Location of the farm
);

-- Table for Customer
CREATE TABLE Customer (
    Customer_ID VARCHAR(255) PRIMARY KEY, -- Unique identifier for the customer
    CName VARCHAR(255) NOT NULL,          -- Customer's full name
    C_Address VARCHAR(255),               -- Customer's address
    Contact_Info VARCHAR(255)             -- Contact details (mobile and email)
);

-- Table for Harvest_Batch
CREATE TABLE Harvest_Batch (
    Batch_ID VARCHAR(255) PRIMARY KEY,   -- Unique identifier for the batch
    Batch_Name VARCHAR(255),            -- Name of the harvest batch
    Batch_Type VARCHAR(255),            -- Type of harvest in the batch
    Weight NUMERIC,                     -- Weight of the batch in kg
    Quantity NUMERIC,                   -- Quantity of items in the batch
    Date DATE                           -- Date of the batch harvest
);

-- Table for QC_Officer
CREATE TABLE QC_Officer (
    QCOID VARCHAR(255) PRIMARY KEY,     -- Unique identifier for the QC officer
    Name VARCHAR(255) NOT NULL,         -- Full name of the QC officer
    Contact VARCHAR(255),               -- Contact information (SIM1 and SIM2)
    Certification VARCHAR(255)          -- Certification details
);

-- Table for Grade
CREATE TABLE Grade (
    Grade_ID VARCHAR(255) PRIMARY KEY,   -- Unique identifier for the grade
    Protein_Content NUMERIC,            -- Protein content percentage
    Nutrition_Level NUMERIC,            -- Nutritional value score
    Lab_Test VARCHAR(255),              -- Lab test results (Size, Shape, Color)
    Moisture_Content NUMERIC,           -- Moisture content percentage
    Ripeness_Level NUMERIC,             -- Ripeness score (scale 1-10)
    Physical_Defects VARCHAR(255),      -- Details of any physical defects
    StoredDate DATE                     -- Date the grade was recorded
);

-- Table for Package
CREATE TABLE Package (
    PackageID VARCHAR(255) PRIMARY KEY, -- Unique identifier for the package
    PackageType VARCHAR(255),           -- Type of packaging
    Description VARCHAR(255),           -- Description of the package contents
    Packaging_Date DATE                 -- Date the packaging was done
);

-- Table for Packaging_Staff
CREATE TABLE Packaging_Staff (
    Staff_ID VARCHAR(255) PRIMARY KEY, -- Unique identifier for the staff
    SName VARCHAR(255) NOT NULL,       -- Full name of the packaging staff
    Address VARCHAR(255),              -- Address of the staff
    Date_of_Birth DATE,                -- Date of birth of the staff
    Contact_Info VARCHAR(255)          -- Staff's contact details
);

-- Table for Order
CREATE TABLE Order_Table (
    Order_ID VARCHAR(255) PRIMARY KEY,  -- Unique identifier for the order
    Customer_ID VARCHAR(255),          -- Foreign Key: References Customer table
    Order_Date DATE,                   -- Date of the order
    Total_Amount NUMERIC,              -- Total amount for the order
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
);

-- Table for Vehicle
CREATE TABLE Vehicle (
    Vehicle_ID VARCHAR(255) PRIMARY KEY, -- Unique identifier for the vehicle
    Type VARCHAR(255),                   -- Type of vehicle
    Capacity NUMERIC,                    -- Capacity of the vehicle in kg
    Registration_Number VARCHAR(255)     -- Vehicle registration number
);

-- Table for Transport
CREATE TABLE Transport (
    Transport_ID VARCHAR(255) PRIMARY KEY, -- Unique identifier for the transport
    Vehicle_ID VARCHAR(255),               -- Foreign Key: References Vehicle table
    Driver_ID VARCHAR(255),                -- Foreign Key: References Driver table
    Start_Date DATE,                       -- Start date of the transport
    End_Date DATE,                         -- End date of the transport
    FOREIGN KEY (Vehicle_ID) REFERENCES Vehicle(Vehicle_ID)
);

-- Table for Product
CREATE TABLE Product (
    Product_ID VARCHAR(255) PRIMARY KEY, -- Unique identifier for the product
    Name VARCHAR(255),                   -- Name of the product
    Type VARCHAR(255),                   -- Type of product
    Price_per_kg NUMERIC                 -- Price of the product per kilogram
);

-- Table for Driver
CREATE TABLE Driver (
    Driver_ID VARCHAR(255) PRIMARY KEY,  -- Unique identifier for the driver
    Name VARCHAR(255),                   -- Name of the driver
    License_Number VARCHAR(255),         -- Driver's license number
    Contact_Info VARCHAR(255)            -- Contact details of the driver
);
