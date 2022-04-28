<?php
    if (isset($_POST['field_submit'])) {
        require_once("conn.php");
        $var_player = $_POST['field_player'];
        $query = "SELECT DISTINCT player_name FROM players_info WHERE player_id = :ph_player";

    try
        {
        $prepared_stmt = $dbo->prepare($query);
        $prepared_stmt->bindValue(':ph_player', $var_player, PDO::PARAM_STR);
        $prepared_stmt->execute();
        $result = $prepared_stmt->fetchAll();

        }
        catch (PDOException $ex)
        { 
            echo $sql . "<br>" . $error->getMessage(); 
        }
    }
?>

<html>
    <head>
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
               <h1> Search for a player by their ID </h1>
               <br/>
                <form method="post">
                    <label for="id_player">Enter the player's id:</label>
                    <input type="text" name="field_player" id = "id_player">
                    <br />
                    <input type="submit" name="field_submit" value="SUBMIT">
                </form>
            </div>
        <?php
        if (isset($_POST['field_submit'])) {
            if ($result && $prepared_stmt->rowCount() > 0) { ?>
                <div>
                <h3> The player name for <?php echo $_POST['field_player']; ?> is <?php foreach ($result as $row) { ?>
                         <?php echo $row["player_name"]; ?>
                        <?php } ?>. </h3>
                <div id="spacer"></div>
            <?php } else { ?>
                <div>
                <h3> Sorry, no results found for player <?php echo $_POST['field_player']; ?>. </h3>
                </div>
                <div id="spacer"></div>
           <?php }
        } ?>
    </body>
</html>






