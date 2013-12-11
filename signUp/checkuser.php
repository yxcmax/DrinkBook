<?php
	if(!isset($_POST['user'])){
	    echo "something went wrong, you will be redirected
	          <a href='signup.php'><p>Click here if nothing happens</p></a>
	          ";
	    header('Refresh: 3;url=signup.php');
	    exit();
	}
	$checkpass=0;
	if(isset($_POST['pass'])){
		$checkpass=1;
	}

	$con=mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","socialdrinkers_b","testing123","socialdrinkers_db");

	$user = $_POST['user'];

	$result = mysqli_query($con, "SELECT * FROM `Drinker` where `userID` = '$user'");

	if($checkpass){
		$row = mysqli_fetch_assoc($result);
		if($row['password']!=$_POST['pass']){
			echo 'notmatch';
		}else{
			echo 'match';
		}
	}else{
		if (mysqli_num_rows($result) >0){
			echo 'exist';
		}else{
			echo 'notexist';
		}
	}
?>