<?php
            	   
   switch ($_GET['action']) {
	case 'getDrinks':  
		getDrinks(); //your specific function
		break;
	case 'addDrink':
		addDrink($_GET['drink'], $_GET['type']);
		break;
	case 'searchDrinks':
		searchDrinks($_GET['drink']);
		break;
	case 'getIngredients':
		getIngredients($_GET['drink']);
		break;
	case 'getDescription':
		getDescription($_GET['drink']);
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
		   
	   	$result= mysqli_query($con,"INSERT INTO Drink VALUES ('" . $drink . "','" . $type . "', 'Blend')");
	   	
	   	if ( false===$result ) {
		  //echo mysqli_error($con);
		  echo "INSERT INTO Drink VALUES ('" . $drink . "','" . $type . "', 'Blend')";
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