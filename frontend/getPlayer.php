<?php
    if (isset($_POST['field_submit'])) {
        require_once("conn.php");
        $var_player = $_POST['field_player'];
        $query = "SELECT * FROM players_info";

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
		        <li><a href="index.html">Home</a></li>
		        <li><a href="getPlayer.php">Search Players</a></li>
		        <li><a href="getTeam.html">Search Teams</a></li>
                <li><a href="getMatch.html">Search Matches</a></li>
		    </ul>
		</div>
        
        <h1> Search for a player's information </h1>

        <form method="post">
            <label for="id_player">Player</label>
            <input type="text" name="field_player" id = "id_player">
            <input type="submit" name="field_submit" value="Submit">
        </form>
        
        <?php
        if (isset($_POST['field_submit'])) {
            if ($result && $prepared_stmt->rowCount() > 0) { ?>
                <h2>Results</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Player's Name</th>
                            <th>Team ID</th>
                            <th>Player ID</th>
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






