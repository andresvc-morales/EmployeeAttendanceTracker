CREATE DATABASE IF NOT EXISTS employee_attendance;

USE employee_attendance;

-- Stores registered employees linked to their Firebase UID
CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    firebase_uid VARCHAR(255) NOT NULL UNIQUE -- UID provided by Firebase after sign-up
);

-- Stores daily attendance records (one entry + one exit per employee per day)
CREATE TABLE IF NOT EXISTS assistance_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    date DATE NOT NULL,
    entry_time TIME NULL,
    exit_time TIME NULL,
    entry_status ENUM('complete', 'incomplete') NULL, -- 'complete' once exit is registered
    FOREIGN KEY (employee_id) REFERENCES employees (id)
);

-- Sample attendance record for the test employee
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
    ),
    (
        1,
        '2024-06-02',
        '09:15:00',
        NULL,
        'incomplete'
    ),
    (
        1,
        '2024-06-03',
        '09:05:00',
        '17:10:00',
        'complete'
    ),
    (
        1,
        '2024-06-04',
        '09:00:00',
        NULL,
        'incomplete'
    ),
    (
        1,
        '2024-06-05',
        '09:20:00',
        '17:00:00',
        'complete'
    ),
    (
        1,
        '2024-06-06',
        '09:00:00',
        NULL,
        'incomplete'
    ),
    (
        1,
        '2024-06-07',
        '09:10:00',
        '17:05:00',
        'complete'
    ),
    (
        1,
        '2024-06-08',
        '09:00:00',
        NULL,
        'incomplete'
    ),
    (
        1,
        '2024-06-09',
        '09:05:00',
        '17:00:00',
        'complete'
    );

DROP TABLE IF EXISTS employees;

DROP TABLE IF EXISTS assistance_records;