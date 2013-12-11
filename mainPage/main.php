<!-- The login implementation -->
<?php
  if(isset($_GET['logout'])) 
  {
    $expire = time()-60*60*24;
    setcookie('userID', " ", $expire, '/');
    unset($_COOKIE['userID']);
    header('Location: main.php');
    exit();
  }

  if(isset($_POST['user']))
  {
    //variable declaration 
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    //connect to data base 
    $con=mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","socialdrinkers_b","testing123","socialdrinkers_db");
    
    $result = mysqli_query($con, "SELECT * FROM `Drinker` where `userID` = '$user' AND `password` = '$pass'");
    echo mysqli_error($con);
    if (mysqli_num_rows($result) >0)
    { // correct info
      while($row = mysqli_fetch_assoc($result))
      {//cookie implementation
        $expire = time() + 60*60*24; //1 day
        setcookie('userID', $row['userID'], $expire, '/');
        //$userID = $row['userID'];
        header('Location: main.php');
        exit();
      }
    }
    else{ // wrong info
      echo '<script>
              alert("Your user name and password did not match, please try again.");
              window.location.assign("main.php");
            </script>';
      //header('Location: main.php');
      //exit();
    }
  }

  if(isset($_COOKIE['userID'])) 
  {
    $userID = $_COOKIE['userID'];
  }
?>
<!-- The login implementation -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DrinkBook</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="modern-business.css" rel="stylesheet">
    <link href="font-awesome.min.css" rel="stylesheet">
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
          <a class="navbar-brand" href="../mainPage/main.php">DrinkBook</a>
        </div>
        <div class="navbar-collapse collapse">
          <?php
            if(!isset($userID)){
              echo '
              <form class="navbar-form navbar-right" method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                <div class="form-group">
                  <input type="text" placeholder="username" class="form-control" name="user">
                </div>
                <div class="form-group">
                  <input type="password" placeholder="Password" class="form-control" name="pass">
                </div>
                <button type="submit" class="btn btn-success">DRINK!</button>
                <a type="button" class="btn btn-primary" href="../signUp">Signup</a>
              </form>
              ';
            }else{
              echo '
              <p class="navbar-text navbar-right">Signed in as '.$userID.', <a href="?logout" class="navbar-link"><b>click here to logout</b></a>.</p>
              ';
            }
          ?>
        </div><!--/.navbar-collapse -->
      </div>
    </div>
	
    <div id="myCarousel" class="carousel slide">
      <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
          <div class="item active">
            <div class="fill" style="background-image:url('http://fwallpapers.com/files/images/flaming-drinks.jpg');"></div>
            <div class="carousel-caption">
              <h1>Creatively Thirsty</h1>
            </div>
          </div>
          <div class="item">
            <div class="fill" style="background-image:url('http://www.allaboutbarsinfo.com/wp-content/uploads/2011/02/3-fancy-drinks.jpg');"></div>
            <div class="carousel-caption">
              <h1>Creatively Thirsty</h1>
            </div>
          </div>
          <div class="item">
            <div class="fill" style="background-image:url('http://thumbs.ifood.tv/files/images/editor/images/Shaken_Not_Stirred_V2_0.jpg');"></div>
            <div class="carousel-caption">
              <h1>Creatively Thirsty</h1>
            </div>
          </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
          <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
          <span class="icon-next"></span>
        </a>
    </div>

	<div class="container">

 
          <div class="well">
            <h4>Lets Get Weird!</h4>
            <div class="input-group">
              <input type="text" class="form-control" id="searchInput" placeholder="Search">
              <span class="input-group-btn">
                <button type="submit" class="btn btn-success" id="drinkSearchButton">Search by drink name</button>
				<button type="submit" class="btn btn-success" id="ingredientSearchButton">Search by ingredients</button>
              </span>
            </div><!-- /input-group -->
            
            <div id="searchResults"></div>



      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Mixes</h2>
          <p>Newest mixes of the week</p>
          <p><a class="btn btn-default" href="../mixesPage/mixes.php" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>About Us</h2>
		  <p>Our Mission</p>
          <p><a class="btn btn-default" href="../aboutPage/about.php" role="button">View details &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Profile</h2>
          <p>About you</p>
          <p><a class="btn btn-default" href="../profile" role="button">View details &raquo;</a></p>
        </div>
      </div>

      <hr>

      <footer>
        <p>&copy; Company 2013</p>
      </footer>
    </div> <!-- /container -->
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>
	
		function totable(data){
			var d = document.getElementById("searchResults");
			d.setAttribute("class","panel panel-default");
			var dd = document.createElement("div");
			dd.setAttribute("class","panel-heading");
			dd.appendChild(document.createTextNode("Search results"));
			d.appendChild(dd);
			var mytable = document.createElement("table");
			mytable.setAttribute("class","table");
      var thead = document.createElement("thead");
      var tbody = document.createElement("tbody");
      mytable.appendChild(thead);
      mytable.appendChild(tbody);
			var thr = document.createElement("tr");
			for(var key in data[0]){
				var th = document.createElement("th");
				th.appendChild(document.createTextNode(key));
				thr.appendChild(th);
			}
			thead.appendChild(thr);
			for(var i=0;i<data.length;i++){
				var r = document.createElement("tr");
				for(var key in data[i]){
					var td = document.createElement("td");
					td.appendChild(document.createTextNode(data[i][key]));
					r.appendChild(td);
				}
				tbody.appendChild(r);
			}
			d.appendChild(mytable);
		}
	
		$(document).ready(function(){
      var drinkSearchValue="";
		
			$("#searchInput").on("change", function() {
				   drinkSearchValue = this.value;
			});
				
			$("#drinkSearchButton").on("click", function(){
				var actionType = "searchDrinks";
				$.ajax({                                      
				  url: '../fn.php',                  
				  data: {action: actionType, drink: drinkSearchValue}, 
				  datatype: 'json',
				 success: function(data)
				  {
				  	console.log(data);
				  	data=JSON.parse(data);
				  	$('#searchResults').text("");
				  	totable(data);
				  	/*
				  	//$('#searchResults').append(data[0].name + " - " + data[0].type);
				  	$.each(data, function(index,data) {        
					    $('#searchResults').append(data.name+" - "+data.type + "<br>");
					});
					*/
				  },
				  error: function (xhr, ajaxOptions, thrownError) {
				        alert(xhr.statusText);
				        //alert(thrownError);
				    }
			  	});
			});
			
			$("#ingredientSearchButton").on("click", function(){
				var actionType = "searchIngredients";
				$.ajax({                                      
				  url: '../fn.php',                  
				  data: {action: actionType, ingredient: drinkSearchValue}, 
				  datatype: 'json',
				 success: function(data)
				  {
				  	console.log(data);
				  	data=JSON.parse(data);
				  	$('#searchResults').text("");
				  	totable(data);
				  	/*
				  	//$('#searchResults').append(data[0].name + " - " + data[0].type);
				  	$.each(data, function(index,data) {        
					    $('#searchResults').append(data.name+" - "+data.type + "<br>");
					});
					*/
				  },
				  error: function (xhr, ajaxOptions, thrownError) {
				        alert(xhr.statusText);
				        //alert(thrownError);
				    }
			  	});
			});
		});
		
		

	</script>

    <!-- Bootstrap core JavaScript -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="bootstrap.js"></script>
    <script src="modern-business.js"></script>
  </body>
</html>