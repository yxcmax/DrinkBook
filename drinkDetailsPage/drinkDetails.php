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
          <a class="navbar-brand" href="../mainPage/main.php">DrinkBook</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="../mixesPage/mixes.php">Mixes</a></li>
			<li><a href="../aboutPage/about.php">About</a></li>
            <li><a href="../profile">Profile</a></li>
          </ul>
          <!--<form class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control">
            </div>
			<button type="submit" class="btn btn-success">Drink!</button>
          </form>-->
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
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

      <div class="starter-template">
       
       <div id="drinkIngredients"></div>
	   <div id="drinkDescription">
			<p id = "type">Type: </p>
			<p id = "directions">Directions: </p>
	   </div>
	   <button type="button" id="favoriteButton" class="btn btn-default btn-lg">
		  <span id="favoriteIcon" class="glyphicon glyphicon-heart-empty"></span> Favorite
		</button>
		<button type="button" id="drinkHistoryButton" class="btn btn-default btn-lg">
		  <span id="favoriteIcon" class="glyphicon glyphicon-plus"></span> Add to my history
		</button>
            
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			loadIngredients();
			loadDescription();
			checkFavorite();
			isDrinkFavorite = false;
			
			$("#favoriteButton").on("click", function() {
				favoriteDrink();
			});
			
			$("#drinkHistoryButton").on("click", function() {
				$.ajax({                                      
				  url: '../fn.php',                  
				  data: "action=addToHistory&user=" + getCookie("userID") + "&drink=" + encodeURIComponent(getUrlVars()["drink"]),
				  dataType: 'text',
				  success: function(data)
				  {
					$("#drinkHistoryButton").text(" Added to your history!");
				  },
				  error: function (xhr, ajaxOptions, thrownError) {
				        //alert(xhr.statusText);
						console.log("action=getIngredients&drink=" + getUrlVars()["drink"]);
				        //alert(thrownError);
				    } 
			  	});
			});
			
			function loadIngredients() {
				 $.ajax({                                      
				  url: '../fn.php',                  
				  data: "action=getIngredients&drink=" + encodeURIComponent(getUrlVars()["drink"]),
				  dataType: 'json',
				  success: function(data)
				  {
					//console.log(data);
					//data=JSON.parse(data);
				  	$('#drinkIngredients').text("");
				  	totable(data, "drinkIngredients");
				  },
				  error: function (xhr, ajaxOptions, thrownError) {
				        //alert(xhr.statusText);
						console.log("action=getIngredients&drink=" + getUrlVars()["drink"]);
				        //alert(thrownError);
				    } 
			  	});
		  	}
			
			function loadDescription() {
				$.ajax({                                      
					url: '../fn.php',                  
					data: "action=getDescription&drink=" + encodeURIComponent(getUrlVars()["drink"]),                       
					dataType: 'json',     
					success: function(data)
					{
						//data=JSON.parse(data);
						//console.log("action=getDescription&drink=" + getUrlVars()["drink"]);
						$('#type').append(data[0]["Type"]);
						if(data[0]["Directions"] != "")
							$('#directions').append(data[0]["Directions"]);
						else
							$('#directions').append("Mix ingredients in a glass");
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.statusText);
						//alert(thrownError);
					} 
				});
		  	}
			
			function favoriteDrink() {
				var d = document.getElementById("favoriteIcon");
				if(isDrinkFavorite) {
					d.className = "glyphicon glyphicon-heart-empty";
					updateFavorite();
					isDrinkFavorite = false;
				} else {
					d.className = "glyphicon glyphicon-heart";
					updateFavorite();
					isDrinkFavorite = true;
				}
			}
			
			function checkFavorite() {
				$.ajax({                                      
					url: '../fn.php',                  
					data: "action=isFavorite&user=oliver&drink=" + encodeURIComponent(getUrlVars()["drink"]),                       
					dataType: 'text',     
					success: function(data)
					{
						if(data === "a favorite") {
							var d = document.getElementById("favoriteIcon");
							d.className = "glyphicon glyphicon-heart";
							isDrinkFavorite = true;
						}
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.statusText);
						//alert(thrownError);
					} 
				});
			}
			
			function updateFavorite() {
				$.ajax({                                      
					url: '../fn.php',                  
					data: "action=updateFavorite&user=" + getCookie("userID") + "&drink=" + encodeURIComponent(getUrlVars()["drink"]) + "&favStat=" + isDrinkFavorite,                       
					dataType: 'text',     
					success: function(data)
					{
						
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.statusText);
						//alert(thrownError);
					} 
				});
			}
			
			function totable(data, divToAttach){
				var d = document.getElementById(divToAttach);
				d.setAttribute("class","panel panel-default");
				var dd = document.createElement("div");
				dd.setAttribute("class","panel-heading");
				dd.appendChild(document.createTextNode("Drink Ingredients"));
				d.appendChild(dd);
				var mytable = document.createElement("table");
				mytable.setAttribute("class","table");
				var thr = document.createElement("tr");
				for(var key in data[0]){
					var th = document.createElement("th");
					th.appendChild(document.createTextNode(key));
					thr.appendChild(th);
				}
				mytable.appendChild(thr);
				for(var i=0;i<data.length;i++){
					var r = document.createElement("tr");
					var ingredientName = "" + data[i]["Ingredient"];
					for(var key in data[i]){
						var td = document.createElement("td");
						if(key == "Ingredient") {
							$(td).on("click", { value : ingredientName }, function( event ) {
								viewIngredientPrice(event.data.value);
							});
						}
						// else if(key == "type")
							// $(td).on("click", viewTag);
						td.appendChild(document.createTextNode(data[i][key]));
						r.appendChild(td);
					}
					mytable.appendChild(r);
				}
				d.appendChild(mytable);
			}
			
			function getUrlVars() {
				var vars = {};
				var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,    
				function(m,key,value) {
					vars[key] = value;
				});
				return vars;
			}
			
			function viewIngredientPrice() {
				console.log("click works");
			}
			function viewIngredientPrice(ingredientName) {
				window.open("http://www.walmart.com/search/search-ng.do?search_query=" + ingredientName.replace(" ","+") + "&ic=16_0&Find=Find&search_constraint=976759");
			}
			
			function getCookie(c_name) {
				var c_value = document.cookie;
				var c_start = c_value.indexOf(" " + c_name + "=");
				if (c_start == -1) {
					c_start = c_value.indexOf(c_name + "=");
				}
				if (c_start == -1) {
					c_value = null;
				} else {
					c_start = c_value.indexOf("=", c_start) + 1;
					var c_end = c_value.indexOf(";", c_start);
					if (c_end == -1)
					{
						c_end = c_value.length;
					}
					c_value = unescape(c_value.substring(c_start,c_end));
				}
				return c_value;
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