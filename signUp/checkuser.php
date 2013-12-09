<?php
	if(!isset($_POST['user'])){
	    echo "something went wrong, you will be redirected
	          <a href='signup.php'><p>Click here if nothing happens</p></a>
	          ";
	    header('Refresh: 3;url=signup.php');
	    exit();
	}

	$con=mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","socialdrinkers_b","testing123","socialdrinkers_db");

	$user = $_POST['user'];

	$result = mysqli_query($con, "SELECT * FROM `Drinker` where `userID` = '$user'");

	if (mysqli_num_rows($result) >0){
		echo 'exist';
	}else{
		echo 'notexist';
	}
?>