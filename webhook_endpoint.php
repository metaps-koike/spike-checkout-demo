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
    print 'query string is not found.';
    exit;
}

parse_str($p, $q);
if (empty($q['publishable_key'])) {
    header('HTTP/1.0 400 Bad Request');
    print 'publishable_key is not found.';
    exit;
}

require 'vendor/autoload.php';

$f = file_get_contents('php://input');
$j = urldecode($f);

$r = new Predis\Client(array(
    'host' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_HOST),
    'port' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_PORT),
    'password' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_PASS),
));
$d = array(
    'signature' => $_SERVER['HTTP_X_SPIKE_WEBHOOKS_SIGNATURE'],
    'body' => $j
);
$r->setex($q['publishable_key'], 60 * 30, serialize($d));

header('HTTP/1.0 200 OK');
print('OK');
