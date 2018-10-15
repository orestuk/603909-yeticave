CREATE DATABASE IF NOT EXISTS YetiCave;

USE YetiCave;

CREATE TABLE  categories (
	id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name  VARCHAR( 50) UNIQUE
);

CREATE TABLE lots (
	id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name  VARCHAR( 50) NOT NULL,
    date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    description VARCHAR(255) NOT NULL,
    image_url VARCHAR(100) NOT NULL,
    price INT NOT NULL,
    date_completion TIMESTAMP NOT NULL,
    
    bid_step INT DEFAULT 0,

    owner_id INT NOT NULL,
    winner_id INT,
    category_id INT NOT NULL
);

CREATE TABLE bids (
	id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    amount INT NOT NULL,

	owner_id INT NOT NULL,
    lot_id INT NOT NULL
);

CREATE TABLE users (
	id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name  VARCHAR(60) NOT NULL,
  date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  email VARCHAR(60),
  password VARCHAR(255),
  avatar_url VARCHAR(100),
  contacts VARCHAR(255)
);

CREATE UNIQUE INDEX email ON users(email);

CREATE INDEX lot_name ON lots(name);

CREATE INDEX lot_description ON lots(description);

CREATE INDEX lot_owner_id ON lots(owner_id);

CREATE INDEX lot_winner_id ON lots(winner_id);

CREATE INDEX lot_category_id ON lots(category_id);

CREATE INDEX bid_owner_id ON bids(owner_id);

CREATE INDEX bid_lot_id ON bids(lot_id);


