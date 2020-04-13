<?php
$stylesheet = 'index.css';

$header = 'Home';
include_once('includes/header.php');
?>
<div class="">
  <section id="bigimage">
    <div class="centre">
      <h1>Nutritius</h1>
      <a href="register.php" class="btn btn-green" role="button" id="bigimageButton">Register</a>
    </div>
  </section>
</div>

<div class="container" id="main">
  <div class="row" id="icons">
    <figure class="icon">
      <i class="fas fa-chart-pie fa-7x"></i>
      <h2>Track Nutrition</h2>
      <p>Keep track of your daily nutrition values</p>
    </figure>
    <figure class="icon">
      <i class="fas fa-utensils fa-7x"></i>
      <h2>Log Meals</h2>
      <p>Search database for food you've eaten and log it</p>
    </figure>
    <figure class="icon">
      <i class="fas fa-chart-bar fa-7x"></i>
      <h2>Set Goals</h2>
      <p>Set calorie & protein goals for yourself</p>
    </figure>
  </div>

<?php
include_once('includes/footer.php');
?>