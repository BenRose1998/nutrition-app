<?php
require_once('includes/connect.php');

$stylesheet = 'login.css';
$header = 'Login';
include_once('includes/header.php');

// Default the error variable to null
$error = null;

// Checks if the form has been submitted
if (isset($_POST) && !empty($_POST)) {
  // Stores user inputs as variables to be used later
  $email = $_POST['email'];
  $password = $_POST['password'];
  // Checks if inputs are empty, if so sends an error
  if (empty($email) || empty($password)) {
    $error = "Please fill in all information";
    goto error;
  } else {
    // If inputs aren't empty the user's data is pulled from the database

    // Query
    // User's data is pulled from user table and their job title from employee table if they are in it
    $sql = 'SELECT *
            FROM users
            WHERE user_email = ?
            LIMIT 1';

    // Prepare and execute statement
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    // Saves result in object
    $user = $stmt->fetch();

    // Only checks for password if a record is found in database
    if ($user) {
      // Inputted password is checked against password stored in database
      if (password_verify($password, $user->user_password)) {
        // If password is correct information on user is stored in the session
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['username'] = $user->user_username;
        $_SESSION['email'] = $email;
        // User is redirected to their dashboard
        redirect('dashboard.php');
      } else {
        // If the password inputted by user did not match then an error is sent
        $error = "Invalid email or password";
        goto error;
      }
    } else {
      // If no record found with that email then an error is sent
      $error = "Invalid email or password";
      goto error;
    }
  }
}

?>
<div id="main">

  <!-- If an error is sent it is displayed -->
  <?php error: if ($error != null) : ?>
  <h3 class='error'><?php echo $error; ?></h3>
  <?php endif; ?>

  <form class="login-form" method="post" action="login.php">
    <h2>Login</h2>
    <div class="form-group">
      <label for="emailInput">Email address</label>
      <input type="email" class="form-control" name="email" id="emailInput">
    </div>
    <div class="form-group">
      <label for="passwordInput">Password</label>
      <input type="password" class="form-control" name="password" id="passwordInput">
    </div>
    <button type="submit" class="btn btn-green">Login</button>
    <a href="register.php" class="btn btn-green" role="button">Register</a>
  </form>
</div>


<?php
include('includes/footer.php');
?>