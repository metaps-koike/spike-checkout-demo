<?php
/**
 * Menu page
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
    <title>SPIKE Checkout demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  </head>
  <body>


  <h1>SPIKE Checkout demo</h1>

<?php
if ($_SERVER['HTTP_X_FORWARDED_PROTO'] != 'https') {
    print sprintf('<p style="color: red;">WARNING:<strong>USE <a href="%s">HTTPS</a> to send secret key securely.</strong></p>', 'https://'.$_SERVER['HTTP_HOST']);
}
?>

<?php
if (empty($_SESSION['secret_key']) || empty($_SESSION['publishable_key'])) {
?>

    <a href="index.php">Back to TOP</a>

<?php
} else {
?>

    <h3>Checkout</h3>
    <ul>
      <li><a href="payment_form.php">Demo program</a></li>
    </ul>

    <h3>Webhook</h3>
    <ul>
      <li><a href="webhook_preview.php">Request preview</a></li>
    </ul>

<?php
}
?>


  </body>
</html>
