<?php

namespace Tests\Mobilly\Mpay;

require_once 'src/Mobilly/Mpay/Connector.php';
require_once 'src/Mobilly/Mpay/Test/Connector.php';
require_once 'src/Mobilly/Mpay/Test/Client.php';
require_once 'src/Mobilly/Mpay/Test/Response.php';
require_once 'src/Mobilly/Mpay/Test/Body.php';
require_once 'src/Mobilly/Mpay/Response.php';
require_once 'src/Mobilly/Mpay/ErrorResponse.php';
require_once 'src/Mobilly/Mpay/Request.php';
require_once 'src/Mobilly/Mpay/SecurityContext.php';
require_once 'src/Mobilly/Mpay/SuccessResponse.php';



use Mobilly\Mpay\Connector;
use Mobilly\Mpay\ErrorResponse;
use Mobilly\Mpay\Request;
use Mobilly\Mpay\Response;
use Mobilly\Mpay\SecurityContext;
use Mobilly\Mpay\SuccessResponse;


class ConnectorTest extends \PHPUnit_Framework_TestCase
{
    public function testSendSuccess()
    {
        $context = new SecurityContext('testuser', 'tests/private.pem', 'test', 'tests/public.pem');

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
        $context = new SecurityContext('testuser', 'tests/private.pem', 'test', 'tests/public.pem');
        $connector = new \Mobilly\Mpay\Test\Connector($context);

        $connector->setResponse('', 500);
        $response = $connector->send(new Request($context));
        $this->assertTrue($response instanceof ErrorResponse);
    }
}
