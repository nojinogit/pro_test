# web-2-1

予約システム『Rese』
<<img width="1882" alt="Rese index" src="https://github.com/nojinogit/web-second/assets/127584258/9409a87d-d71e-406b-849f-ec3294d9b5d2">>

#作成の目的  
外部の飲食店予約サービスは手数料を取られるので自社で予約サービスを持ちたい。

#アプリケーション URL  
検索ページ‥http://13.114.114.137/  
メールアドレス「admin@admin」パスワード「123456789」で管理者ログインできます。  
Mailpit‥メールテストページ　http://13.114.114.137:8025/  
phpMyAdmin‥データベース確認ページ　http://13.114.114.137:8080/

#機能一覧  
飲食店一覧ページ表示  
飲食店詳細ページ表示  
会員登録ページ表示  
会員登録  
ログイン  
ログアウト  
飲食店一覧検索  
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
<img width="1083" alt="テーブル仕様書" src="https://github.com/nojinogit/web-second/assets/127584258/ef431b2a-bbc8-4586-8e1b-dd329cd234b7">

#ER 図  
<img width="624" alt="rese-ER" src="https://github.com/nojinogit/web-second/assets/127584258/4d2975c8-13dd-4688-8736-1776acdf2202">

#環境構築  
・プロジェクトをコピーしたいディレクトリにて「git clone https://github.com/nojinogit/web-2-1.git」を行いプロジェクトをコピー  
・「cd web-2-1/src」を行い.env.example のあるディレクトリに移動  
・.env.example をコピーし.env を作成  
・.env の　 DB_DATABASE=laravel_db DB_USERNAME=laravel_user DB_PASSWORD=laravel_pass を記載  
・docker-compose.yml の存在するディレクトリにて「docker-compose up -d --build」  
・php コンテナに入る「docker-compose exec php bash」  
・コンポーザのアップデート「composer update」  
・APP_KEY の作成「php artisan key:generate」  
・テーブルの作成「php artisan migrate」もしくは「php artisan migrate:fresh」※私の環境では「fresh」をつけないと git hub からクローンしたプロジェクトではテーブルを作成できませんでした  
・店舗データ・マスターユーザの作成「php artisan db:seed」  
・シンボリックリンク作成「php artisan storage:link」  
・php コンテナから「exit」し node コンテナに入る「docker-compose exec node bash」  
・npm インストール「npm install && npm run build」  
・権限のエラーが出た場合は「sudo chmod -R 777 src」にて権限解除してください  
以上でアプリ使用可能です「localhost/」にて店舗検索ページ開きます。  
管理者ユーザ『admin@admin』がいますのでパスワードリセットからパスワード再設定をお願いします。  
パスワードリセットメール等は Mailpit「localhost:8025/」 に届いています。

##備考  
決済システム stripe にはアカウント作成後にテスト環境の公開キー・シークレットキーを.env ファイルの STRIPE_PUBLIC_KEY=　 STRIPE_SECRET_KEY=　に下さい。  
スケジューラーのテストは『php artisan schedule:work』にて行ってください。  
マネジメント画面から送信できるお知らせメールと当日 AM8:00 に届くお知らせメールは同じ内容です  
予約時間の 1 時間後になるとレビュー箇所が店舗詳細にでてきますので、phpmyadmin「localhost:8080/」から当日予約を作成し、スケジューラーを動かしてテストしてください。  
github のファイルではローカルで環境が完結した方がよいと考え、画像ファイルは storage/app/public/sample に保存されます。デプロイしたアプリでは s3 に保存されるコードにしてあります。
