<?php
// Only starts a session if there isn't already an active session
if (session_status() != PHP_SESSION_ACTIVE) {
  session_start();
}

// Function that can be used to redirect user using Javascript rather than manipulating the header
// Changing header location is not possible after outputting anything so javascript needs to be used
function redirect($url)
{ ?>
  <script type='text/javascript'>
    window.location.href = '<?php echo $url; ?>';
  </script>
<?php } ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Nutrition App | <?php echo $header ?></title>
  <!-- Link css files -->
  <!-- Twitter Bootstrap from https://getbootstrap.com/ -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <!-- Font Awesome - available at https://fontawesome.com/ -->
  <script src="https://kit.fontawesome.com/f2a72a8b1b.js" crossorigin="anonymous"></script>
  <!-- Link main stylesheet -->
  <link rel="stylesheet" href="css/main.css">
  <!-- Link stylesheet -->
  <?php
  if(isset($stylesheet)){
    echo '<link rel="stylesheet" href="css/' . $stylesheet . '">';
  }
  ?>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <div class="container" id="nav-content">
      <a class="navbar-brand" href="index.php">Nutritius</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-content" aria-controls="navbar-content" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar-content">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="guide.php">How it works</a>
          </li>
        </ul>
        <ul class="navbar-nav navbar-right">
          <?php
          if (isset($_SESSION['user_id'])) {
            // Add navigation link to 'My Nutrition' dashboard page
            echo '<li class="nav-item">';
            echo  '<a class="nav-link" href="dashboard.php">My Nutrition</a>';
            echo '</li>';
            // Add navigation link to 'My Account' page
            echo '<li class="nav-item">';
            echo  '<a class="nav-link" href="account.php">My Account</a>';
            echo '</li>';
            // Add navigation link to log out
            echo '<li class="nav-item">';
            echo  '<a class="nav-link" href="logout.php">Logout (' . $_SESSION['username'] . ')</a>';
            echo '</li>';
          } else {
            // Add navigation link to 'Login' page
            echo '<li class="nav-item">';
            echo  '<a class="nav-link" href="login.php">Login/Register</a>';
            echo '</li>';
          }
          ?>
        </ul>
      </div>
    </div>
    </div>
  </nav>