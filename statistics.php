<?php
require_once('includes/connect.php');

// $stylesheet = 'view_food.css';
$header = 'Statistics';
include_once('includes/header.php');

if (!isset($_SESSION['user_id'])) {
  redirect('index.php');
}

?>

<div class="container" id="main">
  <a href="dashboard.php">Back to My Nutrition</a>



</div>






<?php
include('includes/footer.php');
?>