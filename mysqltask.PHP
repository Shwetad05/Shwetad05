Database Details 

   CREATE TABLE Customers (
    customer_id INT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(100),
    address VARCHAR(200),
    city VARCHAR(50),
    state VARCHAR(50),
    zip VARCHAR(10)
);


CREATE TABLE Products (
    product_id INT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2),
    inventory INT
);

CREATE TABLE Orders (
    order_id INT PRIMARY KEY,
    customer_id INT,
    order_date DATETIME,
    total DECIMAL(10,2),
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id)
);

CREATE TABLE Order_Items (
    order_id INT,
    product_id INT,
    quantity INT,
    price DECIMAL(10,2),
    PRIMARY KEY (order_id, product_id),
    FOREIGN KEY (order_id) REFERENCES Orders(order_id),
    FOREIGN KEY (product_id) REFERENCES Products(product_id)
);
 




Data


INSERT INTO Customers VALUES
(1, 'John', 'Doe', 'mailto:john.doe@example.com', '123 Main St', 'Anytown', 'CA', '12345'),
(2, 'Jane', 'Smith', 'mailto:jane.smith@example.com', '456 Oak Ave', 'Somecity', 'NY', '54321'),
(3, 'Bob', 'Johnson', 'mailto:bob.johnson@example.com', '789 Elm St', 'Othercity', 'TX', '67890');

INSERT INTO Products VALUES
(1, 'Widget', 'A widget for doing things', 10.99, 100),
(2, 'Thingamabob', 'A thingamabob for doing other things', 24.99, 50),
(3, 'Gizmo', 'A gizmo for doing yet more things', 19.99, 75);

INSERT INTO Orders VALUES
(1, 1, '2022-01-01 10:00:00', 10.99),
(2, 1, '2022-01-02 11:00:00', 35.98),
(3, 2, '2022-01-03 12:00:00', 19.99),
(4, 3, '2022-01-04 13:00:00', 54.97);

INSERT INTO Order_Items VALUES
(1, 1, 1, 10.99),
(2, 1, 2, 10.99),
(2, 2, 1, 24.99),
(3, 3, 1, 19.99),
(4, 1, 2, 21.98),
(4, 2, 1, 24.99),
(4, 3, 1, 7.00);






QUESTIONS:

1.Show all customers in the database.

=> SELECT * FROM `customers`;

2.Show all products in the database.

=> SELECT * FROM `products`;

3.Show all orders in the database.

=> SELECT * FROM `orders`;

4.Show all order items in the database.

=> SELECT * FROM `order_items`

5.Show the customer with ID 1.

=> SELECT * FROM `mart`.`customers` WHERE `customer_id` = 1;

6.Show the product with ID 2.

=> SELECT * FROM `mart`.`products` WHERE `product_id` = 2;

7. Show the order with ID 3.

=> SELECT * FROM `mart`.`orders` WHERE `order_id` = 3;

8. Show the order item for order ID 1 and product ID 1.

=> SELECT * FROM `mart`.`order_items` WHERE `product_id` = 1 and `order_id`=1;

9.Show the total number of customers in the database.

=> SELECT COUNT(*) FROM customers`customers`;

10.Show the total number of products in the database.

=> SELECT COUNT(*) FROM products`products`;

11.Show the total number of orders in the database.

=> SELECT COUNT(*) FROM orders`orders`;

12.Show the total number of order items in the database.

=>SELECT COUNT(*) FROM order_items`order_items`;

13.Show the average price of products in the database.

=>SELECT AVG(price) FROM products`products`;

14.Show the maximum price of products in the database.

=>SELECT MAX(price) FROM products`products`;

15.Show the minimum price of products in the database.

=>SELECT MIN(price) FROM products`products`;

16.Show the total inventory of all products.

=>SELECT SUM(inventory) FROM products`products`;
  SELECT COUNT(*) FROM products`inventory`;

17.Show the orders for customer with ID 2.

=>SELECT * FROM `orders` WHERE `customer_id` = 2;

18.Show the order items for order with ID 4.

=>SELECT * FROM `order_items` WHERE `order_id` = 4;

19.Show the total amount spent by customer with ID 1.

=> SELECT SUM(total) FROM `orders` WHERE `customer_id` = 1;

20.Show the total number of order items for order with ID 2.

=> SELECT COUNT(*) FROM `order_items` WHERE `order_id` = 2;

21.Show the product with the highest price.

=>SELECT product_id, name, MAX(price) FROM products;

22.Show the customer who has spent the most money.

=>SELECT first_name,last_name, SUM(total) as total_spent FROM customers,orders GROUP BY first_name,last_name ORDER BY total_spent DESC LIMIT 1;

23.Show the customer who has placed the most orders.

=> SELECT customer_id,first_name,last_name ,MAX(quantity) FROM order_items,customers;

24.Show the product with the most inventory.

=>SELECT product_id, name, MAX(inventory) FROM products;

25.Show the order with the highest total.

=>SELECT order_id, MAX(total) FROM orders;

26.Show the total revenue for the month of January 2022.

=> SELECT SUM(total) FROM orders WHERE order_date LIKE '2022-01-%';  
    or
   SELECT SUM(total) FROM Orders WHERE MONTH(order_date) = 1 AND YEAR(order_date) = 2022;

27.Show the total revenue for each month in 2022.

=> SELECT order_id,customer_id,order_date,SUM(total) AS 'TOTAL_REVENUE' FROM orders GROUP BY MONTH(order_date);
   or  
   SELECT MONTH(order_date) AS month, SUM(total) AS revenue
FROM Orders
WHERE YEAR(order_date) = 2022
GROUP BY MONTH(order_date);

28.Show the average total spent per order.

=>SELECT AVG(total) FROM orders WHERE order_id IN ('1,2,3');

29.Show the average price of products with more than 50 units in inventory.

=> SELECT AVG(price) FROM `products` WHERE inventory>50;

30.Show the number of orders placed each day in January 2022.

=>SELECT order_date,COUNT(quantity) AS 'ORDERS_PLACED' FROM order_items,orders GROUP BY DAY(order_date);
  SELECT order_id,COUNT(quantity) AS 'ORDERS_PLACED' FROM order_items GROUP BY order_id;      /////(to find no. of orders placed by particular id)
or  
SELECT DATE(order_date) AS date, COUNT(*) AS order_count
FROM Orders
WHERE MONTH(order_date) = 1 AND YEAR(order_date) = 2022
GROUP BY DATE(order_date);


31.Show the number of orders placed each hour of the day.

=> SELECT HOUR(order_date) AS hour_of_day, COUNT(*) AS num_orders FROM orders GROUP BY hour_of_day;

32.Show the number of orders placed on each day of the week.

=>SELECT DATE(order_date) AS order_day, COUNT(quantity) AS order_placed_per_day FROM order_items,orders GROUP BY DAYNAME(order_day);

33.Show the top 5 customers by total amount spent.

=> SELECT first_name,last_name, SUM(total) AS total_spent FROM orders,customers GROUP BY first_name,last_name ORDER BY total_spent DESC LIMIT 5;

34.Show the top 5 products by total revenue.

=> SELECT product_id, SUM(total) AS total_revenue FROM order_items GROUP BY product_id ORDER BY total_revenue DESC LIMIT 5;

35.Show the customers who have never placed an order.

=> SELECT mart.customers.customer_id, first_name FROM customers LEFT JOIN orders ON customers.customer_id = orders.customer_id 
WHERE orders.order_id IS NULL;

36.Show the products that have never been ordered.

=>SELECT products.product_id, products.name FROM products LEFT JOIN order_items ON products.product_id = order_items.product_id 
WHERE order_items.order_id IS NULL;

37.Show the customers who have placed more than 2 orders.

=> SELECT first_name,last_name, COUNT(*) AS num_orders FROM orders,customers GROUP BY first_name,last_name HAVING num_orders > 2;

38.Show the products that have a price between $10 and $20.

=> SELECT * FROM products WHERE price BETWEEN 10 AND 20;

39.Show the orders placed in the month of January 2022, sorted by order date.

=> SELECT * FROM orders WHERE MONTH(order_date) = 1 AND YEAR(order_date) = 2022 ORDER BY order_date;

40.Show the order items for the order placed on January 2, 2022.

=> SELECT * FROM order_items WHERE order_id IN ( SELECT order_id FROM orders WHERE order_date = '2022-01-02' );

41.Show the orders placed by customer with ID 1, sorted by order date.

=> SELECT * FROM orders WHERE customer_id = 1 ORDER BY order_date;

42.Show the customer who has placed the most orders in January 2022.

=> SELECT customer_id, COUNT(*) as num_orders FROM orders WHERE MONTH(order_date) = 1 AND YEAR(order_date) = 2022 
GROUP BY customer_id ORDER BY num_orders DESC LIMIT 1;

43.Show the products that have been ordered at least once, sorted by product name.

=>SELECT * FROM products WHERE product_id IN ( SELECT product_id FROM order_items ) ORDER BY name;

44.Show the customers who live in California or Texas.

=>SELECT * FROM customers WHERE state IN ('CA', 'TX');

45.Show the orders that were placed on January 1, 2022, and have a total greater than $20.

=>SELECT * FROM orders WHERE order_date = '2022-01-01' AND order_id IN ( SELECT order_id FROM order_items 
GROUP BY order_id HAVING SUM(total) > 20 );

46.Show the products that have less than 10 units in inventory.

=>SELECT * FROM products WHERE inventory < 10;

47.Show the customers who have spent more than $100.

=>SELECT customers.customer_id, customers.first_name, customers.last_name, SUM(total) AS total_spent FROM customers
 JOIN orders ON customers.customer_id = orders.customer_id JOIN order_items ON orders.order_id = order_items.order_id 
 GROUP BY customers.customer_id HAVING total_spent > 100;

48.Show the customers who have an email address that ends with '@example.com'.

=>SELECT * FROM customers WHERE email LIKE '%@example.com';

49.Show the orders placed by customers who live in New York.

=>SELECT * FROM orders WHERE customer_id IN ( SELECT customer_id FROM customers WHERE state = 'NY' );
                            or
  SELECT * FROM orders,customers WHERE state = 'NY';

50.Show the products that have been ordered at least 5 times, sorted by total revenue.

=>SELECT products.product_id, products.name, SUM(order_items.quantity) AS total_quantity_ordered, 
SUM(order_items.price * order_items.quantity) AS total_revenue FROM products INNER JOIN order_items 
ON products.product_id = order_items.product_id GROUP BY products.product_id, products.name HAVING total_quantity_ordered >= 5
 ORDER BY total_revenue DESC;

































