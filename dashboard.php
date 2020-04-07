<?php


$header = 'Dashboard';

include_once('includes/header.php');

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

  <!-- Search bar -->
  <div class="row justify-content-center" id="search">
    <form class="col-lg-8 col-md-9 col-sm-8" id="search-form">
      <input class="form-control form-control-lg search" type="text" placeholder="Search food...">
    </form>
    <!-- Button links -->
    <a href="view_food.php" class="btn col-lg-1 col-md-1 col-sm-2 dashboard-btn" role="button">My Food</a>
    <a href="statistics.php" class="btn col-lg-1 col-md-1 col-sm-2 dashboard-btn" role="button">Statistics</a>
    <!-- Search results -->
    <ul class="list-group results">
    </ul>
    
  </div>

  <!-- Charts -->
  <div class="row">
    <div class="col-md-5 chart-container" id="calories-chart">
      <canvas id="calories"></canvas>
      <h3 class="text-center chart-text" id="calories-text">Calories (400/2000)</h3>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4 chart-container">
      <canvas id="nutrition"></canvas>
      <h3 class="text-center chart-text" id="nutrition-text">Nutrition</h3>
    </div>
    <div class="col-md-4 chart-container">
      <canvas id="protein"></canvas>
      <h3 class="text-center chart-text" id="protein-text">Protein (10/60g)</h3>
    </div>
  </div>

</div>


<?php
include('includes/footer.php');
?>

<!-- Link script files -->
<script src="js/dashboard.js"></script>
<script src="js/search.js"></script>