<?php
require_once('includes/connect.php');

$stylesheet = 'login.css';
$header = 'Register';
include_once('includes/header.php');


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
  } else {
    // Check if email address is not valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error = "Email address invalid";
    }
    // Checks if passwords don't match and if so sends an error
    if ($password != $password2) {
      $error = "Passwords do not match";
    } else {
      // If inputs aren't empty, email is valid and passwords match, the user's data is inserted into the database
      // Encrypts password
      $password = password_hash($password, PASSWORD_DEFAULT);

      // Get current data & time
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

<form class="login-form" action="register.php" method="post">
  <h2>Register</h2>
  <div class="form-group">
    <label for="usernameInput">Username</label>
    <input type="text" class="form-control" name="username" id="usernameInput">
  </div>
  <div class="form-group">
    <label for="emailInput">Email address</label>
    <input type="email" class="form-control" name="email" id="emailInput">
  </div>
  <div class="form-group">
    <label for="passwordInput">Password</label>
    <input type="password" class="form-control" name="password" id="passwordInput">
  </div>
  <div class="form-group">
    <label for="passwordInput">Repeat Password</label>
    <input type="password" class="form-control" name="password2" id="passwordInput2">
  </div>
  <button type="submit" class="btn">Submit</button>
</form>

<?php
include('includes/footer.php');
?>