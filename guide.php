<?php
$stylesheet = 'main.css';
$header = 'Guide';
include_once('includes/header.php');

echo '<link rel="stylesheet" href="css/guide.css">';
?>

<div class="container" id="main">

  <h2>How to</h2>
  <section>
    <h4>Log in</h4>
    <p><a href="register.php">Register</a> and <a href="login.php">login</a> to your Dashboard</p>
  </section>
  <section>
    <h4>View your nutrition <?php if (isset($_SESSION['user_id'])) echo '<a href="dashboard.php"><small>(go to)</small></a>'; // Show a link to this page if user is logged in?></h4>
    <p>Type in the search bar to find a food item</p>
    <img class="img-responsive" src="images/dashboard.png" alt="User's dashboard page">
  </section>
  <section>
    <h4>View your food <?php if (isset($_SESSION['user_id'])) echo '<a href="view_food.php"><small>(go to)</small></a>'; // Show a link to this page if user is logged in?></h4>
    <p>Navigate between dates using the arrow buttons, view & edit food for each day</p>
    <img class="img-responsive" src="images/view_food.png" alt="User's 'View Food' page">
  </section>
  <section>
    <h4>Statistics <?php if (isset($_SESSION['user_id'])) echo '<a href="statistics.php"><small>(go to)</small></a>'; // Show a link to this page if user is logged in?></h4>
    <p>View your total nutrition values for the last week</p>
    <img class="img-responsive" src="images/statistics.png" alt="User's 'Statistics' page">
  </section>
  <section>
    <h4>Edit Account Info <?php if (isset($_SESSION['user_id'])) echo '<a href="account.php"><small>(go to)</small></a>'; // Show a link to this page if user is logged in?></h4>
    <p>Edit your username, email or nutrition goal targets</p>
    <img class="img-responsive" src="images/account.png" alt="User's 'Statistics' page">
  </section>
</div>

<?php
include_once('includes/footer.php');
?>