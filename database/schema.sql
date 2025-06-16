-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20),
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    category VARCHAR(50) NOT NULL,
    condition VARCHAR(50) NOT NULL,
    size VARCHAR(50) NOT NULL,
    image_url VARCHAR(255),
    is_sold BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create cart_items table
CREATE TABLE cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Create notifications table
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT,
    sender_id INT,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Create sample data for users
INSERT INTO users (name, email, phone, password, role) VALUES
('John Doe', 'john@example.com', '555-123-4567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Jane Smith', 'jane@example.com', '555-234-5678', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Admin User', 'admin@example.com', '555-345-6789', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Create sample data for products
INSERT INTO products (user_id, name, description, price, category, condition, size, image_url) VALUES
(1, 'Vintage Denim Jacket', 'Classic vintage denim jacket in excellent condition. Perfect for layering in any season.', 45.99, 'men', 'Good', 'M', '/storage/products/denim-jacket.jpg'),
(2, 'Floral Summer Dress', 'Beautiful floral summer dress, worn only once. Light and comfortable for warm days.', 28.50, 'women', 'Like New', 'S', '/storage/products/summer-dress.jpg'),
(1, 'Kids Colorful Sweater', 'Warm and colorful sweater for kids. Perfect for fall and winter.', 18.99, 'kids', 'Good', '6-7Y', '/storage/products/kids-sweater.jpg'),
(2, 'Leather Crossbody Bag', 'Genuine leather crossbody bag with adjustable strap. Multiple compartments for organization.', 35.00, 'bags', 'Good', 'One Size', '/storage/products/crossbody-bag.jpg'),
(1, 'Beaded Statement Necklace', 'Handmade beaded statement necklace. Adds a pop of color to any outfit.', 15.75, 'accessories', 'Excellent', 'One Size', '/storage/products/necklace.jpg'),
(2, 'Wool Winter Coat', 'Warm wool winter coat in dark gray. Perfect for cold weather.', 65.00, 'women', 'Good', 'L', '/storage/products/winter-coat.jpg'),
(1, 'Graphic T-Shirt', 'Cool graphic t-shirt with minimal wear. 100% cotton and very comfortable.', 12.99, 'men', 'Good', 'L', '/storage/products/graphic-tshirt.jpg'),
(2, 'Kids Denim Overalls', 'Cute denim overalls for kids. Adjustable straps and multiple pockets.', 22.50, 'kids', 'Like New', '4-5Y', '/storage/products/kids-overalls.jpg'),
(1, 'Canvas Tote Bag', 'Sturdy canvas tote bag with inner pocket. Great for shopping or beach days.', 18.00, 'bags', 'Excellent', 'One Size', '/storage/products/tote-bag.jpg'),
(2, 'Vintage Sunglasses', 'Retro style sunglasses in excellent condition. UV protection included.', 24.99, 'accessories', 'Good', 'One Size', '/storage/products/sunglasses.jpg');

-- Create sample data for notifications
INSERT INTO notifications (user_id, product_id, sender_id, message, is_read) VALUES
(1, 2, 2, 'Jane Smith is interested in your product "Vintage Denim Jacket".', FALSE),
(2, 4, 1, 'John Doe is interested in your product "Leather Crossbody Bag".', TRUE),
(1, NULL, NULL, 'Welcome to Thrift Fashion! Complete your profile to get started.', TRUE);