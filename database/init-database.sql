-- Thrift Platform Database Initialization Script (SQLite)
-- This script creates all tables and seeds dummy data

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(255),
    email_verified_at DATETIME,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    remember_token VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Cache Table
CREATE TABLE IF NOT EXISTS cache (
    key VARCHAR(255) PRIMARY KEY,
    value TEXT NOT NULL,
    expiration INTEGER NOT NULL
);

-- Jobs Table
CREATE TABLE IF NOT EXISTS jobs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts INTEGER NOT NULL,
    reserved_at INTEGER,
    available_at INTEGER NOT NULL,
    created_at INTEGER NOT NULL
);

-- Categories Table
CREATE TABLE IF NOT EXISTS categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    image VARCHAR(255),
    is_active BOOLEAN DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Products Table
CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    original_price DECIMAL(10, 2),
    size VARCHAR(255),
    brand VARCHAR(255),
    condition VARCHAR(20) NOT NULL CHECK(condition IN ('excellent', 'very_good', 'good', 'fair')),
    images JSON,
    is_available BOOLEAN DEFAULT 1,
    is_featured BOOLEAN DEFAULT 0,
    category_id INTEGER NOT NULL,
    seller_id INTEGER NOT NULL,
    status VARCHAR(255) DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Cart Items Table
CREATE TABLE IF NOT EXISTS cart_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    product_id INTEGER NOT NULL,
    quantity INTEGER NOT NULL DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Notifications Table
CREATE TABLE IF NOT EXISTS notifications (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Personal Access Tokens Table
CREATE TABLE IF NOT EXISTS personal_access_tokens (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id INTEGER NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(80) UNIQUE NOT NULL,
    abilities TEXT,
    last_used_at DATETIME,
    expires_at DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Sessions Table
CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id INTEGER,
    ip_address VARCHAR(45),
    user_agent TEXT,
    payload LONGTEXT NOT NULL,
    last_activity INTEGER NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert Default Seller User
INSERT OR IGNORE INTO users (id, name, email, password, role, email_verified_at, created_at, updated_at)
VALUES (
    1,
    'ThriftPlatform Seller',
    'seller@thriftplatform.com',
    '$2y$12$Xvz1kL9j7mK2oP3qR4sT5uV6wX7yZ8aB9cD0eF1gH2iJ3kL4mN5oP',
    'user',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

-- Insert Categories
INSERT OR IGNORE INTO categories (id, name, slug, description, image, is_active, created_at, updated_at) VALUES
(1, "Women's Clothing", 'womens-clothing', 'Stylish pre-loved clothing for women', '/placeholder.svg?height=300&width=300&query=womens+clothing', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(2, "Men's Clothing", 'mens-clothing', 'Quality second-hand clothing for men', '/placeholder.svg?height=300&width=300&query=mens+clothing', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(3, 'Shoes', 'shoes', 'Pre-owned shoes in great condition', '/placeholder.svg?height=300&width=300&query=vintage+shoes', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(4, 'Accessories', 'accessories', 'Fashion accessories and small items', '/placeholder.svg?height=300&width=300&query=fashion+accessories', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(5, 'Bags & Purses', 'bags-purses', 'Pre-loved bags, purses, and handbags', '/placeholder.svg?height=300&width=300&query=vintage+bags', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(6, 'Jewelry', 'jewelry', 'Beautiful vintage and modern jewelry', '/placeholder.svg?height=300&width=300&query=vintage+jewelry', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- Insert Products for Women's Clothing (Category 1)
INSERT OR IGNORE INTO products (name, slug, description, price, original_price, size, brand, condition, images, is_available, is_featured, category_id, seller_id, status, created_at, updated_at) VALUES
('Floral Summer Dress', 'floral-summer-dress', 'Beautiful floral print summer dress, lightweight and comfortable. Perfect for warm weather.', 32.00, 65.00, 'S', 'Zara', 'very_good', '["\/placeholder.svg?height=400&width=400&query=floral+summer+dress"]', 1, 1, 1, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Wool Sweater', 'wool-sweater', 'Cozy wool sweater perfect for cold weather. Classic design that never goes out of style.', 38.00, 75.00, 'M', 'J.Crew', 'excellent', '["\/placeholder.svg?height=400&width=400&query=wool+sweater"]', 1, 0, 1, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Black Leather Pants', 'black-leather-pants', 'Stylish black leather pants in great condition. Perfect for both casual and formal occasions.', 55.00, 120.00, 'M', 'Hugo Boss', 'excellent', '["\/placeholder.svg?height=400&width=400&query=black+leather+pants"]', 1, 0, 1, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Vintage Blazer', 'vintage-blazer', 'Classic vintage blazer with timeless style. Perfect for professional and casual wear.', 42.00, 95.00, 'S', 'Ralph Lauren', 'very_good', '["\/placeholder.svg?height=400&width=400&query=vintage+blazer"]', 1, 0, 1, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- Insert Products for Men's Clothing (Category 2)
INSERT OR IGNORE INTO products (name, slug, description, price, original_price, size, brand, condition, images, is_available, is_featured, category_id, seller_id, status, created_at, updated_at) VALUES
('Vintage Denim Jacket', 'vintage-denim-jacket', 'Classic vintage denim jacket in excellent condition. Perfect for layering and adding a retro touch to any outfit.', 45.00, 89.00, 'M', 'Levi''s', 'excellent', '["\/placeholder.svg?height=400&width=400&query=vintage+denim+jacket"]', 1, 1, 2, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Vintage Band T-Shirt', 'vintage-band-tshirt', 'Authentic vintage band t-shirt from the 90s. Soft cotton with original graphics.', 28.00, 50.00, 'L', 'Vintage', 'very_good', '["\/placeholder.svg?height=400&width=400&query=vintage+band+tshirt"]', 1, 0, 2, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Oxford Button-Up Shirt', 'oxford-button-up-shirt', 'Crisp Oxford button-up shirt in classic style. Great for work or casual wear.', 25.00, 55.00, 'L', 'Brooks Brothers', 'excellent', '["\/placeholder.svg?height=400&width=400&query=oxford+shirt"]', 1, 0, 2, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Chinos Pants', 'chinos-pants', 'Comfortable chinos in neutral color. Versatile for various occasions.', 32.00, 70.00, '32', 'Banana Republic', 'very_good', '["\/placeholder.svg?height=400&width=400&query=chinos+pants"]', 1, 0, 2, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- Insert Products for Shoes (Category 3)
INSERT OR IGNORE INTO products (name, slug, description, price, original_price, size, brand, condition, images, is_available, is_featured, category_id, seller_id, status, created_at, updated_at) VALUES
('Leather Ankle Boots', 'leather-ankle-boots', 'Genuine leather ankle boots with minimal wear. Comfortable and stylish for everyday wear.', 55.00, 120.00, '8', 'Dr. Martens', 'good', '["\/placeholder.svg?height=400&width=400&query=leather+ankle+boots"]', 1, 0, 3, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Running Sneakers', 'running-sneakers', 'Comfortable running sneakers with cushioned sole. Lightly used, perfect condition.', 48.00, 110.00, '9', 'Nike', 'very_good', '["\/placeholder.svg?height=400&width=400&query=running+sneakers"]', 1, 0, 3, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Vintage Loafers', 'vintage-loafers', 'Classic vintage loafers in burgundy. Perfect for preppy style.', 35.00, 80.00, '7', 'Gucci', 'excellent', '["\/placeholder.svg?height=400&width=400&query=vintage+loafers"]', 1, 0, 3, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Leather Oxford Shoes', 'leather-oxford-shoes', 'Formal leather oxford shoes. Perfect for business or special occasions.', 60.00, 150.00, '10', 'Allen Edmonds', 'excellent', '["\/placeholder.svg?height=400&width=400&query=oxford+shoes"]', 1, 0, 3, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- Insert Products for Accessories (Category 4)
INSERT OR IGNORE INTO products (name, slug, description, price, original_price, size, brand, condition, images, is_available, is_featured, category_id, seller_id, status, created_at, updated_at) VALUES
('Silk Scarf', 'silk-scarf', 'Beautiful silk scarf with classic pattern. Perfect for adding elegance to any outfit.', 18.00, 45.00, NULL, 'Hermès', 'excellent', '["\/placeholder.svg?height=400&width=400&query=silk+scarf"]', 1, 0, 4, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Leather Belt', 'leather-belt', 'Classic leather belt in black. Timeless accessory for any wardrobe.', 22.00, 55.00, NULL, 'Coach', 'very_good', '["\/placeholder.svg?height=400&width=400&query=leather+belt"]', 1, 0, 4, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Vintage Sunglasses', 'vintage-sunglasses', 'Retro-style sunglasses with UV protection. Great for sunny days.', 28.00, 65.00, NULL, 'Ray-Ban', 'excellent', '["\/placeholder.svg?height=400&width=400&query=vintage+sunglasses"]', 1, 0, 4, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Wool Beanie', 'wool-beanie', 'Cozy wool beanie perfect for winter. Available in multiple colors.', 15.00, 35.00, NULL, 'The North Face', 'excellent', '["\/placeholder.svg?height=400&width=400&query=wool+beanie"]', 1, 0, 4, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- Insert Products for Bags & Purses (Category 5)
INSERT OR IGNORE INTO products (name, slug, description, price, original_price, size, brand, condition, images, is_available, is_featured, category_id, seller_id, status, created_at, updated_at) VALUES
('Designer Handbag', 'designer-handbag', 'Pre-owned designer handbag in excellent condition. Comes with authenticity certificate.', 180.00, 450.00, NULL, 'Coach', 'excellent', '["\/placeholder.svg?height=400&width=400&query=designer+handbag"]', 1, 1, 5, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Canvas Tote Bag', 'canvas-tote-bag', 'Spacious canvas tote bag. Perfect for work, school, or shopping.', 25.00, 60.00, NULL, 'L.L.Bean', 'very_good', '["\/placeholder.svg?height=400&width=400&query=canvas+tote+bag"]', 1, 0, 5, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Leather Crossbody Bag', 'leather-crossbody-bag', 'Stylish leather crossbody bag with adjustable strap. Great for travel.', 65.00, 150.00, NULL, 'Fossil', 'excellent', '["\/placeholder.svg?height=400&width=400&query=leather+crossbody+bag"]', 1, 0, 5, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Vintage Leather Briefcase', 'vintage-leather-briefcase', 'Professional vintage leather briefcase. Ideal for business professionals.', 95.00, 250.00, NULL, 'Samsonite', 'very_good', '["\/placeholder.svg?height=400&width=400&query=vintage+briefcase"]', 1, 0, 5, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- Insert Products for Jewelry (Category 6)
INSERT OR IGNORE INTO products (name, slug, description, price, original_price, size, brand, condition, images, is_available, is_featured, category_id, seller_id, status, created_at, updated_at) VALUES
('Gold Chain Necklace', 'gold-chain-necklace', 'Elegant gold chain necklace. Perfect for everyday wear or special occasions.', 45.00, 120.00, NULL, 'Tiffany & Co.', 'excellent', '["\/placeholder.svg?height=400&width=400&query=gold+necklace"]', 1, 0, 6, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Vintage Pearl Earrings', 'vintage-pearl-earrings', 'Classic pearl stud earrings. Timeless and elegant.', 38.00, 95.00, NULL, 'Vintage', 'excellent', '["\/placeholder.svg?height=400&width=400&query=pearl+earrings"]', 1, 0, 6, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Silver Ring', 'silver-ring', 'Beautiful sterling silver ring with simple design. Size 7.', 25.00, 60.00, '7', 'Pandora', 'very_good', '["\/placeholder.svg?height=400&width=400&query=silver+ring"]', 1, 0, 6, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Vintage Bracelet', 'vintage-bracelet', 'Ornate vintage bracelet with intricate details. Collector''s item.', 55.00, 140.00, NULL, 'Cartier', 'excellent', '["\/placeholder.svg?height=400&width=400&query=vintage+bracelet"]', 1, 0, 6, 1, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
