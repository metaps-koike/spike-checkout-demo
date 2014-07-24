SPIKE Checkoutデモ
====


オンラインデモ
----
オンラインデモではデベロッパー向けに提供しているいくつかの機能を試すことができます。以下のURLへアクセスして、ディベロッパーダッシュボードから取得したサンドボックス用のキーを入力してください。オンラインデモではセキュリティの観点からサンドボックス環境のみの利用としてください。

- https://spike-checkout-demo.herokuapp.com/

#### Checkout
SPIKE Checkoutでの決済を試すことができます。SPIKE Checkoutのオーバーレイでの入力と、REST APIを使った決済の処理を確認することができます。SPIKE Checkoutについては、[ドキュメント](https://spike.cc/dashboard/developer/docs/getting_started)（要SPIKEログイン）を参照ください。

#### Webhook
Webhookのリクエスト送信を試すことができます。テスト送信用のエンドポイントURLを提供しますので、そちらを使ってリクエストの受信と内容の確認ができます。Webhookについては、[リファレンス](https://spike.cc/dashboard/developer/docs/references)（要SPIKEログイン）を参照ください。


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


Webhook の機能を動かす場合は redis が必要です。  
redis を用意して接続用の環境変数をセットしてください。

##### redis のセットアップ
以下は [Homebrew](http://brew.sh/) でのインストール方法です。  
インストール後、redisサーバを起動してください。

```
% brew install redis
% redis-server /usr/local/etc/redis.conf
```

##### 環境変数のセット
spike-checkout-demoディレクトリで環境変数をセットして、ローカルサーバを再起動してください。

```
% cd spike-checkout-demo
% export REDISCLOUD_URL="http://:@127.0.0.1:6379"
% php -S localhost:8000 -c .user.ini
```


ソースコード
----

- 以下からダウンロード出来ます。
  - https://github.com/metaps/spike-checkout


- [index.php](index.php)
  - トップページ
- [save_keys.php](save_keys.php)
  - トップページで入力したキーをプログラム内で利用するためにセッション変数に保存する
- [menu.php](menu.php)
  - メニューページ
- [payment_form.php](payment_form.php)
  - SPIKE Checkoutを呼び出すページ
  - マーチャントサイトでは受注完了ページの直前に当たる
- [payment_finish.php](payment_finish.php)
  - REST APIでSPIKEへchargeメソッドを呼び出して課金を行う
  - マーチャントサイトでは決済完了ページに当たる
- [webhook.php](webhook.php)
  - WebhookのURLとして利用可能なエンドポイントURLを作成する(URLの有効期間は30分)
  - エンドポイントURLにて受信したリクエストの内容を表示する
- [webhook_endpoint.php](webhook_endpoint.php)
  - WebhookのURLとして利用可能なエンドポイントURL
  - リクエストの内容をkey-valueストアに保存する(保存期間は30分)


デプロイ
----
[![Codeship Status for metaps/spike-checkout-demo](https://www.codeship.io/projects/484a93f0-da5b-0131-45a4-6ae09c7da1e0/status)](https://www.codeship.io/projects/24311)

- githubからCodeShip経由でherokuへリリースされます。

