function validateTagName(tagName) {
    const regex = /^[A-Za-z0-9\s_]+$/;
    return regex.test(tagName);
}

function showError(message) {
    const errorSpan = document.getElementById('tagNameError');
    if (errorSpan) {
        errorSpan.textContent = message;
        errorSpan.style.display = 'block';
    }
}

function clearError() {
    const errorSpan = document.getElementById('tagNameError');
    if (errorSpan) {
        errorSpan.textContent = '';
        errorSpan.style.display = 'none';
    }
}

function validateTagForm(formId) {
    const tagNameInput = document.getElementById('tag_name');
    const tagName = tagNameInput.value.trim();
    
    // Clear any previous error
    clearError();
    
    // Check if empty
    if (tagName === '') {
        showError('Tag name cannot be empty');
        tagNameInput.focus();
        return false;
    }

    // Check pattern
    if (!validateTagName(tagName)) {
        showError('Tag name can only contain letters, numbers, spaces, and underscores');
        tagNameInput.focus();
        return false;
    }

    return true;
} 