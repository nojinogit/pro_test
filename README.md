# 飲食店予約システム・PRO 入会テスト

予約システム『Rese』
<img width="1882" alt="Rese index" src="https://github.com/nojinogit/web-second/assets/127584258/9409a87d-d71e-406b-849f-ec3294d9b5d2">

#作成の目的  
外部の飲食店予約サービスは手数料を取られるので自社で予約サービスを持ちたい。

#機能一覧  
飲食店一覧ページ表示  
飲食店詳細ページ表示  
会員登録ページ表示  
会員登録  
ログイン  
ログアウト  
飲食店一覧検索  
飲食店一覧並べ替え  
会員登録御礼  
予約御礼  
代表店舗当日予約状況確認  
ユーザー予約・お気に入り表示  
おすすめコース事前決済ページ表示  
飲食店予約情報追加  
飲食店予約情報削除  
飲食店予約情報変更  
飲食店お気に入り追加  
飲食店お気に入り削除  
レビュー記入処理  
レビュー削除処理  
おすすめコース事前決済ページ表示  
おすすめコース事前決済処理  
マネジメントページ表示  
店舗更新ページ表示処理  
予約状況表示処理  
店舗情報作成処理  
店舗情報更新処理  
予約情報メール送信処理  
アカウント管理ページ表示  
アカウント検索処理  
アカウント削除処理  
店舗代表者登録処理  
店舗代表者削除処理  
店舗代表者検索処理  
口コミ投稿機能  
CSV インポートによる飲食店情報取り込み機能

#使用技術  
Laravel Framework 10.14.1/
php:8.2.4/
node:16.20.1/
npm:8.19.4/
mysql:8.0.26/
phpmyadmin/
mailpit/
jquery:3.4.1/

#テーブル設計  
<img width="920" alt="テーブル仕様書" src="https://github.com/nojinogit/pro_test/assets/127584258/d765e0b9-47fd-4956-93c8-7443c644a893">

#ER 図  
<img width="490" alt="ER図" src="https://github.com/nojinogit/pro_test/assets/127584258/41be7bc5-2691-4fca-8ded-84f0a5ea4e37">

#環境構築  
・プロジェクトをコピーしたいディレクトリにて「git clone git@github.com:nojinogit/pro_test.git」を行いプロジェクトをコピー  
・「cd web-2-1/src」を行い.env.example のあるディレクトリに移動  
・.env.example をコピーし.env を作成  
・.env の　 DB_DATABASE=laravel_db DB_USERNAME=laravel_user DB_PASSWORD=laravel_pass を記載  
・docker-compose.yml の存在するディレクトリにて「docker-compose up -d --build」  
・php コンテナに入る「docker-compose exec php bash」  
・コンポーザのアップデート「composer update」  
・APP_KEY の作成「php artisan key:generate」  
・テーブルの作成「php artisan migrate」もしくは「php artisan migrate:fresh」※私の環境では「fresh」をつけないと git hub からクローンしたプロジェクトではテーブルを作成できませんでした  
・店舗データ・マスターユーザ・店舗ユーザ・一般ユーザの作成「php artisan db:seed」  
・シンボリックリンク作成「php artisan storage:link」  
・php コンテナから「exit」し node コンテナに入る「docker-compose exec node bash」  
・npm インストール「npm install && npm run build」  
・権限のエラーが出た場合は「sudo chmod -R 777 src」にて権限解除してください  
以上でアプリ使用可能です「localhost/」にて店舗検索ページ開きます。  
管理者ユーザメールアドレス『admin@admin』パスワード『123456789』でログイン可能です。  
店舗ユーザメールアドレス『aaa@aaa』パスワード『123456789』でログイン可能です。  
一般ユーザメールアドレス 3 アカウント『bbb@bbb,ccc@ccc,ddd@ddd』パスワード『123456789』でログイン可能です。  
パスワードリセットメール・認証メール・お知らせメールは Mailpit「localhost:8025/」 に届きます。

##備考  
決済システム stripe にはアカウント作成後にテスト環境の公開キー・シークレットキーを.env ファイルの STRIPE_PUBLIC_KEY=　 STRIPE_SECRET_KEY=　に下さい。  
スケジューラーのテストはコンテナにて『php artisan schedule:work』を行ってください。  
マネジメント画面から送信できるお知らせメールと当日 AM8:00 に届くお知らせメールは同じ内容です  
予約時間の 1 時間後になるとレビュー箇所が店舗詳細にでてきますので、すぐに表示したい場合は phpmyadmin「localhost:8080/」から予約時間を作成/変更し、コンテナにて『php artisan schedule:work』を動かしてテストしてください。  
github のファイルではローカルで環境が完結した方がよいと考え、画像ファイルは storage/app/public/　の各フォルダ（sample,kutikomi_photo,shop_photo）に保存されます。  
店舗代表者を設定すると代表者のマイページに QR コードが表示され、当日の予約一覧にリンクします。  
口コミ投稿・更新可能なのは一般ユーザのみです。管理者ユーザは全口コミの削除をすることができます。

##csv インポート機能について  
<img width="804" alt="csvファイル" src="https://github.com/nojinogit/pro_test/assets/127584258/7fa7fd9c-0b9c-40ed-9ff9-81246868a073">  
・CSV データ作成について  
1 行目に、name/area/category/overview/url と記入。  
2 行目より店舗のデータを記入します。全ての項目は入力必須となります。  
name=店舗名です。店舗名は 50 文字以内となっており、既存の店舗名と同名のものは登録できません。  
area=都道府県です。現在登録ができる都道府県は「東京都」「大阪府」「福岡県」のいずれかとなっています。  
category=飲食店ジャンルです。現在登録ができるジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかとなっています。  
overview=店舗概要です。400 字以内となります。  
url=店舗画像 URL です。店舗画像の URL を記入してください（アップロードしたい web の画像にて右クリック → 画像アドレスをコピーにて URL が取得できます）。画像種類は jpg.jpeg.png のみアップロード可能となっております。  
文字コードについて、CSV ファイルの文字コードは「ANSI」または「UTF-8」のいずれかにして下さい。（「ANSI」「UTF-8」にて取り込み成功確認しました）文字コード変更する場合は csv ファイルをメモ帳で開き、名前を付けて保存からエンコードにて変更・保存できます。（windows11 環境にて確認）

・インポート機能について  
インポート機能は管理者ユーザログインを行い、マネジメント画面の一番下にあります。  
ファイル選択からファイルを選び、送信をクリックしてください。  
成功の場合は「〇〇件追加しました」とメッセージが表示されます。  
登録内容に不備がある場合はエラーメッセージが表示されます。
