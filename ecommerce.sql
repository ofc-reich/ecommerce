orders

CREATE TABLE orders ( id INT PRIMARY KEY AUTO_INCREMENT, user_id INT, order_date DATE, total DECIMAL(10, 2), product_id INT, product_name VARCHAR(255), product_price DECIMAL(10, 2), quantity INT, product_image VARCHAR(255), FOREIGN KEY (user_id) REFERENCES cart(id), FOREIGN KEY (product_id) REFERENCES products(id) )


sold

CREATE TABLE sold ( id INT PRIMARY KEY AUTO_INCREMENT, order_id INT, product_id INT, product_name VARCHAR(255), product_price DECIMAL(10, 2), quantity INT, total DECIMAL(10, 2), sold_date DATE, FOREIGN KEY (order_id) REFERENCES orders(id), FOREIGN KEY (product_id) REFERENCES products(id) )127.0.0.1/ecommerce/sold/		http://localhost/phpmyadmin/index.php?route=/table/sql&db=ecommerce&table=sold
Your SQL query has been executed successfully.

SHOW CREATE TABLE orders;



orders	CREATE TABLE `orders` (
  `id` int(11) NOT NULL AU...	
