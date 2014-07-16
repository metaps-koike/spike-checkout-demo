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

if (empty($_SESSION['secret_key'])) {
    print 'secret key is not specified';
    exit;
}
if (empty($_SESSION['publishable_key'])) {
    print 'publishable key is not specified';
    exit;
}

require 'vendor/autoload.php';

$r = new Predis\Client(array(
    'host' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_HOST),
    'port' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_PORT),
    'password' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_PASS),
));

$v = $r->get($_SESSION['publishable_key']);
if (empty($v)) {
    print 'data is empty';
    exit;
}

$d = unserialize($v);

// signature check
$s = base64_encode(hash_hmac('sha256', json_decode($d['body']), $_SESSION['secret_key'], true));
if ($s != $d['signature']) {
    print 'signature is invalid';
    exit;
}

header('Content-Type:text/plain');
print_r(json_decode($d['body']));
