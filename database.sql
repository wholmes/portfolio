CREATE DATABASE IF NOT EXISTS portfolio_db;
USE portfolio_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT,
    url VARCHAR(255),
    image_url VARCHAR(255),
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (password: admin123 - change this!)
INSERT INTO users (username, email, password) VALUES 
('admin', 'admin@portfolio.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert your projects
INSERT INTO projects (title, category, description, url, display_order) VALUES
('Datalayer Tracker', 'WordPress Plugin', 'WordPress plugin for tracking and managing data layer events', NULL, 1),
('Tab Anything Block', 'WordPress Plugin', 'Gutenberg block for creating tabbed content in WordPress', NULL, 2),
('Code My Brand', 'WordPress Theme', 'Custom WordPress theme for brand development', NULL, 3),
('Datalayer Tracker SaaS', 'SaaS Service', 'Software as a Service platform for datalayer tracking and analytics', NULL, 4),
('eBook', 'Digital Product', 'Published eBook on web development and marketing', NULL, 5),
('Prompt Enhancer', 'AI Tool', 'Tool for optimizing and enhancing AI prompts', NULL, 6),
('Prompt Builder', 'AI Tool', 'Interactive builder for creating structured AI prompts', NULL, 7),
('Casetext Websites Manager', 'Web Application', 'Management system for multiple Casetext websites', NULL, 8),
('Tag Management Consulting', 'Service', 'Professional consulting services for tag management implementation', NULL, 9),
('Web Development', 'Service', 'Full-stack web development services', NULL, 10);
