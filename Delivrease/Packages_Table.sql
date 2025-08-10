-- Use the database
USE delivery_workforce_system;

-- Create packages table
CREATE TABLE packages (
    package_id INT PRIMARY KEY AUTO_INCREMENT,
    delivery_id INT,
    weight FLOAT,
    dimensions VARCHAR(50),
    status VARCHAR(20),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    notes TEXT,
    FOREIGN KEY (delivery_id) REFERENCES deliveries(delivery_id)
);

-- Show all tables
SHOW TABLES;

-- Describe the structure of packages table
DESCRIBE packages;
