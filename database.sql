-- Create Database
CREATE DATABASE IF NOT EXISTS copper_penny;
USE copper_penny;

-- Users Table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    address TEXT,
    city VARCHAR(50),
    state VARCHAR(50),
    zip_code VARCHAR(20),
    country VARCHAR(50) DEFAULT 'USA',
    phone VARCHAR(20),
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products Table
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    category VARCHAR(50),
    collection VARCHAR(50),
    description TEXT,
    short_desc VARCHAR(500),
    price DECIMAL(10,2),
    sale_price DECIMAL(10,2),
    stock INT DEFAULT 10,
    specs JSON,
    images JSON,
    featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders Table
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    order_number VARCHAR(50) UNIQUE,
    total_amount DECIMAL(10,2),
    shipping_address TEXT,
    payment_method VARCHAR(50),
    payment_status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    order_status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Order Items Table
CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    product_id INT,
    quantity INT,
    price DECIMAL(10,2),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Cart Table
CREATE TABLE cart (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    session_id VARCHAR(255),
    product_id INT,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Contact Messages Table
CREATE TABLE messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    email VARCHAR(100),
    subject VARCHAR(200),
    message TEXT,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Blog Posts Table
CREATE TABLE blog_posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200),
    slug VARCHAR(200) UNIQUE,
    content TEXT,
    excerpt VARCHAR(500),
    author VARCHAR(100),
    image VARCHAR(500),
    published BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Sample Products
INSERT INTO products (name, slug, category, collection, description, short_desc, price, specs, images) VALUES
('The Field Officer - Heritage Edition', 'heritage-field-officer', 'watch', 'heritage', 'A classic field watch with modern bronze durability. Features a 38mm CuSn8 bronze case, sapphire crystal, and Miyota 9015 automatic movement. Water resistant to 5ATM.', '38mm CuSn8 Bronze | Miyota 9015 | 5ATM', 499.00, 
'{"case_size":"38mm","case_material":"CuSn8 Bronze","movement":"Miyota 9015 Automatic","water_resistance":"5ATM (50m)","crystal":"Sapphire","lug_width":"20mm","thickness":"10.5mm"}',
'["watch1.jpg","watch2.jpg"]'),

('The Abyss - Deep Sea Diver', 'deep-sea-abyss', 'watch', 'diver', 'Professional dive watch built for adventure. 42mm CuSn8 bronze case, 200m water resistance, screw-down crown, and ceramic bezel insert. Miyota 9015 automatic movement.', '42mm CuSn8 Bronze | 200m WR | Sapphire', 699.00,
'{"case_size":"42mm","case_material":"CuSn8 Bronze","movement":"Miyota 9015 Automatic","water_resistance":"20ATM (200m)","crystal":"Sapphire","bezel":"Unidirectional Ceramic","lug_width":"22mm"}',
'["diver1.jpg","diver2.jpg"]'),

('The Patina King - Limited Edition', 'limited-patina-king', 'watch', 'limited', 'Limited edition of 100 pieces. Features heat-treated bronze hands, aged Super-LumiNova, and exhibition caseback. Each piece individually numbered.', '40mm CuSn8 Bronze | Limited Edition | Exhibition Back', 899.00,
'{"case_size":"40mm","case_material":"CuSn8 Bronze","movement":"Miyota 9015 Automatic","water_resistance":"10ATM","limited_edition":"100 pieces","special":"Heat-treated hands"}',
'["limited1.jpg","limited2.jpg"]'),

('The Navigator - GMT', 'gmt-navigator', 'watch', 'heritage', 'Dual time zone functionality in a classic bronze case. Perfect for travelers. 40mm case with sapphire crystal and GMT complication.', '40mm Bronze | GMT Function | Sapphire', 799.00,
'{"case_size":"40mm","case_material":"CuSn8 Bronze","movement":"Miyota 9075 GMT","water_resistance":"10ATM","crystal":"Sapphire","gmt":"Independent 24h hand"}',
'["gmt1.jpg","gmt2.jpg"]');

-- Insert Sample Blog Posts
INSERT INTO blog_posts (title, slug, content, excerpt, author) VALUES
('The Science of Bronze Patina', 'science-of-bronze-patina', 'Full content here...', 'Learn how CuSn8 bronze develops its unique character over time and how to care for your living metal timepiece.', 'James Copper'),

('Deep Sea Diving with Bronze', 'deep-sea-diving-bronze', 'Full content here...', 'Why bronze is making a comeback in professional dive watches and how it performs in saltwater environments.', 'Sarah Thompson'),

('Heritage Edition: Design Story', 'heritage-edition-design', 'Full content here...', 'The inspiration behind our 38mm field watch and why we chose the Miyota 9015 movement.', 'Michael Penny');

-- Insert Admin User (password: admin123 - hash it properly in PHP)
INSERT INTO users (username, email, password, full_name, role) VALUES
('admin', 'admin@copperpenny.com', '$2y$10$YourHashedPasswordHere', 'Administrator', 'admin');
