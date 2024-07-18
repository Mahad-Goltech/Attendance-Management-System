-- Create users table
CREATE TABLE users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    subject VARCHAR(50) NOT NULL,
    shift ENUM('morning', 'afternoon', 'evening') NOT NULL,
    semester VARCHAR(10) NOT NULL
);

-- Create students table
CREATE TABLE students (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50) NOT NULL UNIQUE,
    student_name VARCHAR(100) NOT NULL
);

-- Create attendance table
CREATE TABLE attendance (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id INT(11) UNSIGNED NOT NULL,
    user_id INT(11) UNSIGNED NOT NULL,
    date DATE NOT NULL,
    status ENUM('present', 'absent') NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create admin table
CREATE TABLE admin (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    admin_username VARCHAR(50) NOT NULL UNIQUE,
    admin_password VARCHAR(255) NOT NULL
);

-- Insert default admin user
INSERT INTO admin (username, password) VALUES ('admin', PASSWORD_HASH('adminpassword', PASSWORD_DEFAULT));

