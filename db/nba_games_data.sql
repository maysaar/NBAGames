-- Maysaa Rahman, Pei Tan
-- maysaa.rahman@vanderbilt.edu, pei.shan.tan@vanderbilt.edu
-- nba_games_data

-- SET SESSION sql_mode = '';

# Create database
DROP DATABASE IF EXISTS nba_data;
CREATE DATABASE nba_data;
USE nba_data;


# Create mega table for games
DROP TABLE IF EXISTS games_info;
CREATE TABLE IF NOT EXISTS games_info (
	game_date_est DATE DEFAULT NULL,
    game_id VARCHAR(10) NOT NULL UNIQUE,
    game_status_text VARCHAR(10) DEFAULT NULL,
    home_team_id VARCHAR(10) DEFAULT NULL, 
    visitor_team_id VARCHAR(10) DEFAULT NULL,
    season VARCHAR(5) DEFAULT NULL,
    team_id_home VARCHAR(10) DEFAULT NULL,
    pts_home VARCHAR(5) DEFAULT NULL,
    fg_pct_home DECIMAL(4,3) DEFAULT NULL,
    ft_pct_home DECIMAL(4,3) DEFAULT NULL,
    fg3_pct_home DECIMAL(4,3) DEFAULT NULL,
    ast_home VARCHAR(2) DEFAULT NULL,
    reb_home VARCHAR(2) DEFAULT NULL,
    team_id_away VARCHAR(10) DEFAULT NULL,
    pts_away VARCHAR(5) DEFAULT NULL,
    fg_pct_away DECIMAL(4,3) DEFAULT NULL,
    ft_pct_away DECIMAL(4,3) DEFAULT NULL,
    fg3_pct_away DECIMAL(4,3) DEFAULT NULL,
    ast_away VARCHAR(2) DEFAULT NULL,
    reb_away VARCHAR(2) DEFAULT NULL,
    home_team_wins VARCHAR(2) DEFAULT NULL,
    PRIMARY KEY (game_id)
)

ENGINE = InnoDB;

# Load data into games_info
LOAD DATA
    LOCAL
	INFILE 'C:/wamp64/www/NBAGames/data/games.csv'
	INTO TABLE games_info
	FIELDS 
		TERMINATED BY ','
	LINES 
		TERMINATED BY '\n'
	IGNORE 1 LINES;
    

# Create games table for 3NF compliance
DROP TABLE IF EXISTS games;
CREATE TABLE IF NOT EXISTS games (
	game_date_est DATE DEFAULT NULL,
    game_id VARCHAR(10) NOT NULL UNIQUE,
    game_status_text VARCHAR(10) DEFAULT NULL,
    home_team_id VARCHAR(10) DEFAULT NULL, 
    visitor_team_id VARCHAR(10) DEFAULT NULL,
    season VARCHAR(5) DEFAULT NULL,
    PRIMARY KEY (game_id)
)
ENGINE = InnoDB;

INSERT INTO games
SELECT game_date_est,
	   game_id,
       game_status_text,
       home_team_id,
       visitor_team_id,
       season
FROM games_info;

# Create home team games table for 3NF compliance
DROP TABLE IF EXISTS games_home;
CREATE TABLE IF NOT EXISTS games_home (
	game_id VARCHAR(10) NOT NULL UNIQUE,
	team_id_home VARCHAR(10) NOT NULL,
    pts_home VARCHAR(5) DEFAULT NULL,
    fg_pct_home DECIMAL(4,3) DEFAULT NULL,
    ft_pct_home DECIMAL(4,3) DEFAULT NULL,
    fg3_pct_home DECIMAL(4,3) DEFAULT NULL,
    ast_home VARCHAR(2) DEFAULT NULL,
    reb_home VARCHAR(2) DEFAULT NULL,
	home_team_wins VARCHAR(2) DEFAULT NULL,
    PRIMARY KEY (game_id, team_id_home),
    CONSTRAINT fk_games_home FOREIGN KEY (game_id)
		REFERENCES games (game_id)
		ON UPDATE CASCADE
        ON DELETE CASCADE
)
ENGINE = InnoDB;

INSERT INTO games_home
SELECT game_id,
	   team_id_home,
	   pts_home,
       fg_pct_home,
       ft_pct_home,
       fg3_pct_home,
       ast_home,
       reb_home,
       home_team_wins
FROM games_info;

# Create away team games table for 3NF compliance
DROP TABLE IF EXISTS games_away;
CREATE TABLE IF NOT EXISTS games_away (
	game_id VARCHAR(10) NOT NULL UNIQUE,
    team_id_away VARCHAR(10) NOT NULL,
    pts_away VARCHAR(5) DEFAULT NULL,
    fg_pct_away DECIMAL(4,3) DEFAULT NULL,
    ft_pct_away DECIMAL(4,3) DEFAULT NULL,
    fg3_pct_away DECIMAL(4,3) DEFAULT NULL,
    ast_away VARCHAR(2) DEFAULT NULL,
    reb_away VARCHAR(2) DEFAULT NULL,
    PRIMARY KEY (game_id, team_id_away),
    CONSTRAINT fk_games_away FOREIGN KEY (game_id)
		REFERENCES games (game_id)
		ON UPDATE CASCADE
        ON DELETE CASCADE
)
ENGINE = InnoDB;

INSERT INTO games_away
SELECT game_id,
	   team_id_away,
       pts_away,
       fg_pct_away,
       ft_pct_away,
       fg3_pct_away,
       ast_away,
       reb_away
FROM games_info;


SELECT *
FROM games_home;
SELECT *
FROM games_away;


# Create mega table for players
DROP TABLE IF EXISTS players_info;
CREATE TABLE IF NOT EXISTS players_info (
	player_name VARCHAR(30) DEFAULT NULL,
    team_id VARCHAR(10) NOT NULL, 
    player_id VARCHAR(10) NOT NULL,
    season VARCHAR(5) NOT NULL
)
ENGINE = InnoDB;

# Load data into players
LOAD DATA
    LOCAL
	INFILE 'C:/wamp64/www/NBAGames/data/players.csv'
	INTO TABLE players_info
	FIELDS 
		TERMINATED BY ','
	LINES 
		TERMINATED BY '\n'
	IGNORE 1 LINES;


# Create players for 3NF compliance
DROP TABLE IF EXISTS players;
CREATE TABLE IF NOT EXISTS players (
	player_name VARCHAR(30) DEFAULT NULL,
    team_id VARCHAR(10) NOT NULL, 
    player_id VARCHAR(10) NOT NULL,
    season VARCHAR(5) NOT NULL,
    PRIMARY KEY (player_id, team_id, season)
)
ENGINE = InnoDB;

INSERT INTO players
SELECT player_name,
	   team_id,
	   player_id,
	   season
FROM players_info;


# Create mega table for games_details
DROP TABLE IF EXISTS games_details_info;
CREATE TABLE IF NOT EXISTS games_details_info (
	game_id VARCHAR(10) DEFAULT NULL,
    team_id VARCHAR(10) DEFAULT NULL, 
    team_abbreviation VARCHAR(3) DEFAULT NULL,
    team_city VARCHAR(20) DEFAULT NULL,
    player_id VARCHAR(10) DEFAULT NULL,
    player_name VARCHAR(30) DEFAULT NULL,
    nickname VARCHAR(20) DEFAULT NULL,
    start_position VARCHAR(1) DEFAULT NULL,
    comment VARCHAR(100) DEFAULT NULL,
    min VARCHAR(20) DEFAULT NULL,
    fgm VARCHAR(10) DEFAULT NULL,
    fga TINYINT UNSIGNED DEFAULT NULL,
    fg_pct DECIMAL(4,3) DEFAULT NULL,
    fg3m TINYINT UNSIGNED DEFAULT NULL,
    fg3a TINYINT UNSIGNED DEFAULT NULL,
    fg3_pct DECIMAL(4,3) DEFAULT NULL,
    ftm TINYINT UNSIGNED DEFAULT NULL,
    fta TINYINT UNSIGNED DEFAULT NULL,
    ft_pct DECIMAL(4,3) DEFAULT NULL,
    oreb TINYINT UNSIGNED DEFAULT NULL,
    dreb TINYINT UNSIGNED DEFAULT NULL,
    reb TINYINT UNSIGNED DEFAULT NULL,
    ast TINYINT UNSIGNED DEFAULT NULL,
    stl TINYINT UNSIGNED DEFAULT NULL,
    blk TINYINT UNSIGNED DEFAULT NULL,
    to1 TINYINT UNSIGNED DEFAULT NULL,
    pf TINYINT UNSIGNED DEFAULT NULL,
    pts TINYINT UNSIGNED DEFAULT NULL,
    plus_minus TINYINT DEFAULT NULL
)
ENGINE = InnoDB;

# Load data into games_details
LOAD DATA
    LOCAL 
    INFILE 'C:/wamp64/www/NBAGames/data/games_details.csv'
	INTO TABLE games_details_info
	FIELDS 
		TERMINATED BY ','
	LINES 
		TERMINATED BY '\n'
	IGNORE 1 LINES;


# Create games_player_performance for 3NF compliance
DROP TABLE IF EXISTS games_player_performance;
CREATE TABLE IF NOT EXISTS games_player_performance (
	game_id VARCHAR(10) NOT NULL,
    player_id VARCHAR(10) NOT NULL,
    player_name VARCHAR(30) DEFAULT NULL,
    start_position VARCHAR(1) DEFAULT NULL,
    comment VARCHAR(100) DEFAULT NULL,
    fgm VARCHAR(10) DEFAULT NULL,
    fga TINYINT UNSIGNED DEFAULT NULL,
    fg_pct DECIMAL(4,3) DEFAULT NULL,
    fg3m TINYINT UNSIGNED DEFAULT NULL,
    fg3a TINYINT UNSIGNED DEFAULT NULL,
    fg3_pct DECIMAL(4,3) DEFAULT NULL,
    ftm TINYINT UNSIGNED DEFAULT NULL,
    fta TINYINT UNSIGNED DEFAULT NULL,
    ft_pct DECIMAL(4,3) DEFAULT NULL,
    oreb TINYINT UNSIGNED DEFAULT NULL,
    dreb TINYINT UNSIGNED DEFAULT NULL,
    reb TINYINT UNSIGNED DEFAULT NULL,
    ast TINYINT UNSIGNED DEFAULT NULL,
    stl TINYINT UNSIGNED DEFAULT NULL,
    blk TINYINT UNSIGNED DEFAULT NULL,
    to1 TINYINT UNSIGNED DEFAULT NULL,
    pf TINYINT UNSIGNED DEFAULT NULL,
    pts TINYINT UNSIGNED DEFAULT NULL,
    plus_minus TINYINT DEFAULT NULL
)
ENGINE = InnoDB;

INSERT INTO games_player_performance
SELECT game_id,
	   player_id,
       player_name,
       start_position,
       comment,
       fgm,
       fga,
       fg_pct,
       fg3m,
       fg3a,
       fg3_pct,
       ftm,
       fta,
       ft_pct,
       oreb,
       dreb,
       reb,
       ast,
       stl,
       blk,
       to1,
       pf,
       pts,
       plus_minus
FROM games_details_info;


# Create mega table for ranking
DROP TABLE IF EXISTS ranking_info;
CREATE TABLE IF NOT EXISTS ranking_info (
	team_id VARCHAR(12) NOT NULL, 
    league_id VARCHAR(3) DEFAULT NULL,
    season_id VARCHAR(5) DEFAULT NULL,
    standings_date DATE NOT NULL,
    conference VARCHAR(10) DEFAULT NULL,
    city VARCHAR(30) DEFAULT NULL,
    g TINYINT UNSIGNED DEFAULT NULL,
    w TINYINT UNSIGNED DEFAULT NULL,
    l TINYINT UNSIGNED DEFAULT NULL,
    w_pct DECIMAL(4,3) DEFAULT NULL,
    home_record VARCHAR(10) DEFAULT NULL,
    road_record VARCHAR(10) DEFAULT NULL,
    returntoplay VARCHAR(10) DEFAULT NULL
)
ENGINE = InnoDB;

# Load data into ranking_info
LOAD DATA
    LOCAL
	INFILE 'C:/wamp64/www/NBAGames/data/ranking.csv'
	INTO TABLE ranking_info
	FIELDS 
		TERMINATED BY ','
	LINES 
		TERMINATED BY '\r'
	IGNORE 1 LINES;

# Create team_rankings for 3NF compliance
DROP TABLE IF EXISTS team_rankings;
CREATE TABLE IF NOT EXISTS team_rankings (
	team_id VARCHAR(12) NOT NULL, 
    season_id VARCHAR(5) DEFAULT NULL,
    standings_date DATE NOT NULL,
    conference VARCHAR(10) DEFAULT NULL,
    city VARCHAR(30) DEFAULT NULL,
    g TINYINT UNSIGNED DEFAULT NULL,
    w TINYINT UNSIGNED DEFAULT NULL,
    l TINYINT UNSIGNED DEFAULT NULL,
    w_pct DECIMAL(4,3) DEFAULT NULL,
    home_record VARCHAR(10) DEFAULT NULL,
    road_record VARCHAR(10) DEFAULT NULL,
    PRIMARY KEY (team_id, standings_date)
)
ENGINE = InnoDB;

INSERT INTO team_rankings
SELECT TRIM(Replace(Replace(Replace(team_id,'\t',''),'\n',''),'\r','')),
	   season_id,
       standings_date,
       conference,
       city,
       g, 
       w,
       l,
       w_pct,
       home_record,
       road_record
FROM ranking_info;


# Create mega table for teams
DROP TABLE IF EXISTS teams_info;
CREATE TABLE IF NOT EXISTS teams_info (
	league_id VARCHAR(3) DEFAULT NULL,
    team_id VARCHAR(12) NOT NULL UNIQUE, 
    min_year VARCHAR(4) DEFAULT NULL,
    max_year VARCHAR(4) DEFAULT NULL,
    abbreviation VARCHAR(3) DEFAULT NULL,
    team_name VARCHAR(20) DEFAULT NULL,
    year_founded VARCHAR(4) DEFAULT NULL,
    city VARCHAR(20) DEFAULT NULL,
    arena VARCHAR(30) DEFAULT NULL,
    arena_capacity INT DEFAULT NULL,
    owner VARCHAR(50) DEFAULT NULL,
    general_manager VARCHAR(30) DEFAULT NULL,
    head_coach VARCHAR(30) DEFAULT NULL,
    d_league_affiliation VARCHAR(50) DEFAULT NULL
)
ENGINE = InnoDB;

# Load data into teams_info
LOAD DATA
    LOCAL
	INFILE 'C:/wamp64/www/NBAGames/data/teams.csv'
	INTO TABLE teams_info
	FIELDS 
		TERMINATED BY ','
	LINES 
		TERMINATED BY '\r'
	IGNORE 1 LINES;

# Create teams for 3NF compliance
DROP TABLE IF EXISTS teams;
CREATE TABLE IF NOT EXISTS teams (
    team_id VARCHAR(12) NOT NULL UNIQUE, 
    min_year VARCHAR(4) DEFAULT NULL,
    max_year VARCHAR(4) DEFAULT NULL,
    abbreviation VARCHAR(3) DEFAULT NULL,
    team_name VARCHAR(20) DEFAULT NULL,
    year_founded VARCHAR(4) DEFAULT NULL,
    city VARCHAR(20) DEFAULT NULL,
    arena VARCHAR(30) DEFAULT NULL,
    arena_capacity INT DEFAULT NULL,
    owner VARCHAR(50) DEFAULT NULL,
    general_manager VARCHAR(30) DEFAULT NULL,
    head_coach VARCHAR(30) DEFAULT NULL,
    d_league_affiliation VARCHAR(50) DEFAULT NULL,
    PRIMARY KEY (team_id)
)
ENGINE = InnoDB;

INSERT INTO teams
SELECT team_id,
       min_year,
       max_year,
       abbreviation,
       team_name,
       year_founded,
       city,
       arena,
       arena_capacity,
       owner,
       general_manager,
       head_coach,
       d_league_affiliation
FROM teams_info;


# Stored procedure to get player_id
DROP PROCEDURE IF EXISTS get_player_id;
DELIMITER //
CREATE PROCEDURE get_player_id(IN player VARCHAR(30), OUT id VARCHAR(10))
BEGIN

DECLARE sql_error INT DEFAULT FALSE;
DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET sql_error = TRUE;

SET id = (SELECT player_id
			FROM players
			WHERE player = player_name
			GROUP BY player_id);

END //
DELIMITER ;

-- test for get_player_id
-- CALL get_player_id('Andrew Bogut', @id);
-- SELECT @id;


# Stored procedure to get player_name
DROP PROCEDURE IF EXISTS get_player_name;
DELIMITER //
CREATE PROCEDURE get_player_name(IN id VARCHAR(10), OUT player VARCHAR(30))
BEGIN

DECLARE sql_error INT DEFAULT FALSE;
DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET sql_error = TRUE;

SET player = (SELECT player_name
				FROM players
                WHERE id = player_id
                GROUP BY player_name);

END //
DELIMITER ;

-- test for get_player_name
-- CALL get_player_name('101106', @player);
-- SELECT @player;


# Stored procedure to get team_id
DROP PROCEDURE IF EXISTS get_team_id;
DELIMITER //
CREATE PROCEDURE get_team_id(IN team VARCHAR(20), OUT id VARCHAR(12))
BEGIN

	DECLARE sql_error INT DEFAULT FALSE;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET sql_error = TRUE;

	SET id = (SELECT team_id
	FROM teams
	WHERE team = team_name
	GROUP BY team_id);

END //
DELIMITER ;

-- test for get_team_id
-- CALL get_team_id('Hawks', @id);
-- SELECT @id;


# Stored procedure to get team_name
DROP PROCEDURE IF EXISTS get_team_name;
DELIMITER //
CREATE PROCEDURE get_team_name(IN id VARCHAR(12), OUT team VARCHAR(20))
BEGIN

	DECLARE sql_error INT DEFAULT FALSE;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET sql_error = TRUE;

	SET team = (SELECT team_name
	FROM teams
	WHERE id = team_id
	GROUP BY team_name);

END //
DELIMITER ;

-- test for get_team_name
-- CALL get_team_name('1610612737', @team);
-- SELECT @team;

DROP TABLE IF EXISTS inserted_players;
CREATE TABLE IF NOT EXISTS inserted_players (
	player_name VARCHAR(30) DEFAULT NULL,
    team_id VARCHAR(10) NOT NULL, 
    player_id VARCHAR(10) NOT NULL,
    season VARCHAR(5) NOT NULL,
    PRIMARY KEY (player_id, team_id, season)
)
ENGINE = InnoDB;

# trigger when a player is inserted
DROP TRIGGER IF EXISTS player_before_insert;
DELIMITER //
CREATE TRIGGER player_before_insert
BEFORE INSERT
ON players
FOR EACH ROW

BEGIN

	INSERT INTO inserted_players
	VALUES (NEW.player_name,
			NEW.team_id,
			NEW.player_id,
			NEW.season);
            
	INSERT INTO players
	VALUES (NEW.player_name,
			NEW.team_id,
			NEW.player_id,
			NEW.season);

END //
DELIMITER ;

-- SELECT *
-- FROM inserted_players;

DROP TABLE IF EXISTS deleted_players;
CREATE TABLE IF NOT EXISTS deleted_players (
	player_name VARCHAR(30) DEFAULT NULL,
    team_id VARCHAR(10) NOT NULL, 
    player_id VARCHAR(10) NOT NULL,
    season VARCHAR(5) NOT NULL,
    PRIMARY KEY (player_id, team_id, season)
)
ENGINE = InnoDB;


# trigger when a player is deleted
DROP TRIGGER IF EXISTS player_after_delete;
DELIMITER //
CREATE TRIGGER player_after_delete
AFTER DELETE
ON players
FOR EACH ROW

BEGIN

	INSERT INTO deleted_players
	VALUES (OLD.player_name,
			OLD.team_id,
			OLD.player_id,
			OLD.season);

END //
DELIMITER ;


DROP TABLE IF EXISTS updated_players;
CREATE TABLE IF NOT EXISTS updated_players (
	player_name VARCHAR(30) DEFAULT NULL,
    team_id VARCHAR(10) NOT NULL, 
    player_id VARCHAR(10) NOT NULL,
    season VARCHAR(5) NOT NULL,
    PRIMARY KEY (player_id, team_id, season)
)
ENGINE = InnoDB;

# trigger when a player is updated
DROP TRIGGER IF EXISTS player_before_update;
DELIMITER //
CREATE TRIGGER player_before_delete
BEFORE UPDATE
ON players
FOR EACH ROW

BEGIN

	INSERT INTO updated_players
	VALUES (OLD.player_name,
			OLD.team_id,
			OLD.player_id,
			OLD.season);

END //
DELIMITER ;


# view for when a user searches a player
DROP VIEW IF EXISTS search_players;
CREATE VIEW search_players AS
SELECT player_name, team_name, season
FROM players_info
	JOIN teams USING (team_id)
ORDER BY season DESC;

-- test search_players
-- SELECT *
-- FROM search_players;


# stored procedure outputting table for search players feature
DROP PROCEDURE IF EXISTS get_search_players;
DELIMITER //
CREATE PROCEDURE get_search_players(IN player VARCHAR(20))
BEGIN

	DECLARE sql_error INT DEFAULT FALSE;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET sql_error = TRUE;

	SELECT team_name, season
    FROM search_players
    WHERE player_name = player;

END //
DELIMITER ;

-- test get_search_players
-- CALL get_search_players('LeBron James');


# view for when a user searches a player's games
DROP VIEW IF EXISTS search_players_games;
CREATE VIEW search_players_games AS
SELECT player_name, 
	   team_name, 
       season, 
       game_date_est, 
       start_position, 
       comment, 
       fgm, 
       fga, 
       fg_pct, 
       fg3m, 
       fg3a, 
       fg3_pct, 
       ftm, 
       fta, 
       ft_pct, 
       oreb, 
       dreb, 
       reb, 
       ast, 
       stl, 
       blk, 
       to1, 
       pf, 
       pts, 
       plus_minus,
       game_id
FROM games 
	JOIN games_player_performance USING (game_id)
    JOIN teams ON teams.team_id = games.home_team_id;
    
-- test search_players_games
-- SELECT *
-- FROM search_players_games;


# stored procedure outputting table for search player's games feature
DROP PROCEDURE IF EXISTS get_search_players_games;
DELIMITER //
CREATE PROCEDURE get_search_players_games(IN player VARCHAR(20), IN season_year VARCHAR(5))
BEGIN

	DECLARE sql_error INT DEFAULT FALSE;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET sql_error = TRUE;

	SELECT 
			game_id,
			team_name, 
		   game_date_est, 
           start_position, 
           comment, 
           fgm, 
           fga, 
           fg_pct, 
           fg3m, 
           fg3a, 
           fg3_pct, 
           ftm, 
           fta, 
           ft_pct, 
           oreb, 
           dreb, 
           reb, 
           ast, 
           stl, 
           blk, 
           to1, 
           pf, 
           pts, 
           plus_minus
    FROM search_players_games
    WHERE player_name = player AND season = season_year;

END //
DELIMITER ;

-- test get_search_players_games
-- CALL get_search_players_games('Ben Handlogten', '2003');


# view for when a user searches a team
DROP VIEW IF EXISTS search_teams;
CREATE VIEW search_teams AS
SELECT team_name, 
	   abbreviation, 
       year_founded, 
       city, 
       arena, 
       owner, 
       general_manager, 
       head_coach, 
       d_league_affiliation
FROM teams;

-- test search_teams
-- SELECT *
-- FROM search_teams;


# stored procedure outputting table for search teams feature
DROP PROCEDURE IF EXISTS get_search_teams;
DELIMITER //
CREATE PROCEDURE get_search_teams(IN team VARCHAR(20))
BEGIN

	DECLARE sql_error INT DEFAULT FALSE;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET sql_error = TRUE;

	SELECT team_name, 
		   abbreviation, 
           year_founded, 
           city, 
           arena, 
           owner, 
           general_manager, 
           head_coach, 
           d_league_affiliation
    FROM search_teams
    WHERE team_name = team;

END //
DELIMITER ;

-- test get_search_teams
-- CALL get_search_teams('Hawks');


# view for when a user searches a team's rankings
DROP VIEW IF EXISTS search_teams_rankings;
CREATE VIEW search_teams_rankings AS
SELECT team_name, 
	   SUBSTRING(season_id, 2, 4) AS season, 
       standings_date, 
       g, 
       w, 
       l, 
       w_pct, 
       home_record, 
       road_record
FROM teams
	JOIN team_rankings USING (team_id);

-- test search_team_rankings
-- SELECT *
-- FROM search_teams_rankings;


# stored procedure outputting table for search team's rankings feature
DROP PROCEDURE IF EXISTS get_search_teams_rankings;
DELIMITER //
CREATE PROCEDURE get_search_teams_rankings(IN team VARCHAR(20), IN season_year VARCHAR(4))
BEGIN

	DECLARE sql_error INT DEFAULT FALSE;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET sql_error = TRUE;

	SELECT standings_date, g, w, l, w_pct, home_record, road_record
    FROM search_teams_rankings
    WHERE team_name = team AND season = season_year;

END //
DELIMITER ;

-- test get_search_teams_rankings
-- CALL get_search_teams_rankings('Hawks', '2002');


# view for when a user searches a team's games
DROP VIEW IF EXISTS search_teams_games;
CREATE VIEW search_teams_games AS
SELECT game_date_est,
		game_id,
       game_status_text,
       season,
       team_id_home, 
       pts_home, 
       fg_pct_home, 
       ft_pct_home,
       fg3_pct_home,
       ast_home,
       reb_home, 
       team_id_away, 
       pts_away, 
       fg_pct_away,
       ft_pct_away,
       fg3_pct_away,
       ast_away,
       reb_away
FROM games
	JOIN games_home USING (game_id)
    JOIN games_away USING (game_id);
    
-- test search_teams_games
-- SELECT *
-- FROM search_teams_games;


# stored procedure outputting table for search team's games feature
-- **** add team names later
DROP PROCEDURE IF EXISTS get_search_teams_games;
DELIMITER //
CREATE PROCEDURE get_search_teams_games(IN team VARCHAR(20), IN season_year VARCHAR(4))
BEGIN

	DECLARE sql_error INT DEFAULT FALSE;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET sql_error = TRUE;
    
    CALL get_team_id(team, @id);

	SELECT game_date_est,
			game_id,
		   game_status_text, 
           team_id_home,
		   pts_home, 
		   fg_pct_home, 
		   ft_pct_home,
		   fg3_pct_home,
		   ast_home,
		   reb_home, 
           team_id_away,
		   pts_away, 
		   fg_pct_away,
		   ft_pct_away,
		   fg3_pct_away,
		   ast_away,
		   reb_away
    FROM search_teams_games
    WHERE (team_id_home = @id OR team_id_away = @id) AND season = season_year;

END //

DELIMITER ;

DROP PROCEDURE IF EXISTS match_predict;
DELIMITER //
CREATE PROCEDURE match_predict(IN team_one VARCHAR(20), IN team_two VARCHAR(20), OUT winner VARCHAR(20))
BEGIN
	DECLARE team_one_wins INT;
    DECLARE team_two_wins INT;
	DECLARE sql_error INT DEFAULT FALSE;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET sql_error = TRUE;
    
    CALL win_calculator(team_one, team_two, @team_one_wins_home, @team_two_wins_away);
    CALL win_calculator(team_two, team_one, @team_two_wins_home, @team_one_wins_away);

	SET team_one_wins = @team_one_wins_home + @team_one_wins_away;
    SET team_two_wins =  @team_two_wins_home + @team_two_wins_away;

	IF team_one_wins>team_two_wins THEN
		SET winner=team_one;
        SELECT DISTINCT team_name FROM teams WHERE team_id=@id_home;
	ELSE 
		SET winner=team_two;
        SELECT DISTINCT team_name FROM teams WHERE team_id=@id_away;
	END if;
END //
DELIMITER ;
-- test get_search_teams_rankings
-- CALL get_search_teams_games('Hawks', '2003');

DELIMITER ;

DROP PROCEDURE IF EXISTS win_calculator;
DELIMITER //
CREATE PROCEDURE win_calculator(IN team_home VARCHAR(20), IN team_away VARCHAR(20), OUT home_wins INT, OUT away_wins INT)
BEGIN
	DECLARE total INT;
	DECLARE sql_error INT DEFAULT FALSE;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET sql_error = TRUE;
	CALL get_team_id(team_home, @id_home);
	CALL get_team_id(team_away, @id_away);
	
    SET home_wins = (SELECT COUNT(*) FROM games_info WHERE team_id_home=@id_home AND team_id_away=@id_away AND home_team_wins=1);
    SET away_wins = (SELECT COUNT(*) FROM games_info WHERE team_id_home=@id_home AND team_id_away=@id_away AND home_team_wins=0);
END //
DELIMITER ;

CALL match_predict("Celtics","Knicks",@result);
SELECT @result;
