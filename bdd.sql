-- Création de la base de données
CREATE DATABASE IF NOT EXISTS pizza_restaurant;
USE pizza_restaurant;

-- Table des restaurants
CREATE TABLE restaurants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address TEXT,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des tables/QR codes
CREATE TABLE restaurant_tables (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT NOT NULL,
    table_number VARCHAR(10) NOT NULL,
    qr_code VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(id) ON DELETE CASCADE
);

-- Table des ingrédients
CREATE TABLE ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    price DECIMAL(5,2) NOT NULL,
    category ENUM('fromage', 'viande', 'legume', 'sauce') NOT NULL,
    is_available BOOLEAN DEFAULT TRUE,
    restaurant_id INT NOT NULL,
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(id) ON DELETE CASCADE
);

-- Table des commandes
CREATE TABLE commands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    table_id INT NOT NULL,
    ingredients TEXT NOT NULL,
    total_price DECIMAL(6,2) NOT NULL,
    status ENUM('en attente', 'en preparation', 'pret', 'livree') DEFAULT 'en attente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (table_id) REFERENCES restaurant_tables(id) ON DELETE CASCADE
);

-- Insertion de données d'exemple
INSERT INTO restaurants (name, address, phone) VALUES 
('La Pizza Italienne', '123 Rue de la Pizza, Paris', '01 23 45 67 89');

INSERT INTO restaurant_tables (restaurant_id, table_number, qr_code) VALUES
(1, '1', 'http://localhost/PizzaCreator/index.php?table_id=1'),
(1, '2', 'http://localhost/PizzaCreator/index.php?table_id=2'),
(1, '3', 'http://localhost/PizzaCreator/index.php?table_id=3'),
(1, '4', 'http://localhost/PizzaCreator/index.php?table_id=4'),
(1, '5', 'http://localhost/PizzaCreator/index.php?table_id=5'),
(1, '6', 'http://localhost/PizzaCreator/index.php?table_id=6'),
(1, '7', 'http://localhost/PizzaCreator/index.php?table_id=7'),
(1, '8', 'http://localhost/PizzaCreator/index.php?table_id=8'),
(1, '9', 'http://localhost/PizzaCreator/index.php?table_id=9'),
(1, '10', 'http://localhost/PizzaCreator/index.php?table_id=10');


INSERT INTO ingredients (name, price, category, restaurant_id) VALUES
-- Fromages
('Mozzarella', 1.50, 'fromage', 1),
('Chèvre', 2.00, 'fromage', 1),
('Emmental', 1.50, 'fromage', 1),
('Bleu', 2.00, 'fromage', 1),

-- Viandes
('Jambon', 2.00, 'viande', 1),
('Pepperoni', 2.50, 'viande', 1),
('Poulet', 2.00, 'viande', 1),
('Bœuf', 2.50, 'viande', 1),

-- Légumes
('Champignons', 1.50, 'legume', 1),
('Olives', 1.50, 'legume', 1),
('Poivrons', 1.50, 'legume', 1),
('Oignons', 1.00, 'legume', 1);