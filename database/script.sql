-- Active: 1771461580840@@127.0.0.1@3306
CREATE DATABASE IF NOT EXISTS employee_attendance;

USE employee_attendance;

CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    firebase_uid VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS assistance_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    date DATE NOT NULL,
    entry_time TIME NULL,
    exit_time TIME NULL,
    entry_status ENUM('complete', 'incomplete') NULL,
    FOREIGN KEY (employee_id) REFERENCES employees (id)
);

INSERT INTO
    employees (name, email, firebase_uid)
VALUES (
        'John Doe',
        'john.doe@example.com',
        'john_doe_firebase_uid'
    );

INSERT INTO
    assistance_records (
        employee_id,
        date,
        entry_time,
        exit_time,
        entry_status
    )
VALUES (
        1,
        '2024-06-01',
        '09:00:00',
        '17:00:00',
        'complete'
    );