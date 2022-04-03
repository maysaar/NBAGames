-- Maysaa Rahman, Pei Tan
-- maysaa.rahman@vanderbilt.edu, pei.shan.tan@vanderbilt.edu
-- NBA Games

SET SESSION sql_mode = '';

DROP DATABASE IF EXISTS nba_data;
CREATE DATABASE nba_data;
USE nba_data;

DROP TABLE IF EXISTS games_info;
CREATE TABLE IF NOT EXISTS games_info (
	game_date_est DATE DEFAULT NULL,
    game_id VARCHAR(10) DEFAULT NULL,
    game_status_text VARCHAR(10) DEFAULT NULL,
    home_team_id VARCHAR(10) DEFAULT NULL, 
    visitor_team_id VARCHAR(10) DEFAULT NULL,
    season VARCHAR(5) DEFAULT NULL,
    team_id_home VARCHAR(10) DEFAULT NULL,
    pts_home VARCHAR(5) DEFAULT NULL,
    fg_pct_home DECIMAL(4,3) DEFAULT NULL,
    ft_pct_home DECIMAL(4,3) DEFAULT NULL,
    fg3_pct_home DECIMAL(4,3) DEFAULT NULL,
    ast_home DECIMAL(3,1) DEFAULT NULL,
    reb_home DECIMAL(3,1) DEFAULT NULL,
    team_id_away VARCHAR(10) DEFAULT NULL,
    pts_away VARCHAR(5) DEFAULT NULL,
    fg_pct_away DECIMAL(4,3) DEFAULT NULL,
    ft_pct_away DECIMAL(4,3) DEFAULT NULL,
    fg3_pct_away DECIMAL(4,3) DEFAULT NULL,
    ast_away DECIMAL(3,1) DEFAULT NULL,
    reb_away DECIMAL(3,1) DEFAULT NULL,
    home_team_wins VARCHAR(2) DEFAULT NULL
)
ENGINE = InnoDB;

LOAD DATA
    LOCAL
	INFILE '/Users/ytan1/OneDrive/Documents/GitHub/NBAGames/data/games.csv'
	INTO TABLE games_info
	FIELDS 
		TERMINATED BY ','
	LINES 
		TERMINATED BY '\n'
	IGNORE 1 LINES;


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
    comment VARCHAR(30) DEFAULT NULL,
    min VARCHAR(5) DEFAULT NULL,
    fgm DECIMAL(3,1) DEFAULT NULL,
    fga DECIMAL(3,1) DEFAULT NULL,
    fg_pct DECIMAL(4,3) DEFAULT NULL,
    fg3m DECIMAL(3,1) DEFAULT NULL,
    fg3a DECIMAL(3,1) DEFAULT NULL,
    fg3_pct DECIMAL(4,3) DEFAULT NULL,
    ftm DECIMAL(3,1) DEFAULT NULL,
    fta DECIMAL(3,1) DEFAULT NULL,
    ft_pct DECIMAL(4,3) DEFAULT NULL,
    oreb DECIMAL(2,1) DEFAULT NULL,
    dreb DECIMAL(3,1) DEFAULT NULL,
    reb DECIMAL(3,1) DEFAULT NULL,
    ast DECIMAL(3,1) DEFAULT NULL,
    stl DECIMAL(3,1) DEFAULT NULL,
    blk DECIMAL(2,1) DEFAULT NULL,
    to1 DECIMAL(2,1) DEFAULT NULL,
    pf DECIMAL(2,1) DEFAULT NULL,
    pts DECIMAL(3,1) DEFAULT NULL,
    plus_minus DECIMAL(3,1) DEFAULT NULL
)
ENGINE = InnoDB;

LOAD DATA
    LOCAL
	INFILE '/Users/ytan1/OneDrive/Documents/GitHub/NBAGames/data/games_details.csv'
	INTO TABLE games_details_info
	FIELDS 
		TERMINATED BY ','
	LINES 
		TERMINATED BY '\n'
	IGNORE 1 LINES;


DROP TABLE IF EXISTS players_info;
CREATE TABLE IF NOT EXISTS players_info (
	player_name VARCHAR(30) DEFAULT NULL,
    team_id VARCHAR(10) DEFAULT NULL, 
    player_id VARCHAR(10) DEFAULT NULL,
    season VARCHAR(5) DEFAULT NULL
)
ENGINE = InnoDB;

LOAD DATA
    LOCAL
	INFILE '/Users/ytan1/OneDrive/Documents/GitHub/NBAGames/data/players.csv'
	INTO TABLE players_info
	FIELDS 
		TERMINATED BY ','
	LINES 
		TERMINATED BY '\n'
	IGNORE 1 LINES;


DROP TABLE IF EXISTS ranking_info;
CREATE TABLE IF NOT EXISTS ranking_info (
	team_id VARCHAR(10) DEFAULT NULL, 
    league_id VARCHAR(3) DEFAULT NULL,
    season_id VARCHAR(5) DEFAULT NULL,
    standingsdate DATE DEFAULT NULL,
    conference VARCHAR(10) DEFAULT NULL,
    team VARCHAR(20) DEFAULT NULL,
    g VARCHAR(3) DEFAULT NULL,
    w VARCHAR(3) DEFAULT NULL,
    l VARCHAR(3) DEFAULT NULL,
    w_pct DECIMAL(4,3) DEFAULT NULL,
    home_record VARCHAR(5) DEFAULT NULL,
    road_record VARCHAR(5) DEFAULT NULL
)
ENGINE = InnoDB;

LOAD DATA
    LOCAL
	INFILE '/Users/ytan1/OneDrive/Documents/GitHub/NBAGames/data/ranking.csv'
	INTO TABLE ranking_info
	FIELDS 
		TERMINATED BY ','
	LINES 
		TERMINATED BY '\n'
	IGNORE 1 LINES;
