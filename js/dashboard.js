function updateChartData(chart, data) {
  // Add new data
  chart.data.datasets[0].data = data;

  // Update chart
  chart.update();
}

// Update a charts border colour and width (default colour to grey and width to 0)
function updateChartBorder(chart, colour = "rgba(0, 0, 0, 0.1)", width = 0) {
  // Update chart's border colour
  chart.data.datasets[0].borderColor[0] = colour;
  // Update chart's border width
  chart.data.datasets[0].borderWidth[0] = width;

  // Update chart
  chart.update();
}

function updateCharts() {
  // Request
  $.ajax({
    type: "GET",
    url: "api.php?type=getNutrition",
    headers: {},
    success: function (res) {
      console.log(res);

      d = JSON.parse(res);

      // ----------------------------------------------------------------------
      // Calorie Chart
      var cal_remaining = d.calorie_goal - Math.round(d.calories);

      // Check if remaining calories is less than or equal to 0
      if (cal_remaining <= 0) {
        // Prevent remaining calories going below 0
        cal_remaining = 0;
        // Set chart's border to demonstrate breaking nutrition goal
        updateChartBorder(chart_calories, "#d62828", 5);
      } else {
        // Set chart's border to default
        updateChartBorder(chart_calories);
      }

      // Update calorie chart's data (calories eaten and calories remaining)
      updateChartData(chart_calories, [Math.round(d.calories), cal_remaining]);

      $("#calories-text").text(
        "Calories (" + Math.round(d.calories) + "/" + d.calorie_goal + ")"
      );

      // ----------------------------------------------------------------------
      // Nutrition Chart

      updateChartData(chart_nutrition, [
        Math.round(d.protein),
        Math.round(d.carbohydrates),
        Math.round(d.fat),
        Math.round(d.sugar),
        Math.round(d.salt / 1000)
      ]);

      // ----------------------------------------------------------------------
      // Protein Chart
      var protein_remaining = d.protein_goal - Math.round(d.protein);

      // Check if remaining protein is less than or equal to 0
      if (protein_remaining <= 0) {
        // Prevent remaining protein going below 0
        protein_remaining = 0;
        // Set chart's border to demonstrate breaking nutrition goal
        updateChartBorder(chart_protein, "#d62828", 5);
      } else {
        // Set chart's border to default
        updateChartBorder(chart_protein);
      }

      // Update protein chart's data (protein eaten and protein remaining)
      updateChartData(chart_protein, [Math.round(d.protein), protein_remaining]);
      $("#protein-text").text(
        "Protein (" + Math.round(d.protein) + "/" + d.protein_goal + "g)"
      );
      // ----------------------------------------------------------------------

    }
  });
}

// Set up charts
// Chart.js documentation used - https://www.chartjs.org/

// Calories Chart
// Store reference to the HTML canvas
var calories = document.getElementById("calories").getContext("2d");
// Create the chart
var chart_calories = new Chart(calories, {
  type: "doughnut",
  data: {
    labels: ["Calories eaten", "Calories remaining"],
    datasets: [{
      label: "calories",
      // Two data values, 1 - Calorie count, 2 - Calorie goal
      data: [0, 0],
      backgroundColor: ["#00C301"],
      borderColor: ["rgba(0, 0, 0, 0.1)"],
      borderWidth: [0]
    }]
  },
  options: {
    responsive: true,
    legend: {
      display: false
    },
    tooltip: {
      enabled: false
    }
  }
});

// Nutrition Chart
// Store reference to the HTML canvas
var nutrition = document.getElementById("nutrition").getContext("2d");
// Create the chart
var chart_nutrition = new Chart(nutrition, {
  type: "pie",
  data: {
    labels: ["Protein", "Carbs", "Fat", "Sugar", "Salt"],
    datasets: [{
      // Values: Protein, Carbs, Fat, Sugar, Salt
      data: [0, 0, 0, 0, 0],
      backgroundColor: ["#00C301", "#4DED30", "#00C301", "#4DED30", "#00C301"]
    }]
  },
  options: {
    responsive: true,
    legend: {
      display: true,
      position: "bottom"
    }
  }
});

// Protein Chart
// Store reference to the HTML canvas
var protein = document.getElementById("protein").getContext("2d");
// Create the chart
var chart_protein = new Chart(protein, {
  type: "doughnut",
  data: {
    labels: ["Protein eaten"],
    datasets: [{
      label: "protein",
      data: [0, 0],
      backgroundColor: ["#00C301"],
      borderColor: ["rgba(0, 0, 0, 0.1)"],
      borderWidth: [0]
    }]
  },
  options: {
    responsive: true,
    legend: {
      display: false
    },
    tooltip: {
      enabled: false
    }
  }
});

updateCharts();
setInterval(updateCharts(), 1000);