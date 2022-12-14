-- Project Name : t_users
-- Date/Time    : 2023/01/10 22:16:01
-- Author       : twatanabe
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- 管理者
CREATE TABLE t_users.administrators (
  id INT NOT NULL AUTO_INCREMENT
  , email VARCHAR(255) NOT NULL
  , admins_name VARCHAR(255) NOT NULL
  , salt VARCHAR(100) NOT NULL
  , password VARCHAR(255) NOT NULL
  , reset_token VARCHAR(255) NOT NULL
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT administrators_PKC PRIMARY KEY (id)
) ;

-- 試合出場選手
CREATE TABLE t_baseball.game_players (
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
CREATE TABLE t_baseball.position_mst (
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
CREATE TABLE t_baseball.stadiums (
  id INT NOT NULL AUTO_INCREMENT
  , team_id INT NOT NULL
  , stadium_name VARCHAR(50) NOT NULL
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT stadiums_PKC PRIMARY KEY (id)
) ;

-- チームメンバ
CREATE TABLE t_baseball.team_members (
  id BIGINT NOT NULL AUTO_INCREMENT
  , team_id INT NOT NULL
  , user_id INT NOT NULL
  , role INT DEFAULT 4
  , number INT
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT team_members_PKC PRIMARY KEY (id)
) ;

-- チーム役割マスタ
CREATE TABLE t_baseball.team_role_mst (
  id INT NOT NULL AUTO_INCREMENT
  , label VARCHAR(20) NOT NULL
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT team_role_mst_PKC PRIMARY KEY (id)
) ;

-- 仮ユーザ
CREATE TABLE t_users.temp_users (
  id INT NOT NULL AUTO_INCREMENT
  , email VARCHAR(255) NOT NULL
  , token VARCHAR(255) NOT NULL
  , expiration_date DATETIME NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT temp_users_PKC PRIMARY KEY (id)
) ;

-- ユーザ
CREATE TABLE t_users.users (
  id INT NOT NULL AUTO_INCREMENT
  , name1 VARCHAR(20) NOT NULL
  , name2 VARCHAR(20) NOT NULL
  , ruby1 VARCHAR(20) NOT NULL
  , ruby2 VARCHAR(20) NOT NULL
  , birthday DATE NOT NULL
  , email VARCHAR(255) NOT NULL
  , password VARCHAR(255) NOT NULL
  , invitation_code VARCHAR(255)
  , reset_token VARCHAR(255)
  , expiration_date DATETIME NOT NULL
  , is_enabled INT DEFAULT 0 NOT NULL
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP
  , CONSTRAINT users_PKC PRIMARY KEY (id)
) ;

-- 試合
CREATE TABLE t_baseball.games (
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
CREATE TABLE t_baseball.opponent_teams (
  id INT NOT NULL AUTO_INCREMENT
  , team_id INT NOT NULL
  , team_name VARCHAR(50) NOT NULL
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT opponent_teams_PKC PRIMARY KEY (id)
) ;

-- 大会
CREATE TABLE t_baseball.tournaments (
  id INT NOT NULL AUTO_INCREMENT
  , tournament_name VARCHAR(50) NOT NULL
  , team_id INT NOT NULL
  , year YEAR NOT NULL
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT tournaments_PKC PRIMARY KEY (id)
) ;

-- 試合招待
CREATE TABLE t_baseball.consent_games (
  id INT NOT NULL AUTO_INCREMENT
  , invitee_id INT NOT NULL
  , guest_id INT NOT NULL
  , consent_status_id INT NOT NULL
  , possible_date DATE NOT NULL
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT consent_games_PKC PRIMARY KEY (id)
) ;

-- 招待ステータスマスタ
CREATE TABLE t_baseball.consent_status_mst (
  id INT NOT NULL AUTO_INCREMENT
  , label VARCHAR(10) NOT NULL
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT consent_status_mst_PKC PRIMARY KEY (id)
) ;

-- チーム
CREATE TABLE t_baseball.teams (
  id INT NOT NULL AUTO_INCREMENT
  , team_name VARCHAR(255) NOT NULL
  , invitation_code VARCHAR(255) NOT NULL
  , team_address_id BIGINT NOT NULL
  , sport_affiliation_mst_id INT NOT NULL
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT teams_PKC PRIMARY KEY (id)
) ;

-- スポーツ種類
CREATE TABLE t_baseball.sport_affiliation_mst (
  id INT NOT NULL AUTO_INCREMENT
  , name VARCHAR(255) NOT NULL
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT sport_affiliation_mst_PKC PRIMARY KEY (id)
) ;

-- チーム住所
CREATE TABLE t_baseball.team_addresses (
  id BIGINT NOT NULL AUTO_INCREMENT
  , prefecture INT NOT NULL
  , address VARCHAR(255) NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT team_addresses_PKC PRIMARY KEY (id)
) ;

ALTER TABLE t_baseball.consent_games
  ADD CONSTRAINT consent_games_FK1 FOREIGN KEY (guest_id) REFERENCES t_baseball.teams(id)
  on delete cascade
  on update cascade;

ALTER TABLE t_baseball.consent_games
  ADD CONSTRAINT consent_games_FK2 FOREIGN KEY (invitee_id) REFERENCES t_baseball.teams(id)
  on delete cascade
  on update cascade;

ALTER TABLE t_baseball.consent_games
  ADD CONSTRAINT consent_games_FK3 FOREIGN KEY (consent_status_id) REFERENCES t_baseball.consent_status_mst(id)
  on delete cascade
  on update cascade;

ALTER TABLE t_baseball.game_players
  ADD CONSTRAINT game_players_FK1 FOREIGN KEY (position_mst_id) REFERENCES t_baseball.position_mst(id)
  on delete cascade
  on update cascade;

ALTER TABLE t_baseball.game_players
  ADD CONSTRAINT game_players_FK2 FOREIGN KEY (game_id) REFERENCES t_baseball.games(id)
  on delete cascade
  on update cascade;

ALTER TABLE t_baseball.games
  ADD CONSTRAINT games_FK1 FOREIGN KEY (opponent_team_id) REFERENCES t_baseball.opponent_teams(id)
  on delete cascade
  on update cascade;

ALTER TABLE t_baseball.games
  ADD CONSTRAINT games_FK2 FOREIGN KEY (tournament_id) REFERENCES t_baseball.tournaments(id)
  on delete cascade
  on update cascade;

ALTER TABLE t_baseball.games
  ADD CONSTRAINT games_FK3 FOREIGN KEY (consent_game_id) REFERENCES t_baseball.consent_games(id)
  on delete cascade
  on update cascade;

ALTER TABLE t_baseball.team_members
  ADD CONSTRAINT team_members_FK1 FOREIGN KEY (user_id) REFERENCES t_users.users(id)
  on delete cascade
  on update cascade;

ALTER TABLE t_baseball.team_members
  ADD CONSTRAINT team_members_FK2 FOREIGN KEY (role) REFERENCES t_baseball.team_role_mst(id)
  on delete cascade
  on update cascade;

ALTER TABLE t_baseball.team_members
  ADD CONSTRAINT team_members_FK3 FOREIGN KEY (team_id) REFERENCES t_baseball.teams(id)
  on delete cascade
  on update cascade;

ALTER TABLE t_baseball.teams
  ADD CONSTRAINT teams_FK1 FOREIGN KEY (sport_affiliation_mst_id) REFERENCES t_baseball.sport_affiliation_mst(id)
  on delete cascade
  on update cascade;

ALTER TABLE t_baseball.teams
  ADD CONSTRAINT teams_FK2 FOREIGN KEY (team_address_id) REFERENCES t_baseball.team_addresses(id)
  on delete cascade
  on update cascade;

