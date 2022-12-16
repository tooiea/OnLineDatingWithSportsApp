#!/bin/sh

CLIENT="/tmp/client.cnf"
SQL_PATH="/tmp/sql"
DB="t_baseball"

mysql --defaults-extra-file=${CLIENT} < ${SQL_PATH}/create_database/ptp_jleague.sql

mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/player_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/team_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/purchase_status_type_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/gender_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/login_type_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/rarity_type_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/distribution_type_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/position_type_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/play_type_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/league_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/payment_method_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/admin_role_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/users.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/user_profiles.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/purchases.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/gmo_credit_purchase_details.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/gmo_line_pay_purchase_details.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/tournaments.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/teams.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/games.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/players.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/player_stats.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/team_stats.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/cards.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/card_tags.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/packs.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/albums.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/teams_users.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/packs_users.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/cards_users.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/cards_packs.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/packs_purchases.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/cards_card_tags.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/albums_cards.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/temp_users.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/teams_temp_users.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/admins.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/create_table/admin_settings.sql

mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/insert/team_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/insert/purchase_status_type_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/insert/gender_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/insert/login_type_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/insert/rarity_type_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/insert/position_type_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/insert/play_type_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/insert/league_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/insert/payment_method_mst.sql
mysql --defaults-extra-file=${CLIENT} ${DB} < ${SQL_PATH}/insert/admin_role_mst.sql
