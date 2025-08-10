-- Use the database
USE delivery_workforce_system;

-- Create deliveries table
CREATE TABLE deliveries (
    delivery_id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT,
    location_id INT,
    delivery_date DATE NOT NULL,
    status VARCHAR(20),
    tracking_number VARCHAR(50),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    notes TEXT,
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id),
    FOREIGN KEY (location_id) REFERENCES locations(location_id)
);

-- Show all tables
SHOW TABLES;

-- Describe the structure of deliveries table
DESCRIBE deliveries;
