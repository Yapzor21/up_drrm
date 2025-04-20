const cityList = [
'Bacolod', 

'Bago' ,

'Cadiz' ,

'Escalante' ,

'Himamaylan',

'Iloilo City' ,

'Kabankalan' ,

'La Carlota' ,

'Passi' ,

'Roxas' ,

'Sagay' ,

'San Carlos' ,

'Silay' ,

'Sipalay' ,

'Talisay',

'Victorias'
];

// Wait for DOM to fully load
document.addEventListener('DOMContentLoaded', function() {
    const citySelect = document.getElementById('city');

    cityList.forEach(function(cityName) {
        const option = document.createElement('option');
        option.value = cityName;
        option.textContent = cityName;
        citySelect.appendChild(option);
    });
});




