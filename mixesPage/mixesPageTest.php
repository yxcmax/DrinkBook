<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title>Mixes</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://web.engr.illinois.edu/~snissa4/mainPage.php">DrinkBook</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="http://web.engr.illinois.edu/~snissa4/mixesPage.php">Mixes</a></li>
			<li><a href="http://web.engr.illinois.edu/~snissa4/aboutPage.php">About</a></li>
            <li><a href="#contact">Profile</a></li>
          </ul>
          <form class="navbar-form navbar-right">
		  	<div class="search">
              <input type="search" placeholder="Search" class="form-control">
            </div>
			<button type="Drink" class="btn btn-success">Drink!</button>
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control">
            </div>
			<button type="submit" class="btn btn-success">Sign in</button>
          </form>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

      <div class="starter-template">
        <h1 class = "blue">Bootstrap starter template</h1>
        
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
			<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css"></link>
			<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
			<script>
			$(document).ready(function(){
				  $("button").click(function(){
					$.ajax({                                      
					  url: 'fn.php',                  
					  data: "action=getDrinks",                       
					  dataType: 'json',     
					  success: function(data)
					  {
					  	//console.log(data);
						$.each(data, function(index,data) {        
						    $('#drinkList').append(data.name+" - "+data.type + "<br>")
						});
					  },
					  error: function (xhr, ajaxOptions, thrownError) {
					        alert(xhr.statusText);
					        //alert(thrownError);
					    } 
				  	});
				  	
				  	
				});
				
			});
			</script>
			</head>
			<body>
			<div id="drinkList"></div>
			<br>
			<button>Remove class from elements</button>
		
		
		
		
      </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="bootstrap.min.js"></script>
  </body>
</html>