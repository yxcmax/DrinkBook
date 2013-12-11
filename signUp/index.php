<?php
  if(isset($_COOKIE['userID'])) 
  {
    echo '
          <!DOCTYPE html>
          <html lang="en">
            <head>
              <meta charset="utf-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <meta name="description" content="">
              <meta name="author" content="">

              <title>DrinkBook - Signup</title>

              <!-- Bootstrap core CSS -->
              <link href="bootstrap.css" rel="stylesheet">

              <!-- Add custom CSS here -->
            </head>
            <body>
              <div class="container" style="padding-top: 25px;">
                <legend>Sign up for DrinkBook</legend>
                <div class="well" style="background: rgba(0, 128, 255, 0.3);padding-top: 50px;padding-bottom: 50px;">
                  <h1>Signed in as '.$_COOKIE['userID'].'</h1>
                  <p>redirecting</p>
                  <a href="signup.php">Click here if nothing happens</a>
                </div>
              </div>
            </body>
    ';
    header('Refresh: 3;url=../mainPage/main.php');
  }else{
    echo '



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DrinkBook - Signup</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
  </head>

  <body>
    <div class="container" style="padding-top: 25px;">
      <legend>Sign up for <a href="../mainPage/main.php">DrinkBook</a></legend>
      <div class="well" style="background: rgba(0, 128, 255, 0.3);padding-top: 50px;padding-bottom: 50px;">
        <form class="form-horizontal" role="form" id="form1" method="post" action="welcome.php">
          <div class="form-group">
            <label for="inputUser3" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-6">
              <input name="user" type="text" class="form-control" id="inputUser3" placeholder="username" autocomplete="off">
            </div>
            <div style="color:red;" id="userwar"></div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-6">
              <input name="pass" type="password" class="form-control" id="inputPassword3" placeholder="Password">
            </div>
            <div style="color:red" id="passwar"></div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="button" class="btn btn-default" id="mysubmit">DRINK!</button>
            </div>
          </div>
        </form>
      </div>
    </div>


  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script>
    $(document).ready(function(){

      $("#mysubmit").click(function() {
        document.getElementById("userwar").innerHTML="";
        document.getElementById("passwar").innerHTML="";
        var userVal = $("#inputUser3").val();
        var passVal = $("#inputPassword3").val();
        if(userVal.length > 12 || userVal.length < 3){
          document.getElementById("userwar").innerHTML="username must be 3~12 characters long";
          return false;
        }
        for(var i=0;i<userVal.length;i++){
          var c = userVal.charAt(i);
          if( !(c<="z" && c>="a") && !(c<="Z" && c>="A") ){
            document.getElementById("userwar").innerHTML="username must only contain characters";
            return false;
          }
        }
        if(passVal.length > 15 || passVal.length < 6){
          document.getElementById("passwar").innerHTML="password must be 6~15 characters long";
          return false;
        }
        //alert(userVal);
        $.post("checkuser.php", {user : userVal}, function(data) {
          if(data=="exist"){
            document.getElementById("userwar").innerHTML="The user name you entered already exists, please choose a new one.";
            return false;
          }
          else{
            $("#form1").submit();
          }
        });
      });
    });
  </script>
  </body>

      ';
  }
?>