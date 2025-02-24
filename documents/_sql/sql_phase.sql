-- Project Name : t_users
-- Date/Time    : 2023/02/14 7:48:48
-- Author       : twatanabe
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- 返信
CREATE TABLE replies (
  id BIGINT NOT NULL AUTO_INCREMENT
  , consent_game_id BIGINT NOT NULL
  , team_id INT NOT NULL
  , message TEXT NOT NULL
  , created_at DATETIME NOT NULL
  , updated_at DATETIME NOT NULL
  , CONSTRAINT replies_PKC PRIMARY KEY (id)
) ;


-- チームメンバ
CREATE TABLE team_members (
  id BIGINT NOT NULL AUTO_INCREMENT
  , team_id INT NOT NULL
  , user_id INT NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT team_members_PKC PRIMARY KEY (id)
) ;

-- 管理者
CREATE TABLE administrators (
  id INT NOT NULL AUTO_INCREMENT
  , email VARCHAR(255) NOT NULL
  , name VARCHAR(255) NOT NULL
  , password VARCHAR(255) NOT NULL
  , reset_token VARCHAR(255) NOT NULL
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT administrators_PKC PRIMARY KEY (id)
) ;

-- 仮ユーザ
CREATE TABLE temp_users (
  id INT NOT NULL AUTO_INCREMENT
  , name VARCHAR(20) NOT NULL
  , email VARCHAR(255) NOT NULL
  , password VARCHAR(255) NOT NULL
  , token VARCHAR(255) NOT NULL
  , expiration_date DATETIME NOT NULL
  , sport_affiliation_type INT
  , team_name VARCHAR(255)
  , image_path VARCHAR(255)
  , image_extension VARCHAR(255)
  , team_url VARCHAR(255)
  , prefecture_code INT
  , address VARCHAR(255)
  , invitation_code VARCHAR(255)
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT temp_users_PKC PRIMARY KEY (id)
) ;

-- ユーザ
CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT
  , name VARCHAR(20) NOT NULL
  , email VARCHAR(255)
  , password VARCHAR(255)
  , google_login_id VARCHAR(255)
  , line_login_id VARCHAR(255)
  , last_login_time DATETIME NOT NULL
  , remember_token VARCHAR(255)
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP
  , CONSTRAINT users_PKC PRIMARY KEY (id)
) ;


-- 試合招待
CREATE TABLE consent_games (
  id BIGINT NOT NULL AUTO_INCREMENT
  , invitee_id INT NOT NULL
  , guest_id INT NOT NULL
  , consent_status INT NOT NULL
  , game_date DATETIME
  , first_preferered_date DATETIME NOT NULL
  , second_preferered_date DATETIME NOT NULL
  , third_preferered_date DATETIME
  , message TEXT
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT consent_games_PKC PRIMARY KEY (id)
) ;

-- チーム
CREATE TABLE teams (
  id INT NOT NULL AUTO_INCREMENT
  , team_name VARCHAR(255) NOT NULL
  , sport_affiliation_type INT NOT NULL
  , invitation_code VARCHAR(255) NOT NULL
  , prefecture_code INT NOT NULL
  , address VARCHAR(255)
  , team_url VARCHAR(255)
  , image_path VARCHAR(255) NOT NULL
  , image_extension VARCHAR(255) NOT NULL
  , is_deleted INT DEFAULT 0 NOT NULL
  , created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
  , updated_at DATETIME DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP NOT NULL
  , CONSTRAINT teams_PKC PRIMARY KEY (id)
) ;

ALTER TABLE consent_games
  ADD CONSTRAINT consent_games_FK1 FOREIGN KEY (guest_id) REFERENCES teams(id)
  on delete cascade
  on update cascade;

ALTER TABLE consent_games
  ADD CONSTRAINT consent_games_FK2 FOREIGN KEY (invitee_id) REFERENCES teams(id)
  on delete cascade
  on update cascade;

ALTER TABLE replies
  ADD CONSTRAINT replies_FK1 FOREIGN KEY (consent_game_id) REFERENCES consent_games(id)
  ADD CONSTRAINT replies_FK2 FOREIGN KEY (team_id) REFERENCES teams(id)
  on delete cascade
  on update cascade;

ALTER TABLE team_members
  ADD CONSTRAINT team_members_FK1 FOREIGN KEY (user_id) REFERENCES users(id)
  on delete cascade
  on update cascade;

ALTER TABLE team_members
  ADD CONSTRAINT team_members_FK2 FOREIGN KEY (team_id) REFERENCES teams(id)
  on delete cascade
  on update cascade;

