-- Create the delivery workforce management database
CREATE DATABASE delivery_workforce_system;
USE delivery_workforce_system;

-- 1. Customers table
CREATE TABLE customers (
    customer_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50),
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(15),
    address VARCHAR(255),
    city VARCHAR(100),
    state VARCHAR(100),
    zip_code VARCHAR(10),
    country VARCHAR(100),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    notes TEXT
);

-- 2. Locations table
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

-- 3. Vehicles table
CREATE TABLE vehicles (
    vehicle_id INT PRIMARY KEY AUTO_INCREMENT,
    license_plate VARCHAR(20) NOT NULL UNIQUE,
    model VARCHAR(50),
    make VARCHAR(50),
    year INT,
    status VARCHAR(20),
    capacity FLOAT,
    location_id INT,
    employee_id INT,
    last_service_date DATE,
    next_service_date DATE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    notes TEXT,
    FOREIGN KEY (location_id) REFERENCES locations(location_id)
);

-- 4. Roles table
CREATE TABLE roles (
    role_id INT PRIMARY KEY AUTO_INCREMENT,
    role_name VARCHAR(50) NOT NULL
);

-- 5. Employees table
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

-- 6. Schedules table
CREATE TABLE schedules (
    schedule_id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT,
    start_time DATETIME,
    end_time DATETIME,
    recurrence_pattern VARCHAR(50),
    status VARCHAR(20),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    notes TEXT,
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id)
);

-- 7. Deliveries table
CREATE TABLE deliveries (
    delivery_id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT,
    customer_id INT,
    location_id INT,
    delivery_date DATE,
    status VARCHAR(20),
    tracking_number VARCHAR(50),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    notes TEXT,
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id),
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id),
    FOREIGN KEY (location_id) REFERENCES locations(location_id)
);

-- 8. Packages table
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

-- 9. Notifications table
CREATE TABLE notifications (
    notification_id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT,
    customer_id INT,
    message TEXT,
    status VARCHAR(20),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id),
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
);

-- 10. Feedback table
CREATE TABLE feedback (
    feedback_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT,
    delivery_id INT,
    rating FLOAT,
    comments TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id),
    FOREIGN KEY (delivery_id) REFERENCES deliveries(delivery_id)
);
