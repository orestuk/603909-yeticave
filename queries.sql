
-- Create categories


INSERT INTO categories
	SET name = 'Доски и лыжи';

SET @boards_category_id = last_insert_id();

INSERT INTO categories
	SET name = 'Крепления';

SET @mounts_category_id = last_insert_id();

INSERT INTO categories
	SET name = 'Ботинки';

SET @boots_category_id = last_insert_id();

INSERT INTO categories
	SET name = 'Одежда';

SET @clothes_category_id = last_insert_id();

INSERT INTO categories
	SET name = 'Инструменты';

SET @instruments_category_id = last_insert_id();

INSERT INTO categories
	SET name = 'Разное';

SET @different_category_id = last_insert_id();

-- Create users

INSERT INTO users (name, email, password, avatar_url, contacts)
	VALUES
		('Oleg Test', 'oleg_test@test.com', 'oleg', 'oleg.jpg', 'home 1') ,
		('Ivan Test', 'ivan_test@test.com', 'ivan', 'ivan.jpg', 'home 2'),
		('Serg Test', 'serg_test@test.com', 'serg', 'serg.jpg', 'home 3');

-- Create lots

INSERT INTO lots(name, description, image_url, price,
						date_completion, bid_step, owner_id, winner_id, category_id)
	VALUES
		('2014 Rossignol District Snowboard', 'Lorem ipsum dolor sit amet, consectetur adipiscing', 'img/lot-1.jpg', 10999,
			TIMESTAMP('2018-10-25'), 100, 1, 2, @boards_category_id),
		('DC Ply Mens 2016/2017 Snowboard', 'Lorem ipsum dolor sit amet, consectetur adipiscing', 'img/lot-2.jpg', 159999,
			TIMESTAMP('2018-10-26'), 1000, 2, NULL, @boards_category_id),
		('Крепления Union Contact Pro 2015 года размер L/XL', 'Lorem ipsum dolor sit amet, consectetur adipiscing', 'img/lot-3.jpg', 8000,
			TIMESTAMP('2018-10-27'), 100, 2, NULL, @mounts_category_id),
        ('Ботинки для сноуборда DC Mutiny Charocal.', 'Lorem ipsum dolor sit amet, consectetur adipiscing', 'img/lot-4.jpg', 10999,
			TIMESTAMP('2018-11-05'), 100, 1, NULL, @boots_category_id),
		('Куртка для сноуборда DC Mutiny Charoca', 'Lorem ipsum dolor sit amet, consectetur adipiscing', 'img/lot-5.jpg', 7500,
			TIMESTAMP('2018-11-30'),  20, 2, NULL, @clothes_category_id),
        ('Маска Oakley Canopy', 'Lorem ipsum dolor sit amet, consectetur adipiscing', 'img/lot-6.jpg', 5400,
			TIMESTAMP('2018-12-05'), 10, 2, NULL, @different_category_id);

-- Create bids

INSERT INTO bids (amount, owner_id, lot_id)
	VALUES
		-- 1 lot
		(11099, 2, 1),
        (11199, 3, 1),
        (11299, 2, 1),
        -- 2 lot
        (160999, 3, 2),
        (161999, 1, 2);

-- Select all categories

SELECT * FROM categories;

-- Select new opened lots

SELECT lt.name, lt.price, lt.image_url, ct.name, MAX(bd.amount) AS last_bid_amount, COUNT(bd.id) AS bid_number
FROM lots AS lt
	INNER JOIN categories AS ct ON ct.id = lt.category_id
    INNER JOIN bids AS bd ON bd.lot_id = lt.id
WHERE lt.date_completion > current_date()
GROUP BY lt.name, lt.price, lt.image_url, ct.name;

-- Select lot by id

SET @lot_id = 1;

SELECT lt.name, lt.description, lt.price, lt.image_url, ct.name as category_name
FROM lots AS lt
	INNER JOIN categories AS ct ON ct.id = lt.category_id
WHERE lt.id = @lot_id;

-- Update lot by id

SET @lot_name = 'new lot name';

UPDATE lots
SET name = @lot_name
WHERE id = @lot_id;

-- Select bids by lot id

SELECT *
FROM bids
WHERE lot_id = @lot_id;
