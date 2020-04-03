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
  <canvas id="calories"></canvas>


</div>






<?php
include('includes/footer.php');
?>

<!-- Link script files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="js/statistics.js"></script>