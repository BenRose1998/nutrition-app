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

if(isset($_POST['id']) && !empty($_POST['id'])){
  // Store posted food id
  $food_id = $_POST['id'];
  // Store user id
  $user_id = $_SESSION['user_id'];

  // Query
  // If food item exists and belongs to this user it is deleted
  $sql = 'DELETE FROM food
          WHERE food_id = ?
          AND user_id = ?';

  // Prepare and execute statement
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$food_id, $user_id]);
}
