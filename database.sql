-- =========================
-- DATABASE
-- =========================
CREATE DATABASE IF NOT EXISTS ekikoba_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE ekikoba_db;

-- =========================
-- USERS
-- =========================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kikoba_id INT NULL,
    role ENUM('super_admin','admin','member') NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255) NOT NULL,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- VIKOBA
-- =========================
CREATE TABLE vikoba (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(100),
    contribution_amount DECIMAL(10,2) NOT NULL,
    start_date DATE,
    admin_id INT,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES users(id)
);

-- =========================
-- MEMBERS
-- =========================
CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kikoba_id INT NOT NULL,
    user_id INT NOT NULL,
    join_date DATE,
    total_contribution DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (kikoba_id) REFERENCES vikoba(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- =========================
-- CONTRIBUTIONS
-- =========================
CREATE TABLE contributions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kikoba_id INT NOT NULL,
    member_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    month VARCHAR(20),
    year YEAR,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kikoba_id) REFERENCES vikoba(id),
    FOREIGN KEY (member_id) REFERENCES members(id)
);

-- =========================
-- LOANS
-- =========================
CREATE TABLE loans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kikoba_id INT NOT NULL,
    member_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    interest DECIMAL(5,2) DEFAULT 0,
    status ENUM('pending','approved','completed') DEFAULT 'pending',
    issued_date DATE,
    FOREIGN KEY (kikoba_id) REFERENCES vikoba(id),
    FOREIGN KEY (member_id) REFERENCES members(id)
);

-- =========================
-- LOAN PAYMENTS
-- =========================
CREATE TABLE loan_payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    loan_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_date DATE,
    FOREIGN KEY (loan_id) REFERENCES loans(id)
);

-- =========================
-- FINES
-- =========================
CREATE TABLE fines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kikoba_id INT NOT NULL,
    member_id INT NOT NULL,
    reason VARCHAR(255),
    amount DECIMAL(10,2),
    status ENUM('unpaid','paid') DEFAULT 'unpaid',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kikoba_id) REFERENCES vikoba(id),
    FOREIGN KEY (member_id) REFERENCES members(id)
);

-- =========================
-- EVENTS (JAMII)
-- =========================
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kikoba_id INT NOT NULL,
    title VARCHAR(100),
    event_date DATE,
    contribution_amount DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kikoba_id) REFERENCES vikoba(id)
);

-- =========================
-- DEFAULT SUPER ADMIN
-- =========================
INSERT INTO users (role, full_name, email, password)
VALUES (
  'super_admin',
  'System Owner',
  'admin@ekikoba.com',
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
);