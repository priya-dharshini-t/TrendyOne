-- Create the `users` table
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

-- Create the `products` table
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  category VARCHAR(50) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  image VARCHAR(255) NOT NULL
);

-- Insert a sample user (Note: In real use, passwords should be hashed!)
INSERT INTO users (name, email, password) VALUES
('Priya', 'priya@gmail.com', '$2y$10$examplehashvaluefakepassword'); -- Example hashed password

-- Insert sample products
INSERT INTO products (name, category, price, image) VALUES
('Classic White Tee', 'T-Shirt', 399.00, 'white-tshirt.jpg'),
('Graphic Black Tee', 'T-Shirt', 499.00, 'black-tshirt1.jpg'),
('Teal Collar Tee', 'T-Shirt', 499.00, 'tealcollar-tshirt.jpg'),
('SandStone Orange Tee', 'T-Shirt', 499.00, 'sandstoneorange-tshirt.jpg'),
('Oversized Round Neck Tee', 'T-Shirt', 499.00, 'oversizedroundneck-tshirt.jpg'),
('Oversized Tee', 'T-Shirt', 499.00, 'oversized-tshirt.jpg'),
('Olive Printed Tee', 'T-Shirt', 499.00, 'oliveprinted-tshirt.jpg'),
('Plain Maroon Tee', 'T-Shirt', 499.00, 'maroon-tshirt.jpg'),
('Chain White Tee', 'T-Shirt', 499.00, 'chainwhite-tshirt.jpg'),
('Plain Navy-Blue Tee', 'T-Shirt', 499.00, 'navy-blue.jpg'),




('Formal White Shirt', 'Shirts', 899.00, 'whiteshirt.jpg');
('Summer leaf Shirt', 'Shirts', 89.00, 'summershirt.jpg');
('Royal Red Shirt', 'Shirts', 899.00, 'royalredshirt.jpg');
('Shirt and Pant Combo', 'Shirts', 899.00, 'shirtandpant.jpg');
('White Casual Shirt', 'Shirts', 899.00, 'whitecasualshirt.jpg');
('Sky Blue Shirt', 'Shirts', 899.00, '-shirt.jpg');
('Polycotton Halfsleve Shirt', 'Shirts', 899.00, '-shirt.jpg');
('Pastal Pink Shirt', 'Shirts', 899.00, '-shirt.jpg');
('Printed Collar Shirt', 'Shirts', 899.00, '-shirt.jpg');
('Classic Black Shirt', 'Shirts', 899.00, 'blackshirt.jpg');
('Aqua Blue Shirt', 'Shirts', 899.00, 'aquashirt.jpg');
('Gold Patoo Shirt', 'Shirts', 899.00, '-shirt.jpg');
('Green Lining Print Shirt', 'Shirts', 899.00, 'liningprint.jpg');
('Creamy Shirt', 'Shirts', 899.00, 'creamshirt.jpg');



('Slim Fit Blue Jeans', 'Jeans', 999.00, 'blue-jeans.jpg'),
('Ripped Black Jeans', 'Jeans', 1099.00, 'black-jeans.jpg'),

('White Sneakers', 'Shoes', 1499.00, 'white-shoes.jpg'),
('Running Shoes', 'Shoes', 1699.00, 'running-shoes.jpg'),



('Aviator Shades', 'Glasses', 799.00, 'aviator.jpg'),
('Unisex Hexagon Glasses', 'Glasses', 699.00, 'unisexhexagonglass.jpg'),
('Round Retro Glasses', 'Glasses', 699.00, 'unbreakablesportglass.jpg'),
('Round Retro Glasses', 'Glasses', 699.00, 'squareglass.jpg'),
('Round Retro Glasses', 'Glasses', 699.00, 'rectangleretronarrowglass.jpg'),
('Round Retro Glasses', 'Glasses', 699.00, 'squarecateyeglass.jpg'),
('Round Retro Glasses', 'Glasses', 699.00, 'roundpolaruvglass.jpg'),
('Round Retro Glasses', 'Glasses', 699.00, 'round-glasses.jpg'),
('Round Retro Glasses', 'Glasses', 699.00, 'retrorectangleglass.jpg'),
('Round Retro Glasses', 'Glasses', 699.00, 'pilotglass.jpg'),
('Round Retro Glasses', 'Glasses', 699.00, 'nightdriveglass.jpg'),
('Round Retro Glasses', 'Glasses', 699.00, 'Moneyheistglass.jpg'),
('Round Retro Glasses', 'Glasses', 699.00, 'lightweightmattfinishglass.jpg'),
('Round Retro Glasses', 'Glasses', 699.00, 'drivingpilotgradientglass.jpg'),
('Round Retro Glasses', 'Glasses', 699.00, 'autofocusreadingglass.jpg'),
('Round Retro Glasses', 'Glasses', 699.00, 'aviator.jpg'),
('Round Retro Glasses', 'Glasses', 699.00, 'blackjonesglass.jpg'),
('Round Retro Glasses', 'Glasses', 699.00, 'combooffer5glass.jpg'),
('Round Retro Glasses', 'Glasses', 699.00, 'drivingglass.jpg'),



('Analog Leather Watch', 'Watch', 899.00, 'analog.jpg'),
('Digital Sports Watch', 'Watch', 1199.00, 'digital.jpg'),


('Wine Slimfit Waist Coat', 'Suits and Blazers', 1999.00, 'wineslimfitwaistcoat.jpg'),
('V-shape Suit', 'Suits and Blazers', 1999.00, 'vshapesuit.jpg'),
('Wine Slimfit Waist Coat', 'Suits and Blazers', 1999.00, 'stylepartyblazer.jpg'),
('Wine Slimfit Waist Coat', 'Suits and Blazers', 1999.00, 'purplesuit.jpg'),
('Wine Slimfit Waist Coat', 'Suits and Blazers', 1999.00, 'peacockblueblazer.jpg'),
('Wine Slimfit Waist Coat', 'Suits and Blazers', 1999.00, 'kingformalcoatsuitset.jpg'),
('Wine Slimfit Waist Coat', 'Suits and Blazers', 1999.00, 'greybusinesssuit.jpg'),
('Wine Slimfit Waist Coat', 'Suits and Blazers', 1999.00, 'peacockblueblazer.jpg'),
('Wine Slimfit Waist Coat', 'Suits and Blazers', 1999.00, 'blacklapelcollarcoatsuit.jpg'),
('Wine Slimfit Waist Coat', 'Suits and Blazers', 1999.00, 'lightbluesuit.jpg'),
('Wine Slimfit Waist Coat', 'Suits and Blazers', 1999.00, 'classicblackblazer.jpg'),

