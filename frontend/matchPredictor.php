<?php
    if (isset($_POST['field_submit'])) {
        require_once("conn.php");
        $var_teamone = $_POST['field_teamone'];
        $var_teamtwo = $_POST['field_teamtwo'];
        $query = "CALL match_predict(:ph_teamone, :ph_teamtwo)";

    try
        {
        $prepared_stmt = $dbo->prepare($query);
        $prepared_stmt->bindValue(':ph_teamone', $var_teamone, PDO::PARAM_STR);
        $prepared_stmt->bindValue(':ph_teamtwo', $var_teamtwo, PDO::PARAM_STR);
        $prepared_stmt->execute();
        $result = $prepared_stmt->fetchAll();
        // $match_winner = $row['match_winner'];
        // var_dump($match_winner);

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
			<a style="float:right" href="matchPredictor.php">PREDICT</a>
			<a style="float:right" href="index.html">WELCOME</a>
		</div>
       
            <div id="searchbg">
               <h1> Predict which team will win a match </h1>
               <br/>
                <form method="post">
                    <label for="id_teamone">Enter team 1's name</label>
                    <input type="text" name="field_teamone" id = "id_teamone">
                    <label for="id_teamtwo">Enter team 2's name</label>
                    <input type="text" name="field_teamtwo" id = "id_teamtwo">
                    <br />
                    <input type="submit" name="field_submit" value="SUBMIT">
                </form>
            </div>
    
            <?php
            if (isset($_POST['field_submit'])) {
                if ($result && $prepared_stmt->rowCount() > 0) { ?>
                    <h2>The winner for <?php echo $_POST['field_teamone']; ?> vs <?php echo $_POST['field_teamtwo']; ?> is</h2>
                    <?php foreach ($result as $row) { ?>
                        <h1 style="color:red"><?php echo $row["team_name"]; ?></h1>
                        <?php } ?>
            <?php } else { ?>
                <div>
                <h3> Sorry, there was an error calculating your output. </h3>
                </div>
                <div id="spacer"></div>
           <?php }
        } ?>
    </body>
</html>






