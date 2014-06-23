<?php
require __DIR__ . '/../vendor/autoload.php';
/**
 * Test
 *
 * @category SPIKE
 * @package  SPIKE
 * @author   Yuki Matsukura <yuki_matsukura@metaps.com>
 * @license  GPL3  http://opensource.org/licenses/gpl-3.0.html
 * @link     https://github.com/metaps/spike-checkout-demo
 */
class PHPCSTest extends \PHPUnit_Framework_TestCase
{
    /**
     * PHPCS
     */
    public function testUserScore1()
    {
        $command = __DIR__ . '/../vendor/bin/phpcs -n *.php';
        exec($command, $return);
        $this->assertTrue(!$return);
    }
}
