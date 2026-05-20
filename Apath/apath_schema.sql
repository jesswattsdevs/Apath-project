CREATE DATABASE IF NOT EXISTS apath;
USE apath;

CREATE TABLE IF NOT EXISTS apath_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    pw VARCHAR(50) NOT NULL,
    type INT NOT NULL
);

CREATE TABLE IF NOT EXISTS apath_student (
    s_id INT PRIMARY KEY,
    email VARCHAR(100),
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    gender VARCHAR(20),
    phone VARCHAR(20),
    major VARCHAR(100),
    classification VARCHAR(50),
    bringing_family VARCHAR(10),
    student_status VARCHAR(20),
    school_graduated_from VARCHAR(150),
    emergency_phone VARCHAR(20),
    covid_vaccine VARCHAR(10),
    special_attention VARCHAR(10),
    student_comment TEXT,
    admin_comment TEXT,
    leaving_flight_number VARCHAR(50),
    leaving_airline_name VARCHAR(100),
    leaving_date VARCHAR(40),
    leaving_time VARCHAR(40)
);

CREATE TABLE IF NOT EXISTS apath_volunteer (
    v_id INT PRIMARY KEY,
    email VARCHAR(100),
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    gender VARCHAR(20),
    phone VARCHAR(20),
    occupation VARCHAR(100),
    affiliation VARCHAR(100),
    wechat VARCHAR(100),
    covid_vaccine VARCHAR(10),
    special_note TEXT,
    car_make VARCHAR(100),
    car_model VARCHAR(100),
    car_year VARCHAR(20),
    car_color VARCHAR(50),
    car_plate VARCHAR(50),
    seats_available VARCHAR(20)
);

INSERT INTO apath_users (id, email, pw, type) VALUES
(1, 'admin1@test.edu', 'admin1', 0),
(2, 's1@test.com', 's1', 2),
(3, 'v1@test.com', 'v1', 1),
(4, 's2@test.com', 's2', 2),
(5, 'v2@test.com', 'v2', 1),
(6, 's3@test.com', 's3', 2)
ON DUPLICATE KEY UPDATE email=email;
