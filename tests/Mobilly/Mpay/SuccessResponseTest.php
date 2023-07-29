<?php declare(strict_types=1);

namespace Mobilly\Mpay;

use PHPUnit\Framework\TestCase;

class SuccessResponseTest extends TestCase
{
    public function testGetTransactionId()
    {
        $jsonString = '{"transaction_id": "1234567890"}';
        $response = new SuccessResponse($jsonString);

        $this->assertEquals('1234567890', $response->getTransactionId());
    }
}
