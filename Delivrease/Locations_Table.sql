-- Use the delivery workforce management database
USE delivery_workforce_system;

-- Create locations table
CREATE TABLE locations (
    location_id INT PRIMARY KEY AUTO_INCREMENT,
    address VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL,
    zip_code VARCHAR(10),
    country VARCHAR(100),
    latitude FLOAT,
    longitude FLOAT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    notes TEXT
);

-- Show all tables in the database
SHOW TABLES;

-- Describe the locations table structure
DESCRIBE locations;
