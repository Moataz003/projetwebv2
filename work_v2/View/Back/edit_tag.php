<?php
include_once __DIR__ . '/../../Controller/tag_con.php';

$tagC = new TagController('tag');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tag_id'], $_POST['tag_name'])) {
    try {
        $tagC->updateTag($_POST['tag_id'], $_POST['tag_name']);
        header('Location: tags_management.php');
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error updating tag: ' . $e->getMessage() . '</div>';
    }
} elseif (isset($_GET['id'])) {
    $tag = $tagC->getTag($_GET['id']);
} else {
    echo '<div class="alert alert-danger">Invalid request.</div>';
}
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
    <link href="css/uif9e3.css?v=1.1" rel="stylesheet" type="text/css" />
    <link href="css/responsivef9e3.css?v=1.1" rel="stylesheet" />
    <link href="./custom styles/task management style.css" rel="stylesheet" type="text/css" />
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
        </div>

        <nav>
            <ul class="menu-aside">
                <li class="menu-item">
                    <a class="menu-link" href="./index.php"> 
                        <i class="icon material-icons md-home"></i>
                        <span class="text">Acceuil</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="./tasks_management.php"> 
                        <i class="icon material-icons md-comment"></i>
                        <span class="text">Tasks</span>
                    </a>
                </li>
                <li class="menu-item active">
                    <a class="menu-link" href="./tags_management.php"> 
                        <i class="icon material-icons md-local_offer"></i>
                        <span class="text">Tags</span>
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="menu-aside">
                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#"> 
                        <i class="icon material-icons md-settings"></i>
                        <span class="text">Paramètres</span>
                    </a>
                    <div class="submenu">
                        <a href="page-settings-1.html">Setting sample 1</a>
                        <a href="page-settings-2.html">Setting sample 2</a>
                    </div>
                </li>
            </ul>
        </nav>
    </aside>

    <header class="main-header navbar">
        <!-- Copy the header from tasks_management.php -->
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
            <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"> 
                <i class="md-28 material-icons md-menu"></i> 
            </button>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link btn-icon" onclick="darkmode(this)" title="Dark mode" href="#"> 
                        <i class="material-icons md-nights_stay"></i> 
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-icon" href="#"> 
                        <i class="material-icons md-notifications_active"></i> 
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"> English </a>
                </li>
                <li class="dropdown nav-item">
                    <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#"> 
                        <img class="img-xs rounded-circle" src="images/people/avatar1.jpg" alt="User">
                    </a>
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
            <h2>Edit Tag</h2>
            <form action="edit_tag.php" method="POST" onsubmit="return validateTagForm('editTagForm')">
                <input type="hidden" name="tag_id" value="<?php echo $tag['tag_id']; ?>">
                <div class="form-group">
                    <label for="tag_name">Tag Name:</label>
                    <input type="text" 
                           id="tag_name" 
                           name="tag_name" 
                           value="<?php echo htmlspecialchars($tag['tag_name']); ?>" 
                           placeholder="Enter tag name">
                    <span id="tagNameError" class="error-message"></span>
                </div>
                <div class="form-group">
                    <div class="action-buttons">
                        <button type="submit" class="button-edit">Update Tag</button>
                        <button type="button" 
                                class="button-delete" 
                                onclick="window.location.href='tags_management.php'">
                            Cancel
                        </button>
                    </div>
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
    <script src="asset/js/scriptc619.js?v=1.0" type="text/javascript"></script>
    <script src="./custom js/verif_tags.js"></script>
</body>
</html> 