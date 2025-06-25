CREATE DATABASE IF NOT EXISTS savings_tracker;
USE savings_tracker;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
);

-- Savings Table (User's personal expenses)
CREATE TABLE IF NOT EXISTS savings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  purpose VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Lending Table (Money given to others)
CREATE TABLE IF NOT EXISTS lending (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL,
  name VARCHAR(100) NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  given_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Safely drop indexes if they exist (MySQL workaround)
-- First check and drop manually or use DROP INDEX if sure they exist.

-- Create Indexes for faster monthly filtering
CREATE INDEX IF NOT EXISTS idx_savings_user_month ON savings (username, created_at);
CREATE INDEX IF NOT EXISTS idx_lending_user_month ON lending (username, given_at);
