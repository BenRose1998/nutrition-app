<?php

// Checks if inputted email address already exists in database
function checkEmailExists($pdo, $email)
{
  // Query
  // Select user data for the specified email
  $sql = 'SELECT *
          FROM users
          WHERE user_email = ?';

  // Prepare and execute statement
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$email]);
  $accounts = $stmt->fetchAll();

  // If any accounts were returned return true
  if (count($accounts) === 0) {
    return false;
  } else {
    return true;
  }
}

// Checks if inputted username already exists in database
function checkUsernameExists($pdo, $username)
{
  // Query
  // Select user data for the specified username
  $sql = 'SELECT *
          FROM users
          WHERE user_username = ?';

  // Prepare and execute statement
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$username]);
  $accounts = $stmt->fetchAll();

  // If any accounts were returned return true
  if (count($accounts) === 0) {
    return false;
  } else {
    return true;
  }
}

?>