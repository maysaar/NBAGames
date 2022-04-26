<?php

if (isset($_POST['f_submit'])) {

    require_once("conn.php");

    $var_player_name = $_POST['f_player_name'];
    $var_team_id = $_POST['f_team_id'];
    $var_player_id = $_POST['f_player_id'];
    $var_season= $_POST['f_season'];

    $query = "INSERT INTO players_info (player_name, team_id, player_id, season) "
            . "VALUES (:player_name, :team_id, :player_id, :season)";

    try
    {
      $prepared_stmt = $dbo->prepare($query);
      $prepared_stmt->bindValue(':player_name', $var_player_name, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':team_id', $var_team_id, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':player_id', $var_player_id, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':season', $var_season, PDO::PARAM_STR);
      $result = $prepared_stmt->execute();

    }
    catch (PDOException $ex)
    { // Error in database processing.
      echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
    }
}

?>

<html>
  <head>
    <!-- THe following is the stylesheet file. The CSS file decides look and feel -->
    <link rel="stylesheet" type="text/css" href="index.css" />
  </head> 

  <body>
  <div id="navbar">
			<ul>
            <li><a href="index.html">HOME</a></li>
		        <li><a href="getPlayer.php">PLAYERS</a></li>
		        <li><a href="getTeam.php">TEAMS</a></li>
                <li><a href="getMatch.php">MATCHES</a></li>
				<li><a href="matchPredictor.html">PREDICT</a></li>
		    </ul>
		</div>
        <div id="navbar">
			<ul>
				<li><a href="addPlayer.php">ADD PLAYER</a></li>
				<li><a href="removePlayer.php">REMOVE PLAYER</a></li>
                <li><a href="viewPlayer.php">PLAYER INFO</a></li>
		    </ul>
		</div>

<h1> Add a player</h1>

    <form method="post">
    	<label for="id_player_name">Player Name</label>
    	<input type="text" name="f_player_name" id="id_player_name"> 

    	<label for="id_team_id">Team ID</label>
    	<input type="text" name="f_team_id" id="id_team_id">

    	<label for="id_player_id">Player Id</label>
    	<input type="text" name="f_player_id" id="id_player_id">

    	<label for="id_season">Season</label>
    	<input type="text" name="f_season" id="id_season">
    	<br/>
    	<input type="submit" name="f_submit" value="Submit">
    </form>
    <?php
      if (isset($_POST['f_submit'])) {
        if ($result) { 
    ?>
          Player data was inserted successfully.
    <?php 
        } else { 
    ?>
          <h3> Sorry, there was an error. Player data was not inserted. </h3>
    <?php 
        }
      } 
    ?>


    
  </body>
</html>