<?php
            	   
   switch ($_GET['action']) {
	case 'getDrinks':  
		getDrinks(); //your specific function
		break;
	case 'addDrink':
		addDrink($_GET['drink'], $_GET['type']);
		break;
	case 'addIngredients':
		addIngredients($_GET['drink'], $_REQUEST['ingredients'], $_REQUEST['quantities']);
		break;
	case 'addFavorite':
		addFavorite($_GET['drink']);
		break;
	case 'searchDrinks':
		searchDrinks($_GET['drink']);
		break;
	case 'searchIngredients':
		searchDrinksByIngredients($_GET['ingredient']);
		break;
	case 'getIngredients':
		getIngredients($_GET['drink']);
		break;
	case 'getDescription':
		getDescription($_GET['drink']);
		break;
	case 'isFavorite':
		isFavorite($_GET['user'], $_GET['drink']);
		break;
	case 'updateFavorite':
		updateFavorite($_GET['user'], $_GET['drink'], $_GET['favStat']);
		break;
	default:
	}

	function getDrinks() {
		$con=mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","socialdrinkers_b","testing123","socialdrinkers_db");
		if (mysqli_connect_errno($con))
		{
		   //echo '<script>alert("connection has failed");</script>';
		}else{
		   //echo '<script>alert("successful");</script>';
		   /*$result = mysqli_query($con,"SELECT name, type FROM Drink");
		   $rows = array();
		   while($row[] = mysqli_fetch_array($result)){
			  $rows[]=$row;
		   }
		   echo json_encode($rows);*/
		   
		   	$sql =  mysqli_query($con,"SELECT name as Name, type as Type FROM Drink");
			$results = array();
			while($row = mysqli_fetch_array($sql))
			{
			   $results[] = array(
			      'Name' => $row['Name'],
			      'Type' => $row['Type']
			   );
			}
			echo json_encode($results);
		}
	}
	
	function addDrink($drink, $type) {
		$con=mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","socialdrinkers_b","testing123","socialdrinkers_db");
		if (mysqli_connect_errno($con))
		{
			echo "fail";
		   //echo '<script>alert("connection has failed");</script>';
		}else{
			//echo '<script>alert("successful");</script>';
			//echo "INSERT INTO Drink VALUES ('" . $drink . "','','" . $type . "','','";
			$result= mysqli_query($con,"INSERT INTO Drink VALUES ('" . $drink . "','','" . $type . "','','')");
			
			if ( false===$result ) {
			  //echo mysqli_error($con);
			  //echo "INSERT INTO Drink VALUES ('" . $drink . "','" . $type . "', 'Blend')";
			}
			else {
			  echo 'sucess';
			}
			/*$results = array();
			while($row = mysqli_fetch_array($sql))
			{
			   $results[] = array(
				  'name' => $row['name'],
				  'type' => $row['type']
			   );
			}
			echo json_encode($results);*/
		}
	}
	
	function addIngredients($drink, $ingrArray, $quantArray) {
		$con=mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","socialdrinkers_b","testing123","socialdrinkers_db");
		if (mysqli_connect_errno($con))
		{
			echo "fail";
		   //echo '<script>alert("connection has failed");</script>';
		}else{
		   //echo '<script>alert("successful");</script>';
		   
			for($i = 0, $size = count($ingrArray); $i < $size; $i++) {
				echo "INSERT INTO Ingredient VALUES ('" . $drink . "','" . $ingrArray[$i] . "','" . $quantArray[$i] . "')";
				$result= mysqli_query($con,"INSERT INTO Ingredient VALUES ('" . $drink . "','" . $ingrArray[$i] . "','" . $quantArray[$i] . "')");
			}
			if ( false===$result ) {
			  //echo mysqli_error($con);
			  echo "INSERT INTO Drink VALUES ('" . $drink . "','" . $type . "', 'Blend')";
			}
			else {
			  echo 'success';
			}
		}
	}
	
	function searchDrinks($drink) {
		$con=mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","socialdrinkers_b","testing123","socialdrinkers_db");
		if (mysqli_connect_errno($con))
		{
		   //echo '<script>alert("connection has failed");</script>';
		} else { 
		   	$sql =  mysqli_query($con,"SELECT * FROM Drink WHERE name LIKE '%" . $drink . "%'");
		   	if (!$sql) {
			    printf("Error: %s\n", mysqli_error($con));
			    exit();
			}
			$results = array();
			while($row = mysqli_fetch_assoc($sql))
			{
			   $results[] = $row;
			}
			echo json_encode($results);
		}
	}
	
	function searchDrinksByIngredients($ingr) {
		$con=mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","socialdrinkers_b","testing123","socialdrinkers_db");
		if (mysqli_connect_errno($con))
		{
		   //echo '<script>alert("connection has failed");</script>';
		} else { 
		   	$sql =  mysqli_query($con,"select name as Name, type as Type from Drink inner join Ingredient on Drink.name=Ingredient.drinkName where Ingredient.ingredientName LIKE '%" . $ingr . "%'");
			$results = array();
			while($row = mysqli_fetch_array($sql))
			{
			   $results[] = array(
			      'Name' => $row['Name'],
			      'Type' => $row['Type']
			   );
			   //$results[] = $row;
			}
			echo json_encode($results);
		}
	}
	
	function getIngredients($drink) {
		$con=mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","socialdrinkers_b","testing123","socialdrinkers_db");
		if (mysqli_connect_errno($con))
		{
		   echo '<script>alert("connection has failed");</script>';
		} else { 
		   	$sql =  mysqli_query($con,"SELECT ingredientName as Ingredient, quantity as Quantity FROM Ingredient WHERE drinkName =  '" . $drink . "'");
			$results = array();
			while($row = mysqli_fetch_array($sql))
			{
			   $results[] = array(
			      'Ingredient' => $row['Ingredient'],
			      'Quantity' => $row['Quantity']
			   );
			}
			echo json_encode($results);
		}
	}
	
	function getDescription($drink) {
		$con=mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","socialdrinkers_b","testing123","socialdrinkers_db");
		if (mysqli_connect_errno($con))
		{
		   //echo '<script>alert("connection has failed");</script>';
		} else {
			echo "SELECT type as Type, directions as Directions FROM Drink WHERE name =  '" . urldecode($drink) . "'";
		   	$sql =  mysqli_query($con,"SELECT type as Type, directions as Directions FROM Drink WHERE name =  '" . urldecode($drink) . "'");
			$results = array();
			while($row = mysqli_fetch_array($sql))
			{
			   $results[] = array(
			      'Type' => $row['Type'],
			      'Directions' => $row['Directions']
			   );
			}
			echo json_encode($results);
		}
	}
	
	function isFavorite($user, $drink) {
		$con=mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","socialdrinkers_b","testing123","socialdrinkers_db");
		if (mysqli_connect_errno($con))
		{
		   //echo '<script>alert("connection has failed");</script>';
		} else {
			//echo "SELECT * from Favorite where userID = '" . $user . "' and drinkName = '" . urldecode($drink) . "'\n";
		   	$sql =  mysqli_query($con,"SELECT * from Favorite where userID = '" . $user . "' and drinkName = '" . urldecode($drink) . "'");
			//echo $sql;
			if( mysqli_num_rows($sql) != 0)
				echo "a favorite";
			else
				echo "not a favorite";
		}
	}
	
	function updateFavorite($user, $drink, $favStat) {
				$con=mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","socialdrinkers_b","testing123","socialdrinkers_db");
		if (mysqli_connect_errno($con))
		{
		   //echo '<script>alert("connection has failed");</script>';
		} else {
			echo $favStat . "\n";
			if($favStat == "true") { // true meaning is already a favorite, so remove as a favorite
				echo "DELETE FROM Favorite WHERE userID= '" . $user . "' and drinkName='" . urldecode($drink) . "'\n";
				$result =  mysqli_query($con,"DELETE FROM Favorite WHERE userID= '" . $drink . "' and drinkName='" . urldecode($drink) . "'");
			} else { //add as a favorite
				echo "INSERT INTO Favorite VALUES ('','" . $user . "','" . urldecode($drink) . "')\n";
				$result =  mysqli_query($con,"INSERT INTO Favorite VALUES ('','" . $user . "','" . urldecode($drink) . "')");
			}
			
			echo $result;
			
			if ( false===$result ) {
			  echo mysqli_error($con);
			}
			else {
			  echo 'success';
			}
		}
	}