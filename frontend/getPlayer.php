<?php
    if (isset($_POST['field_submit'])) {
        require_once("conn.php");
        $var_player = $_POST['field_player'];

        $query = "SELECT * FROM games_details_info WHERE player_name = :ph_player";
        //$query = "CALL get_search_players(:ph_player)";

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
			<img id="logobar" src="https://cdn.nba.com/logos/nba/nba-logoman-75-word_white.svg">
			<div id="navspacer"> </div>
            <a href="index.html">HOME</a>
			<div class="dropdown">
			  <button class="dropbtn">PLAYERS
				<i class="fa fa-caret-down"></i>
			  </button>
				<div class="dropdown-content">
					<a href="viewPlayer.php">PLAYER INFO</a>
					<a href="getPlayer.php">PLAYER MATCHES</a>
					<a href="addPlayer.php">ADD A PLAYER</a>
					<a href="removePlayer.php">REMOVE A PLAYER</a>
				</div>
			</div>
			<div class="dropdown">
				<button class="dropbtn">TEAMS
				  <i class="fa fa-caret-down"></i>
				</button>
				<div class="dropdown-content">
					<a href="getPlayer.php">TEAM MATCHES</a>
					<a href="addPlayer.php">ADD TEAM</a>
					<a href="removePlayer.php">REMOVE TEAM</a>
					<a href="viewPlayer.php">TEAM INFO</a>
				</div>
			</div>
			<div class="dropdown">
				<button class="dropbtn">MATCHES
				  <i class="fa fa-caret-down"></i>
				</button>
				<div class="dropdown-content">
				  <a href="getPlayer.php">TEAM MATCHES</a>
				  <a href="addPlayer.php">ADD MATCH</a>
				  <a href="removePlayer.php">REMOVE MATCH</a>
				  <a href="viewPlayer.php">MATCH INFO</a>
				</div>
			</div>
			<a href="matchPredictor.html">PREDICT</a>
		</div>
        <div id="bggrad"></div>
        <h1> Search for a player's matches </h1>

        <form method="post">
            <label for="id_player">Enter the player's full name:</label>
            <input type="text" name="field_player" id = "id_player">
            <br />
            <input type="submit" name="field_submit" value="Submit">
        </form>
        
        <?php
        if (isset($_POST['field_submit'])) {
            if ($result && $prepared_stmt->rowCount() > 0) { ?>
                <h2>Results for <?php echo $_POST['field_player']; ?> </h2>
                <table>
                    <thead>
                        <tr>
                            <th>Game ID</th>
                            <th>Team</th>
                            <th>Minutes</th>
                            <th>FGM</th>
                            <th>FGA</th>
                            <th>FTM</th>
                            <th>FTA</th>
                            <th>REB</th>
                            <th>AST</th>
                            <th>PF</th>
                            <th>PTS</th>

                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($result as $row) { ?>
                            <tr>
                                <td><?php echo $row["game_id"]; ?></td>
                                <td><?php echo $row["team_abbreviation"]; ?></td>
                                <td><?php echo $row["min"]; ?></td>
                                <td><?php echo $row["fgm"]; ?></td>
                                <td><?php echo $row["fga"]; ?></td>
                                <td><?php echo $row["ftm"]; ?></td>
                                <td><?php echo $row["fta"]; ?></td>
                                <td><?php echo $row["reb"]; ?></td>
                                <td><?php echo $row["ast"]; ?></td>
                                <td><?php echo $row["pf"]; ?></td>
                                <td><?php echo $row["pts"]; ?></td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
    
            <?php } else { ?>
                <h3> Sorry, no results found for player <?php echo $_POST['field_player']; ?>. </h3>
            <?php }
        } ?>
    </body>
</html>






