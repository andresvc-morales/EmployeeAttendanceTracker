-- Active: 1771461580840@@127.0.0.1@3306
CREATE DATABASE IF NOT EXISTS employee_attendance;
USE employee_attendance;


CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firebase_uid VARCHAR(255) NOT NULL UNIQUE,
    type ENUM('employee', 'admin') NOT NULL DEFAULT 'employee',
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);
CREATE TABLE IF NOT EXISTS assistance_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    date DATE NOT NULL,
    entry_time TIME NULL,
    exit_time TIME NULL,
    entry_status ENUM('complete', 'incomplete') NULL,
    FOREIGN KEY (employee_id) REFERENCES employees(id)
);

INSERT INTO employees (type, name, email) VALUES ('employee', 'John Doe', 'john.doe@example.com');
INSERT INTO assistance_records (employee_id, date, entry_time, exit_time, status) VALUES (1, '2024-06-01', '09:00:00', '17:00:00', 'present');