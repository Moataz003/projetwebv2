function validateForm(event) {
    // Prevent form submission to validate inputs
    event.preventDefault();

    // Get form values
    const title = document.getElementById('title').value.trim();
    const description = document.getElementById('description').value.trim();
    const location = document.getElementById('location').value.trim();
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const status = document.getElementById('status').value;
    const logo = document.querySelector('input[name="logo"]').files[0];

    // Validate Title
    if (!title) {
        alert("Title is required.");
        return false;
    }

    // Validate Description
    if (!description) {
        alert("Description is required.");
        return false;
    }

    // Validate Location
    if (!location) {
        alert("Location is required.");
        return false;
    }

    // Validate Start Date and End Date
    if (!startDate) {
        alert("Start Date is required.");
        return false;
    }

    if (!endDate) {
        alert("End Date is required.");
        return false;
    }

    // Validate Title (only alphabetic characters and spaces)
    const titlePattern = /^[a-zA-Z\s]+$/;
    if (!title || !titlePattern.test(title)) {
        alert("Title must only contain alphabetic characters and spaces.");
        return false;
    }
    
    // Check if Start Date is in the past
    const currentDate = new Date();
    const startDateTime = new Date(startDate);
    if (startDateTime < currentDate) {
        alert("Start Date cannot be in the past.");
        return false;
    }

    // Check if End Date is before Start Date
    const endDateTime = new Date(endDate);
    if (endDateTime <= startDateTime) {
        alert("End Date cannot be earlier than or equal to Start Date.");
        return false;
    }

    // Validate Status
    if (!status) {
        alert("Status must be selected.");
        return false;
    }

    // Validate Image File (Optional, if the logo field is provided)
    if (logo) {
        const allowedExtensions = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedExtensions.includes(logo.type)) {
            alert("Only image files (JPEG, PNG, GIF) are allowed for the logo.");
            return false;
        }
    }

    // If all validations pass, submit the form
    alert("Form submitted successfully!");
    document.getElementById("eventForm").submit();
    return true;
}