document.addEventListener('DOMContentLoaded', () => {
    
    document.getElementById('Nom').addEventListener('keyup', validateNom);
    document.getElementById('Prenom').addEventListener('keyup', validatePrenom);
    document.getElementById('Age').addEventListener('keyup', validateAge);
    document.getElementById('Num_tel').addEventListener('keyup', validateNumTel);
    document.getElementById('Email').addEventListener('keyup', validateEmail);
    document.getElementById('password').addEventListener('keyup', validatePassword);
    document.getElementById('Ville').addEventListener('keyup', validateVille);

    document.querySelector('form').addEventListener('submit', function (e) {
        let isValid = true;
        if (!validateNom()) isValid = false;
        if (!validatePrenom()) isValid = false;
        if (!validateAge()) isValid = false;
        if (!validateNumTel()) isValid = false;
        if (!validateEmail()) isValid = false;
        if (!validateVille()) isValid = false;
        if (!validatePassword()) isValid = false;

        if (!isValid) {
            e.preventDefault(); 
            alert("Veuillez corriger les erreurs avant de soumettre le formulaire.");
        }
    });
});


function validateNom() {
    const input = document.getElementById('Nom');
    const value = input.value.trim();

    if (value.length < 3 || value.length > 15) {
        createMessage(input, "Le nom doit contenir entre 3 et 15 caractères.", 'error');
        return false;
    } else {
        createMessage(input, "Nom valide.", 'success');
        return true;
    }
}

function validatePrenom() {
    const input = document.getElementById('Prenom');
    const value = input.value.trim();

    if (value.length < 3 || value.length > 15) {
        createMessage(input, "Le prénom doit contenir entre 3 et 15 caractères.", 'error');
        return false;
    } else {
        createMessage(input, "Prénom valide.", 'success');
        return true;
    }
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
    const telRegex = /^\d{8}$/;

    if (!telRegex.test(input.value)) {
        createMessage(input, "Le numéro de téléphone doit contenir exactement 8 chiffres.", 'error');
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

function validateVille() {
    const input = document.getElementById('Ville');
    const value = input.value.trim();

    if (value.length < 3) {
        createMessage(input, "La ville doit contenir au moins 3 caractères.", 'error');
        return false;
    } else {
        createMessage(input, "Ville valide.", 'success');
        return true;
    }
}

function validatePassword() {
    const input = document.getElementById('password');
    if (input.value !== "" && !/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{1,}$/.test(input.value)) {
        createMessage(input, "Le mot de passe doit contenir au moins une lettre majuscule, un chiffre et un caractère spécial.", 'error');
        return false;
    } else if (input.value === "") {
        createMessage(input, "Laissez vide si vous ne souhaitez pas modifier le mot de passe.", 'info');
        return true;
    } else {
        createMessage(input, "Mot de passe valide.", 'success');
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
    const messages = element.parentNode.querySelectorAll('.error, .success', '.info');
    messages.forEach((message) => message.remove());
}
