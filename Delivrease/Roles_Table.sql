-- Use the database
USE delivery_workforce_system;

-- Create roles table
CREATE TABLE roles (
    role_id INT PRIMARY KEY AUTO_INCREMENT,
    role_name VARCHAR(50) NOT NULL
);

-- Show all tables
SHOW TABLES;

-- Describe the structure of roles table
DESCRIBE roles;
