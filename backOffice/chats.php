<?php
require_once '../../controllers/chatC.php';
require_once '../../controllers/userC.php';
require_once '../../controllers/roomC.php';
require_once '../../controllers/participationC.php';

$chatC = new ChatC();
$userC = new UserC();
$roomC = new RoomC();
$pC = new ParticipationC();

$room = $roomC->recupererRoom($_GET['id']);
$chats = $chatC->afficherChats($_GET['id']);
$ps = $pC->afficherParticipationsByRoom($_GET['id']);
?>
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
				<li class="menu-item active">
					<a class="menu-link" href="index.php"> <i class="icon material-icons md-home"></i>
						<span class="text">Acceuil</span>
					</a>
				</li>
				<li class="menu-item has-submenu">
					<a class="menu-link" href="#"> <i class="icon material-icons md-person"></i>
						<span class="text">Utilsateurs</span>
					</a>
					<div class="submenu">
						<a href="ajouterUtilisateurs.php">Ajouter Utilisateurs</a>
						<a href="modifierUtilisateurs.php">Modifier Utilisateurs</a>
						<a href="supprimerUtilisateurs.php">Supprimer Utilisateurs</a>
						<a href="afficherUtilisateurs.php">Afficher Utilisateurs</a>

					</div>
				</li>
				<li class="menu-item">
					<a class="menu-link" href="page-reviews.html"> <i class="icon material-icons md-comment"></i>
						<span class="text">Reviews</span>
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

		<section class="content-main">
			<div class="container">
				<!-- Room Table -->
				<div class="row">
					<div class="col-12">
						<h3 class="mb-4">Chats for : <?php echo $room['nom'];?></h3>
                        <a href="index.php" class="btn btn-primary btn-sm">
												Back to Rooms
											</a>
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Chat Content</th>
									<th>Date</th>
									<th>User Name</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php 
                                foreach ($ps as $p):
                                foreach ($chats as $chat):
                                    if($p['id'] == $chat['id_participation']){
                                        $user = $userC->recupererUser($p['id_user']);
									     $username = $user['Nom'] . " " . $user['Prenom'];
								?>

									<tr>
										<td><?php echo htmlspecialchars($chat['contenu']); ?></td>
										<td><?php echo htmlspecialchars($chat['date']); ?></td>
										<td><?php echo htmlspecialchars($username); ?></td>
										<td>
											<a href="delete_chat.php?id=<?php echo $chat['id']; ?>&&room=<?php echo $_GET['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this room?');">
												Delete
											</a>
										</td>
									</tr>
								<?php 
                                    }
                            endforeach;
                            endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>

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

	</main>


</body>

<!-- Mirrored from www.ecommerce-admin.com/demo/page-index-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 Apr 2022 00:14:39 GMT -->

</html>