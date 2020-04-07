<?php
require_once('includes/connect.php');

$header = 'My Food';
include_once('includes/header.php');

// Link this page's stylesheets
echo '<link rel="stylesheet" href="css/search.css">';
echo '<link rel="stylesheet" href="css/view_food.css">';

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


  <!-- <h2 id="date-title">Food</h2> -->
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
<script src="js/search.js"></script>
