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

  <!-- Search bar nav -->
  <nav class="navbar navbar-light navbar-expand-lg" id="search-form">
    <input class="col-lg-10 col-md-9 col-sm-8 m-0 p-0 form-control search" id="search" type="search"
      placeholder="Search food...">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
      aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse col-lg-2" id="navbarNavDropdown">
      <a href="view_food.php" class="btn btn-green" role="button">View Food</a>
      <a href="statistics.php" class="btn btn-green" role="button">Statistics</a>
    </div>
  </nav>
  <ul class="list-group results"></ul>

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