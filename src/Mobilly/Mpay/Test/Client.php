<?php

namespace Mobilly\Mpay\Test;


class Client
{
    private $responseContent;

    private $statusCode;

    public function __construct($responseContent, $statusCode)
    {

        $this->responseContent = $responseContent;
        $this->statusCode = $statusCode;
    }

    public function post($endpoint, $options = [])
    {
        return new Response($this->responseContent, $this->statusCode);
    }
}