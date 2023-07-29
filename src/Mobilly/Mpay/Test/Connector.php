<?php declare(strict_types=1);

namespace Mobilly\Mpay\Test;


use GuzzleHttp\Handler\MockHandler;

class Connector extends \Mobilly\Mpay\Connector
{
    private string $responseContent = '';

    private int $statusCode = 200;


    protected function getHttpClient(): \GuzzleHttp\Client
    {
        $mockHandler = new MockHandler([
            new \GuzzleHttp\Psr7\Response($this->statusCode, [], $this->responseContent),
        ]);
        return new \GuzzleHttp\Client(['handler' => $mockHandler]);
    }


    public function setResponse(string $content, int $code): void
    {
        $this->responseContent = $content;
        $this->statusCode = $code;
    }
}