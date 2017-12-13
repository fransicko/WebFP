DROP TABLE IF EXISTS hash, orders, customers, products;

CREATE TABLE customers (
	customerID serial,
	firstName varchar(255) NOT NULL,
	lastName varchar(255) NOT NULL,
	email varchar(255) NOT NULL,
	PRIMARY KEY (customerID)
);

CREATE TABLE products (
	productID serial,
	name varchar(255) NOT NULL,
	price int NOT NULL,
	image text NOT NULL,
	prodType varchar(255) NOT NULL,
	stock int,
	PRIMARY KEY (productID)
);

CREATE TABLE orders (
	orderID int NOT NULL,
	productID BIGINT UNSIGNED NOT NULL,
	customerID BIGINT UNSIGNED NOT NULL,
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

/*	Hash table for users	*/
CREATE TABLE hash (
	customerID BIGINT UNSIGNED NOT NULL,
	salt varchar(255) NOT NULL,
	hash varchar(255) NOT NULL,
	FOREIGN KEY (customerID) REFERENCES customers(customerID)
);

-- Insert items into products.  'Image' will store the value for the <option> within the html.
-- This is because selection of images is defined in a .js which uses the value in <option>

-- The Chicago Typewriter from Resident Evil 4
INSERT INTO products(name, price, image, prodType, stock)
VALUES ('Chicago Typewriter', 1000000, 'typewriter', 'Men', 10);

-- The Apple Gel from Tales of Symphonia
INSERT INTO products(name, price, image, prodType, stock)
VALUES ('Apple Gel', 225, 'apple', 'Men', 99);

-- The Phoenix Down from Final Fantasy
INSERT INTO products(name, price, image, prodType, stock)
VALUES ('Phoenix Down', 515, 'phoenix', 'Women', 99);

-- An Iron Helmet from the The Elder Scrolls series
INSERT INTO products(name, price, image, prodType, stock)
VALUES ('Iron Helmet', 122, 'helmet', 'Child', 15);

/*	Insert a test customer	*/
INSERT INTO customers(firstName, lastName, email)
VALUES ('test', 'test', 'test@gmail.com');

INSERT INTO hash(customerID, salt, hash)
VALUES (1, 'salt', 'salSp1wOPp6fk');