-- File: sql/database.sql

CREATE DATABASE IF NOT EXISTS travel_db;
USE travel_db;

-- Users table for storing signup details
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    age INT NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Trips table for storing travel information created by users
CREATE TABLE IF NOT EXISTS trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    destination VARCHAR(255) NOT NULL,
    transportation VARCHAR(255) NOT NULL,
    travel_details TEXT,
    budget DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table for storing which users have joined which trips
CREATE TABLE IF NOT EXISTS trip_participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trip_id INT NOT NULL,
    user_id INT NOT NULL,
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
ALTER TABLE users ADD COLUMN hometown VARCHAR(100) NOT NULL;

-- Insert fake users
INSERT INTO users (name, age, gender, email, username, password) VALUES
('John Doe', 30, 'Male', 'john@example.com', 'john_doe', '$2y$10$abcdef1234567890abcdef1234567890abcdef1234567890abcdef12'),
('Jane Smith', 25, 'Female', 'jane@example.com', 'jane_smith', '$2y$10$abcdef1234567890abcdef1234567890abcdef1234567890abcdef12'),
('Alice Johnson', 28, 'Female', 'alice@example.com', 'alice_johnson', '$2y$10$abcdef1234567890abcdef1234567890abcdef1234567890abcdef12');

-- Insert fake trips (assuming user_id 1,2,3 exist as above)
INSERT INTO trips (user_id, destination, transportation, travel_details, budget) VALUES
(1, 'Paris, France', 'Plane', 'Visit the Eiffel Tower, Louvre Museum, and enjoy exquisite French cuisine.', 1500.00),
(2, 'New York, USA', 'Train', 'Explore Broadway, Central Park, and the iconic skyline of Manhattan.', 1200.00),
(3, 'Tokyo, Japan', 'Bus', 'Experience the vibrant culture, historic temples, and modern attractions in Tokyo.', 2000.00);

-- Insert fake trip participants
INSERT INTO trip_participants (trip_id, user_id) VALUES
(1, 2),  -- Jane Smith joins John Doe's trip
(2, 1),  -- John Doe joins Jane Smith's trip
(2, 3),  -- Alice Johnson joins Jane Smith's trip
(3, 1);  -- John Doe joins Alice Johnson's trip
