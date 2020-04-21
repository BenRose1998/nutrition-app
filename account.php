<?php
require_once('includes/connect.php');

$header = 'My Account';

include_once('includes/header.php');
require_once('includes/functions.php');

echo '<link rel="stylesheet" href="css/account.css">';

if (!isset($_SESSION['user_id'])) {
  redirect('index.php');
  exit();
}

// Default the error variable to null
$error = null;


// -----------------------------------------------------------------
// USERNAME FORM
// -----------------------------------------------------------------
if (isset($_POST['username'])) {
  // Trims white space and stores user input as variable to be used later
  $username = trim($_POST['username']);
  // Checks if input is empty, if so sends an error
  if (empty($username)) {
    $error = "Please enter a username";
    // Skips the rest of the script and goes to error output
    goto error;
  } else{

    // Checks if username length is greater than 20
    if(strlen($username) > 20){
      $error = "Username too long";
      // Skips the rest of the script and goes to error output
      goto error;
    }

    // Checks if account with that username already exists in the database
    if(checkUsernameExists($pdo, $username)){
      $error = "Account with this username already exists";
      // Skips the rest of the script and goes to error output
      goto error;
    }

    // Query
    // Update user's username
    $sql = 'UPDATE users 
            SET user_username = :username
            WHERE user_id = :user_id';

    // Prepare and execute statement
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username, 'user_id' => $_SESSION['user_id']]);
  }
}

// -----------------------------------------------------------------
// PASSWORD FORM
// -----------------------------------------------------------------
if (isset($_POST['password1']) && isset($_POST['password2'])) {
  // Trims white space and stores user inputs as variables to be used later
  $password1 = trim($_POST['password1']);
  $password2 = trim($_POST['password2']);
  // Checks if inputs are empty, if so sends an error
  if (empty($password1) || empty($password2)) {
    $error = "Please fill in all password information";
    // Skips the rest of the script and goes to error output
    goto error;
  } else{

    // Checks if password length is less than 8
    if(strlen($password2) < 8){
      $error = "New password is too short";
      // Skips the rest of the script and goes to error output
      goto error;
    }

    // Query
    // Select user's password from user table
    $sql = 'SELECT user_password
    FROM users
    WHERE user_id = ?
    LIMIT 1';

    // Prepare and execute statement
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user_id']]);
    // Saves result in object
    $password = $stmt->fetch();

    // If inputted password (password1) matches current password in database (for this user)
    if (password_verify($password1, $password->user_password)) {
      // Encrypts password2 (new password)
      $password = password_hash($password2, PASSWORD_DEFAULT);

      // Query
      // Update user's password
      $sql = 'UPDATE users 
              SET user_password = :password
              WHERE user_id = :user_id';

      // Prepare and execute statement
      $stmt = $pdo->prepare($sql);
      $stmt->execute(['password' => $password, 'user_id' => $_SESSION['user_id']]);
    }else{
      // Password incorrect
      $error = "Incorrect current password";
      // Skips the rest of the script and goes to error output
      goto error;
    }
  }
}

// -----------------------------------------------------------------
// NUTRITION GOALS FORM
// -----------------------------------------------------------------
if (isset($_POST['calories']) && isset($_POST['protein'])) {
  // Trims white space and stores user inputs as variables to be used later
  $calorie_goal = trim($_POST['calories']);
  $protein_goal = trim($_POST['protein']);
  // Checks if inputs are empty, if so sends an error
  if (empty($calorie_goal) || empty($protein_goal)) {
    $error = "Please fill in all nutrition goal information";
    // Skips the rest of the script and goes to error output
    goto error;
  } else{

    // Convert to integers (whole number)
    $calorie_goal = (int)$calorie_goal;
    $protein_goal = (int)$protein_goal;
    
    // Check if either value is 0 or less
    if($calorie_goal <= 0 || $protein_goal <= 0){
      $error = "Please enter whole numeric values (above 0)";
      // Skips the rest of the script and goes to error output
      goto error;
    }

    // Query
    // Update user's nutrition goal values
    $sql = 'UPDATE users 
            SET user_calorie_goal = :calorie_goal, user_protein_goal = :protein_goal
            WHERE user_id = :user_id';

    // Prepare and execute statement
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['calorie_goal' => $calorie_goal, 'protein_goal' => $protein_goal, 'user_id' => $_SESSION['user_id']]);
  }
}

?>




<!-- If an error is sent it is displayed -->
<?php error: if ($error != null) : ?>
<h3 class='error'><?php echo $error; ?></h3>
<?php endif; ?>

<?php

// Query
// User's data is pulled from user table
$sql = 'SELECT user_username, user_calorie_goal, user_protein_goal
        FROM users
        WHERE user_id = ?
        LIMIT 1';

// Prepare and execute statement
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
// Saves result in object
$user = $stmt->fetch();

?>

<div class="container" id="main">
  <h2>My Account</h2>

  <h4>Account Information</h4>
  <form action="account.php" method="POST">
    <div class="row">
      <div class="col-10 form-group">
        <label for="username">Username <small>(max length: 20)</small></label>
        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user->user_username ?>">
      </div>
      <button type="submit" class="col-2 btn btn-green">Change</button>
    </div>
  </form>

  </br>

  <form action="account.php" method="POST">
    <div class="row">
      <div class="col-5 form-group">
        <label for="password1">Old Password</label>
        <input type="password" class="form-control" id="password1" name="password1">
      </div>
      <div class="col-5 form-group">
        <label for="password2">New Password <small>(min length: 8)</small></label>
        <input type="password" class="form-control" id="password2" name="password2">
      </div>
      <button type="submit" class="col-2 btn btn-green">Change</button>
    </div>
  </form>

  <h4>Nutrition Goals</h4>
  <form action="account.php" method="POST">
    <div class="row">
      <div class="col-5 form-group">
        <label for="calories">Daily Calorie Goal</label>
        <input type="text" class="form-control" id="calories" name="calories" value="<?php echo $user->user_calorie_goal ?>">
      </div>
      <div class="col-5 form-group">
        <label for="protein">Daily Protein Goal</label>
        <input type="text" class="form-control" id="protein" name="protein" value="<?php echo $user->user_protein_goal ?>">
      </div>
      <button type="submit" class="col-2 btn btn-green">Change</button>
    </div>
  </form>

</div>

<?php
include('includes/footer.php');
?>