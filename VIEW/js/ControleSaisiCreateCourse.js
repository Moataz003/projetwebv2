console.log("JavaScript file is loaded.");

document.addEventListener("DOMContentLoaded", function () {
    // Select the form and input elements
    const form = document.querySelector("form");
    const courseNameInput = document.getElementById("courseName");
    const descriptionInput = document.getElementById("description");
    const priceInput = document.getElementById("price");
    const categorySelect = document.getElementById("category");

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

    // Validate course name input (must only contain letters and spaces)
    function validateCourseName() {
        const courseName = courseNameInput.value.trim();
        
        // Check if course name is empty
        if (courseName === "") {
            displayError(courseNameInput, "Course name is required.");
            return false;
        }

        // Check if course name contains only alphabetic characters and spaces
        const regex = /^[A-Za-z\s]+$/; // Only allows letters and spaces
        if (!regex.test(courseName)) {
            displayError(courseNameInput, "Course name must contain only letters and spaces.");
            return false;
        }

        clearError(courseNameInput);
        return true;
    }

    // Validate description input
    function validateDescription() {
        const description = descriptionInput.value.trim();
        if (description === "") {
            displayError(descriptionInput, "Description is required.");
            return false;
        }
        if (description.length < 10) {
            displayError(descriptionInput, "Description must be at least 10 characters long.");
            return false;
        }
        clearError(descriptionInput);
        return true;
    }

    // Validate price input
    function validatePrice() {
        const price = priceInput.value.trim();
        if (price === "") {
            displayError(priceInput, "Price is required.");
            return false;
        }
        if (isNaN(price) || parseFloat(price) <= 0) {
            displayError(priceInput, "Please enter a valid price greater than zero.");
            return false;
        }
        clearError(priceInput);
        return true;
    }

    // Validate category selection
    function validateCategory() {
        if (categorySelect.value === "") {
            displayError(categorySelect, "Please select a category.");
            return false;
        }
        clearError(categorySelect);
        return true;
    }

    // Attach event listeners for real-time validation
    courseNameInput.addEventListener("input", validateCourseName);
    descriptionInput.addEventListener("input", validateDescription);
    priceInput.addEventListener("input", validatePrice);
    categorySelect.addEventListener("change", validateCategory);

    // Validate form on submit
    form.addEventListener("submit", function (event) {
        const isCourseNameValid = validateCourseName();
        const isDescriptionValid = validateDescription();
        const isPriceValid = validatePrice();
        const isCategoryValid = validateCategory();

        // If any validation fails, prevent form submission
        if (!isCourseNameValid || !isDescriptionValid || !isPriceValid || !isCategoryValid) {
            event.preventDefault();
        }
    });
});
