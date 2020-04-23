$(document).ready(function () {

  // Get food data from server
  function getFoodData() {
    const days = [
      "Sunday",
      "Monday",
      "Tuesday",
      "Wednesday",
      "Thursday",
      "Friday",
      "Saturday"
    ];

    const months = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December"
    ];

    var day = days[date.getDay()];
    var month = months[date.getMonth()];

    $("#date").text(
      day + " " + date.getDate() + " " + month + " " + date.getFullYear()
    );

    // Convert date to a unix timestamp
    timestamp = Math.round(date.getTime() / 1000);

    // Send 'viewFood' GET request to back-end API, pass current timestamp
    // Returns all food items for the last 7 days for this user
    $.ajax({
      type: "GET",
      url: "api.php?type=viewFood",
      data: "timestamp=" + timestamp,
      dataType: "json",
      headers: {},
      success: function (res) {
        // If nothing is returned from request
        if (res.length == 0) {
          // Clear the table
          $("tbody").empty();
          // Set list item (day-calories) to a default value of 0
          $("#day-calories").text("Calories: 0");
          // Set list item (day-protein) to a default value of 0
          $("#day-protein").text("Protein: 0g");
        } else {
          // If values were returned
          // Take last element from response object (data about that day, total calories & protein)
          var dayData = res.pop();
          // Populate the list item (day-calories) with total calories data
          $("#day-calories").text("Calories: " + dayData["total_calories"].toFixed(1));
          // Populate the list item (day-protein) with total protein data
          $("#day-protein").text("Protein: " + dayData["total_protein"].toFixed(2) + "g");

          // Clear the table
          $("tbody").empty();
          // Foreach item in res object (as key & food)
          $.each(res, function (key, food) {
            // Populate the mobile version of the table
            if ($(window).width() <= 768) {
              // Create a table row element and append all data as table data elements
              var $tr = $("<tr>")
                .append(
                  $("<td>").text(food["food"]),
                  $("<td>").text(food["amount"]),
                  $("<td>").text(parseFloat(food["calories"]).toFixed(1)),
                  // Add a button to remove the food, give it an id attribute
                  $("<td>").append('<a href="" id="' + food["id"] + '" class="btn btn-green delete-food" role="button">X</a>')
                )
                .appendTo("tbody");
            } else {
              // Populate the desktop version of the table
              // Create a table row element and append all data as table data elements
              var $tr = $("<tr>")
                .append(
                  $("<td>").text(food["food"]),
                  $("<td>").text(food["amount"]),
                  $("<td>").text(parseFloat(food["calories"]).toFixed(1)),
                  $("<td>").text(parseFloat(food["protein"]).toFixed(2) + "g"),
                  $("<td>").text(food["date"]),
                  // Add a button to remove the food, give it an id attribute
                  $("<td>").append('<a href="" id="' + food["id"] + '" class="btn btn-green delete-food" role="button">X</a>')
                )
                .appendTo("tbody");
            }
          });
        }
      }
    });
  }

  // Keep track of date, intialise as current date
  var date = new Date();

  // Get food data and populate table on page load
  getFoodData();

  // EVENT: Bind '.delete-food' click event to body so that dynamic element events also trigger
  $("body").on("click", ".delete-food", function (event) {
    // Prevent buttons default action
    event.preventDefault();
    // Store button's food id
    const food_id = $(this).attr("id");
    // Log food to be deleted
    console.log("Deleting " + food_id + "...");
    // Send request to remove food from DB
    $.get("api.php?type=removeFood", {
      id: food_id
    }, function (ret) {
      console.log(ret);
      // Get food data to retrieve new values after food has been deleted
      getFoodData();
    });
  });

  // EVENT: previous day button clicked
  $("#previous-btn").on("click", function (event) {
    // Prevent buttons default action
    event.preventDefault();

    // Decrement date by one day
    date.setDate(date.getDate() - 1);

    // Get food data and populate table
    getFoodData();
  });

  // EVENT: When next day button clicked
  $("#next-btn").on("click", function (event) {
    // Prevent buttons default action
    event.preventDefault();

    // Only increment date if it is not currently equal to today's date
    // Don't let the user view future dates
    if (date.getDate() != new Date().getDate()) {
      // Increment date by one day
      date.setDate(date.getDate() + 1);

      // Get food data and populate table
      getFoodData();
    }

  });
});