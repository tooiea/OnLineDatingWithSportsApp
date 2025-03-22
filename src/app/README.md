## チーム作成 (仮登録)
/temp_register/team
/temp_register/team/back
/temp_register/team/confirm
/temp_register/team/complete

## チーム入会 (仮登録)
/temp_register/team/join/{invitation_code}
/temp_register/team/join/{invitation_code}/back
/temp_register/team/join/{invitation_code}/confirm
/temp_register/team/join/{invitation_code}/complete

## チーム作成 (本登録)
/register/{token}

## ログイン
/login
/login/sns/google
/login/sns/google/callback
/login/sns/line
/login/sns/line/callback

## マイチーム
/myteam
/myteam/profile # マイチームプロフィール
/myteam/edit # マイチーム編集
/myteam/detail # マイチーム詳細
/myteam/games # マイチーム試合一覧 (未実装)
/myteam/games/{game_id} # マイチーム試合詳細 (未実装)

## マイチーム試合
/myteam/consent_games/{consent_game_id} # マイチーム試合詳細
/myteam/consent_games/{consent_game_id}/reply # マイチーム試合招待返信 (未返信)
/myteam/consent_games/{consent_game_id}/reply/back
/myteam/consent_games/{consent_game_id}/reply/confirm
/myteam/consent_games/{consent_game_id}/reply/complete  # 返信完了

## 別チーム
/teams  # チーム一覧
/teams/{team_id}    # チーム詳細
/teams/{team_id}/invite_game    # 試合の招待
/teams/{team_id}/invite_game/back
/teams/{team_id}/invite_game/confirm
/teams/{team_id}/invite_game/complete   # 招待完了

## ユーザ
/forgot-password    # パスワードリセット
/reset-password/{token}  # パスワードリセット
/reset-password/    # パスワードリセット