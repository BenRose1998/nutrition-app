<?php
require_once('includes/connect.php');

$stylesheet = 'dashboard.css';
$header = 'Statistics';
include_once('includes/header.php');

if (!isset($_SESSION['user_id'])) {
  redirect('index.php');
}

?>

<div class="container" id="main">
  <a href="dashboard.php">Back to My Nutrition</a>

  <ul class="nav nav-tabs nav-justified">
    <li class="nav-item">
      <a class="nav-link active" href="nutrition">Weekly Nutrition</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="calories">Weekly Calories</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="protein">Weekly Protein</a>
    </li>
  </ul>

  <!-- HTML Canvas - Chart.js chart will be displayed here -->
  <canvas id="graph"></canvas>


</div>






<?php
include('includes/footer.php');
?>

<!-- Link script files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="js/statistics.js"></script>