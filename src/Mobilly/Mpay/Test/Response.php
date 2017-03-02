<?php

namespace Mobilly\Mpay\Test;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response implements ResponseInterface
{
    private $content;

    private $code;

    public function __construct($content, $code)
    {
        $this->content = $content;
        $this->code = $code;
    }

    public function getBody()
    {
        return new Body($this->content);
    }


    public function getProtocolVersion()
    {
    }


    public function withProtocolVersion($version)
    {
    }


    public function getHeaders()
    {
    }


    public function hasHeader($name)
    {
    }


    public function getHeader($name)
    {
    }


    public function getHeaderLine($name)
    {
    }


    public function withHeader($name, $value)
    {
    }


    public function withAddedHeader($name, $value)
    {
    }


    public function withoutHeader($name)
    {
    }


    public function withBody(StreamInterface $body)
    {
    }

    public function getStatusCode()
    {
        return $this->code;
    }

    public function withStatus($code, $reasonPhrase = '')
    {
    }

    public function getReasonPhrase()
    {
    }
}