<?php
$stylesheet = 'main.css';
$header = 'Guide';
include_once('includes/header.php');

echo '<link rel="stylesheet" href="css/guide.css">';
?>

<div class="container" id="main">

  <h1>How to use Nutritius</h2>
  <section>
    <h3>Log in</h3>
    <p><a href="register.php">Register</a> and <a href="login.php">login</a> to your Account</p>
  </section>
  <section>
    <h3>View your nutrition <?php if (isset($_SESSION['user_id'])) echo '<a href="dashboard.php"><small>(go to)</small></a>'; // Show a link to this page if user is logged in?></h3>
    <p>Type in the search bar to find a food item</p>
    <img class="img-responsive" src="images/dashboard.png" alt="User's dashboard page">
  </section>
  <section>
    <h3>View your food <?php if (isset($_SESSION['user_id'])) echo '<a href="view_food.php"><small>(go to)</small></a>'; // Show a link to this page if user is logged in?></h3>
    <p>Navigate between dates using the arrow buttons, view & edit food for each day</p>
    <img class="img-responsive" src="images/view_food.png" alt="User's 'View Food' page">
  </section>
  <section>
    <h3>Statistics <?php if (isset($_SESSION['user_id'])) echo '<a href="statistics.php"><small>(go to)</small></a>'; // Show a link to this page if user is logged in?></h3>
    <p>View your total nutrition values over the last 7 days</p>
    <img class="img-responsive" src="images/statistics.png" alt="User's 'Statistics' page">
  </section>
  <section>
    <h3>Edit Account Info <?php if (isset($_SESSION['user_id'])) echo '<a href="account.php"><small>(go to)</small></a>'; // Show a link to this page if user is logged in?></h3>
    <p>Edit your username, email or nutrition goal targets</p>
    <img class="img-responsive" src="images/account.png" alt="User's 'Account' page">
  </section>
</div>

<?php
include_once('includes/footer.php');
?>