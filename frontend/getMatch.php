<?php
    if (isset($_POST['field_submit'])) {
        require_once("conn.php");
        $var_team = $_POST['field_team'];
        $var_season = $_POST['field_season'];
        $query = "SELECT * FROM games_info JOIN games USING game_id WHERE city = :ph_team AND season = :ph_season";
        //$query = "CALL get_search_teams_games(:ph_team, :ph_season)";

    try
        {
        $prepared_stmt = $dbo->prepare($query);
        $prepared_stmt->bindValue(':ph_team', $var_team, PDO::PARAM_STR);
        $prepared_stmt->bindValue(':ph_season', $var_season, PDO::PARAM_STR);
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
        
        <h1> Search for a team's information </h1>

        <form method="post">
            <label for="id_team">Enter the team's city:</label>
            <input type="text" name="field_team" id = "id_team"><br />
            <label for="id_season">Enter the season:</label>
            <input type="text" name="field_season" id = "id_season"><br />
            <input type="submit" name="field_submit" value="Submit">
        </form>
        
        <?php
        if (isset($_POST['field_submit'])) {
            if ($result && $prepared_stmt->rowCount() > 0) { ?>
                <h2>Results for <?php echo $_POST['field_team']; ?></h2>
                <table>
                    <thead>
                        <tr>
                            <th>Game Date</th>
                            <th>Home Team ID</th>
                            <th>Home Points</th>
                            <th>Home FG</th>
							<th>Home FT</th>
							<th>Home Ast</th>
							<th>Home Reb</th>
                            <th>Away Team ID</th>
                            <th>Away Points</th>
                            <th>Away FG</th>
							<th>Away FT</th>
							<th>Away Ast</th>
							<th>Away Reb</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($result as $row) { ?>
                            <tr>
                                <td><?php echo $row["game_date_est"]; ?></td>
                                <td><?php echo $row["team_id_home"]; ?></td>
                                <td><?php echo $row["pts_home"]; ?></td>
								<td><?php echo $row["fg_pct_home"]; ?></td>
                                <td><?php echo $row["ft_pct_home"]; ?></td>
                                <td><?php echo $row["ast_home"]; ?></td>
                                <td><?php echo $row["reb_home"]; ?></td>
                                <td><?php echo $row["team_id_away"]; ?></td>
								<td><?php echo $row["pts_away"]; ?></td>
                                <td><?php echo $row["fg_pct_away"]; ?></td>
                                <td><?php echo $row["ft_pct_away"]; ?></td>
								<td><?php echo $row["pts_away"]; ?></td>
                                <td><?php echo $row["ast_away"]; ?></td>
								<td><?php echo $row["reb_away"]; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
    
            <?php } else { ?>
                <h3> Sorry, no results found for team <?php echo $_POST['field_team']; ?> in the season <?php echo $_POST['field_season']; ?>. </h3>
            <?php }
        } ?>
    </body>
</html>






