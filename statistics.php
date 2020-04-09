<?php
require_once('includes/connect.php');

$header = 'Statistics';
include_once('includes/header.php');

echo '<link rel="stylesheet" href="css/statistics.css">';
echo '<link rel="stylesheet" href="css/dashboard.css">';
echo '<link rel="stylesheet" href="css/search.css">';

if (!isset($_SESSION['user_id'])) {
  redirect('index.php');
}

?>

<!-- Modal -->
<div class="modal fade" id="quantity-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Quantity</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-center">
          <a href="" class="btn modal-btn" role="button" id="modal-previous-btn">
            <</a> <h3 class="modal-quantity">1</h3>
              <a href="" class="btn modal-btn" role="button" id="modal-next-btn">></a>
        </div>
        <div class="row justify-content-center">
          <a href="" class="btn modal-btn" role="button" id="modal-add-btn">Add</a>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="container" id="main">
  <!-- <a href="dashboard.php">Back to My Nutrition</a> -->

  <!-- Search bar -->
  <div class="row justify-content-center" id="search">
    <a href="dashboard.php" class="btn dashboard-btn" role="button" id="home-btn"><i class="fas fa-home fa-1x"></i></a>
    <form class="col-lg-8 col-md-9 col-sm-8" id="search-form">
      <input class="form-control form-control-lg search" type="text" placeholder="Search food...">
    </form>
    <!-- Search results -->
    <ul class="list-group results">
    </ul>
    <!-- Button links -->
    <a href="view_food.php" class="btn col-lg-1 col-md-1 col-sm-2 dashboard-btn" role="button">My Food</a>
    <a href="statistics.php" class="btn col-lg-1 col-md-1 col-sm-2 dashboard-btn" role="button">Statistics</a>
  </div>


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
  <div class="chart-container" style="position: relative; height:70vh; width:80vw">
    <canvas id="graph"></canvas>
  </div>


</div>






<?php
include('includes/footer.php');
?>

<!-- Link script files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<script src="js/statistics.js"></script>
<script src="js/search.js"></script>