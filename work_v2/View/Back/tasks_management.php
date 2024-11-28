<!DOCTYPE HTML>
<html lang="en">

<!-- Mirrored from www.ecommerce-admin.com/demo/page-form-product-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 Apr 2022 00:14:44 GMT -->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Dashboard</title>

	<link href="./images/wajahni.png" rel="shortcut icon" type="image/x-icon">

	<link href="css/bootstrapf9e3.css?v=1.1" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="fonts/material-icon/css/round.css" />

	<!-- custom style -->
	<link href="css/uif9e3.css?v=1.1" rel="stylesheet" type="text/css" />
	<link href="css/responsivef9e3.css?v=1.1" rel="stylesheet" />

	<!-- custom style -->
	<link href="./custom styles/task management style.css" rel="stylesheet" type="text/css" />

</head>

<body>

	<?php
	include_once __DIR__ . '/../../Controller/course_con.php';
	include_once __DIR__ . '/../../Controller/task_con.php';
	include_once __DIR__ . '/../../Controller/tag_con.php';

	$courseC = new CourseController('course');
	$taskC = new TaskController('task');
	$tagC = new TagController('tag');

	$courses = $courseC->listCourses();
	$allTags = $tagC->listTags();

	$tasks = [];

	if (isset($_GET['course-filter'])) {
		$course_id = $_GET['course-filter'];
		$tasks = $taskC->getTasksByForeignKey($course_id, 'course');
	} else {
		$tasks = [];
	}

	?>

	<b class="screen-overlay"></b>

	<aside class="navbar-aside" id="offcanvas_aside">
		<div class="aside-top">
			<a href="index.php" class="brand-wrap">
				<img src="./images/wajahni.png" height="46" class="logo" alt="">
			</a>
			<div>
				<button class="btn btn-icon btn-aside-minimize"> <i class="text-muted material-icons md-menu_open"></i>
				</button>
			</div>
		</div> <!-- aside-top.// -->

		<nav>
			<ul class="menu-aside">
				<li class="menu-item">
					<a class="menu-link" href="./index.php"> <i class="icon material-icons md-home"></i>
						<span class="text">Acceuil</span>
					</a>
				</li>
				<li class="menu-item active">
					<a class="menu-link" href="./tasks_management.php"> <i class="icon material-icons md-comment"></i>
						<span class="text">Tasks</span>
					</a>
				</li>
				<li class="menu-item ">
                    <a class="menu-link" href="./tags_management.php"> 
                        <i class="icon material-icons md-local_offer"></i>
                        <span class="text">Tags</span>
                    </a>
                </li>
			</ul>
			<hr>
			<ul class="menu-aside">
				<li class="menu-item has-submenu">
					<a class="menu-link" href="#"> <i class="icon material-icons md-settings"></i>
						<span class="text">Paramètres</span>
					</a>
					<div class="submenu">
						<a href="page-settings-1.html">Setting sample 1</a>
						<a href="page-settings-2.html">Setting sample 2</a>
					</div>
				</li>
				<li class="menu-item">
					<a class="menu-link" href="page-0-blank.html"> <i class="icon material-icons md-local_offer"></i>
						<span class="text"> Starter page </span>
					</a>
				</li>
			</ul>
			<br>
			<br>
		</nav>
	</aside>


	<header class="main-header navbar">
		<div class="col-search">
			<form class="searchform">
				<div class="input-group">
					<input list="search_terms" type="text" class="form-control" placeholder="Search term">
					<button class="btn btn-light bg" type="button"> <i class="material-icons md-search"></i> </button>
				</div>
				<datalist id="search_terms">
					<option value="Products">
					<option value="New orders">
					<option value="Apple iphone">
					<option value="Ahmed Hassan">
				</datalist>
			</form>
		</div>
		<div class="col-nav">
			<button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"> <i
					class="md-28 material-icons md-menu"></i> </button>
			<ul class="nav">
				<li class="nav-item">
					<a class="nav-link btn-icon" onclick="darkmode(this)" title="Dark mode" href="#"> <i
							class="material-icons md-nights_stay"></i> </a>
				</li>
				<li class="nav-item">
					<a class="nav-link btn-icon" href="#"> <i class="material-icons md-notifications_active"></i> </a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#"> English </a>
				</li>
				<li class="dropdown nav-item">
					<a class="dropdown-toggle" data-bs-toggle="dropdown" href="#"> <img class="img-xs rounded-circle"
							src="images/people/avatar1.jpg" alt="User"></a>
					<div class="dropdown-menu dropdown-menu-end">
						<a class="dropdown-item" href="#">My profile</a>
						<a class="dropdown-item" href="#">Settings</a>
						<a class="dropdown-item text-danger" href="#">Exit</a>
					</div>
				</li>
			</ul>
		</div>
	</header>

	<main class="main-wrap" style="margin-left: 200px;">
		<div class="form-container">
			<h2>Add a task</h2>
			<form action="add_task.php" method="POST">
				<!-- Course Id -->
				<div class="form-group">
					<label for="course">Course:</label>
					<select id="course_id" name="course_id">
						<option value="" selected>No course selected</option>
						<?php for ($i = 0; $i < count($courses); $i++):
							$course = $courses[$i]; ?>
							<option value=<?php echo $course['course_id']; ?>><?php echo $course['course_name']; ?></option>
						<?php endfor; ?>
					</select>
					<span class="task-error" id="courseError"></span>
				</div>


				<!-- Task Name -->
				<div class="form-group">
					<label for="task_name">Task Name:</label>
					<input type="text" id="task_name" name="task_name" placeholder="Enter task name">
					<span class="task-error" id="taskNameError"></span>
				</div>



				<!-- Task Description -->
				<div class="form-group">
					<label for="task_description">Task Description:</label>
					<textarea id="task_description" name="task_description" rows="5"
						placeholder="Enter task description"></textarea>
					<span class="task-error" id="taskDescriptionError"></span>
				</div>

				<!-- Tags -->
				<div class="form-group">
					<label for="tag_select">Tags:</label>
					<div class="tag-input-container">
						<select id="tag_select" class="form-control">
							<option value="">Select a tag</option>
							<?php foreach ($allTags as $tag): ?>
								<option value="<?php echo $tag['tag_id']; ?>" 
										data-name="<?php echo htmlspecialchars($tag['tag_name']); ?>">
									<?php echo htmlspecialchars($tag['tag_name']); ?>
								</option>
							<?php endforeach; ?>
						</select>
						<button type="button" onclick="addSelectedTag()">Add Tag</button>
					</div>
					<div id="selected_tags" class="selected-tags">
						<!-- Selected tags will appear here -->
					</div>
					<input type="hidden" name="selected_tag_ids" id="selected_tag_ids">
				</div>

				<!-- Submit Button -->
				<div class="form-group">
					<button type="submit" onclick="return validateTaskForm()">Add</button>
				</div>
			</form>
		</div>
	</main>

	<div class="container-for-table">
		<h2 class="header-for-table">Task Table View</h2>
		<form action="" method="get">
			<div class="filter-section">

				<select class="filter-select" name="course-filter" id="course-filter">
					<option value="">Select a course</option>
					<?php foreach ($courses as $course) { ?>
						<option value="<?php echo $course['course_id']; ?>" <?php echo (isset($_GET['course-filter']) && $course['course_id'] == $_GET['course-filter']) ? 'selected' : ''; ?>>
							<?php echo $course['course_name']; ?>
						</option>
					<?php } ?>
				</select>
				<button class="filter-button" type="submit">Search</button>
			</div>
		</form>

		<?php if (count($tasks) === 0 && isset($_GET['course-filter'])) { ?>
			<div class="alert alert-info" role="alert">
				No tasks found for the selected course.
			</div>
		<?php } elseif (count($tasks) === 0 && !isset($_GET['course-filter'])) { ?>
			<div class="alert alert-info" role="alert">
				No tasks found. Please select a course to view tasks.
			</div>
		<?php } else { ?>
			<table class="task-table">
				<thead class="table-header">
					<tr class="table-row">
						<th class="table-cell">Order</th>
						<th class="table-cell">Task Name</th>
						<th class="table-cell">Task Description</th>
						<th class="table-cell">Tags</th>
						<th class="table-cell">Actions</th>
					</tr>
				</thead>
				<tbody>
					<!-- Sample Row -->
					<?php foreach ($tasks as $task) { ?>
						<tr class="table-row">
							<td class="table-cell"><?php echo $task['task_order']; ?></td>
							<td class="table-cell"><?php echo $task['task_name']; ?></td>
							<td class="table-cell"><?php echo $task['task_description']; ?></td>
							<td class="table-cell">
								<?php if (!empty($task['tags'])): ?>
									<div class="task-tags">
										<?php 
										$tagPairs = explode(',', $task['tags']);
										foreach ($tagPairs as $tagPair): 
											list($tagId, $tagName) = explode('|', $tagPair);
										?>
											<span class="tag-item">
												<?php echo htmlspecialchars(trim($tagName)); ?>
												<a href="remove_tag_from_task.php?task_id=<?php echo $task['task_id']; ?>&tag_id=<?php echo trim($tagId); ?>&course_id=<?php echo $task['course_id']; ?>" 
												   onclick="return confirm('Are you sure you want to remove this tag?')" 
												   class="tag-remove">×</a>
											</span>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
								<button type="button" class="add-tag-btn" onclick="showAddTagModal(<?php echo $task['task_id']; ?>)">+</button>
							</td>
							<td class="table-cell">
								<div class="action-buttons">
									<button class="button-edit"
										onclick="window.location.href='edit_task.php?id=<?php echo $task['task_id']; ?>&type=course&course_id=<?php echo $task['course_id']; ?>'">Edit</button>
									<button class="button-delete"
										onclick="window.location.href='delete_task.php?id=<?php echo $task['task_id']; ?>&type=course&course_id=<?php echo $task['course_id']; ?>'">Delete</button>


									<!-- Down buttons -->
									<?php if ($task['task_order'] < count($tasks)) { ?>
										<button class="button-order"
											onclick="window.location.href='order_down.php?id=<?php echo $task['task_id']; ?>&type=course&course_id=<?php echo $task['course_id']; ?>'">&#11163;</button>

									<?php } ?>

									<!-- Up buttons -->
									<?php if ($task['task_order'] > 1) { ?>
										<button class="button-order"
											onclick="window.location.href='order_up.php?id=<?php echo $task['task_id']; ?>&type=course&course_id=<?php echo $task['course_id']; ?>'">&#11161;</button>
									<?php } ?>


								</div>
							</td>
						</tr>

					<?php } ?>
				</tbody>
			</table>
		<?php } ?>
	</div>

	<script type="text/javascript">
		if (localStorage.getItem("darkmode")) {
			var body_el = document.body;
			body_el.className += 'dark';
		}
	</script>

	<script src="asset/js/jquery-3.5.0.min.js"></script>
	<script src="asset/js/bootstrap.bundle.min.js"></script>

	<!-- ChartJS files-->
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

	<!-- Custom JS -->
	<script src="asset/js/scriptc619.js?v=1.0" type="text/javascript"></script>

	<!-- Custom JS -->
	<script src="./custom js/verif_tasks.js"></script>

	<!-- Add this before the closing </body> tag -->
	<script src="./custom js/tag_management.js"></script>

	<!-- Add Tag Modal -->
	<div id="addTagModal" class="modal">
		<div class="modal-content">
			<span class="close">&times;</span>
			<h3>Add Tag to Task</h3>
			<select id="modalTagSelect">
				<option value="">Select a tag</option>
			</select>
			<button onclick="addTagToTask()">Add Tag</button>
		</div>
	</div>

	<!-- Make sure your JavaScript is loaded after the modal HTML -->
	<script src="./custom js/tag_management_table.js"></script>

</body>

<!-- Mirrored from www.ecommerce-admin.com/demo/page-index-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 Apr 2022 00:14:39 GMT -->

</html>