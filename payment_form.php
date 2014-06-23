<?php
/**
 * SPIKE Checkout page
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
    <title>SPIKE Checkout demo program (1/2)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  </head>
  <body>

  <form action="payment_finish.php" method="post">
    <input id="token" type="hidden" name="token" value="">
    <button id="customButton">Purchase</button>
  </form>


<script src="https://checkout.spike.cc/v1/checkout.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
var handler = SpikeCheckout.configure({
  key: "<?php print htmlspecialchars(addslashes($_SESSION['publishable_key'])); ?>",
  token: function(token, args) {
    $("#customButton").attr('disabled', 'disabled');
    $(':input[type="hidden"][name="token"]').val(token.id);
    $('form').submit();
  },
  opened: function(e) {
    console.debug("Event: Overlay opened.");
  },
  closed: function(e) {
    console.debug("Event: Overlay closed.");
  }
});


$("#customButton").click(function(e) {
    handler.open({
      name: "My Shop",
      amount: 900,
      currency: "JPY",
      email: "foo@example.com"
    });
  e.preventDefault();
});
</script>



  </body>
</html>


