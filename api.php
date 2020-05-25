<?php
require_once('includes/connect.php');

// Only starts a session if there isn't already an active session
if (session_status() != PHP_SESSION_ACTIVE) {
  session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  // Bad request - throw bad request error (400)
  http_response_code(400);
  exit();
}

// Execute different function depending on data requested
if (isset($_GET['type'])) {
  switch ($_GET['type']) {
    case 'addFood':
      addFood($pdo);
      break;
    case 'getNutrition':
      getNutrition($pdo);
      break;
    case 'viewFood':
      // Only if an timestamp value has been passed, call the viewFood function
      if(isset($_GET['timestamp'])){
        viewFood($pdo, $_GET['timestamp']);
      }
      break;
    case 'removeFood':
      // Only if an id value has been passed, call the removeFood function
      if(isset($_GET['id'])){
        removeFood($pdo, $_GET['id']);
      }
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
      // Bad request - throw bad request error (400)
      http_response_code(400);
      break;
  }
} else {
  // Bad request - throw bad request error (400)
  http_response_code(400);
}

// Inserts posted food data into the database for this user
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
    // Create a date in SQL format
    $food_added = date('Y-m-d H:i:s');

    // Query
    // Food data is inserted into the database
    $sql = 'INSERT INTO food (user_id, food_name, food_serving_unit, food_serving_base, food_serving_quantity, food_calories, food_fat, food_salt, food_protein, food_total_carbohydrates, food_sugar, food_added) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

    // Prepare and execute statement
    $stmt = $pdo->prepare($sql);
    // If query was successful
    if($stmt->execute([$user_id, $food_name, $food_serving_unit, $food_serving_base, $food_serving_quantity, $food_calories, $food_fat, $food_salt, $food_protein, $food_total_carbohydrates, $food_sugar, $food_added])){
      // CREATED - throw CREATED response code (201)
      http_response_code(201);
    }else{
      // Error - throw server error response code (500)
      http_response_code(500);
    }
  }
}

// Returns total nutrition values and goals for a specified user today
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
  }else{
    // Not found - throw Not found error (404)
    http_response_code(404);
  }
}

// Returns this user's food data for the specified day 
function viewFood($pdo, $timestamp){
  // Convert passed date to SQL format
  $date = date('Y-m-d', $_GET['timestamp']);

  // Save reference to user id
  $user_id = $_SESSION['user_id'];

  // Query
  // User's food data for the specified day is pulled from the database (newest results first)
  $sql = 'SELECT *
          FROM calculated_nutrition
          WHERE user_id = ?
          AND DATE(food_added) = ?
          ORDER BY food_added DESC';

  // Prepare and execute statement
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$user_id, $date]);
  // Saves results in object
  $foods = $stmt->fetchAll();

  // Create empty array for each food record to be added to
  $data = [];
  // Create a variable to store total number of calories for that day
  $totalCalories = 0;
  // Create a variable to store total amount of protein for that day
  $totalProtein = 0;

  // Only run if results where returned
  if ($foods) {
    // Loop through all food records
    foreach ($foods as $food) {
      $amount = $food->food_serving_quantity * $food->food_serving_base . " " . $food->food_serving_unit;
      // Create an array of all food values
      $foodData = ["id" => $food->food_id, "amount" => $amount , "food" => $food->food_name, "calories" => $food->calories, 
      "protein" => $food->protein, "date" => $food->food_added];
      // Insert foodData array into the data array
      array_push($data, $foodData);
      $totalCalories += $food->calories;
      $totalProtein += $food->protein;
    }
  // Push an array of total calories and total protein to the end of the data array
  array_push($data, ["total_calories" => $totalCalories, "total_protein" => $totalProtein]);
  } else {
    // Food not found
  }
  // Encode data array to json and send as response to request
  echo json_encode($data);
}

// Removes a food item by ID (only if that food belongs to this user)
function removeFood($pdo, $id){
  // Store user id
  $user_id = $_SESSION['user_id'];

  // Query
  // If food item exists and belongs to this user it is deleted
  $sql = 'DELETE FROM food
          WHERE food_id = ?
          AND user_id = ?';

  // Prepare and execute statement
  $stmt = $pdo->prepare($sql);
  if($stmt->execute([$id, $user_id])){
    // Done - throw OK code (200)
    http_response_code(200);
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
  } else{
    print_r(json_encode([]));
  }
}