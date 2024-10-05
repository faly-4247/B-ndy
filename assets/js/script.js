document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('modifyForm');
    const errorMessage = document.getElementById('errorMessage');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
       
        const espece_id = document.getElementById('espece_id').value;
        const quantite = document.getElementById('quantite').value;

        if (espece_id.trim() === '' || quantite.trim() === '') {
            errorMessage.textContent = 'Veuillez remplir tous les champs.';
            errorMessage.style.opacity = '1';
        } else {
            errorMessage.style.opacity = '0';

            // Simulate successful form submission for demo
            form.classList.add('submitted');
            setTimeout(() => {
                alert('Stock modifié avec succès !');
                form.submit();
            }, 500);
        }
    });

    // Add focus animation to inputs
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'scale(1.05)';
            this.style.transition = 'transform 0.3s ease';
        });
        input.addEventListener('blur', function() {
            this.style.transform = 'scale(1)';
        });
    });
});
