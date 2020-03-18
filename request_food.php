<?php
require_once('includes/connect.php');
session_start();

// Ensure user sending request is logged in
if (isset($_SESSION['user_id'])) {
  // Check if request has been sent
  if (isset($_GET['timestamp'])) {

    // Convert passed date to SQL format
    $date = date('Y-m-d', $_GET['timestamp']);

    // Save reference to user id
    $user_id = $_SESSION['user_id'];

    // Query
    // User's food data for the specified day is pulled from the database
    $sql = 'SELECT food_id, food_name, food_calories, food_protein, TIME(food_added) AS "food_added", food_serving_unit, food_serving_base, food_serving_quantity
          FROM food
          WHERE user_id = ?
          AND DATE(food_added) = ?';

    $sql = 'SELECT *
            FROM calculated_nutrition
            WHERE user_id = ?
            AND DATE(food_added) = ?';

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
        $foodData = ["id" => $food->food_id, "amount" => $amount , "food" => $food->food_name, "calories" => $food->calories, "protein" => $food->protein, "date" => $food->food_added];
        // Insert foodData array into the data array
        array_push($data, $foodData);
        $totalCalories += $food->calories;
        $totalProtein =+ $food->protein;
      }
    // Push an array of total calories and total protein to the end of the data array
    array_push($data, ["total_calories" => $totalCalories, "total_protein" => $totalProtein]);
    } else {
      // No food found
    }
    // Encode data array to json and send as response to request
    echo json_encode($data);
  }
}
