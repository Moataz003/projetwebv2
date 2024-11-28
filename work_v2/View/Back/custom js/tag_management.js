let selectedTags = [];

function addSelectedTag() {
    const selectElement = document.getElementById('tag_select');
    const tagId = selectElement.value;
    const tagName = selectElement.options[selectElement.selectedIndex].text;
    
    if (!tagId) return; // Don't add if no tag is selected
    
    // Check if tag is already selected
    if (!selectedTags.some(tag => tag.id === tagId)) {
        selectedTags.push({
            id: tagId,
            name: tagName
        });
        updateTagsDisplay();
        updateHiddenInput();
    }
    
    // Reset select to default option
    selectElement.value = "";
}

function removeTag(tagId) {
    selectedTags = selectedTags.filter(tag => tag.id !== tagId);
    updateTagsDisplay();
    updateHiddenInput();
}

function updateTagsDisplay() {
    const container = document.getElementById('selected_tags');
    container.innerHTML = '';
    
    selectedTags.forEach(tag => {
        const tagElement = document.createElement('span');
        tagElement.className = 'tag-item';
        tagElement.innerHTML = `
            ${tag.name}
            <span class="tag-remove" onclick="removeTag('${tag.id}')">×</span>
        `;
        container.appendChild(tagElement);
    });
}

function updateHiddenInput() {
    const hiddenInput = document.getElementById('selected_tag_ids');
    if (hiddenInput) {
        const tagIds = selectedTags.map(tag => tag.id);
        hiddenInput.value = JSON.stringify(tagIds);
        console.log('Updated hidden input with tags:', hiddenInput.value); // Debug log
    }
}

// Add event listener for Enter key on tag input
document.addEventListener('DOMContentLoaded', function() {
    const tagInput = document.getElementById('tag_input');
    if (tagInput) {
        tagInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Prevent form submission
                addSelectedTag();
            }
        });
    }
}); 