<?php
    if (isset($_POST['field_submit'])) {
        require_once("conn.php");
        $var_team = $_POST['field_team'];
        //$query = "SELECT * FROM teams_info WHERE city = :ph_team";
        $query = "CALL get_search_teams(:ph_team)";

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
        <h1> Search for a team's information </h1>

        <form method="post">
            <label for="id_team">Enter the team's name:</label>
            <input type="text" name="field_team" id = "id_team"><br />
            <input type="submit" name="field_submit" value="Submit">
        </form>
</div>
        <?php
        if (isset($_POST['field_submit'])) {
            if ($result && $prepared_stmt->rowCount() > 0) { ?>
                <h2>Results for <?php echo $_POST['field_team']; ?></h2>
                <table>
                    <tbody>
                        <?php foreach ($result as $row) { ?>
                            <tr> <td><b>Team Name</b></td> <td><?php echo $row["team_name"]; ?></td> </tr>
                            <tr> <td><b>Abbreviation</b></td><td><?php echo $row["abbreviation"]; ?></td></tr>
                            <tr> <td><b>Year Founded</b></td><td><?php echo $row["year_founded"]; ?></td></tr>
                            <tr> <td><b>City</b></td><td><?php echo $row["city"]; ?></td></tr>
                            <tr> <td><b>Arena</b></td><td><?php echo $row["arena"]; ?></td></tr>
                            <tr> <td><b>Owner</b></td><td><?php echo $row["owner"]; ?></td></tr>
                            <tr> <td><b>General Manager</b></td><td><?php echo $row["general_manager"]; ?></td></tr>
                            <tr> <td><b>Head Coach</b></td><td><?php echo $row["head_coach"]; ?></td></tr>
                            <tr> <td><b>League Affiliation</b></td><td><?php echo $row["d_league_affiliation"]; ?></td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            <div id="spacer"></div>
            <?php } else { ?>
                <h3> Sorry, no results found for team <?php echo $_POST['field_team']; ?> . </h3>
            <?php }
        } ?>
    </body>
</html>






