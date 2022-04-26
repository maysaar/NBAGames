<?php
    if (isset($_POST['field_submit'])) {
        require_once("conn.php");
        $var_team = $_POST['field_team'];
        $query = "SELECT * FROM teams_info WHERE city = :ph_team";

    try
        {
        $prepared_stmt = $dbo->prepare($query);
        $prepared_stmt->bindValue(':ph_team', $var_team, PDO::PARAM_STR);
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
            <input type="submit" name="field_submit" value="Submit">
        </form>
        
        <?php
        if (isset($_POST['field_submit'])) {
            if ($result && $prepared_stmt->rowCount() > 0) { ?>
                <h2>Results for <?php echo $_POST['field_team']; ?></h2>
                <table>
                    <thead>
                        <tr>
                            <th>Team Name</th>
                            <th>Abbreviation</th>
                            <th>Year Founded</th>
                            <th>City</th>
							<th>Arena</th>
							<th>Owner</th>
							<th>General Manager</th>
							<th>Head Coach</th>
							<th>League Affiliation</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($result as $row) { ?>
                            <tr>
                                <td><?php echo $row["team_name"]; ?></td>
                                <td><?php echo $row["abbreviation"]; ?></td>
                                <td><?php echo $row["year_founded"]; ?></td>
                                <td><?php echo $row["city"]; ?></td>
								<td><?php echo $row["arena"]; ?></td>
                                <td><?php echo $row["owner"]; ?></td>
                                <td><?php echo $row["general_manager"]; ?></td>
                                <td><?php echo $row["head_coach"]; ?></td>
								<td><?php echo $row["d_league_affiliation"]; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
    
            <?php } else { ?>
                <h3> Sorry, no results found for team <?php echo $_POST['field_team']; ?> . </h3>
            <?php }
        } ?>
    </body>
</html>






