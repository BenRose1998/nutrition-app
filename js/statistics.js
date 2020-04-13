$(document).ready(function () {

  var chart;
  // Run weekly calories graph function on page load
  weeklyNutrition();

  // When a navigation tab link is clicked
  $(".nav-tabs>.nav-item>.nav-link").on("click", function (event) {
    // Destroys previous chart if exists
    if(chart){
      chart.destroy();
    }
    // Clear graph error text
    $('#graph-error').text("");
    // Prevent default events (navigating to different page)
    event.preventDefault();
    // Remove 'active' class from all tabb links
    $(".nav-tabs>.nav-item>.nav-link").each(function (index) {
      $(this).removeClass("active");
    });
    // Add 'active' class to this tab link
    $(this).addClass("active");

    // Execute different function depending on nav link selected (value stored in href attribute)
    switch ($(this).attr("href")) {
      case "calories":
        console.log("calories requested");
        weeklyCalories();
        break;
      case "protein":
        console.log("protein requested");
        weeklyProtein();
        break;
      case "nutrition":
        console.log("nutrition requested");
        weeklyNutrition();
        break;
      default:
        console.log("nothing requested");
        weeklyNutrition();
        break;
    }
  });

  // Gets dates for the last 7 days, returns an aray
  function getDates(){
    // Create a moment.js date object to store a date (initialised at today)
    let date = moment();

    // Create a dates array, populate with the date of today (e.g. 20)
    let dates = [date.date()];

    // Loop 6 times
    for (let index = 0; index <= 5; index++) {
      // Decrement the date by 1 day
      date.subtract(1, 'days');
      // Push the decremented date's date (e.g. 19) into the array
      dates.push(date.date());
    }

    // Reverse the array
    return dates.reverse();
  }

  // Get graph labels for days & dates for the last 7 days
  function getLabels() {
    const days = [
      "Sunday",
      "Monday",
      "Tuesday",
      "Wednesday",
      "Thursday",
      "Friday",
      "Saturday"
    ];

    // Create date object (today)
    const date1 = new Date();

    // Create array, initialise with value: 'Today'
    let labels = ['Today'];

    // Loop 6 times
    for (let index = 0; index <= 5; index++) {
      // Decrement the date by 1 day
      date1.setDate(date1.getDate() - 1);
      // Push day & date into the array
      labels.push(days[date1.getDay()] + ' ' + date1.getDate());
    }

    // Return the labels array (reversed)
    return labels.reverse();
  }

  // Display a graph of weekly calorie intake for the user
  function weeklyCalories() {
    // Request - requests all calories for every food item added within 7 days
    $.ajax({
      type: "GET",
      url: "api.php?type=weeklyCalories",
      dataType: "json",
      headers: {},
      success: function (res) {
		  
		console.log(res);
        // If no response print error
        if(res.length == 0){
          console.log("failed");
          $('#graph-error').text("No Data");
        }
        
        // Call getDates functions - returns an array of dates of last 7 days
        let dates = getDates();

        // Empty array
        let data = [];

        // Loop through every day (last 7 days)
        $.each(dates, function (key, d) {
          // Total calories for that day
          let total = 0;
          // Loop through every food
          $.each(res, function (key, food) {
            // Create JS date
            food.food_added = moment(food.food_added);
            // Check if the food's date matches the date
            if (food.food_added.date() == d) {
              // Add this food's calories to the day's total
              total += parseFloat(food.calories);
            }
          });
          // Push this day's calories into the data array
          data.push(parseFloat(total).toFixed(2));
        });
		console.log(data);
        // Form chart
        chart = new Chart(graph, {
          type: 'bar',
          data: {
            labels: getLabels(),
            datasets: [{
              data: data,
              label: "Calories",
              backgroundColor: "#00c301",
              fill: false
            }]
          },
          options: {
            maintainAspectRatio: false
          }
        });
      }
    });
  }

  // Display a graph of weekly protein intake for the user
  function weeklyProtein() {
    // Request - requests all calories for every food item added within 7 days
    $.ajax({
      type: "GET",
      url: "api.php?type=weeklyProtein",
      dataType: "json",
      headers: {},
      success: function (res) {
        // If no response print error
        if(res.length == 0){
          console.log("failed");
          $('#graph-error').text("No Data");
        }
        
        // Call getDates functions - returns an array of dates of last 7 days
        let dates = getDates();

        // Empty array
        let data = [];

        // Loop through every day (last 7 days)
        $.each(dates, function (key, d) {
          // Total calories for that day
          let total = 0;
          // Loop through every food
          $.each(res, function (key, food) {
            // Create JS date
            food.food_added = moment(food.food_added);
            // Check if the food's date matches the date
            if (food.food_added.date() == d) {
              // Add this food's calories to the day's total
              total += parseFloat(food.protein);
            }
          });
          // Push this day's calories into the data array
          data.push(parseFloat(total).toFixed(2));
        });

        // Form chart
        chart = new Chart(graph, {
          type: 'bar',
          data: {
            labels: getLabels(),
            datasets: [{
              data: data,
              label: "Protein",
              backgroundColor: "#00c301",
              fill: false
            }]
          },
          options: {
            maintainAspectRatio: false
          }
        });
      }
    });
  }


  // Display a graph of weekly protein intake for the user
  function weeklyNutrition() {
    // Request - requests all calories for every food item added within 7 days
    $.ajax({
      type: "GET",
      url: "api.php?type=weeklyNutrition",
      dataType: "json",
      headers: {},
      success: function (res) {
        // If no response print error
        if(res.length == 0){
          console.log("failed");
          $('#graph-error').text("No Data");
        }
        
        // Call getDates functions - returns an array of dates of last 7 days
        let dates = getDates();

        // Get keys of all values received (types - type(e.g. fat))
        const types = Object.keys(res[0]);

        // Remove the last element from types array (food_added)
        types.pop();

        // Create empty object to store all data
        let data = {};

        // Loop through all types (type: e.g. fat)
        $.each(types, function (key, type) {
          // Empty array to store data on that type
          let type_data = [];

          // Loop through every day (last 7 days)
          $.each(dates, function (key, d) {
            // Total value for that day
            let total = 0;
            // Loop through every food
            $.each(res, function (key, food) {
              // Create moment.js date
              food.food_added = moment(food.food_added);
              // Check if the food's date matches the current date (in loop)
              if (food.food_added.date() == d) {
                // If nutrition type is salt, divide value by 1000 to convert from milligrams to grams
                if(type == 'salt'){
                  // Add this food's value to the day's total
                  total += parseFloat(food[type] / 1000);
                }else{
                  // Add this food's value to the day's total
                  total += parseFloat(food[type]);
                }
                
                
              }
            });
            // Push this day's total into the type_data array
            type_data.push(parseFloat(total).toFixed(2));
          });
          // At to data object with key of this type (e.g. data.fat)
          data[type] = type_data;
        });

        console.log(data);
        

        // Form chart
        chart = new Chart(graph, {
          type: 'bar',
          data: {
            labels: getLabels(),
            datasets: [{
                data: data.carbohydrates,
                label: "Carbohydrates",
                backgroundColor: "#00C301",
                fill: false
              },
              {
                data: data.protein,
                label: "Protein",
                backgroundColor: "#4DED30",
                fill: false
              },
              {
                data: data.fat,
                label: "Fat",
                backgroundColor: "#00C301",
                fill: false
              },
              {
                data: data.salt,
                label: "Salt",
                backgroundColor: "#4DED30",
                fill: false
              },
              {
                data: data.sugar,
                label: "Sugar",
                backgroundColor: "#00C301",
                fill: false
              }
            ]
          },
          options: {
            maintainAspectRatio: false
          }
        });
      }
    });
  }
});