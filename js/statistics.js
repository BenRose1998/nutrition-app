$(document).ready(function () {

  function getLabels(){
    const days = [
      "Sunday",
      "Monday",
      "Tuesday",
      "Wednesday",
      "Thursday",
      "Friday",
      "Saturday"
    ];
    const date1 = new Date();
    
    let labels = ['Today'];
  
    // Loop 6 times
    for (let index = 0; index <= 5; index++) {
      // Decrement the date by 1 day
      date1.setDate(date1.getDate() - 1);
      // Push day & date into the array
      labels.push(days[date1.getDay()] + ' ' + date1.getDate());
    }
    return labels.reverse();
  }

  // Request - requests all calories for every food item added within 7 days
  $.ajax({
    type: "GET",
    url: "requests.php?type=weeklyCalories",
    dataType: "json",
    headers: {},
    success: function (res) {
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
      dates.reverse();
      
      // Empty array
      let data = [];

      // Loop through every day (last 7 days)
      $.each(dates, function(key, d) {
        // Total calories for that day
        let total = 0;
        // Loop through every food
        $.each(res, function(key, food) {
          // Create JS date
          food.food_added = moment(food.food_added);
          // Check if the food's date matches the date
          if(food.food_added.date() == d){
            // Add this food's calories to the day's total
            total += food.calories;
          }
        });
        // Push this day's calories into the data array
        data.push(total);
      });
      
      // Form chart
      var chart = new Chart(calories, {
        type: 'line',
        data: {
          labels: getLabels(),
          datasets: [{ 
              data: data,
              label: "Calories",
              borderColor: "#3e95cd",
              fill: false
            }
          ]
        },
        options: {}
      });
    }
  });

});