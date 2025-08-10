-- Show existing databases
SHOW DATABASES;

-- Create database for delivery workforce management
CREATE DATABASE delivery_workforce_system;

-- Use the created database
USE delivery_workforce_system;

-- Create table for delivery vehicles
CREATE TABLE vehicles (
    vehicle_id INT PRIMARY KEY AUTO_INCREMENT,
    license_plate VARCHAR(20) NOT NULL UNIQUE,
    model VARCHAR(50),
    capacity FLOAT NOT NULL
);

-- Show tables in current database
SHOW TABLES;

-- Select all data from vehicles (should be empty initially)
SELECT * FROM vehicles;

-- Describe the vehicles table structure
DESCRIBE vehicles;
