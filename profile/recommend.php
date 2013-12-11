<?php
  if(!isset($_COOKIE['userID'])){
    echo 'This page is not supposed to be used like this.';
    exit();
  }
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
  $result = mysqli_query($con, "SELECT * from Drink where type = '$winner' and name NOT in (select drinkName from History where userID = '$user')");
  if(mysqli_num_rows($result)==0)
    $result = mysqli_query($con, "SELECT * from Drink where type = '$winner'");
  $num_rows = mysqli_num_rows($result);
  $results = array();
  while($row = mysqli_fetch_assoc($result)){
    $results[]=$row;
  }
  srand(mktime(0, 0, 0));
  $drink_idx = rand(0, $num_rows-1);
  $recom = $results[$drink_idx]['name'];
?>