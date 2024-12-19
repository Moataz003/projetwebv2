<?php
require_once '../../controllers/roomC.php';
require_once '../../controllers/userC.php';

$roomC = new RoomC();
$userC = new UserC();

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'ASC'; // Default sorting order

// Pagination settings
$limit = 4; // Items per page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Current page
$offset = ($page - 1) * $limit;

// Fetch the total count of Rooms for search
$totalRooms = $roomC->countRoomsWithSearch($search);
$totalPages = ceil($totalRooms / $limit);

// Fetch the filtered and sorted list of Rooms
$rooms = $roomC->fetchFilteredSortedRooms($search, $sort, $limit, $offset);
?>
<!DOCTYPE HTML>
<html lang="en">

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
                    <a class="menu-link" href="#"> <i class="icon material-icons md-pie_chart"></i>
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
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Rooms :</h4>
                                <div class="table-responsive pt-3">
                                    <form method="GET" class="d-flex mb-3">
                                        <input type="text" name="search" class="form-control me-2" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
                                        <select name="sort" class="form-control me-2">
                                            <option value="ASC" <?php echo $sort == 'ASC' ? 'selected' : ''; ?>>nbr participants Ascending</option>
                                            <option value="DESC" <?php echo $sort == 'DESC' ? 'selected' : ''; ?>>nbr participants Descending</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </form>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Room Name</th>
                                                <th>Owner</th>
                                                <th>Nbr Participants</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($rooms as $room):
                                                $user = $userC->recupererUser($room['owner']);
                                                $username = $user['Nom'] . " " . $user['Prenom'];
                                            ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($room['nom']); ?></td>
                                                    <td><?php echo htmlspecialchars($username); ?></td>
                                                    <td><?php echo htmlspecialchars($room['nbr_participants']); ?></td>
                                                    <td>
                                                        <a href="chats.php?id=<?php echo $room['id']; ?>" class="btn btn-primary btn-sm">Chats</a>
                                                        <a href="detele_room.php?room_id=<?php echo $room['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this room?');">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <?php if ($page > 1): ?>
                                            <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo $sort; ?>">Previous</a></li>
                                        <?php endif; ?>
                                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo $sort; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <?php if ($page < $totalPages): ?>
                                            <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo $sort; ?>">Next</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script type="text/javascript">
            if (localStorage.getItem("darkmode")) {
                document.body.classList.add('dark');
            }
        </script>

        <script src="asset/js/jquery-3.5.0.min.js"></script>
        <script src="asset/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <script src="asset/js/scriptc619.js?v=1.0" type="text/javascript"></script>
    </main>
</body>
</html>
