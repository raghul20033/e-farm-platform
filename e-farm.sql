CREATE DATABASE efarm;
USE efarm;

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    place VARCHAR(100),
    phone VARCHAR(15),
    password VARCHAR(255),
    otp VARCHAR(10),
    is_verified BOOLEAN DEFAULT 0
);

CREATE TABLE farmers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    place VARCHAR(100),
    phone VARCHAR(15),
    password VARCHAR(255),
    otp VARCHAR(10),
    is_verified BOOLEAN DEFAULT 0
);

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255)
);
