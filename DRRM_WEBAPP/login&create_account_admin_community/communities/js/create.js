// password hidden
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const type = input.type === 'password' ? 'text' : 'password';
    input.type = type;
}



// select barangay
const barangays = [
    'Alijis', 'Banago', 'Bata', 'Granada', 'Mandalagan',
    'Mansilingan', 'Pahanocoy', 'Singcang', 'Sum-ag', 'Taculing'
];

// Populate barangay dropdown
const barangaySelect = document.getElementById('barangay');
barangays.forEach(barangay => {
    const option = document.createElement('option');
    option.value = barangay;
    option.textContent = barangay;
    barangaySelect.appendChild(option);
});

