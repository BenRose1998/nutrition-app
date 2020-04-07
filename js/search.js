$(document).ready(function () {
  console.log("Search script running");

  // Post food data to database
  function postToDatabase(data, quantity) {
    // Construct request
    const request = {
      name: data.foods[0].food_name,
      serving_unit: data.foods[0].serving_unit,
      serving_base: data.foods[0].serving_qty,
      serving_quantity: quantity,
      calories: data.foods[0].nf_calories,
      fat: data.foods[0].nf_total_fat,
      salt: data.foods[0].nf_sodium,
      protein: data.foods[0].nf_protein,
      carbohydrates: data.foods[0].nf_total_carbohydrate,
      sugar: data.foods[0].nf_sugars
    };

    // Request
    $.ajax({
      type: "POST",
      url: "api.php?type=addFood",
      headers: {},
      data: request,
      success: function (res) {
        console.log("Request: " + res);

        console.log("Posted to server");

        // Update nutrition charts
        // Only call this function if it exists (user is on the dashboard page)
        if (typeof updateCharts == 'function') { 
          updateCharts(); 
        }
      }
    });
  }

  // Modal
  $("#modal-previous-btn").on("click", function (event) {
    event.preventDefault();
    var current = $(".modal-quantity").text();
    $(".modal-quantity").text(current - 1);
  });

  $("#modal-next-btn").on("click", function (event) {
    event.preventDefault();
    var current = parseInt($(".modal-quantity").text());
    $(".modal-quantity").text(current + 1);
  });

  // Hide search results when anywhere on document is clicked
  $(document).on("click", function () {
    $(".results").hide();
  });
  // Don't hide search results if search bar is clicked
  $(".search").on("click", function (event) {
    // Prevents current event happening (clicking document to hide results)
    event.stopPropagation();
  });

  // Focus
  $(".search").on("focus", function () {
    $(".results").show();
  });

  // Typed
  $(".search").on("input", function () {
    console.log("Changed");

    if ($(".search").val() == "") {
      $(".results").hide();
    } else {
      $(".results").show();

      // URL
      const url =
        "https://trackapi.nutritionix.com/v2/search/instant?query=" +
        $(".search").val();

      // Request
      $.ajax({
        url: url,
        headers: {
          "x-app-id": "e89c61d3",
          "x-app-key": "8619e65d6db60b9d527293b94155c557"
        },
        success: function (res) {
          // console.log(res);

          // Remove all results from list
          $(".results").empty();
          // Loop through every result
          for (let key in res.common) {
            const name = res.common[key].food_name;
            const serving_unit = res.common[key].serving_unit;
            const serving_qty = res.common[key].serving_qty;
            const img = res.common[key].photo.thumb;
            $(".results").append(
              '<li class="list-group-item results-item"><img class="result-img" src="' +
              img +
              '"></img>' +
              name +
              " (" +
              serving_qty +
              " " +
              serving_unit +
              ")</li>"
            );
          }
        }
      });
    }
  });

  // When search result is clicked
  $(".results").on("click", ".results-item", function () {

    // Store reference to text of search result that was clicked
    var result = $(this).text();
    console.log(result);

    // Hide search results
    $(".results").hide();

    // Set quantity modal's title to the name of the food search result clicked
    $(".modal-title").text(result);

    // Display quantity modal
    $("#quantity-modal").modal("show");
  });

  // Quantity modal 'Add' button clicked
  $("#modal-add-btn").on("click", function (event) {

    // Prevent the button redirecting
    event.preventDefault();

    // Hide the modal
    $("#quantity-modal").modal("hide");

    // Store result text from modal's title element
    const result = $(".modal-title").text();

    // Store quantity value inputted by user
    const quantity = $(".modal-quantity").text();

    // Set quantity back to 1
    $(".modal-quantity").text("1");

    // URL
    const url = "https://trackapi.nutritionix.com/v2/natural/nutrients";

    // Store search result text in a JSON object
    const data = JSON.stringify({
      query: result
    });

    // Request
    $.ajax({
      type: "POST",
      url: url,
      headers: {
        "Content-Type": "application/json",
        "x-app-id": "e89c61d3",
        "x-app-key": "8619e65d6db60b9d527293b94155c557"
      },
      data: data,
      success: function (res) {
        // If data is returned from request, post it to the database
        postToDatabase(res, quantity);
      }
    });
  });

});