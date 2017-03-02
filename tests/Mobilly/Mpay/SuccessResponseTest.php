<?php
/**
 * Created by PhpStorm.
 * User: uldis
 * Date: 17.2.3
 * Time: 12:13
 */

namespace Tests\Mobilly\Mpay;

require_once 'src/Mobilly/Mpay/Response.php';
require_once 'src/Mobilly/Mpay/SuccessResponse.php';

use Mobilly\Mpay\SuccessResponse;

class SuccessResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testGetTransactionId()
    {
        $jsonString = '{"transaction_id": "1234567890"}';
        $response = new SuccessResponse($jsonString);

        $this->assertEquals('1234567890', $response->getTransactionId());
    }
}
