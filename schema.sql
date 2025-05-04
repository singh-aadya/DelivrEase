-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'worker') DEFAULT 'worker'
);

-- Zones Table
CREATE TABLE zones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    complexity ENUM('rural', 'suburban', 'urban') DEFAULT 'suburban'
);

-- Workers Table
CREATE TABLE workers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    zone ENUM('urban', 'suburban', 'rural') NOT NULL,
    current_status ENUM('available', 'busy', 'on_leave') DEFAULT 'available',
    is_active BOOLEAN DEFAULT TRUE,
    total_deliveries INT DEFAULT 0,
    fatigue_score DECIMAL(5,2) DEFAULT 0,
    last_active TIMESTAMP,
    last_delivery_timestamp TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Delivery Logs Table
CREATE TABLE delivery_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    worker_id INT,
    customer_name VARCHAR(100),
    address TEXT,
    zone ENUM('urban', 'suburban', 'rural'),
    order_weight DECIMAL(5,2),
    status ENUM('assigned', 'in_progress', 'completed', 'failed') DEFAULT 'assigned',
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (worker_id) REFERENCES workers(id)
);

-- Deliveries Table
CREATE TABLE deliveries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_code VARCHAR(50) NOT NULL,
    address VARCHAR(255) NOT NULL,
    assigned_worker_id INT,
    status ENUM('Pending', 'In Progress', 'Completed') DEFAULT 'Pending',
    eta DATETIME,
    zone_id INT,
    order_weight DECIMAL(5,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_worker_id) REFERENCES workers(id),
    FOREIGN KEY (zone_id) REFERENCES zones(id)
);

-- Leaves Table
CREATE TABLE leaves (
    id INT AUTO_INCREMENT PRIMARY KEY,
    worker_id INT,
    start_date DATE,
    end_date DATE,
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    reason TEXT,
    FOREIGN KEY (worker_id) REFERENCES workers(id)
);

-- Worker Zones Mapping Table
CREATE TABLE worker_zones (
    worker_id INT,
    zone_id INT,
    PRIMARY KEY (worker_id, zone_id),
    FOREIGN KEY (worker_id) REFERENCES workers(id),
    FOREIGN KEY (zone_id) REFERENCES zones(id)
);
-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'worker') DEFAULT 'worker'
);

-- Zones Table
CREATE TABLE zones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    complexity ENUM('rural', 'suburban', 'urban') DEFAULT 'suburban'
);

-- Workers Table
CREATE TABLE workers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    zone ENUM('urban', 'suburban', 'rural') NOT NULL,
    current_status ENUM('available', 'busy', 'on_leave') DEFAULT 'available',
    is_active BOOLEAN DEFAULT TRUE,
    total_deliveries INT DEFAULT 0,
    fatigue_score DECIMAL(5,2) DEFAULT 0,
    last_active TIMESTAMP,
    last_delivery_timestamp TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Delivery Logs Table
CREATE TABLE delivery_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    worker_id INT,
    customer_name VARCHAR(100),
    address TEXT,
    zone ENUM('urban', 'suburban', 'rural'),
    order_weight DECIMAL(5,2),
    status ENUM('assigned', 'in_progress', 'completed', 'failed') DEFAULT 'assigned',
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (worker_id) REFERENCES workers(id)
);

-- Deliveries Table
CREATE TABLE deliveries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_code VARCHAR(50) NOT NULL,
    address VARCHAR(255) NOT NULL,
    assigned_worker_id INT,
    status ENUM('Pending', 'In Progress', 'Completed') DEFAULT 'Pending',
    eta DATETIME,
    zone_id INT,
    order_weight DECIMAL(5,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_worker_id) REFERENCES workers(id),
    FOREIGN KEY (zone_id) REFERENCES zones(id)
);

-- Leaves Table
CREATE TABLE leaves (
    id INT AUTO_INCREMENT PRIMARY KEY,
    worker_id INT,
    start_date DATE,
    end_date DATE,
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    reason TEXT,
    FOREIGN KEY (worker_id) REFERENCES workers(id)
);

-- Worker Zones Mapping Table
CREATE TABLE worker_zones (
    worker_id INT,
    zone_id INT,
    PRIMARY KEY (worker_id, zone_id),
    FOREIGN KEY (worker_id) REFERENCES workers(id),
    FOREIGN KEY (zone_id) REFERENCES zones(id)
);
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'worker') DEFAULT 'worker'
);

-- zones table
CREATE TABLE zones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- workers table
CREATE TABLE workers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    zone ENUM('urban', 'suburban', 'rural') NOT NULL,
    current_status ENUM('available', 'busy', 'on_leave') DEFAULT 'available',
    is_active BOOLEAN DEFAULT TRUE,
    total_deliveries INT DEFAULT 0,
    fatigue_score DECIMAL(5,2) DEFAULT 0,
    last_active TIMESTAMP,
    last_delivery_timestamp TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    zone ENUM('urban', 'suburban', 'rural') NOT NULL,
    current_status ENUM('available', 'busy', 'on_leave') DEFAULT 'available',
    is_active BOOLEAN DEFAULT TRUE,
    total_deliveries INT DEFAULT 0,
    fatigue_score DECIMAL(5,2) DEFAULT 0,
    last_active TIMESTAMP,
    last_delivery_timestamp TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    status ENUM('Available', 'On Delivery', 'Fatigued', 'On Leave') DEFAULT 'Available',
    fatigue_score INT DEFAULT 0,
);

-- deliveries table
CREATE TABLE delivery_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    worker_id INT,
    customer_name VARCHAR(100),
    address TEXT,
    zone ENUM('urban', 'suburban', 'rural'),
    order_weight DECIMAL(5,2),
    status ENUM('assigned', 'in_progress', 'completed', 'failed') DEFAULT 'assigned',
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (worker_id) REFERENCES workers(id)
);

CREATE TABLE deliveries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_code VARCHAR(50) NOT NULL,
    address VARCHAR(255) NOT NULL,
    assigned_worker_id INT,
    status ENUM('Pending', 'In Progress', 'Completed') DEFAULT 'Pending',
    eta DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_worker_id) REFERENCES workers(id)
);

-- leaves table
CREATE TABLE leaves (
    id INT AUTO_INCREMENT PRIMARY KEY,
    worker_id INT,
    start_date DATE,
    end_date DATE,
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    FOREIGN KEY (worker_id) REFERENCES workers(id)
);

CREATE TABLE worker_zones (
    worker_id INT,
    zone_id INT,
    PRIMARY KEY (worker_id, zone_id),
    FOREIGN KEY (worker_id) REFERENCES workers(id),
    FOREIGN KEY (zone_id) REFERENCES zones(id)
);

ALTER TABLE deliveries
    ADD COLUMN pickup_location VARCHAR(255),
    ADD COLUMN delivery_location VARCHAR(255),
    ADD COLUMN zone_id INT,
    ADD FOREIGN KEY (zone_id) REFERENCES zones(id);

    