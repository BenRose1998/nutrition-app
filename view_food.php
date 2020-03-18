<?php
require_once('includes/connect.php');

$stylesheet = 'view_food.css';
$header = 'My Food';
include_once('includes/header.php');

if (!isset($_SESSION['user_id'])) {
  redirect('index.php');
}

?>

<div class="container" id="main">
  <!-- <a href="dashboard.php" class="btn" role="button" id="back-btn">Back</a> -->
  <a href="dashboard.php">Back to My Nutrition</a>
  <h2 id="date-title">Food</h2>
  <div class="row">
    <div class="col-md-3">
      <a href="" class="btn" role="button" id="previous-btn">Previous</a>
    </div>
    <h3 class="col-md-6" id="date">Date</h3>
    <div class="col-md-3">
      <a href="" class="btn" role="button" id="next-btn">Next</a>
    </div>
  </div>

  <div class="container day-info-div">
    <div class="row justify-content-center">
      <ul class="list-group col-md-6 day-info">
        <li class="list-group-item day-info" id="day-calories">Calories: 0</li>
      </ul>
      <ul class="list-group col-md-6 day-info">
        <li class="list-group-item day-info" id="day-protein">Protein: 0g</li>
      </ul>
    </div>
  </div>


  <table class="table">
    <thead class="thead">
      <tr>
        <th>Food</th>
        <th>Amount</th>
        <th>Calories</th>
        <th>Protein</th>
        <th>Time</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>
</div>

<?php
include('includes/footer.php');
?>

<!-- Link script files -->
<script src="js/view_food.js"></script>
