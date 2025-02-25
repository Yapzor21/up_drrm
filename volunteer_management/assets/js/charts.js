const ctxBar = document.getElementById("myChart").getContext("2d");

  new Chart(ctxBar, {
    type: "bar",
    data: {
      labels: ["Earthquake", "Floods", "Fire", "Accident", "Landslide", "Health Related"],
      datasets: [
        {
          label: "2022",
          data: [37.76, 95.57, 81.35, 99.92, 96.89, 89.84],
          backgroundColor: "rgba(104, 100, 236, 0.7)", // Purple
          borderColor: "rgba(104, 100, 236, 1)",
          borderWidth: 1
        },
        {
          label: "2023",
          data: [63.14, 70.79, 10.89, 84.27, 43.55, 24.38],
          backgroundColor: "rgba(255, 99, 132, 0.7)", // Red
          borderColor: "rgba(255, 99, 132, 1)",
          borderWidth: 1
        },
        {
          label: "2024",
          data: [19.69, 69, 93.13, 20.94, 59.18, 27.37],
          backgroundColor: "rgba(54, 162, 235, 0.7)", // Blue
          borderColor: "rgba(54, 162, 235, 1)",
          borderWidth: 1
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: "bottom",
          labels: {
            font: {
              size: 14
            }
          }
        },
        title: {
          display: true,
          text: "Emergency Incidents",
          font: {
            size: 18
          }
        }
      },
      scales: {
        x: {
          grid: {
            display: false
          }
        },
        y: {
          beginAtZero: true
        }
      }
    }
  });

  // Doughnut Chart
  const ctxDoughnut = document.getElementById("doughnutChart").getContext("2d");

  new Chart(ctxDoughnut, {
    type: 'doughnut',
    data: {
      labels: ['Barangay 30', 'Barangay 3', 'Barangay Sum Ag', 'Barangay 12', 'Others'],
      datasets: [{
        data: [154.7, 120, 128.69, 118.38, 163.52], // Adjusted values
        backgroundColor: ['#8A5CF5', '#FF6F61', '#3DB5F4', '#FFB74D', '#E57373'],
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'right',
          labels: {
            color: '#000', // Legend text color
            font: { size: 14 }
          }
        },
        title: {
          display: true,
          text: "Emergency Cases by Location",
          font: {
            size: 20
          }
        },
        tooltip: {
          enabled: true
        }
      }
    }
  });