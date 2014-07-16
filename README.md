SPIKE Checkoutデモサイト
====


オンラインデモ
----
- 以下のURLへアクセスして、ディベロッパーダッシュボードから取得したキーを入力してください。
  - https://spike-checkout-demo.herokuapp.com/


ローカルホストでデモを動かす
----

自分のMacで動かしてみる場合。

```
% git clone git@github.com:metaps/spike-checkout-demo.git
% cd spike-checkout-demo
% curl -sS https://getcomposer.org/installer | php
% php composer.phar install
% php -S localhost:8000 -c .user.ini
```


- ブラウザで以下のURLを開きます
  - http://localhost:8000/


Webhook の機能を動かす場合は redis が必要です。redis を用意して接続用の環境変数をセットしてください。

```
% export REDISCLOUD_URL="http://user:password@hostname:port"
```


ソースコード
----

- 以下からダウンロード出来ます。
  - https://github.com/metaps/spike-checkout


- [index.php](index.php)
 - トップページ
- [save_keys.php](save_keys.php)
  - トップページで入力したキーをプログラム内で利用するためにセッション変数に保存する
- [payment_form.php](payment_form.php)
  - SPIKE Checkoutを呼び出すページ
  - マーチャントサイトでは受注完了ページの直前に当たる
- [payment_finish.php](payment_finish.php)
  - REST APIでSPIKEへchargeメソッドを呼び出して課金を行う
  - マーチャントサイトでは決済完了ページに当たる
- [webhook_endpoint.php](webhook_endpoint.php)
  - Webhook のURLとして利用可能なエンドポイント
  - リクエストの内容をkey-valueストアに保存する(保存期間は30分)
- [webhook_preview.php](webhook_preview.php)
  - webhook_endpoint.php での保存内容の確認ページ


デプロイ
----
[![Codeship Status for metaps/spike-checkout-demo](https://www.codeship.io/projects/484a93f0-da5b-0131-45a4-6ae09c7da1e0/status)](https://www.codeship.io/projects/24311)

- githubからCodeShip経由でherokuへリリースされます。

