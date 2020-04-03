DROP DATABASE IF EXISTS nutrition;
CREATE DATABASE IF NOT EXISTS nutrition;
USE nutrition;
CREATE TABLE IF NOT EXISTS users(
  user_id INT(64) PRIMARY KEY AUTO_INCREMENT,
  user_username VARCHAR(20) NOT NULL,
  user_email VARCHAR(40) NOT NULL,
  user_password VARCHAR(255) NOT NULL,
  user_created DATETIME,
  user_calorie_goal INT(10) DEFAULT 2000,
  user_protein_goal INT(10) DEFAULT 60
);
CREATE TABLE IF NOT EXISTS food(
  food_id INT(64) PRIMARY KEY AUTO_INCREMENT,
  user_id INT(64),
  food_name VARCHAR(40) NOT NULL,
  food_serving_unit VARCHAR(40),
  food_serving_base DOUBLE(10, 2),
  food_serving_quantity DOUBLE(10, 2),
  food_calories DOUBLE(10, 2),
  food_fat DOUBLE(10, 2),
  food_salt DOUBLE(10, 2),
  food_protein DOUBLE(10, 2),
  food_total_carbohydrates DOUBLE(10, 2),
  food_sugar DOUBLE(10, 2),
  food_added DATETIME,
  CONSTRAINT FK_food_user_id FOREIGN KEY (user_id) REFERENCES users(user_id)
);
-- Nutrition values for meal are multiplied by the serving quantity
CREATE VIEW calculated_nutrition AS
SELECT
  food_id,
  user_id,
  food_name,
  food_serving_unit,
  food_serving_base,
  food_serving_quantity,
  (food_calories * food_serving_quantity) AS 'calories',
  (food_fat * food_serving_quantity) AS 'fat',
  (food_salt * food_serving_quantity) AS 'salt',
  (food_protein * food_serving_quantity) AS 'protein',
  (food_total_carbohydrates * food_serving_quantity) AS 'carbohydrates',
  (food_sugar * food_serving_quantity) AS 'sugar',
  food_added
FROM food;
INSERT INTO users
VALUES
  (
    1,
    'BenRose',
    'benrose11@hotmail.co.uk',
    '$2y$10$naNcGrRr8sWT.590d1BFNOl4WhsH2flRidVkSfh8srR10KkOJhgQy',
    '2020-02-12 13:14:03',
    2000,
    60
  );
INSERT INTO users
VALUES
  (
    2,
    'Test',
    'test@test.com',
    '$2y$10$naNcGrRr8sWT.590d1BFNOl4WhsH2flRidVkSfh8srR10KkOJhgQy',
    '2020-02-12 13:14:03',
    2000,
    60
  );
-- Insert example foods (today)
INSERT INTO `food` (
    user_id,
    food_name,
    food_serving_unit,
    food_serving_base,
    food_serving_quantity,
    food_calories,
    food_fat,
    food_salt,
    food_protein,
    food_total_carbohydrates,
    food_sugar,
    food_added
  )
VALUES
  (
    1,
    'bread',
    'slice',
    1.00,
    4.00,
    77.14,
    0.97,
    142.10,
    2.57,
    14.33,
    1.64,
    NOW()
  ),
  (
    1,
    'whiskey',
    'shot',
    1.00,
    4.00,
    97.02,
    0.00,
    0.42,
    0.00,
    0.00,
    0.00,
    NOW()
  ),
  (
    1,
    'toast',
    'slice',
    1.00,
    5.00,
    63.80,
    0.88,
    118.14,
    1.98,
    11.99,
    1.36,
    NOW()
  );
-- Insert example foods (Today -1)
INSERT INTO `food` (
    user_id,
    food_name,
    food_serving_unit,
    food_serving_base,
    food_serving_quantity,
    food_calories,
    food_fat,
    food_salt,
    food_protein,
    food_total_carbohydrates,
    food_sugar,
    food_added
  )
VALUES
  (
    1,
    'banana',
    'medium',
    7.00,
    2.00,
    735.14,
    2.73,
    8.26,
    9.00,
    188.66,
    101.02,
    NOW() - INTERVAL 1 DAY
  ),
  (
    1,
    'cereal bar',
    'bar',
    1.00,
    1.00,
    126.54,
    0.33,
    5.92,
    2.18,
    28.71,
    16.74,
    NOW() - INTERVAL 1 DAY
  ),
  (
    1,
    'chicken',
    'oz',
    3.00,
    1.00,
    187.00,
    11.11,
    60.35,
    20.37,
    0.04,
    0.00,
    NOW() - INTERVAL 1 DAY
  );

  -- Insert example foods (Today -2)
INSERT INTO `food` (
    user_id,
    food_name,
    food_serving_unit,
    food_serving_base,
    food_serving_quantity,
    food_calories,
    food_fat,
    food_salt,
    food_protein,
    food_total_carbohydrates,
    food_sugar,
    food_added
  )
VALUES
  (
    1,
    'banana',
    'medium',
    7.00,
    2.00,
    735.14,
    2.73,
    8.26,
    9.00,
    188.66,
    101.02,
    NOW() - INTERVAL 2 DAY
  ),
  (
    1,
    'cereal bar',
    'bar',
    1.00,
    1.00,
    126.54,
    0.33,
    5.92,
    2.18,
    28.71,
    16.74,
    NOW() - INTERVAL 2 DAY
  ),
  (
    1,
    'chicken',
    'oz',
    3.00,
    1.00,
    187.00,
    11.11,
    60.35,
    20.37,
    0.04,
    0.00,
    NOW() - INTERVAL 2 DAY
  );