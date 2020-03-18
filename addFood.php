<?php
require_once('includes/connect.php');

// Only starts a session if there isn't already an active session
if(session_status() != PHP_SESSION_ACTIVE){
  session_start();
}

if(!isset($_SESSION['user_id'])){
  // Exit script if user is not logged in
  exit();
}

if(isset($_POST) && !empty($_POST)){
  // Store user id
  $user_id = $_SESSION['user_id'];
  // Store all posted values
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
  // Store current date, formatted for SQL
  $food_added = date('Y-m-d H:i:s');

  // Query
  // Food data is inserted into the database
  $sql = 'INSERT INTO food (user_id, food_name, food_serving_unit, food_serving_base, food_serving_quantity, food_calories, food_fat, food_salt, food_protein, food_total_carbohydrates, food_sugar, food_added) 
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

  // Prepare and execute statement
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$user_id, $food_name, $food_serving_unit, $food_serving_base, $food_serving_quantity, $food_calories, $food_fat, $food_salt, $food_protein, $food_total_carbohydrates, $food_sugar, $food_added]);
}
