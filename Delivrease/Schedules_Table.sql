-- Use the database
USE delivery_workforce_system;

-- Create schedules table
CREATE TABLE schedules (
    schedule_id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    status VARCHAR(20),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    notes TEXT,
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id)
);

-- Show all tables
SHOW TABLES;

-- Describe the structure of schedules table
DESCRIBE schedules;
