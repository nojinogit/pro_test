# web-second

予約システム『Rese』
<<img width="1882" alt="Rese index" src="https://github.com/nojinogit/web-second/assets/127584258/9409a87d-d71e-406b-849f-ec3294d9b5d2">>

#作成の目的  
外部の飲食店予約サービスは手数料を取られるので自社で予約サービスを持ちたい。

#アプリケーション URL  
デプロイはまだできていません

#機能一覧  
ユーザー新規登録ページ表示  
ユーザー新規登録処理  
ユーザーログイン処理  
ユーザーログアウト処理  
打刻ページ表示処理  
日付別勤怠ページ表示処理  
日付別勤怠表示処理  
勤務時間開始登録処理  
勤務時間終了登録処理  
休憩時間開始登録処理  
休憩時間終了登録処理  
ユーザー別勤怠ページ表示処理  
ユーザー別勤怠検索処理  
ユーザー一覧ページ表示処理  
ユーザー検索処理  
パスワードリセットメール送信処理  
パスワードリセット処理

#使用技術  
laravel sail/
Laravel Framework 10.13.1/
php:8.2.6/
node:18.16.0/
npm:9.6.7/
mysql:8.0.32/
phpmyadmin:/
mailpit/
jquery:3.4.1/

#テーブル設計  
<img width="1083" alt="テーブル仕様書" src="https://github.com/nojinogit/web-second/assets/127584258/ef431b2a-bbc8-4586-8e1b-dd329cd234b7">

#ER 図  
<img width="624" alt="rese-ER" src="https://github.com/nojinogit/web-second/assets/127584258/4d2975c8-13dd-4688-8736-1776acdf2202">

#環境構築  
・.env.example をコピーし.env を作成  
・composer の依存関係をインストール『docker run --rm \
 -u "$(id -u):$(id -g)" \
 -v $(pwd):/var/www/html \
 -w /var/www/html \
 laravelsail/php82-composer:latest \
 composer install --ignore-platform-reqs』  
・docker-compose.yml の存在するディレクトリにて「./vendor/bin/sail up -d」  
・コンポーザのアップデート「./vendor/bin/sail composer update」  
・APP_KEY の作成「./vendor/bin/sail artisan key:generate」  
・テーブルの作成「./vendor/bin/sail artisan migrate」もしくは「./vendor/bin/sail artisan migrate:fresh」※私の環境では「fresh」をつけないと git hub からクローンしたプロジェクトではテーブルを作成できませんでした  
・店舗データ・マスターユーザの作成「./vendor/bin/sail artisan db:seed」  
・シンボリックリンク作成「./vendor/bin/sail artisan storage:link」  
・Node.js インストール「./vendor/bin/sail npm install && ./vendor/bin/sail npm run build」  
以上でアプリ使用可能です「localhost/」にて店舗検索ページ開きます。  
管理者ユーザがいますので『admin@admin』でパスワードリセットかけてパスワード再設定をお願いします。  
メールは Mailpit に届いています。

##備考  
決済システム stripe にはアカウント作成後にテスト環境の公開キー・シークレットキーを.env ファイルの STRIPE_PUBLIC_KEY=　 STRIPE_SECRET_KEY=　に入れてコンテナを up しなおして下さい。  
スケジューラーのテストは『./vendor/bin/sail artisan schedule:work』にて行ってください。
