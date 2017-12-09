DROP TABLE IF EXISTS orders, customers, products;

CREATE TABLE customers (
	customerID int NOT NULL,
	firstName varchar(255) NOT NULL,
	lastName varchar(255) NOT NULL,
	email varchar(255) NOT NULL,
	PRIMARY KEY (customerID)
);

CREATE TABLE products (
	productID int NOT NULL,
	name varchar(255) NOT NULL,
	price int NOT NULL,
	image text NOT NULL,
	game varchar(255) NOT NULL,
	stock int,
	PRIMARY KEY (productID)
);

CREATE TABLE orders (
	orderID int NOT NULL,
	productID int NOT NULL,
	customerID int NOT NULL,
	quantity int NOT NULL,
	tax float NOT NULL,
	donation float NOT NULL,
	subtotal double NOT NULL,
	total double NOT NULL,
	time text NOT NULL,
	FOREIGN KEY (productID) REFERENCES products(productID),
	FOREIGN KEY (customerID) REFERENCES customers(customerID),
	PRIMARY KEY (orderID)
);

-- Insert items into products.  'Image' will store the value for the <option> within the html.
-- This is because selection of images is defined in a .js which uses the value in <option>

-- The Chicago Typewriter from Resident Evil 4
INSERT INTO products
VALUES (1, 'Chicago Typewriter', 1000000, 'typewriter', 're4', 10);

-- The Apple Gel from Tales of Symphonia
INSERT INTO products
VALUES (2, 'Apple Gel', 225, 'apple', 'tos', 99);

-- The Phoenix Down from Final Fantasy
INSERT INTO products
VALUES (3, 'Phoenix Down', 515, 'phoenix', 'ff', 99);

-- An Iron Helmet from the The Elder Scrolls series
INSERT INTO products
VALUES (4, 'Iron Helmet', 122, 'helmet', 'tes', 15);