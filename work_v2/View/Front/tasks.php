<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="" />

  <title>Finexo</title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet" />

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

  <!-- custom stylesheet -->
  <link rel="stylesheet" href="custom_css/static to do.css" />

</head>

<body class="sub_page">

  <?php
  include_once __DIR__ . '/../../Controller/task_con.php';

  $taskC = new TaskController('task');

  // Get the foreign key id and foreign key type from the URL
  $foreign_key_id = isset($_GET['key_id']) ? $_GET['key_id'] : null;
  $foreign_key_type = isset($_GET['key_type']) ? $_GET['key_type'] : null;

  $error_message = null;
  $tasks = [];

  if ($foreign_key_id !== null && $foreign_key_type !== null) {
    try {
      $tasks = $taskC->getTasksByForeignKey($foreign_key_id, $foreign_key_type);
    } catch (Exception $e) {
      $error_message = 'Error: ' . $e->getMessage();
    }
  } else {
    $error_message = 'Error: Missing foreign key ID or type.';
  }
  ?>

  <div class="hero_area">
    <div class="hero_bg_box">
      <div class="bg_img_box">
        <img src="images/hero-bg.png" alt="" />
      </div>
    </div>

    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="index.html">
            <span>Wajahni</span>
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="index.html">Home </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.html"> About</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="courses.php">Courses <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="why.html">Why Us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="team.html">Team</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./../Back">
                  <i class="fa fa-user" aria-hidden="true"></i> Login</a>
              </li>
              <form class="form-inline">
                <button class="btn my-2 my-sm-0 nav_search-btn" type="submit">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </button>
              </form>
            </ul>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>

  <!-- static to-do list -->
  <div class="static-to-do-wrapper">
    <div class="static-to-do-container">
      <h1>To-Do List</h1>
      <?php if ($error_message): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $error_message; ?>
        </div>
      <?php endif; ?>
      <?php if ((empty($tasks)) && ($error_message === null)): ?>
        <div class="alert alert-info" role="alert">
          No tasks found.
        </div>
      <?php elseif ($error_message === null): ?>
        <div class="static-to-do-progress-bar">
          <div id="progress"></div>
        </div>
        <ul class="static-to-do-task-list" id="task-list">
          <?php foreach ($tasks as $task): ?>
            <li data-task-id="<?php echo htmlspecialchars($task['task_id']); ?>">
              <input type="checkbox" onchange="updateProgress()" <?php echo $task['status'] ? 'checked' : ''; ?> />
              <div class="task-content">
                <span><?php echo htmlspecialchars($task['task_name']); ?></span>
                <p class="task-description"><?php echo htmlspecialchars($task['task_description']); ?></p>
                <div class="task-tags">
                  <?php if (!empty($task['tags'])): ?>
                    <?php foreach (explode(',', $task['tags']) as $tag): ?>
                      <span class="tag-box"><?php echo htmlspecialchars(trim($tag)); ?></span>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <span>No tags</span>
                  <?php endif; ?>
                </div>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>


      <?php endif; ?>
    </div>
  </div>
  <!-- end static to-do list -->


  <!-- info section -->
  <section class="info_section layout_padding2">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-3 info_col">
          <div class="info_contact">
            <h4>Address</h4>
            <div class="contact_link_box">
              <a href="">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span> Location </span>
              </a>
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span> Call +01 1234567890 </span>
              </a>
              <a href="">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span> demo@gmail.com </span>
              </a>
            </div>
          </div>
          <div class="info_social">
            <a href="">
              <i class="fa fa-facebook" aria-hidden="true"></i>
            </a>
            <a href="">
              <i class="fa fa-twitter" aria-hidden="true"></i>
            </a>
            <a href="">
              <i class="fa fa-linkedin" aria-hidden="true"></i>
            </a>
            <a href="">
              <i class="fa fa-instagram" aria-hidden="true"></i>
            </a>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 info_col">
          <div class="info_detail">
            <h4>Info</h4>
            <p>
              necessary, making this the first true generator on the Internet.
              It uses a dictionary of over 200 Latin words, combined with a
              handful
            </p>
          </div>
        </div>
        <div class="col-md-6 col-lg-2 mx-auto info_col">
          <div class="info_link_box">
            <h4>Links</h4>
            <div class="info_links">
              <a class="active" href="index.html"> Home </a>
              <a class="" href="about.html"> About </a>
              <a class="" href="service.html"> Services </a>
              <a class="" href="why.html"> Why Us </a>
              <a class="" href="team.html"> Team </a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 info_col">
          <h4>Subscribe</h4>
          <form action="#">
            <input type="text" placeholder="Enter email" />
            <button type="submit">Subscribe</button>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- end info section -->

  <!-- footer section -->
  <section class="footer_section">
    <div class="container">
      <p>
        &copy; <span id="displayYear"></span> All Rights Reserved By
        <a href="https://html.design/">Free Html Templates</a>
      </p>
    </div>
  </section>
  <!-- footer section -->

  <!-- jQery -->
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <!-- bootstrap js -->
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <!-- owl slider -->
  <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <!-- custom js -->
  <script type="text/javascript" src="js/custom.js"></script>
  <!-- Google Map -->
  <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
  <!-- End Google Map -->


  <script>
    document.addEventListener('DOMContentLoaded', function () {
      updateProgress();

      const checkboxes = document.querySelectorAll('.static-to-do-task-list li input[type="checkbox"]');
      checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
          const taskId = this.closest('li').dataset.taskId;
          const status = this.checked ? 1 : 0;

          updateTaskStatus(taskId, status);
          updateProgress();
        });
      });
    });

    function updateTaskStatus(taskId, status) {
      fetch('./ajax scripts/update_task_status.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `task_id=${taskId}&status=${status}`
      })
        .then(response => response.json())
        .then(data => {
          if (!data.success) {
            alert(data.message || 'An error occurred while updating the task status.');
            console.log('An error occurred.', data);
          }
          else {
            console.log('Task status updated successfully.', data);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while updating the task status.');
          console.log('An error occurred.', data);
        });
    }


    function updateProgress() {
      const tasks = document.querySelectorAll('.static-to-do-task-list li input[type="checkbox"]');
      const totalTasks = tasks.length;
      const completedTasks = Array.from(tasks).filter(task => task.checked).length;
      const progress = (completedTasks / totalTasks) * 100;
      document.getElementById('progress').style.width = progress + '%';
    }
  </script>


</body>

</html>