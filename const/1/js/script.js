document.getElementById('selected').addEventListener('click', function() {
    const options = document.getElementById('options');
    options.style.display = options.style.display === 'block' ? 'none' : 'block';
});

const optionElements = document.querySelectorAll('.option');
optionElements.forEach(option => {
    option.addEventListener('click', function() {
        const selectedValue = this.getAttribute('data-value');
        document.getElementById('selected').innerText = this.innerText;
        document.getElementById('options').style.display = 'none';

        // You can handle the selected image value here
        console.log('Selected image:', selectedValue);
    });
});

// Close the dropdown if clicked outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.custom-select')) {
        document.getElementById('options').style.display = 'none';
    }
});
