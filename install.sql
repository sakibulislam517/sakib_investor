-- Investor Profit Management System - Database
-- Run this SQL to set up the database

CREATE DATABASE IF NOT EXISTS investor_sakib;
USE investor_sakib;

-- Admin table
CREATE TABLE IF NOT EXISTS admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Default admin: admin / password
INSERT INTO admin (username, password) VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Investors table
CREATE TABLE IF NOT EXISTS investors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  email VARCHAR(100) DEFAULT '',
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  address TEXT,
  profit_percent DECIMAL(5,2) NOT NULL DEFAULT 0 COMMENT 'Admin profit share %',
  status INT DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Unified ledger for all financial transactions
CREATE TABLE IF NOT EXISTS investor_ledger (
  id INT AUTO_INCREMENT PRIMARY KEY,
  investor_id INT NOT NULL,
  date DATE NOT NULL,
  type ENUM('deposit','investment_withdraw','profit','profit_withdraw') NOT NULL,
  amount DECIMAL(12,2) NOT NULL,
  remarks TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (investor_id) REFERENCES investors(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Daily profit entries with admin/investor split
CREATE TABLE IF NOT EXISTS daily_profit (
  id INT AUTO_INCREMENT PRIMARY KEY,
  investor_id INT NOT NULL,
  date DATE NOT NULL,
  gross_profit DECIMAL(12,2) NOT NULL,
  admin_percent DECIMAL(5,2) NOT NULL,
  admin_amount DECIMAL(12,2) NOT NULL,
  investor_amount DECIMAL(12,2) NOT NULL,
  remarks TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (investor_id) REFERENCES investors(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Settings
CREATE TABLE IF NOT EXISTS settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company_name VARCHAR(200) DEFAULT 'Investor Profit Management System',
  currency VARCHAR(10) DEFAULT 'USD',
  logo VARCHAR(255) DEFAULT '',
  timezone VARCHAR(50) DEFAULT 'Asia/Dhaka'
) ENGINE=InnoDB;

INSERT INTO settings (company_name, currency) VALUES ('Investor Profit Management System', 'USD');
