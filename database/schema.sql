CREATE DATABASE IF NOT EXISTS blood_emergency_db;
USE blood_emergency_db;

CREATE TABLE IF NOT EXISTS donors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    blood_group ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'Bombay_Oh', 'Rh_null') NOT NULL,
    city VARCHAR(80) NOT NULL,
    is_available TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS blood_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hospital_name VARCHAR(150) NOT NULL,
    hospital_unit_id VARCHAR(50) NOT NULL,
    patient_blood_group ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'Bombay_Oh', 'Rh_null') NOT NULL,
    units_needed INT NOT NULL DEFAULT 1,
    urgency_level ENUM('Standard', 'Urgent', 'Critical') NOT NULL,
    contact_phone VARCHAR(15) NOT NULL,
    is_verified TINYINT(1) DEFAULT 0,
    status ENUM('Pending', 'Active', 'Fulfilled') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);