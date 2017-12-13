DROP TABLE IF EXISTS hash, orders, cart, customers, products;

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

CREATE TABLE cart (
	cartID serial,
	productID BIGINT UNSIGNED NOT NULL,
	customerID BIGINT UNSIGNED NOT NULL,
	FOREIGN KEY (productID) REFERENCES products(productID),
	FOREIGN KEY (customerID) REFERENCES customers(customerID),
	PRIMARY KEY (cartID)
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

-- Insert items into products.  'Image' will store the location for the img within the html.

INSERT INTO products(name, price, image, prodType, stock)
VALUES ("Bird Dress - Kids", 5.99, "birdDress.jpg", "child", 10);

INSERT INTO products(name, price, image, prodType, stock)
VALUES ("Black Dress (Short) - Women", 15.99, "blackDress1.jpg", "women", 250);

INSERT INTO products(name, price, image, prodType, stock)
VALUES ("Bird Dress (Long) - Women", 15.99, "blackDress2.jpg", "women", 5);

INSERT INTO products(name, price, image, prodType, stock)
VALUES ("Blue Shirt with Cardigan - Women", 19.99, "blueShirt1.jpg", "women", 10);

INSERT INTO products(name, price, image, prodType, stock)
VALUES ("Blue Long-sleeve Shirt - Women", 10.99, "blueShirt2.jpg", "women", 200);

INSERT INTO products(name, price, image, prodType, stock)
VALUES ("Blue Polo - Men", 5.99, "blueShirt3.jpg", "men", 100);

INSERT INTO products(name, price, image, prodType, stock)
VALUES ("Bunny Outfit - Women", 70.99, "bunny.jpg", "women", 2);

INSERT INTO products(name, price, image, prodType, stock)
VALUES ("Grey-stripe Tanktop - Kids", 7.99, "greyTank.jpg", "child", 25);

INSERT INTO products(name, price, image, prodType, stock)
VALUES ("Perfect Day T-Shirt - Kids", 10.99, "kids3.jpg", "child", 30);

INSERT INTO products(name, price, image, prodType, stock)
VALUES ("Penguin Sweater - Kids", 15.99, "pengSweater.jpg", "child", 20);

INSERT INTO products(name, price, image, prodType, stock)
VALUES ("Red Dress - Women", 30.99, "redDress.jpg", "women", 15);

INSERT INTO products(name, price, image, prodType, stock)
VALUES ("White Dress - Women", 15.99, "whiteDress.jpg", "women", 10);

INSERT INTO products(name, price, image, prodType, stock)
VALUES ("White Shirt - Women", 7.99, "whiteTop.jpg", "women", 20);

/*	Insert a test customer	*/
INSERT INTO customers(firstName, lastName, email)
VALUES ('test', 'test', 'test@gmail.com');

INSERT INTO hash(customerID, salt, hash)
VALUES (1, 'salt', 'salSp1wOPp6fk');