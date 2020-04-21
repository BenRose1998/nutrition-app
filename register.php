<?php
require_once('includes/connect.php');

// Load composer
require_once('vendor/autoload.php');
// bjeavons - zxcvbn-php password strength library used - https://github.com/bjeavons/zxcvbn-php
use ZxcvbnPhp\Zxcvbn;

$stylesheet = 'login.css';
$header = 'Register';
include_once('includes/header.php');

require_once('includes/functions.php');


// Default the error variable to null
$error = null;

// Checks if the form has been submitted
if (isset($_POST) && !empty($_POST)) {
  // Trims white space and stores user inputs as variables to be used later
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $password2 = trim($_POST['password2']);
  // Checks if inputs are empty, if so sends an error
  if (empty($username) || empty($email) || empty($password) || empty($password2)) {
    $error = "Please fill in all information";
    // Skips the rest of the script and goes to error output
    goto error;
  } else {
    // Checks if username length is greater than 20
    if(strlen($username) > 20){
      $error = "Username too long";
      // Skips the rest of the script and goes to error output
      goto error;
    }

    // Checks if email length is greater than 40
    if(strlen($email) > 40){
      $error = "Email too long";
      // Skips the rest of the script and goes to error output
      goto error;
    }

    // Checks if account with that username already exists in the database
    if(checkUsernameExists($pdo, $username)){
      $error = "Account with this username already exists";
      // Skips the rest of the script and goes to error output
      goto error;
    }

    // Checks if account with that email already exists in the database
    if(checkEmailExists($pdo, $email)){
      $error = "Account with this email address already exists";
      // Skips the rest of the script and goes to error output
      goto error;
    }

    // Check if email address is not valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error = "Email address invalid";
      // Skips the rest of the script and goes to error output
      goto error;
    }

    // Checks if passwords don't match and if so sends an error
    if ($password != $password2) {
      $error = "Passwords do not match";
      // Skips the rest of the script and goes to error output
      goto error;
    } else {

      // Checks if password length is less than 8
      if(strlen($password) < 8){
        $error = "Password too short";
        // Skips the rest of the script and goes to error output
        goto error;
      }

      // ---------------------------------------------------------------------------------------------
      // bjeavons - zxcvbn-php password strength library documentation used - https://github.com/bjeavons/zxcvbn-php

      // Store user's data in an array
      $data = [
        $username,
        $email
      ];
      // Create an instance of the Zxcvbn object
      $zxcvbn = new Zxcvbn();
      // Call the passwordStrength test method, pass it the password and user's data
      $strength = $zxcvbn->passwordStrength($password, $data);

      // Returns a password strength score between 0-4 (Weak - Strong)

      // ---------------------------------------------------------------------------------------------

      // If password strength is less than 2 an error is thrown
      if($strength['score'] < 2){
        // Create an array storing strings (password strengths)
        $strengths = ['Very Poor', 'Weak'];
        // Set password score to index of the strengths array (e.g. 0 = Very Poor)
        $score = $strengths[$strength['score']];
        // Print error
        $error = "Password too weak </br> 
        Password Strength: <strong>" . $score . "</strong> (" . $strength['score'] . ")
         - Must have a strength of at least <strong>Okay</strong> (2)";
        // Skips the rest of the script and goes to error output
        goto error;
      }

      // If inputs aren't empty, email is valid and passwords match, the user's data is inserted into the database
      // Encrypts password
      $password = password_hash($password, PASSWORD_DEFAULT);

      // Get current data & time in SQL format
      $created = date('Y-m-d H:i:s');

      // Query
      // User's data is inserted into the database
      $sql = 'INSERT INTO users (user_username, user_email, user_password, user_created) VALUES (:username, :email, :password, :created)';

      // Prepare and execute statement
      $stmt = $pdo->prepare($sql);
      $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password, 'created' => $created]);

      // Redirects user to login page
      redirect('login.php');
    }
  }
}

?>

<!-- If an error is sent it is displayed -->
<?php error: if ($error != null) : ?>
<h3 class='error'><?php echo $error; ?></h3>
<?php endif; ?>

<div id="main">
  <form class="login-form" action="register.php" method="post">
    <h2>Register</h2>
    <div class="form-group">
      <label for="usernameInput">Username <small>(max length: 20)</small></label>
      <input type="text" class="form-control" name="username" id="usernameInput">
    </div>
    <div class="form-group">
      <label for="emailInput">Email address <small>(max length: 40)</small></label>
      <input type="email" class="form-control" name="email" id="emailInput">
    </div>
    <div class="form-group">
      <label for="passwordInput">Password <small>(min length: 8)</small></label>
      <input type="password" class="form-control" name="password" id="passwordInput">
    </div>
    <div class="form-group">
      <label for="passwordInput">Repeat Password <small>(min length: 8)</small></label>
      <input type="password" class="form-control" name="password2" id="passwordInput2">
    </div>
    <button type="submit" class="btn btn-green">Submit</button>
  </form>
</div>
<?php
include('includes/footer.php');
?>