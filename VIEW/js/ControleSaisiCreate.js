console.log("JavaScript file is loaded.");

document.addEventListener("DOMContentLoaded", function () {
    // Select the form and input elements
    const form = document.querySelector("form");
    const nameInput = document.getElementById("name");
    const descriptionInput = document.getElementById("description");

    // Function to display error messages
    function displayError(element, message) {
        // Remove any existing error
        const existingError = element.parentElement.querySelector(".error");
        if (existingError) {
            existingError.remove();
        }

        // Create and add the new error message
        const error = document.createElement("small");
        error.className = "error";
        error.style.color = "red";
        error.textContent = message;
        element.parentElement.appendChild(error);
    }

    // Function to remove error messages
    function clearError(element) {
        const existingError = element.parentElement.querySelector(".error");
        if (existingError) {
            existingError.remove();
        }
    }

    // Validate name input
    function validateName() {
        const name = nameInput.value.trim();
        const namePattern = /^[A-Za-z\s]+$/; // Only allows letters and spaces

        if (name === "") {
            displayError(nameInput, "Name is required.");
            return false;
        }
        if (name.length > 15) {
            displayError(nameInput, "Name must not exceed 15 characters.");
            return false;
        }
        if (!namePattern.test(name)) {
            displayError(nameInput, "Name cannot contain numbers.");
            return false;
        }
        clearError(nameInput);
        return true;
    }

    // Validate description input
    function validateDescription() {
        const description = descriptionInput.value.trim();

        if (description === "") {
            displayError(descriptionInput, "Description is required.");
            return false;
        }
        if (description.length > 30) {
            displayError(descriptionInput, "Description must not exceed 30 characters.");
            return false;
        }
        clearError(descriptionInput);
        return true;
    }

    // Attach event listeners for real-time validation
    nameInput.addEventListener("input", validateName);
    descriptionInput.addEventListener("input", validateDescription);

    // Validate form on submit
    form.addEventListener("submit", function (event) {
        const isNameValid = validateName();
        const isDescriptionValid = validateDescription();

        // If any validation fails, prevent form submission
        if (!isNameValid || !isDescriptionValid) {
            event.preventDefault();
        }
    });
});