document.addEventListener('DOMContentLoaded', () => {
    // Add event listeners for input fields
    document.getElementById('Nom').addEventListener('keyup', validateNomPrenom);
    document.getElementById('Prenom').addEventListener('keyup', validateNomPrenom);
    document.getElementById('Age').addEventListener('keyup', validateAge);
    document.getElementById('Num_tel').addEventListener('keyup', validateNumTel);
    document.getElementById('Email').addEventListener('keyup', validateEmail);

    // Main form validation on submit
    document.querySelector('form').addEventListener('submit', function (e) {
        let isValid = true;
        if (!validateNomPrenom()) isValid = false;
        if (!validateAge()) isValid = false;
        if (!validateNumTel()) isValid = false;
        if (!validateEmail()) isValid = false;

        if (!isValid) {
            e.preventDefault(); // Prevent form submission if validation fails
            alert("Veuillez corriger les erreurs avant de soumettre le formulaire.");
        }
    });
});

// Validation functions
function validateNomPrenom() {
    let isValid = true;

    ['Nom', 'Prenom'].forEach((id) => {
        const input = document.getElementById(id);
        if (input.value.trim() === '') {
            createMessage(input, `${id} ne doit pas être vide.`, 'error');
            isValid = false;
        } else {
            createMessage(input, `${id} valide.`, 'success');
        }
    });

    return isValid;
}

function validateAge() {
    const input = document.getElementById('Age');
    const age = parseInt(input.value, 10);

    if (isNaN(age) || age <= 0) {
        createMessage(input, "L'âge doit être un entier positif.", 'error');
        return false;
    } else {
        createMessage(input, "Âge valide.", 'success');
        return true;
    }
}

function validateNumTel() {
    const input = document.getElementById('Num_tel');
    const telRegex = /^\d+$/;

    if (!telRegex.test(input.value)) {
        createMessage(input, "Le numéro de téléphone doit contenir uniquement des chiffres.", 'error');
        return false;
    } else {
        createMessage(input, "Numéro de téléphone valide.", 'success');
        return true;
    }
}

function validateEmail() {
    const input = document.getElementById('Email');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(input.value)) {
        createMessage(input, "Veuillez entrer un email valide.", 'error');
        return false;
    } else {
        createMessage(input, "Email valide.", 'success');
        return true;
    }
}

// Utility functions
function createMessage(element, message, type) {
    clearMessages(element);
    const messageElement = document.createElement('p');
    messageElement.textContent = message;
    messageElement.className = type;
    element.parentNode.appendChild(messageElement);
}

function clearMessages(element) {
    const messages = element.parentNode.querySelectorAll('.error, .success');
    messages.forEach((message) => message.remove());
}
