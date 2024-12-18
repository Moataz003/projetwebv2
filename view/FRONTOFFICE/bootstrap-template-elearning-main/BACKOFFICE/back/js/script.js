function validateForm(event) {
    // Prevent form submission for validation
    event.preventDefault();

    // Get form values
    const title = document.getElementById('title').value.trim();
    const description = document.getElementById('description').value.trim();
    const location = document.getElementById('location').value.trim();
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const status = document.getElementById('status').value;
    const logo = document.querySelector('input[name="logo"]').files[0];

    // Validate Title (only alphabetic characters and spaces)
    const titlePattern = /^[a-zA-Z\s]+$/;
    if (!title || !titlePattern.test(title)) {
        alert("Title must only contain alphabetic characters and spaces.");
        return false;
    }

    // Validate Description
    if (!description) {
        alert("Description cannot be empty.");
        return false;
    }

    // Validate Location
    if (!location) {
        alert("Location cannot be empty.");
        return false;
    }

    // Validate Start Date
    if (!startDate) {
        alert("Start Date is required.");
        return false;
    }
    const currentDate = new Date();
    const startDateTime = new Date(startDate);
    if (startDateTime < currentDate) {
        alert("Start Date cannot be in the past.");
        return false;
    }

    // Validate End Date
    if (!endDate) {
        alert("End Date is required.");
        return false;
    }
    const endDateTime = new Date(endDate);
    if (endDateTime <= startDateTime) {
        alert("End Date cannot be earlier than or equal to the Start Date.");
        return false;
    }

    // Validate Status
    if (!status) {
        alert("Status must be selected.");
        return false;
    }

    // If all validations pass, allow form submission
    alert("Form submitted successfully!");
    document.getElementById("updateForm").submit();
    return true;
    
}