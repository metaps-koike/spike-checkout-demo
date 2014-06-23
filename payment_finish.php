<?php
/**
 * Finish page
 *
 * @category SPIKE
 * @package  SPIKE
 * @author   Yuki Matsukura <yuki_matsukura@metaps.com>
 * @license  GPL3  http://opensource.org/licenses/gpl-3.0.html
 * @link     https://github.com/metaps/spike-checkout-demo
 */

if (!$_POST['token']) {
    print 'token is not specified';
    exit;
}


require 'vendor/autoload.php';


$products = array();
$products[] = array(
  "title" => "商品",
  "description" => "商品説明",
  "language" => "JA",
  "price" => 300,
  "currency" => "JPY",
  "count" => 1,
  "id" => "00001",
  "stock" => 10,
);
$products[] = array(
  "title" => "Item",
  "description" => "itemdescription",
  "language" => "EN",
  "price" => 300,
  "currency" => "JPY",
  "count" => 2,
  "id" => "00002",
  "stock" => 10,
);

$params = array(
  'amount' => 900,
  'currency' => 'JPY',
  'card' => $_REQUEST['token'],
  'products' => json_encode($products),
);


$curl = new Curl\Curl();
$curl->setBasicAuthentication($_SESSION['secret_key'], '');
$curl->post('https://api.spike.cc/v1/charges', $params);



header('Content-Type:text/plain');
print_r(json_decode($curl->response));


