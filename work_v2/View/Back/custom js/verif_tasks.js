function validateTaskForm() {
  // Get form elements
  const courseSelect = document.getElementById("course_id");
  const taskNameInput = document.getElementById("task_name");
  const taskDescriptionInput = document.getElementById("task_description");

  // Get error spans
  const courseError = document.getElementById("courseError");
  const taskNameError = document.getElementById("taskNameError");
  const taskDescriptionError = document.getElementById("taskDescriptionError");

  // Reset error messages
  courseError.textContent = "";
  taskNameError.textContent = "";
  taskDescriptionError.textContent = "";

  let isValid = true; // Track overall form validity

  // Validate course selection
  if (!courseSelect.value) {
    courseError.textContent = "Please select a course.";
    isValid = false;
  }

  // Validate task name
  const taskNamePattern = /^[A-Za-z0-9 _]+$/;
  const taskNameValue = taskNameInput.value.trim();
  if (!taskNameValue) {
    taskNameError.textContent = "Task Name is required.";
    isValid = false;
  } else if (!taskNamePattern.test(taskNameValue)) {
    taskNameError.textContent =
      "Task Name can only contain letters, numbers, spaces, and underscores.";
    isValid = false;
  }

  // Validate task description
  if (!taskDescriptionInput.value.trim()) {
    taskDescriptionError.textContent = "Task Description is required.";
    isValid = false;
  }

  // Return form validity
  return isValid;
}
