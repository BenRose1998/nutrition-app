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

  <!-- Search bar nav -->
  <nav class="navbar navbar-light navbar-expand-lg" id="search-form">
    <input class="col-lg-9 col-md-8 col-sm-8 m-0 p-0 form-control search" id="search" type="search"
      placeholder="Search food...">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
      aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse col-lg-3 col-md-4" id="navbarNavDropdown">
      <a href="dashboard.php" class="btn btn-green col-lg-4 search-btn" role="button">My Nutrition</a>
      <a href="view_food.php" class="btn btn-green col-lg-4 search-btn" role="button">View Food</a>
      <a href="statistics.php" class="btn btn-green col-lg-4 search-btn active" role="button">Statistics</a>
    </div>
    <ul class="list-group results"></ul>
  </nav>



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
  <h2 id="graph-error"></h2>
  <div class="chart-container" style="position: relative; height:70vh; width:80vw">
    <canvas id="graph"></canvas>
  </div>


</div>






<?php
include('includes/footer.php');
?>

<!-- Link script files -->
<!-- Moment.js used - https://momentjs.com/ -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<script src="js/statistics.js"></script>
<script src="js/search.js"></script>