<?php
// If the all the variables are set when the Submit button is clicked...
if (isset($_POST['field_submit'])) {
    // It will refer to conn.php file and will open a connection.
    require_once("conn.php");
    // Will get the value typed in the form text field and save into variable
    $var_name= $_POST['field_name'];
    // Save the query into variable called $query. NOte that :title is a place holder
    $query = "DELETE FROM players_info WHERE player_name = :name";
    
    try
    {
      $prepared_stmt = $dbo->prepare($query);
      //bind the value saved in the variable $var_title to the place holder :title after //verifying (using PDO::PARAM_STR) that the user has typed a valid string.
      $prepared_stmt->bindValue(':name', $var_name, PDO::PARAM_STR);
      //Execute the query and save the result in variable named $result
      $result = $prepared_stmt->execute();

    }
    catch (PDOException $ex)
    { // Error in database processing.
      echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
    }
}

?>

<html>
  <!-- Any thing inside the HEAD tags are not visible on page.-->
  <head>
    <!-- THe following is the stylesheet file. The CSS file decides look and feel -->
    <link rel="stylesheet" type="text/css" href="index.css" />
  </head> 

  <!-- Everything inside the BODY tags are visible on page.-->
  <body>
     <!-- See the project.css file to see how is navbar stylized.-->
     <div class="navbar">
			<img id="logobar" src="https://cdn.nba.com/logos/nba/nba-logoman-75-word_white.svg">
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
    <!-- See the project.css file to note h1 (Heading 1) is stylized.-->
    <h1> Remove a Player </h1>
    <!-- This is the start of the form. This form has one text field and one button.
      See the project.css file to note how form is stylized.-->
    <form method="post">

      <label for="id_title">Player's Name</label>
      <!-- The input type is a text field. Note the name and id. The name attribute
        is referred above on line 7. $var_title = $_POST['field_title']; -->
      <input type="text" name="field_name" id="id_name">
      <br />
      <!-- The input type is a submit button. Note the name and value. The value attribute decides what will be dispalyed on Button. In this case the button shows Delete Movie.
      The name attribute is referred above on line 3 and line 63. -->
      <input type="submit" name="field_submit" value="Submit">
    </form>

    <?php
      if (isset($_POST['field_submit'])) {
        if ($result) { 
    ?>
          Player was deleted successfully.
    <?php 
        } else { 
    ?>
          <h3> Sorry, there was an error. Player data was not deleted. </h3>
    <?php 
        }
      } 
    ?>

    
  </body>
</html>
