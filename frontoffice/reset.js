
function togglePasswordVisibility(fieldId, toggleButtonId) {
    const field = document.getElementById(fieldId);
    const toggleButton = document.getElementById(toggleButtonId);

    if (field.type === "password") {
        field.type = "text";
        toggleButton.textContent = "🙈";
    } else {
        field.type = "password";
        toggleButton.textContent = "👁️";
    }
}


document.getElementById("toggleNewPassword").addEventListener("click", function () {
    togglePasswordVisibility("new_password", "toggleNewPassword");
});

document.getElementById("toggleConfirmPassword").addEventListener("click", function () {
    togglePasswordVisibility("confirm_password", "toggleConfirmPassword");
});


document.getElementById("resetForm").addEventListener("submit", function (event) {
    const newPassword = document.getElementById("new_password").value;
    const confirmPassword = document.getElementById("confirm_password").value;

    
    if (newPassword !== confirmPassword) {
        alert("Passwords do not match.");
        event.preventDefault();
        return;
    }

   
    const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{4,}$/;
    if (!passwordRegex.test(newPassword)) {
        alert("Password does not meet the required criteria.");
        event.preventDefault();
        return;
    }
});
