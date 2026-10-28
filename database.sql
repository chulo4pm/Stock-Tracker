-- Create Database
CREATE DATABASE IF NOT EXISTS stock_tracker;
USE stock_tracker;

-- USERS TABLE
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('manager', 'staff') NOT NULL,
  date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- TABLES ITEM
CREATE TABLE tables_item (
  id INT AUTO_INCREMENT PRIMARY KEY,
  item_name VARCHAR(100) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  quantity INT NOT NULL,
  aisle_number VARCHAR(50) NOT NULL,
  image VARCHAR(255),
  mime_type VARCHAR(100),
  date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- CHAIRS ITEM
CREATE TABLE chairs_item (
  id INT AUTO_INCREMENT PRIMARY KEY,
  item_name VARCHAR(100) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  quantity INT NOT NULL,
  aisle_number VARCHAR(50) NOT NULL,
  image VARCHAR(255),
  mime_type VARCHAR(100),
  date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- CABINETS ITEM
CREATE TABLE cabinets_item (
  id INT AUTO_INCREMENT PRIMARY KEY,
  item_name VARCHAR(100) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  quantity INT NOT NULL,
  aisle_number VARCHAR(50) NOT NULL,
  image VARCHAR(255),
  mime_type VARCHAR(100),
  date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- BEDS ITEM
CREATE TABLE beds_item (
  id INT AUTO_INCREMENT PRIMARY KEY,
  item_name VARCHAR(100) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  quantity INT NOT NULL,
  aisle_number VARCHAR(50) NOT NULL,
  image VARCHAR(255),
  mime_type VARCHAR(100),
  date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- CART TABLE
CREATE TABLE cart (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_email VARCHAR(100) NOT NULL,
  item_table ENUM('tables_item', 'chairs_item', 'cabinets_item', 'beds_item') NOT NULL,
  item_id INT NOT NULL,
  quantity INT NOT NULL,
  date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- SALES HISTORY TABLE
CREATE TABLE sales_history (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_email VARCHAR(100) NOT NULL,
  item_name VARCHAR(100) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  quantity INT NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  date_sold TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- RESTOCK HISTORY TABLE
CREATE TABLE restock_history (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_email VARCHAR(100) NOT NULL,
  item_name VARCHAR(100) NOT NULL,
  quantity INT NOT NULL,
  date_restocked TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Default demo accounts (password: 1234, stored as bcrypt hashes). Change after first login!
INSERT INTO users (name, email, password, role)
VALUES ('Manager', 'manager@local.test', '$2b$10$5YtyAhB6pyKDsMYuu3EsW.n858tsfniqgyKG3G9isqtbcXJSQCqXq', 'manager');
-- Insert a default staff user
INSERT INTO users (name, email, password, role)
VALUES ('Staff', 'staff@local.test', '$2b$10$5YtyAhB6pyKDsMYuu3EsW.n858tsfniqgyKG3G9isqtbcXJSQCqXq', 'staff');
