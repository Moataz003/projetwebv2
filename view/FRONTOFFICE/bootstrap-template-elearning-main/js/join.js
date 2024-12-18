function handleFormSubmit(event) {
    event.preventDefault();  // Prevent form submission for custom validation

    // Get form elements
    const name = document.getElementById('name').value.trim();
    const surname = document.getElementById('surname').value.trim();
    const email = document.getElementById('email').value.trim();
    const contact = document.getElementById('contact').value.trim();

    // Custom validation checks
    if (!name || !surname || !email || !contact) {
        alert("Please fill in all the fields.");
        return false;
    }
    
    // Name and surname validation (no numbers or special characters)
    const namePattern = /^[a-zA-Z\s]+$/;
    if (!namePattern.test(name)) {
        alert("Name should only contain letters and spaces.");
        return false;
    }

    if (!namePattern.test(surname)) {
        alert("Surname should only contain letters and spaces.");
        return false;
    }

    // Email format validation (basic)
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    // All fields are valid, proceed with form submission (optional AJAX or normal submit)
    alert("Form submitted successfully!");
    return true;
}
