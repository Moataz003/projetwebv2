<!DOCTYPE HTML>
<html lang="en">

<!-- Mirrored from www.ecommerce-admin.com/demo/page-form-product-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 Apr 2022 00:14:44 GMT -->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Dashboard</title>

	<link href="./images/wajahni.png" rel="shortcut icon" type="image/x-icon">

	<link href="css/bootstrapf9e3.css?v=1.1" rel="stylesheet" type="text/css"/>

	<link rel="stylesheet" href="fonts/material-icon/css/round.css"/>

	<!-- custom style -->
	<link href="css/uif9e3.css?v=1.1" rel="stylesheet" type="text/css"/>
	<link href="css/responsivef9e3.css?v=1.1" rel="stylesheet" />

</head>
<body>

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
				<li class="menu-item active">
					<a class="menu-link" href="./index.php"> <i class="icon material-icons md-home"></i>
						<span class="text">Acceuil</span>
					</a>
				</li>
				<li class="menu-item">
					<a class="menu-link" href="./tasks_management.php"> <i class="icon material-icons md-comment"></i>
						<span class="text">Tasks</span>
					</a>
				</li>
				<li class="menu-item">
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
<main class="main-wrap">

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
     <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"> <i class="md-28 material-icons md-menu"></i> </button>
	 	<ul class="nav">
	      <li class="nav-item">
	          <a class="nav-link btn-icon" onclick="darkmode(this)" title="Dark mode" href="#"> <i class="material-icons md-nights_stay"></i> </a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link btn-icon" href="#"> <i class="material-icons md-notifications_active"></i> </a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="#"> English </a>
	      </li>
	      <li class="dropdown nav-item">
	        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#"> <img class="img-xs rounded-circle" src="images/people/avatar1.jpg" alt="User"></a>
	        <div class="dropdown-menu dropdown-menu-end">
	          <a class="dropdown-item" href="#">My profile</a>
	          <a class="dropdown-item" href="#">Settings</a>
	          <a class="dropdown-item text-danger" href="#">Exit</a>
	        </div>
	      </li>
	    </ul> 
  	</div>
</header>

<script type="text/javascript">
	if(localStorage.getItem("darkmode")){
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

<!-- ChartJS customize-->
<script>
	var ctx = document.getElementById('myChart').getContext('2d');
	var chart = new Chart(ctx, {
	    // The type of chart we want to create
	    type: 'line',

	    // The data for our dataset
	    data: {
	        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
	        datasets: [
	        {
	            label: 'Sales',
	            backgroundColor: 'rgb(44, 120, 220)',
	            borderColor: 'rgb(44, 120, 220)',
	            data: [18, 17, 4, 3, 2, 20, 25, 31, 25, 22, 20, 9]
	        },
	        {
	            label: 'Visitors',
	            backgroundColor: 'rgb(180, 200, 230)',
	            borderColor: 'rgb(180, 200, 230)',
	            data: [40, 20, 17, 9, 23, 35, 39, 30, 34, 25, 27, 17]
	        } 

	        ]
	    },

	    // Configuration options go here
	    options: {}
	});
</script>

</body>

<!-- Mirrored from www.ecommerce-admin.com/demo/page-index-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 Apr 2022 00:14:39 GMT -->
</html>






















