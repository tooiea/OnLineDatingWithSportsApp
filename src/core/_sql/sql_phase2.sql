-- Project Name : t_users
-- Date/Time    : 2023/02/14 7:48:48
-- Author       : twatanabe
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- 試合出場選手
CREATE TABLE game_players (
  id BIGINT NOT NULL AUTO_INCREMENT
  , game_id BIGINT NOT NULL
  , team_id INT NOT NULL
  , team_member_id INT NOT NULL
  , position_mst_id INT
  , batting_order INT NOT NULL
  , start_inning INT NOT NULL
  , end_inning INT
  , out_count_start INT NOT NULL
  , out_count_end INT
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT game_players_PKC PRIMARY KEY (id)
) ;

-- ポジションマスタ
CREATE TABLE position_mst (
  id INT NOT NULL AUTO_INCREMENT
  , sport_affiliation_mst_id INT NOT NULL
  , position_name VARCHAR(50) NOT NULL
  , position_code VARCHAR(20) NOT NULL
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT position_mst_PKC PRIMARY KEY (id)
) ;

-- 球場
CREATE TABLE stadiums (
  id INT NOT NULL AUTO_INCREMENT
  , team_id INT NOT NULL
  , stadium_name VARCHAR(50) NOT NULL
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT stadiums_PKC PRIMARY KEY (id)
) ;

-- 試合
CREATE TABLE games (
  id BIGINT NOT NULL AUTO_INCREMENT
  , my_team_id INT NOT NULL
  , consent_game_id INT
  , opponent_team_id INT
  , result INT NOT NULL
  , start_time DATETIME NOT NULL
  , finish_time DATETIME NOT NULL
  , stadium_id INT NOT NULL
  , tournament_id INT NOT NULL
  , is_published INT NOT NULL
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT games_PKC PRIMARY KEY (id)
) ;

-- 対戦相手チーム
CREATE TABLE opponent_teams (
  id INT NOT NULL AUTO_INCREMENT
  , team_id INT NOT NULL
  , team_name VARCHAR(50) NOT NULL
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT opponent_teams_PKC PRIMARY KEY (id)
) ;

-- 大会
CREATE TABLE tournaments (
  id INT NOT NULL AUTO_INCREMENT
  , tournament_name VARCHAR(50) NOT NULL
  , team_id INT NOT NULL
  , year YEAR NOT NULL
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT tournaments_PKC PRIMARY KEY (id)
) ;

ALTER TABLE game_players
  ADD CONSTRAINT game_players_FK1 FOREIGN KEY (game_id) REFERENCES games(id)
  on delete cascade
  on update cascade;

ALTER TABLE game_players
  ADD CONSTRAINT game_players_FK2 FOREIGN KEY (position_mst_id) REFERENCES position_mst(id)
  on delete cascade
  on update cascade;

ALTER TABLE games
  ADD CONSTRAINT games_FK1 FOREIGN KEY (opponent_team_id) REFERENCES opponent_teams(id)
  on delete cascade
  on update cascade;

ALTER TABLE games
  ADD CONSTRAINT games_FK2 FOREIGN KEY (consent_game_id) REFERENCES consent_games(id)
  on delete cascade
  on update cascade;

ALTER TABLE games
  ADD CONSTRAINT games_FK3 FOREIGN KEY (tournament_id) REFERENCES tournaments(id)
  on delete cascade
  on update cascade;
