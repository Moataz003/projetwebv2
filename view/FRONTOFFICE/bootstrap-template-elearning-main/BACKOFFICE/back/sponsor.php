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

<h1>Sponsor Management</h1>

<!-- Add Sponsor Form -->
<div class="form-container">
    <h2>Add Sponsor</h2>
    <form id="sponsorForm" action="http://localhost/MajdBenAbdallah/model/handle_req_s.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add_s">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" class="form-control" id="logo" name="logo" accept="image/*" required>
        </div>
        <div class="mb-3">
            <label for="contact_info" class="form-label">Contact Info</label>
            <input type="text" class="form-control" id="contact_info" name="contact_info" required>
        </div>
        <button type="submit" class="btn btn-success">Add Sponsor</button>
    </form>
</div>

<!-- Sponsor List -->
<h2>All Sponsors</h2>
<table id="sponsorTable" class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Logo</th>
            <th>Contact Info</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
       <!--  Sponsors will be populated here dynamically -->
    </tbody>
</table>

<script>
    const sponsorTableBody = document.getElementById('sponsorTable').getElementsByTagName('tbody')[0];

    // Fetch all sponsors
    function fetchSponsors() {
        fetch('http://localhost/MajdBenAbdallah/model/handle_req_s.php?action=fetch')
            .then(response => response.json())
            .then(data => {
                sponsorTableBody.innerHTML = ''; // Clear the table
                data.forEach(sponsor => {
                    const row = sponsorTableBody.insertRow();
                    row.innerHTML = `
                        <td>${sponsor.id}</td>
                        <td>${sponsor.name}</td>
                        <td><img src="${sponsor.logo}" alt="${sponsor.name}" style="width: 50px;"></td>
                        <td>${sponsor.contact_info}</td>
                        <td>
                            <button onclick="editSponsor(${sponsor.id})">Edit</button>
                            <button onclick="deleteSponsor(${sponsor.id})">Delete</button>
                        </td>
                    `;
                });
            });
    }

    // Edit sponsor
    function editSponsor(id) {
        fetch(`http://localhost/MajdBenAbdallah/model/handle_req_s.php?action=get&id=${id}`)
            .then(response => response.json())
            .then(sponsor => {
                document.getElementById('name').value = sponsor.name;
                document.getElementById('contact_info').value = sponsor.contact_info;
                // Handle additional fields if necessary
            });
    }

    // Delete sponsor
    function deleteSponsor(id) {
        if (confirm('Are you sure you want to delete this sponsor?')) {
            fetch(`http://localhost/MajdBenAbdallah/model/handle_req_s.php?action=delete&id=${id}`, {
                method: 'POST'
            })
            .then(response => {
                if (response.ok) {
                    alert('Sponsor deleted successfully!');
                    fetchSponsors();
                } else {
                    alert('Error deleting sponsor.');
                }
            });
        }
    }

    // Initial fetch of sponsors
    fetchSponsors();
</script>

</body>
</html>
