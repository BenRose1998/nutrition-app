function updateChartData(chart, data) {
  // Add new data
  chart.data.datasets[0].data = data;

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

      var cal_limit = 2000;
      var cal_remaining = d.calorie_goal - Math.round(d.calories);

      // Prevent remaining calories going below 0
      if (cal_remaining < 0){
        cal_remaining = 0;
      }

      updateChartData(chart_calories, [Math.round(d.calories), cal_remaining]);
      $("#calories-text").text(
        "Calories (" + Math.round(d.calories) + "/" + d.calorie_goal + ")"
      );

      updateChartData(chart_nutrition, [
        Math.round(d.protein),
        Math.round(d.carbohydrates),
        Math.round(d.fat),
        Math.round(d.sugar),
        Math.round(d.salt / 1000)
      ]);

      var pro_limit = 60;
      updateChartData(chart_protein, [Math.round(d.protein), d.protein_goal]);
      $("#protein-text").text(
        "Protein (" + Math.round(d.protein) + "/" + d.protein_goal + "g)"
      );

      console.log("updated charts");
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
    labels: ["Calories eaten"],
    datasets: [{
      label: "calories",
      // Two data values, 1 - Calorie count, 2 - Calorie goal
      data: [0, 0],
      backgroundColor: ["#00C301"],
      borderColor: ["#FF0000"],
      borderWidth: [3]
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
      backgroundColor: ["#00C301"]
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