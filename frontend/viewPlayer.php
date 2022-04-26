<?php
    if (isset($_POST['field_submit'])) {
        require_once("conn.php");
        $var_player = $_POST['field_player'];
        $query = "SELECT * FROM players_info WHERE player_name = :ph_player";
        // $query = "CALL get_search_players(:ph_player)";

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
        <h1> Search for a player's information </h1>

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
                            <th>Name</th>
                            <th>Player ID</th>
                            <th>Team ID</th>
                            <th>Season</th>

                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($result as $row) { ?>
                            <tr>
                                <td><?php echo $row["player_name"]; ?></td>
                                <td><?php echo $row["team_id"]; ?></td>
                                <td><?php echo $row["player_id"]; ?></td>
                                <td><?php echo $row["season"]; ?></td>

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






