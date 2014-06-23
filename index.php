<?php
/**
 * Index page
 *
 * @category SPIKE
 * @package  SPIKE
 * @author   Yuki Matsukura <yuki_matsukura@metaps.com>
 * @license  GPL3  http://opensource.org/licenses/gpl-3.0.html
 * @link     https://github.com/metaps/spike-checkout-demo
 */
?><!doctype html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>SPIKE Checkout demo program</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  </head>
  <body>


  <h1>SPIKE Checkout demo</h1>

<?php
if ($_SERVER['HTTP_X_FORWARDED_PROTO'] != 'https') {
    print sprintf('<p style="color: red;">WARNING:<strong>USE <a href="%s">HTTPS</a> to send secret key securely.</strong></p>', 'https://'.$_SERVER['HTTP_HOST']);
}
?>


  <form action="save_keys.php" method="post">

    <dl>
      <dt>Secret key</dt>
      <dd><input type="text" name="secret_key" value="<?php print $_SESSION['secret_key'] ?>" size="50" placeholder="Paste your key"></dd>
      <dt>Publishable key</dt>
      <dd><input type="text" name="publishable_key" value="<?php print $_SESSION['publishable_key'] ?>" size="50" placeholder="Paste your key"></dd>
    </dl>

    <input type="submit" value="Show SPIKE Checkout page">

  </form>

  <hr>
  <footer>
    version:1.0.0
  </footer>

  </body>
</html>


