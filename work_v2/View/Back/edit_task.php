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

	$courseC = new CourseController('course');
	$taskC = new TaskController('task');

	$current_id = $_GET['id']; 
    $current_type = $_GET['type'];
    $current_course_id = $_GET['course_id'];


	$courses = $courseC->listCourses();

	$task = $taskC->getTask($current_id);

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
				<li class="menu-item">
					<a class="menu-link" disabled href="#"> <i class="icon material-icons md-pie_chart"></i>
						<span class="text">Statistiques/span>
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
			<form action="./edit_task_action.php?id=<?php echo $task['task_id']; ?>&type=<?php echo $current_type; ?>&course_id=<?php echo $current_course_id; ?>" 
			method="post">
				<!-- Course Id -->
				<div class="form-group">
					<label for="course">Course:</label>
					<select id="course_id" name="course_id">
						<option value="" selected>No course selected</option>
						<?php for ($i = 0; $i < count($courses); $i++):
							$course = $courses[$i]; ?>
							<option 
							value=<?php echo $course['course_id']; ?>
							<?php if ($course['course_id'] == $current_course_id) echo 'selected'; ?> 
							>
							<?php echo $course['course_name']; ?></option>
						<?php endfor; ?>
					</select>
					<span class="task-error" id="courseError"></span>
				</div>


				<!-- Task Name -->
				<div class="form-group">
					<label for="task_name">Task Name:</label>
					<input type="text" id="task_name" name="task_name" placeholder="Enter task name" value="<?php echo $task['task_name']; ?>">
					<span class="task-error" id="taskNameError"></span>
				</div>



				<!-- Task Description -->
				<div class="form-group">
					<label for="task_description">Task Description:</label>
					<textarea id="task_description" name="task_description" rows="5"
						placeholder="Enter task description" ><?php echo $task['task_description']; ?></textarea>
					<span class="task-error" id="taskDescriptionError"></span>
				</div>

				<!-- Submit Button -->
				<div class="form-group">
					<button type="submit" onclick="return validateTaskForm()">Edit</button>
				</div>
			</form>
		</div>
	</main>

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



</body>

<!-- Mirrored from www.ecommerce-admin.com/demo/page-index-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 Apr 2022 00:14:39 GMT -->

</html>