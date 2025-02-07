document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            let isValid = true;
            
            const inputs = form.querySelectorAll('input[type="email"], input[type="password"], input[type="date"], input[type="time"], select');
            
            inputs.forEach(input => {
                if (input.value.trim() === '') {
                    isValid = false;
                    input.classList.add('is-invalid');
                    const feedbackElement = input.nextElementSibling;
                    if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                        feedbackElement.textContent = 'This field is required.';
                    }
                } else {
                    input.classList.remove('is-invalid');
                    const feedbackElement = input.nextElementSibling;
                    if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                        feedbackElement.textContent = '';
                    }
                }
            });
            
            if (!isValid) {
                event.preventDefault();
            }
        });
    });
});
// Add this to your existing validation.js file

document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            let isValid = true;
            
            const inputs = form.querySelectorAll('input[type="email"], input[type="password"], input[type="date"], input[type="time"], input[type="text"], select, textarea');
            
            inputs.forEach(input => {
                if (input.value.trim() === '') {
                    isValid = false;
                    input.classList.add('is-invalid');
                    const feedbackElement = input.nextElementSibling;
                    if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                        feedbackElement.textContent = 'This field is required.';
                    }
                } else {
                    input.classList.remove('is-invalid');
                    const feedbackElement = input.nextElementSibling;
                    if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                        feedbackElement.textContent = '';
                    }
                }
            });
            
            if (!isValid) {
                event.preventDefault();
            }
        });
    });
});