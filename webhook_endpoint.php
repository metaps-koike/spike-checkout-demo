<?php
/**
 * Webhook endpoint
 *
 * @category SPIKE
 * @package  SPIKE
 * @author   Noboru Koike <noboru_koike@metaps.com>
 * @license  GPL3  http://opensource.org/licenses/gpl-3.0.html
 * @link     https://github.com/metaps/spike-checkout-demo
 */

$p = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
if (empty($p)) {
    header('HTTP/1.0 400 Bad Request');
    print 'webhook_demo_key is not specified.';
    exit;
}
parse_str($p, $q);
if (empty($q['webhook_demo_key'])) {
    header('HTTP/1.0 400 Bad Request');
    print 'webhook_demo_key is not specified.';
    exit;
}


require 'vendor/autoload.php';
$r = new Predis\Client(array(
    'host' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_HOST),
    'port' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_PORT),
    'password' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_PASS),
));
$k = 'webhook:' . $q['webhook_demo_key'];

$v = $r->get($k);
$d = unserialize($v);

if (empty($d['secret_key'])) {
    header('HTTP/1.0 400 Bad Request');
    print 'webhook prepare is missing.';
    exit;
}


$f = file_get_contents('php://input');
$j = urldecode($f);


// signature check
$s = base64_encode(hash_hmac('sha256', json_decode($j), $d['secret_key'], true));
if ($s != $_SERVER['HTTP_X_SPIKE_WEBHOOKS_SIGNATURE']) {
    header('HTTP/1.0 400 Bad Request');
    print 'signature is invalid.';
    exit;
}


$d['body'] = $j;
$r->setex($k, 60 * 30, serialize($d));


header('HTTP/1.0 200 OK');
print('OK');
