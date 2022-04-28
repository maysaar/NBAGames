<?php

if (isset($_POST['f_submit'])) {

    require_once("conn.php");

    $var_id = $_POST['f_id'];
    $var_hid = $_POST['f_hid'];

    $var_hpts= $_POST['f_hpts'];
    $var_hfg = $_POST['f_hfg'];
    $var_hft= $_POST['f_hft'];

    $var_hast = $_POST['f_hast'];
    $var_hreb= $_POST['f_hreb'];
    $var_aid = $_POST['f_aid'];

    $var_apts= $_POST['f_apts'];
    $var_afg = $_POST['f_afg'];
    $var_aft= $_POST['f_aft'];

    $var_aast = $_POST['f_aast'];
    $var_areb= $_POST['f_areb'];

    $query = "INSERT INTO games_info (game_date_est,game_id,game_status_text,home_team_id,visitor_team_id,season,team_id_home,pts_home,fg_pct_home,ft_pct_home,fg3_pct_home,ast_home,reb_home,team_id_away,pts_away,fg_pct_away,ft_pct_away,fg3_pct_away,ast_away,reb_away,home_team_wins)"
            . "VALUES (NULL, :ph_id, NULL, NULL, NULL, NULL, :ph_hid, :ph_hpts, :ph_hfg, :ph_hft, NULL, :ph_hast, :ph_hreb, :ph_aid, :ph_apts, :ph_afg, :ph_aft, NULL, :ph_aast. :ph_areb, NULL)";

    try
    {
      $prepared_stmt = $dbo->prepare($query);
      $prepared_stmt->bindValue(':ph_id', $var_id, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':ph_hid', $var_hid, PDO::PARAM_STR);

      $prepared_stmt->bindValue(':ph_hpts', $var_hpts, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':ph_hfg', $var_hfg, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':ph_hft', $var_hft, PDO::PARAM_INT);

      $prepared_stmt->bindValue(':ph_hast', $var_hast, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':ph_hreb', $var_hreb, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':ph_aid', $var_aid, PDO::PARAM_STR);

      $prepared_stmt->bindValue(':ph_apts', $var_apts, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':ph_afg', $var_afg, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':ph_aft', $var_aft, PDO::PARAM_INT);

      $prepared_stmt->bindValue(':ph_aast', $var_aast, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':ph_areb', $var_areb, PDO::PARAM_STR);
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
			<a style="float:right" href="matchPredictor.php">PREDICT</a>
			<a style="float:right" href="index.html">WELCOME</a>
		</div>

		<div id="searchbg">
<h1> Add a match</h1>
    <form method="post">
    <table style="box-shadow: 0 0 0 #17408B">
        <tr><td>Game ID</td><td><input type="text" name="f_id" id="id_id"> </td></tr>
        <tr><td>Home Team ID</td><td><input type="text" name="f_hid" id="id_hid"> </td></tr>
        <tr>  <td>Home Points</td><td><input type="text" name="f_hpts" id="id_hpts"> </td></tr>
        <tr> <td>Home FG</td><td><input type="number" name="f_hfg" id="id_hfg"> </td></tr>
        <tr> <td>Home FT</td><td><input type="number" name="f_hft" id="id_hft"> </td></tr>
        <tr>  <td>Home Ast</td><td><input type="text" name="f_hast" id="id_hast"> </td></tr>
        <tr>  <td>Home Reb</td><td><input type="text" name="f_hreb" id="id_hreb"> </td></tr>
        <tr>  <td>Away Team ID</td><td><input type="text" name="f_aid" id="id_aid"> </td></tr>
        <tr>  <td>Away Points</td><td><input type="text" name="f_apts" id="id_apts"> </td></tr>
        <tr>  <td>Away FG</td><td><input type="number" name="f_afg" id="id_afg"> </td></tr>
        <tr>  <td>Away FT</td><td><input type="number" name="f_aft" id="id_aft"> </td></tr>
        <tr> <td>Away Ast</td><td><input type="text" name="f_aast" id="id_aast"> </td></tr>
        <tr> <td>Away Reb</td><td><input type="text" name="f_areb" id="id_areb"> </td></tr>   
    </table>
    <br />
    <input type="submit" name="f_submit" value="Submit">
    </form>
</div>
    <?php
      if (isset($_POST['f_submit'])) {
        if ($result) { 
    ?>
          <h3> Match data was inserted successfully. </h3>
    <?php 
        } else { 
    ?>
          <h3> Match data was inserted successfully. </h3>
    <?php 
        }
      } 
    ?>


    
  </body>
</html>