
document.addEventListener('DOMContentLoaded', function() {
    createBarChart();
    createPieChart();
});



function createBarChart() {
    const incidentsCtx = document.getElementById('incidentsChart').getContext('2d');
    
    new Chart(incidentsCtx, {
        type: 'bar',
        data: disasterTypeData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Emergency Incidents by Disaster Type',
                    font: { size: 16 }
                },
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                x: {
                    stacked: false,
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function createPieChart() {
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    
    // Generate colors for pie chart segments
    const backgroundColors = [
        '#8A5CF5', // Purple
        '#FF6F61', // Coral
        '#3DB5F4', // Blue
        '#FFB74D', // Orange
        '#E57373'  // Red
    ];
    
    new Chart(categoriesCtx, {
        type: 'pie',
        data: {
            labels: locationData.labels,
            datasets: [{
                data: locationData.data,
                backgroundColor: backgroundColors
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Emergency Cases by Location',
                    font: { size: 16 }
                },
                legend: {
                    position: 'right'
                }
            }
        }
    });
}
