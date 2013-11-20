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
          <a class="navbar-brand" href="http://socialdrinkers.web.engr.illinois.edu/p/Project/mainPage/mainPage.php">DrinkBook</a>
        </div>
        <div class="navbar-collapse collapse">
          <form class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">DRINK!</button>
          </form>
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
              <input type="text" class="form-control" id="searchInput" placeholder="Search for a drink">
              <span class="input-group-btn">
                <button type="submit" class="btn btn-success" id="searchButton">DRINK!</button>
              </span>
            </div><!-- /input-group -->
            
            <div id="searchResults"></div>



      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Mixes</h2>
          <p>Newest mixes of the week</p>
          <p><a class="btn btn-default" href="http://socialdrinkers.web.engr.illinois.edu/p/Project/mixesPage/mixesPage.php" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>About Us</h2>
		  <p>Our Mission</p>
          <p><a class="btn btn-default" href="http://socialdrinkers.web.engr.illinois.edu/p/Project/aboutPage/aboutPage.php" role="button">View details &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Profile</h2>
          <p>About you</p>
          <p><a class="btn btn-default" href="date.php" role="button">View details &raquo;</a></p>
        </div>
      </div>

      <hr>

      <footer>
        <p>&copy; Company 2013</p>
      </footer>
    </div> <!-- /container -->
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>
	
	
		///*
		function totable(data){
			var d = document.getElementById("searchResults");
			d.setAttribute("class","panel panel-default");
			var dd = document.createElement("div");
			dd.setAttribute("class","panel-heading");
			dd.appendChild(document.createTextNode("Search results"));
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
				for(var key in data[i]){
					var td = document.createElement("td");
					td.appendChild(document.createTextNode(data[i][key]));
					r.appendChild(td);
				}
				mytable.appendChild(r);
			}
			d.appendChild(mytable);
		}
		
	
		
		
		
		//*/
	
	
	
	
		$(document).ready(function(){
		
			$("#searchInput").on("change", function() {
				   drinkSearchValue = this.value;
			});
				
			$("#searchButton").on("click", function(){
				var actionType = "searchDrinks";
				$.ajax({                                      
				  url: 'http://socialdrinkers.web.engr.illinois.edu/p/Project/fn.php',                  
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
		});
		
		

	</script>

    <!-- Bootstrap core JavaScript -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="jquery.js"></script>
    <script src="bootstrap.js"></script>
    <script src="modern-business.js"></script>
  </body>
</html>