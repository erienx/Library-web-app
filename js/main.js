
function checkInput(input) {
    if (input.value) {
        input.classList.add('has-content');
    } else {
        input.classList.remove('has-content');
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('form input');

    inputs.forEach(input => {
        checkInput(input);

        input.addEventListener('input', function() {
            checkInput(input);
        });

    });
});


function checkPasswordMatch() {
    const password = document.getElementById('pwd').value;
    const confirmPassword = document.getElementById('pwd_confirm').value;
    const errorMessage = document.getElementById('password-error');

    if (password !== confirmPassword) {
        if (!errorMessage) {
            const errorDiv = document.createElement('div');
            errorDiv.id = 'password-error';
            errorDiv.style.color = 'red';
            errorDiv.innerText = 'Passwords do not match';
            document.querySelector('form').appendChild(errorDiv);
        }
    } else {
        if (errorMessage) {
            errorMessage.remove();
        }
    }
}
