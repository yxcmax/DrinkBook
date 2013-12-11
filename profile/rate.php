<?php
  if(!isset($_COOKIE['userID']) || !isset($_POST['drinkName'])){
    echo 'This page is not supposed to be used like this.';
    exit();
  }
  $con=mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","socialdrinkers_b","testing123","socialdrinkers_db");
  $user=$_COOKIE["userID"];
  $drink=$_POST["drinkName"];
  if(isset($_POST['rating'])){
  	$rating=$_POST['rating'];
	$check = "SELECT rating from Rating where userID='$user' and drinkName='$drink'";
	$result = mysqli_query($con, $check);
	if(mysqli_num_rows($result)==0){
		$query="insert into Rating (userID,drinkName,rating) values('$user','$drink',$rating)";
	}
	else
		$query = "UPDATE Rating set rating = '$rating' where userID='$user' and drinkName='$drink'";
  	$result = mysqli_query($con, $query);
  	if(!$result){
  		echo "shit went wrong!";
  		die();
  	}
  	echo "successful";
  }else{
	  $query = "SELECT rating from Rating where userID='$user' and drinkName='$drink'";
	  $result = mysqli_query($con, $query);
	  if(mysqli_num_rows($result)==0){
	  	$rating="";
	  }else{
	  	$row = mysqli_fetch_assoc($result);
	  	$rating = $row["rating"];
	  }
	  echo $rating;
	}
?>