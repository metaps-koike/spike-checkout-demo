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
?><!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="ja">
  <head>
    <meta charset="utf-8">
    <title>SPIKE Checkout demo webhook</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.3.1/css/normalize.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/foundation/5.3.1/css/foundation.min.css">
    <script src="//cdn.jsdelivr.net/foundation/5.3.1/js/vendor/modernizr.js"></script>
  </head>
  <body>

  <h1>SPIKE Checkout demo webhook</h1>

<?php
if (empty($_SESSION['secret_key'])) {
?>

    <div class="row">
      <div class="alert-box alert radius">Please set API keys.</div>
      <a href="index.php" class="button">Back to TOP</a>
    </div>

<?php
} else {
    $demoKey = hash('sha256', session_id());
    $url = "https://spike-checkout-demo.herokuapp.com/webhook_endpoint.php?webhook_demo_key=$demoKey";
    $_SESSION['webhook_demo_key'] = $demoKey;

    require 'vendor/autoload.php';
    $redis = new Predis\Client(array(
        'host' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_HOST),
        'port' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_PORT),
        'password' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_PASS),
    ));
    $storeKey = "webhook:$demoKey";
    $value = $redis->get($storeKey);
    if (empty($value)) {
        $data = array('secret_key' => $_SESSION['secret_key']);
        $redis->setex($storeKey, 60 * 30, serialize($data));
    }
?>

    <?php if (empty($value)) { ?>
    <div class="row">
      <div class="alert-box success radius">New endpoint URL successfully created.</div>
    </div>
    <?php } ?>

    <div class="row">
      <dl>
        <dt>Your endpoint</dt>
        <dd><textarea rows="4" onclick="$(this).select()" readonly="readonly"><?php print $url ?></textarea></dd>
      </dl>
    </div>

    <div class="row">
      <p>Please set your endpoint on SPIKE Developer Dashboard.</p>
      <a href="https://spike.cc/dashboard/developer/webhook/urls" target="_blank" class="button">SPIKE</a>
    </div>

    <div class="row">
      <p>After sending webhook requests, you can preview them.</p>
      <a href="webhook_preview.php" class="button">Preview</a>
    </div>

<?php
}
?>


  <script src="//cdn.jsdelivr.net/foundation/5.3.1/js/vendor/jquery.js"></script>
  <script src="//cdn.jsdelivr.net/foundation/5.3.1/js/foundation.min.js"></script>
  <script>
    $(document).foundation();
  </script>

  </body>
</html>
