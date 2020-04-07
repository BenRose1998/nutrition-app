<?php
require_once('includes/connect.php');

// Only starts a session if there isn't already an active session
if (session_status() != PHP_SESSION_ACTIVE) {
  session_start();
}

if (!isset($_SESSION['user_id'])) {
  redirect('index.php');
}

if (isset($_GET['type'])) {
  switch ($_GET['type']) {
    case 'addFood':
      addFood($pdo);
      break;
    case 'getNutrition':
      getNutrition($pdo);
      break;
    case 'weeklyCalories':
      weeklyFood($pdo, "calories");
      break;
    case 'weeklyProtein':
      weeklyFood($pdo, "protein");
      break;
    case 'weeklyNutrition':
      weeklyFood($pdo, "carbohydrates, protein, fat, salt, sugar");
      break;
    default:
      echo 'Bad Request';
      break;
  }
} else {
  echo 'Bad Request';
}

function addFood($pdo)
{
  if (isset($_POST) && !empty($_POST)) {
    // Store values
    $user_id = $_SESSION['user_id'];
    $food_name = $_POST['name'];
    $food_serving_unit = $_POST['serving_unit'];
    $food_serving_base = $_POST['serving_base'];
    $food_serving_quantity = $_POST['serving_quantity'];
    $food_calories = $_POST['calories'];
    $food_fat = $_POST['fat'];
    $food_salt = $_POST['salt'];
    $food_protein = $_POST['protein'];
    $food_total_carbohydrates = $_POST['carbohydrates'];
    $food_sugar = $_POST['sugar'];
    $food_added = date('Y-m-d H:i:s');

    // Query
    // User's data is inserted into the database
    $sql = 'INSERT INTO food (user_id, food_name, food_serving_unit, food_serving_base, food_serving_quantity, food_calories, food_fat, food_salt, food_protein, food_total_carbohydrates, food_sugar, food_added) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

    // Prepare and execute statement
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $food_name, $food_serving_unit, $food_serving_base, $food_serving_quantity, $food_calories, $food_fat, $food_salt, $food_protein, $food_total_carbohydrates, $food_sugar, $food_added]);
    echo 'Food added';
  }
}

function getNutrition($pdo)
{
  // Store user id
  $user_id = $_SESSION['user_id'];

  // Get totals of all food items for current date for a specific user 
  $sql = "SELECT SUM(calories) AS 'calories', SUM(protein) AS 'protein', SUM(carbohydrates) AS 'carbohydrates', SUM(fat) AS 'fat', SUM(sugar) AS 'sugar', SUM(salt) AS 'salt', user_calorie_goal AS 'calorie_goal', user_protein_goal AS 'protein_goal'
          FROM users
          INNER JOIN calculated_nutrition ON users.user_id = calculated_nutrition.user_id
          WHERE users.user_id = ?
          AND DATE(food_added) = CURDATE()";

  // Prepare and execute statement
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$user_id]);
  // Saves result in object
  $nutrition = $stmt->fetch();

  if ($nutrition) {
    print_r(json_encode($nutrition));
  }
}

// Return a list of specific nutritional values (e.g. protein) of all food items for a user in a week
function weeklyFood($pdo, $type){
  // Store user id
  $user_id = $_SESSION['user_id'];

  // Gets total (e.g. calorie) values for all food items for a user over a week
  $sql = "SELECT " . $type . ", DATE(food_added) AS 'food_added'
          FROM users
          INNER JOIN calculated_nutrition ON users.user_id = calculated_nutrition.user_id
          WHERE users.user_id = ?
          AND (DATE(food_added) <= CURDATE() AND DATE(food_added) > CURDATE() - 8)";

  // Prepare and execute statement
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$user_id]);
  // Saves result in object
  $foods = $stmt->fetchAll();

  if ($foods) {
    print_r(json_encode($foods));
  }
}