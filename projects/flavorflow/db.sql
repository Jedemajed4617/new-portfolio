CREATE TABLE dishes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    pfp VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO dishes (name, category, price, description, image) VALUES
-- Pasta Dishes
('Spaghetti Bolognese', 'Pasta', 12.50, 'Classic Italian pasta with a rich bolognese sauce.', '/img/food.webp'),
('Fettuccine Alfredo', 'Pasta', 13.00, 'Creamy alfredo sauce with fettuccine pasta.', '/img/food.webp'),
('Penne Arrabiata', 'Pasta', 11.00, 'Spicy tomato sauce served over penne.', '/img/food.webp'),
('Lasagna', 'Pasta', 14.50, 'Layers of pasta, beef, ricotta, and mozzarella.', '/img/food.webp'),
('Pesto Linguine', 'Pasta', 12.00, 'Linguine tossed in a fresh basil pesto.', '/img/food.webp'),
('Ravioli in Tomato Sauce', 'Pasta', 12.75, 'Cheese-filled ravioli served with a tangy tomato sauce.', '/img/food.webp'),

-- Pizza Dishes
('Margherita Pizza', 'Pizza', 9.99, 'Pizza with fresh mozzarella, basil, and tomatoes.', '/img/food.webp'),
('Pepperoni Pizza', 'Pizza', 11.50, 'Classic pepperoni pizza with melted mozzarella.', '/img/food.webp'),
('BBQ Chicken Pizza', 'Pizza', 13.00, 'Pizza topped with BBQ sauce, grilled chicken, and onions.', '/img/food.webp'),
('Vegetarian Pizza', 'Pizza', 10.99, 'Pizza topped with mushrooms, bell peppers, and olives.', '/img/food.webp'),
('Four Cheese Pizza', 'Pizza', 12.00, 'A mix of mozzarella, cheddar, gorgonzola, and parmesan.', '/img/food.webp'),
('Hawaiian Pizza', 'Pizza', 11.75, 'Pizza topped with ham and pineapple.', '/img/food.webp'),

-- Salad Dishes
('Chicken Caesar Salad', 'Salad', 8.99, 'Romaine, parmesan, grilled chicken, and Caesar dressing.', '/img/food.webp'),
('Greek Salad', 'Salad', 7.50, 'Cucumbers, tomatoes, olives, and feta cheese.', '/img/food.webp'),
('Caprese Salad', 'Salad', 8.25, 'Fresh mozzarella, tomatoes, and basil, drizzled with balsamic.', '/img/food.webp'),
('Cobb Salad', 'Salad', 10.00, 'Mixed greens with bacon, egg, avocado, and blue cheese.', '/img/food.webp'),
('Quinoa Salad', 'Salad', 9.50, 'Quinoa, chickpeas, cucumbers, and a lemon vinaigrette.', '/img/food.webp'),
('Spinach and Strawberry Salad', 'Salad', 8.00, 'Baby spinach, strawberries, goat cheese, and pecans.', '/img/food.webp'),

-- Seafood Dishes
('Grilled Salmon', 'Seafood', 15.99, 'Grilled salmon served with a side of vegetables.', '/img/food.webp'),
('Fish Tacos', 'Seafood', 12.50, 'Three tacos filled with grilled fish, cabbage, and lime sauce.', '/img/food.webp'),
('Shrimp Scampi', 'Seafood', 14.75, 'Shrimp sautéed in a garlic butter sauce with pasta.', '/img/food.webp'),
('Lobster Bisque', 'Seafood', 16.50, 'Creamy lobster bisque with a hint of sherry.', '/img/food.webp'),
('Crab Cakes', 'Seafood', 14.25, 'Two crab cakes served with a tangy remoulade.', '/img/food.webp'),
('Clam Chowder', 'Seafood', 10.99, 'New England-style clam chowder with potatoes and cream.', '/img/food.webp'),

-- Mexican Dishes
('Beef Tacos', 'Mexican', 10.50, 'Three soft tacos filled with seasoned beef and toppings.', '/img/food.webp'),
('Chicken Quesadilla', 'Mexican', 9.99, 'Grilled tortilla filled with chicken and cheese.', '/img/food.webp'),
('Burrito Bowl', 'Mexican', 11.75, 'Bowl with rice, beans, chicken, and salsa.', '/img/food.webp'),
('Vegetarian Enchiladas', 'Mexican', 12.00, 'Corn tortillas stuffed with vegetables and cheese.', '/img/food.webp'),
('Carnitas Tacos', 'Mexican', 11.50, 'Slow-cooked pork tacos with cilantro and onions.', '/img/food.webp'),
('Churros', 'Mexican', 6.00, 'Fried dough dusted with cinnamon sugar, served with chocolate.', '/img/food.webp');
