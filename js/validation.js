document.getElementById('registerForm').addEventListener('submit', function(event) {
    var isValid = true;
    var fullName = document.getElementById('fullName').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    if(fullName.length === 0 || /[\d]/.test(fullName)) {
        alert('Numele complet este obligatoriu.');
        isValid = false;
    }

    if(email.length === 0 || !email.includes('@')) {
        alert('Introduceți o adresă de email validă.');
        isValid = false;
    }

    if(password.length < 6) {
        alert('Parola trebuie să fie de cel puțin 6 caractere.');
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault();
    }
});
