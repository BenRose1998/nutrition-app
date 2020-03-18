<?php
// Only starts a session if there isn't already an active session
if (session_status() != PHP_SESSION_ACTIVE) {
  session_start();
}

// Function that can be used to redirect user using Javascript rather than manipulating the header
// Changes header location is not possible after outputting anything so javascript needs to be used
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
      <a class="navbar-brand" href="index.php">Nutrition App</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
          </li>
        </ul>
        <ul class="navbar-nav navbar-right">
          <?php
          if (isset($_SESSION['user_id'])) {
            echo '<li class="nav-item">';
            echo  '<a class="nav-link" href="dashboard.php">My Nutrition</a>';
            echo '</li>';

            echo '<li class="nav-item">';
            echo  '<a class="nav-link" href="logout.php">Logout (' . $_SESSION['username'] . ')</a>';
            echo '</li>';
          } else {
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