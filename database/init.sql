-- Create Database
CREATE DATABASE IF NOT EXISTS mindcare;

-- Use the Database
USE mindcare;

-- Table: contacts
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: admins
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    age INT NOT NULL,
    gender INT NOT NULL,
    self_employed INT NOT NULL,
    family_history INT NOT NULL,
    work_interfere INT NOT NULL,
    no_employees INT NOT NULL,
    remote_work INT NOT NULL,
    tech_company INT NOT NULL,
    benefits INT NOT NULL,              -- Don't know -> 0, No -> 1, Yes -> 2
    care_options INT NOT NULL,          -- No -> 0, Not sure -> 1, Yes -> 2
    wellness_program INT NOT NULL,      -- Don't know -> 0, No -> 1, Yes -> 2
    seek_help INT NOT NULL,             -- Don't know -> 0, No -> 1, Yes -> 2
    anonymity INT NOT NULL,             -- Don't know -> 0, No -> 1, Yes -> 2
    leave_policy INT NOT NULL,          -- Don't know -> 0, Somewhat difficult -> 1, Somewhat easy -> 2, Very difficult -> 3, Very easy -> 4
    mental_health_consequence INT NOT NULL,  -- Maybe -> 0, No -> 1, Yes -> 2
    phys_health_consequence INT NOT NULL,    -- Maybe -> 0, No -> 1, Yes -> 2
    coworkers INT NOT NULL,             -- No -> 0, Some of them -> 1, Yes -> 2
    supervisor INT NOT NULL,            -- No -> 0, Some of them -> 1, Yes -> 2
    mental_health_interview INT NOT NULL,  -- Maybe -> 0, No -> 1, Yes -> 2
    phys_health_interview INT NOT NULL,    -- Maybe -> 0, No -> 1, Yes -> 2
    mental_vs_physical INT NOT NULL,       -- Don't know -> 0, No -> 1, Yes -> 2
    obs_consequence INT NOT NULL,       -- No -> 0, Yes -> 1
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS question_answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    response_id INT NOT NULL,
    question_id INT NOT NULL,
    answer TEXT NOT NULL,
    FOREIGN KEY (response_id) REFERENCES responses(id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
);


-- Table: users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    otp VARCHAR(6) NOT NULL,  -- OTP stored as string
    emergency_contact VARCHAR(20), 
    dob DATE DEFAULT NULL,
    gender ENUM('Male', 'Female', 'Other') DEFAULT NULL,
    profile_pic VARCHAR(255) DEFAULT 'uploads/default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Table: user_moods
CREATE TABLE IF NOT EXISTS user_moods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    mood ENUM('Happy', 'Sad', 'Neutral', 'Stressed') NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    message TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS therapists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    specialization VARCHAR(255) NOT NULL,
    experience INT NOT NULL,
    contact VARCHAR(255) NOT NULL,
    bio TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL DEFAULT 0, 
    session_type ENUM('Online', 'Offline', 'Both') NOT NULL DEFAULT 'Online',
    next_slot TIME NOT NULL DEFAULT '09:00:00'
);

CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    therapist_id INT NOT NULL,
    slot_id INT,  -- New column to store the original slot ID
    user_name VARCHAR(255) NOT NULL,
    user_email VARCHAR(255) NOT NULL, -- Removed UNIQUE constraint for repeat users
    user_phone VARCHAR(15) NOT NULL,
    date DATE NOT NULL,
    time_slot DATETIME NOT NULL, -- Stores both date and time
    session_type ENUM('Online', 'Offline') DEFAULT 'Online',
    primary_concern TEXT,
    referral VARCHAR(255),
    status ENUM('Pending', 'Confirmed', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (therapist_id) REFERENCES therapists(id) ON DELETE CASCADE,
    FOREIGN KEY (slot_id) REFERENCES therapist_slots(id) ON DELETE SET NULL,
    INDEX idx_therapist (therapist_id)
);



CREATE TABLE IF NOT EXISTS therapist_slots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    therapist_id INT NOT NULL,
    slot_datetime DATETIME NOT NULL, -- Using DATETIME to store both date and time
    FOREIGN KEY (therapist_id) REFERENCES therapists(id) ON DELETE CASCADE,
    INDEX idx_therapist_slots (therapist_id)  -- Optimized queries
);
ALTER TABLE therapist_slots ADD COLUMN is_booked BOOLEAN DEFAULT FALSE;
ALTER TABLE appointments ADD COLUMN user_id INT NOT NULL AFTER therapist_id;
ALTER TABLE users ADD COLUMN otp_generated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

