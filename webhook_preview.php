<?php
/**
 * Webhook preview
 *
 * @category SPIKE
 * @package  SPIKE
 * @author   Noboru Koike <noboru_koike@metaps.com>
 * @license  GPL3  http://opensource.org/licenses/gpl-3.0.html
 * @link     https://github.com/metaps/spike-checkout-demo
 */

if (empty($_SESSION['webhook_demo_key'])) {
    print 'webhook_demo_key is not specified.';
    exit;
}


require 'vendor/autoload.php';
$r = new Predis\Client(array(
    'host' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_HOST),
    'port' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_PORT),
    'password' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_PASS),
));
$k = 'webhook:' . $_SESSION['webhook_demo_key'];

$v = $r->get($k);
$d = unserialize($v);
if (empty($d['body'])) {
    print 'data is empty.';
    exit;
}

header('Content-Type:text/plain');
print_r(json_decode($d['body']));
