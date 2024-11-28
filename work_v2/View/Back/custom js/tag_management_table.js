let currentTaskId = null;
const modal = document.getElementById('addTagModal');

// Function to show modal and load tags
function showAddTagModal(taskId) {
    console.log('Opening modal for task:', taskId); // Debug log
    currentTaskId = taskId;
    
    // Show the modal first
    modal.style.display = "block";
    
    // Clear and load the select options
    const select = document.getElementById('modalTagSelect');
    select.innerHTML = '<option value="">Select a tag</option>';
    
    // Fetch available tags
    fetch(`get_available_tags.php?task_id=${taskId}`)
        .then(response => response.json())
        .then(data => {
            console.log('Received tags:', data); // Debug log
            if (data.success && data.tags) {
                data.tags.forEach(tag => {
                    const option = document.createElement('option');
                    option.value = tag.tag_id;
                    option.textContent = tag.tag_name;
                    select.appendChild(option);
                });
            }
        })
        .catch(error => console.error('Error loading tags:', error));
}

// Close button handler
document.querySelector('.close').onclick = function() {
    modal.style.display = "none";
}

// Click outside modal to close
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Add tag function
function addTagToTask() {
    const tagSelect = document.getElementById('modalTagSelect');
    const tagId = tagSelect.value;
    
    if (!tagId) {
        alert('Please select a tag');
        return;
    }

    const formData = new URLSearchParams();
    formData.append('task_id', currentTaskId);
    formData.append('tag_id', tagId);

    fetch('add_tag_to_task.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData.toString()
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Response:', data); // Debug log
        if (data.success) {
            window.location.reload();
        } else {
            alert('Error adding tag: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error details:', error);
        alert('Error adding tag. Please try again.');
    });
} 