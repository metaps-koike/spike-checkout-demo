<?php
/**
 * Webhook prepare
 *
 * @category SPIKE
 * @package  SPIKE
 * @author   Noboru Koike <noboru_koike@metaps.com>
 * @license  GPL3  http://opensource.org/licenses/gpl-3.0.html
 * @link     https://github.com/metaps/spike-checkout-demo
 */
?><!doctype html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>SPIKE Checkout demo webhook (1/2)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  </head>
  <body>

  <h1>SPIKE Checkout demo webhook prepare</h1>

<?php
if (empty($_SESSION['secret_key'])) {
?>

    <p>Please set API keys. <a href="index.php">Back to TOP</a></p>

<?php
} else {
    $h = hash('sha256', session_id());
    $u = "https://spike-checkout-demo.herokuapp.com/webhook_endpoint.php?webhook_demo_key=$h";
    $_SESSION['webhook_demo_key'] = $h;

    require 'vendor/autoload.php';
    $r = new Predis\Client(array(
        'host' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_HOST),
        'port' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_PORT),
        'password' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_PASS),
    ));
    $k = "webhook:$h";
    $d = array('secret_key' => $_SESSION['secret_key']);
    $r->setex($k, 60 * 30, serialize($d));
?>

    <p>Your endpoint: <a href="<?php print $u ?>" target="_blank"><?php print $u; ?></a></p>
    <p>Please set your endpoint on <a href="https://spike.cc/dashboard/developer/webhook/urls" target="_blank">SPIKE Developer Dashboard</a>.</p>
    <p>After sending webhook requests, you can preview them on <a href="webhook_preview.php" target="_blank">this page</a>.</p>

<?php
}
?>


  </body>
</html>
