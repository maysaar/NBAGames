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
  <div class="navbar">
			<div class="dropdown">
			  <button class="dropbtn">PLAYERS
				<i class="fa fa-caret-down"></i>
			  </button>
				<div class="dropdown-content">
					<a href="viewPlayer.php">PLAYER INFO</a>
					<a href="getPlayerID.php">GET PLAYER ID</a>
					<a href="searchPlayer.php">SEARCH PLAYER ID</a>
					<a href="getPlayer.php">PLAYER MATCHES</a>
					<a href="addPlayer.php">ADD A PLAYER</a>
					<a href="removePlayer.php">REMOVE A PLAYER</a>
					<a href="updatePlayer.php">UPDATE A PLAYER</a>
				</div>
			</div>
			<div class="dropdown">
				<button class="dropbtn">TEAMS
				  <i class="fa fa-caret-down"></i>
				</button>
				<div class="dropdown-content">
					<a href="viewTeam.php">TEAM INFO</a>
					<a href="getTeam.php">TEAM MATCHES</a>
					<a href="getTeamID.php">GET TEAM ID</a>
					<a href="searchTeam.php">SEARCH TEAM ID</a>
				</div>
			</div>
			<div class="dropdown">
				<button class="dropbtn">MATCHES
				  <i class="fa fa-caret-down"></i>
				</button>
				<div class="dropdown-content">
				  <a href="getMatch.php">SEARCH MATCHES</a>
				  <a href="addMatch.php">ADD MATCH</a>
				  <a href="removeMatch.php">REMOVE MATCH</a>
				</div>
			</div>
			
			<img id="logobar" src="https://cdn.nba.com/logos/nba/nba-logoman-75-word_white.svg">
			<a style="float:right" href="sourceList.html"> SOURCES </a>
			<a style="float:right" href="matchPredictor.html">PREDICT</a>
			<a style="float:right" href="index.html">WELCOME</a>
		</div>

		<div id="searchbg">
<h1> Add a player</h1>
	<br/>
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
</div>
    <?php
      if (isset($_POST['f_submit'])) {
        if ($result) { 
    ?>
          <h3> Player data was inserted successfully. </h3>
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