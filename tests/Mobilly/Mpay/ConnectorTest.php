<?php declare(strict_types=1);

namespace Mobilly\Mpay;

use PHPUnit\Framework\TestCase;


class ConnectorTest extends TestCase
{
    public function testSendSuccess()
    {
        $privateKeyPath = dirname(__FILE__, 3) . '/private.pem';
        $publicKeyPath = dirname(__FILE__, 3) . '/public.pem';
        $context = new SecurityContext('testuser', $privateKeyPath, 'test', $publicKeyPath);

        $responseData = [
            Response::F_TRANSACTION_ID => '1234567890',
            Response::F_TIMESTAMP => date('c'),
        ];
        $responseData[Response::F_SIGNATURE] = $context->getSigner()->sign($responseData);

        $connector = new \Mobilly\Mpay\Test\Connector($context);
        $connector->setResponse(json_encode($responseData), 201);

        $response = $connector->send(new Request($context));

        $this->assertTrue($response instanceof SuccessResponse);
        $this->assertEquals('1234567890', $response->getTransactionId());
    }

    public function testSendError()
    {
        $privateKeyPath = dirname(__FILE__, 3) . '/private.pem';
        $publicKeyPath = dirname(__FILE__, 3) . '/public.pem';
        $context = new SecurityContext('testuser', $privateKeyPath, 'test', $publicKeyPath);
        $connector = new \Mobilly\Mpay\Test\Connector($context);

        $connector->setResponse('', 500);
        $response = $connector->send(new Request($context));
        $this->assertTrue($response instanceof ErrorResponse);
    }
}
