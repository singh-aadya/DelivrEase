-- Use the database
USE delivery_workforce_system;

-- Create employees table
CREATE TABLE employees (
    employee_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(15),
    hire_date DATE,
    job_title VARCHAR(50),
    status VARCHAR(20),
    location_id INT,
    vehicle_id INT,
    schedule_id INT,
    role_id INT,
    rating FLOAT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    notes TEXT,
    FOREIGN KEY (location_id) REFERENCES locations(location_id),
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(vehicle_id),
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
);

-- Show all tables
SHOW TABLES;

-- Describe the structure of employees table
DESCRIBE employees;
