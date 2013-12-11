<?php
  if(!isset($_COOKIE['userID'])){
    echo "<p>You're not signed in, you'll be redirected to the home page.</p>
          <a href='../mainPage/main.php'><p>Click here if nothing happens</p></a>
          ";
    header('Refresh: 3;url=../mainPage/main.php');
    exit();
  }
  $userID = $_COOKIE['userID'];
  $con=mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","socialdrinkers_b","testing123","socialdrinkers_db");
  if(isset($_POST['name'])){
    $newname=$_POST['name'];
    $newpass=$_POST['newpass'];
    $newemail=$_POST['email'];
    if(strlen($newpass)>0)
      $result = mysqli_query($con, "update Drinker set password = '$newpass' where userID = '$userID'");
    if($result==false){
      echo "shit went wrong--updating password!";
      exit();
    }
    $result = mysqli_query($con, "update Profile set Name = '$newname', Email = '$newemail' where UID = (select idNum from Drinker where userID = '$userID')");
    if($result==false){
      echo "shit went wrong!--updating profile";
      exit();
    }
    echo "<p>Your account has been sucessfully updated! You will now be redirected.</p>
          <a href='../mainPage/main.php'><p>Click here if nothing happens</p></a>
          ";
    header('Refresh: 3;url=../mainPage/main.php');
    exit();
  }
  $profile = mysqli_query($con, "select * from Profile inner join Drinker on Profile.UID = Drinker.idNum where Drinker.userID = '$userID'");
  echo mysqli_error($con);
  $name="";
  $email="";
  while($newrow = mysqli_fetch_assoc($profile)){
    $name=$newrow['Name'];
    $email=$newrow['Email'];
  }
  $quote = "'";
  echo '


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DrinkBook - Profile</title>

    <!-- Bootstrap core CSS -->
    <link href="../mainPage/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
  </head>

  <body>
    <div class="container" style="padding-top: 25px;">
      <legend><a href="../mainPage/main.php">DrinkBook</a>-Edit Profile</legend>
      <div class="well" style="background: rgba(0, 128, 255, 0.3);padding-top: 50px;padding-bottom: 50px;">
        <form class="form-horizontal" role="form" id="form1" method="post" action="edit.php">

          <div class="form-group">
            <label for="inputOldPass" class="col-sm-2 control-label">Enter Old Password</label>
            <div class="col-sm-6">
              <input name="oldpass" type="password" class="form-control" id="inputOldPass" placeholder="Old Password" autocomplete="off">
            </div>
            <div style="color:red;" id="oldpasswar"></div>
          </div>

          <div class="form-group">
            <label for="inputNewPass" class="col-sm-2 control-label">Enter New Password</label>
            <div class="col-sm-6">
              <input name="newpass" type="password" class="form-control" id="inputNewPass" placeholder="New Password">
            </div>
            <div style="color:red" id="newpasswar"></div>
          </div>

          <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-6">
              <input name="name" type="text" class="form-control" id="inputName" placeholder="Your Name" value="'.$name.'">
            </div>
            <div style="color:red" id="namewar"></div>
          </div>

          <div class="form-group">
            <label for="inputEmail" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-6">
              <input name="email" type="email" class="form-control" id="inputEmail" placeholder="Your Email" value="'.$email.'">
            </div>
            <div style="color:red" id="emailwar"></div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="button" class="btn btn-default" id="mysubmit">Submit changes</button>
            </div>
          </div>
        </form>
      </div>
    </div>


  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script>
    $(document).ready(function(){

      $("#mysubmit").click(function() {
        var userVal = '.$quote.$_COOKIE["userID"].$quote.';
        document.getElementById("oldpasswar").innerHTML="";
        document.getElementById("newpasswar").innerHTML="";
        document.getElementById("namewar").innerHTML="";
        document.getElementById("emailwar").innerHTML="";
        //Clean previous warnings

        var oldVal = $("#inputOldPass").val();
        var newVal = $("#inputNewPass").val();
        ///*
        if(oldVal.length>0 && (newVal.length > 15 || newVal.length < 6)){
          document.getElementById("newpasswar").innerHTML="password must be 6~15 characters long";
          $("#inputOldPass").val("");
          $("#inputNewPass").val("");
          return false;
        }
        //*/
        if(oldVal.length==0 && newVal.length>0){
          document.getElementById("oldpasswar").innerHTML="please enter your current password";
          $("#inputNewPass").val("");
          return false;
        }
        if(oldVal.length>0 && oldVal==newVal){
          $("#inputOldPass").val("");
          $("#inputNewPass").val("");
          document.getElementById("newpasswar").innerHTML="please enter a different new password";
          return false;
        }

        var emailVal = $("#inputEmail").val();
        if(emailVal.length > 30){
          document.getElementById("emailwar").innerHTML="Email address must be less than 30 characters long";
          return false;
        }
        var atpos=emailVal.indexOf("@");
        var dotpos=emailVal.lastIndexOf(".");
        if (emailVal.length!=0 && (atpos<1 || dotpos<atpos+2 || dotpos+2>=emailVal.length))
        {
          document.getElementById("emailwar").innerHTML="this is not a valid email address";
          return false;
        }

        var nameVal = $("#inputName").val();
        if(nameVal.length > 30){
          document.getElementById("namewar").innerHTML="Name must be less than 30 characters long";
        }
        for(var i=0;i<nameVal.length;i++){
          var c = nameVal.charAt(i);
          if( !(c<="z" && c>="a") && !(c<="Z" && c>="A") && !(c==" ") ){
            document.getElementById("namewar").innerHTML="Name must only contain characters";
            return false;
          }
        }




        //alert(userVal);
        ///*
        $.post("../signUp/checkuser.php", {user : userVal, pass: oldVal}, function(data) {
          if(data=="notmatch"){
            document.getElementById("oldpasswar").innerHTML="Old password does not match";
            $("#inputOldPass").val("");
            $("#inputNewPass").val("");
            return false;
          }
          else{
            //alert("good");
            $("#form1").submit();
          }
        });
        //*/

      });
    });
  </script>
  </body>


  ';
?>
