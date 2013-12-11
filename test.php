<?php
  $con=mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","socialdrinkers_b","testing123","socialdrinkers_db");
  $user=$_COOKIE["userID"];
  $types=array("Vodka", "Beer", "Tequila", "Whiskey", "Rum", "Gin", "Wine", "Brandy", "Misc");
  $results = array();
  foreach($types as $type){
    $query = "SELECT (
                (SELECT COUNT(*)
                FROM   Drink D JOIN History H ON H.drinkName = D.name
                WHERE  type = '$type' AND userID = '$user')
                +
                (((SELECT COUNT(*)
                FROM   Drink D JOIN Favorite F ON F.drinkName = D.name
                WHERE  type = '$type' AND userID = '$user'))*0.666))
                /     
                ((SELECT COUNT(*) FROM History  WHERE userID = '$user') 
                + 
                (SELECT COUNT(*) FROM Favorite WHERE userID = '$user'))
                AS score
              ";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $results[$type] = $row["score"];
  }
  $winner="";
  $best=0;
  foreach($results as $key=>$result){
    if($result>$best){
      $winner=$key;
      $best=$result;
    }
  }
  echo $winner."<br>";
  print_r($results);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="mainPage/bootstrap.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <h1>Hello, world!</h1>
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="mainPage/bootstrap.js"></script>
  </body>
</html>
