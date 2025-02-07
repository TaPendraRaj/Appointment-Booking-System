-- Create the database
CREATE DATABASE appointment_system;
USE appointment_system;

-- Create users table
CREATE TABLE  users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create services table
CREATE TABLE  services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    duration INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

-- Create appointments table
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    service_id INT NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    duration INT NOT NULL,
    status ENUM('confirmed', 'cancelled', 'completed') DEFAULT 'confirmed',
    additional_info TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (service_id) REFERENCES services(id)
);

-- Create contact_messages table
CREATE TABLE  contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample services
INSERT INTO services (name, description, duration, price) VALUES
('Doctor Consultation', 'Book a session with a medical professional for personalized health advice.', 30, 100.00),
('Haircut', 'Get a trendy haircut from experienced stylists to refresh your look.', 45, 35.00),
('Legal Consultation', 'Schedule a consultation with a legal expert for advice on legal matters.', 60, 150.00),
('Fitness Training', 'Personalized workout sessions with certified trainers to achieve your fitness goals.', 60, 50.00),
('Car Repair', 'Professional vehicle repair services to keep your car in top condition.', 120, 200.00);

-- Create an index on the email column in the users table for faster lookups
CREATE INDEX idx_user_email ON users(email);

-- Create an index on the date column in the appointments table for faster date-based queries
CREATE INDEX idx_appointment_date ON appointments(date);

-- Create a composite index on user_id and date in the appointments table for faster user-specific date queries
CREATE INDEX idx_user_date ON appointments(user_id, date);