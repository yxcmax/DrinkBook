<?php
  if(!isset($_POST['user']) || !isset($_POST['pass'])){
    echo "something went wrong, you will be redirected
          <a href='signup.php'><p>Click here if nothing happens</p></a>
          ";
    header('Refresh: 3;url=signup.php');
    exit();
  }

	$con=mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","socialdrinkers_b","testing123","socialdrinkers_db");
	$user = $_POST['user'];
	$pass = $_POST['pass'];

	$result = mysqli_query($con, "INSERT INTO Drinker (userID, password) VALUES ('$user','$pass')");
	if($result==false){
		echo 'something went wrong';
	}else{
		echo'


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DrinkBook - Welcome</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
  </head>

  <body>
    <div class="container" style="padding-top: 75px;">
      <legend>Thank you for signing up at DrinkBook!</legend>
      <div class="well" style="background: rgba(0, 128, 255, 0.3);padding-top: 75px;padding-bottom: 75px;">
      	<h2>Welcome '.$user.", you'll be redirected to the home page soon.</h2>
      	<a href='signup.php'><p>Click here if nothing happens</p></a>
      </div>
    </div>
  </body>


		";
		header('Refresh: 5;url=signup.php');
	}
?>