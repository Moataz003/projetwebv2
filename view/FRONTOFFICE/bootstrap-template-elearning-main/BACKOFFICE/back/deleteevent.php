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
    <button class="btn btn-icon btn-aside-minimize"> <i class="text-muted material-icons md-menu_open"></i> </button>
  </div>
</div> <!-- aside-top.// -->

<nav>
  <ul class="menu-aside">
    <li class="menu-item "> 
      <a class="menu-link" href="index.php"> <i class="icon material-icons md-home"></i> 
        <span class="text">Acceuil</span> 
      </a> 
    </li>
    
    <li class="menu-item has-submenu active"> 
      <a class="menu-link" href="#"> <i class="icon material-icons md-event"></i>  
        <span class="text">events</span> 
      </a> 
      <div class="submenu">
      <a href="addevent.php" class="nav-item nav-link active">Add Event</a>
            <a href="updateevent.php" class="nav-item nav-link">Update event</a>
            <a href="deleteevent.php" class="nav-item nav-link">Delete Event</a>
            <a href="eventlist.php" class="nav-item nav-link"> Event List</a>
		  </div>
    
		</li>
    <li class="menu-item"> 
      <a class="menu-link" href="page-reviews.html"> <i class="icon material-icons md-comment"></i> 
        <span class="text">Reviews</span> 
      </a> 
    </li>
    <li class="menu-item"> 
      <a class="menu-link" disabled href="#"> <i class="icon material-icons md-pie_chart"></i> 
        <span class="text">Statistiques</span> 
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

<div class="card mt-4">
    <h2><div class="card-header">Delete Events</div></h2>
        <div class="card-body">
            <?php
                include(__DIR__ . '/../../../controller/events controller.php');
                
                $controller = new EventController();
                $events = $controller->listEvents();
                $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
                $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
                $sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'asc'; 
                
                // Search or Sort Events
                if (!empty($searchQuery)) {
                    $events = $controller->searchEvents($searchQuery);
                } else {
                    $events = $controller->sortEventsByDate($sortOrder);
                }


                if ($events):
                ?>
                 <!-- Search Bar -->
                <form method="get" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by Title or ID" value="<?= htmlspecialchars($searchQuery) ?>">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>

                 <!-- Sort Options -->
                <div class="mb-4">
                    <a href="?sort=asc" class="btn btn-outline-primary <?= $sortOrder === 'asc' ? 'active' : '' ?>">Sort by Date (Ascending)</a>
                    <a href="?sort=desc" class="btn btn-outline-primary <?= $sortOrder === 'desc' ? 'active' : '' ?>">Sort by Date (Descending)</a>
                </div>

                 <!-- Event Table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Location</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($events as $event): ?>
                        <tr>
                                    <td><?= $event['id'] ?></td>
                                    <td><?= htmlspecialchars($event['title']) ?></td>
                                    <td><?= htmlspecialchars($event['description']) ?></td>
                                    <td><?= htmlspecialchars($event['location']) ?></td>
                                    <td><?= $event['start_date'] ?></td>
                                    <td><?= $event['end_date'] ?></td>
                                    <td><?= $event['status'] ?></td>
                                    <td>
                                        <form action="http://localhost/MajdBenAbdallah/model/handle_request.php" method="POST" style="display:inline-block;">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= $event['id'] ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p>No events found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>


     <!-- JavaScript Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/custom.js"></script>


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
</html>

<?php
/*include(__DIR__ . '/../../../config.php');

try {
    $conn = Config::getConnexion();
    $query = $conn->query("SELECT * FROM events");

    $events = $query->fetchAll();

    echo json_encode($events); 
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<?php
include(__DIR__ . '/../../../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    try {
        $conn = Config::getConnexion();
        $query = $conn->prepare("DELETE FROM events WHERE id = :id");
        $query->execute(['id' => $id]);

        echo "Event deleted successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>*/
