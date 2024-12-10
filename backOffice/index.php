<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <link href="./images/wajahni.png" rel="shortcut icon" type="image/x-icon">
    <link href="css/bootstrapf9e3.css?v=1.1" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="fonts/material-icon/css/round.css"/>
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
                <button class="btn btn-icon btn-aside-minimize">
                    <i class="text-muted material-icons md-menu_open"></i>
                </button>
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
                        <span class="text">Quizzes</span> 
                    </a> 
                    <div class="submenu">
                        <a href="javascript:void(0);" id="add-quiz">Ajouter Quiz</a>
                        <a href="javascript:void(0);" id="list-quiz">Afficher Quiz</a>
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
        <!-- Dynamically loaded content will appear here -->
        <div id="dynamic-content"></div>
    </main>
	

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<script type="text/javascript">
		document.getElementById('edit-quiz-link').addEventListener('click', function() {
    // Open the modal to select a quiz
    $('#quizModal').modal('show');
    loadQuizList();
});

function loadQuizList() {
    // Make an AJAX request to fetch the list of quizzes
    $.ajax({
        url: '../getQuizList.php',  // Endpoint to fetch quizzes
        method: 'GET',
        success: function(response) {
            const quizList = JSON.parse(response);
            let quizItems = '';
            
            quizList.forEach(quiz => {
                quizItems += `
                    <div>
                        <button class="btn btn-primary" onclick="loadQuizData(${quiz.id_quiz})">${quiz.titre_quiz}</button>
                    </div>
                `;
            });

            // Inject quiz list into the modal
            document.getElementById('quiz-list').innerHTML = quizItems;
        }
    });
}

function loadQuizData(quizId) {
    // Close the modal once a quiz is selected
    $('#quizModal').modal('hide');

    // Make an AJAX request to fetch the quiz data for editing
    $.ajax({
        url: 'getQuizData.php',  // Endpoint to fetch quiz data by ID
        method: 'GET',
        data: { quizId: quizId },
        success: function(response) {
            const quizData = JSON.parse(response);

            // Create the quiz form dynamically
            let quizForm = `
                <h3>Edit Quiz: ${quizData.titre_quiz}</h3>
                <form action="../updateQuiz.php" method="POST">
                    <input type="hidden" name="quiz_id" value="${quizData.id_quiz}">
                    <label for="quiz_title">Quiz Title:</label>
                    <input type="text" name="quiz_title" id="quiz_title" value="${quizData.titre_quiz}" class="form-control" required><br>
                    
                    <h4>Questions</h4>
                    ${quizData.questions.map((question, index) => `
                        <div>
                            <h5>Question ${index + 1}</h5>
                            <label>Question:</label>
                            <input type="text" name="questions[${question.id_question}][question]" value="${question.question}" class="form-control" required><br>

                            <label>Option 1:</label>
                            <input type="text" name="questions[${question.id_question}][option1]" value="${question.option1}" class="form-control" required><br>

                            <label>Option 2:</label>
                            <input type="text" name="questions[${question.id_question}][option2]" value="${question.option2}" class="form-control" required><br>

                            <label>Option 3:</label>
                            <input type="text" name="questions[${question.id_question}][option3]" value="${question.option3}" class="form-control" required><br>

                            <label>Answer:</label>
                            <input type="text" name="questions[${question.id_question}][response]" value="${question.reponse}" class="form-control" required><br>
                        </div>
                    `).join('')}

                    <button type="submit" class="btn btn-primary">Update Quiz</button>
                </form>
            `;
            
            // Inject the quiz form into the page
            document.getElementById('edit-quiz-form').innerHTML = quizForm;
        }
    });
}

	</script>
    
    <script type="text/javascript">
        $(document).ready(function() {
            // Load the "Ajouter Quiz" content when the corresponding menu item is clicked
            $("#add-quiz").click(function() {
                $("#dynamic-content").load("../addQuiz.php"); // Load addQuiz.php content dynamically
            });

            // Load the "Afficher Quiz" content when the corresponding menu item is clicked
            $("#list-quiz").click(function() {
                $("#dynamic-content").load("../listQuiz.php"); // Load listQuiz.php content dynamically
            });

            
        });
    </script>

    <script type="text/javascript">
        if(localStorage.getItem("darkmode")) {
            var body_el = document.body;
            body_el.className += 'dark';
        }
    </script>

    <script src="asset/js/jquery-3.5.0.min.js"></script>
    <script src="asset/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="asset/js/scriptc619.js?v=1.0" type="text/javascript"></script>

</body>

</html>
