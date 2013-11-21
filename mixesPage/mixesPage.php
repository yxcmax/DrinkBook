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
          <a class="navbar-brand" href="../mainPage/mainPage.php">DrinkBook</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="../mixesPage/mixesPage.php">Mixes</a></li>
			<li><a href="../aboutPage/aboutPage.php">About</a></li>
            <li><a href="#contact">Profile</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control">
            </div>
			<button type="submit" class="btn btn-success">Drink!</button>
          </form>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

      <div class="starter-template">
      <div class="well">
            <div class="input-group">
              <input type="text" class="form-control" id="drinkInput" placeholder="Drink Name">
              <input type="text" class="form-control" id="typeInput" placeholder="Drink Type">
              <span class="input-group-btn">
                <button type="submit" id="addDrinkButton" class="btn btn-success">Add a drink!</button>
              </span>
       </div>
       
       <div id="drinkList"></div>
            
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			loadDrinks();
		  	
		  	$("#drinkInput").on("change", function() {
			   newDrink = this.value;
			});
			
			$("#typeInput").on("change", function() {
			   newType = this.value;
			});
			
			$("#addDrinkButton").on("click", function(){
				var actionType = "addDrink";
				$.ajax({                                      
				  url: '../fn.php',                  
				  data: {action: actionType, drink: newDrink, type: newType}, 
				  datatype: 'text',                          
				 success: function(data)
				  {
				  	console.log(data);
					$('#drinkList').text("");
					loadDrinks();
				  },
				  error: function (xhr, ajaxOptions, thrownError) {
				        alert(xhr.statusText);
				        //alert(thrownError);
				    }
			  	});
			});
			
			function loadDrinks() {
				 $.ajax({                                      
				  url: '../fn.php',                  
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
		  	}
		  });
	</script>
				  	

      </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="bootstrap.min.js"></script>
  </body>
</html>