<?php

namespace Mobilly\Mpay\Test;


class Connector extends \Mobilly\Mpay\Connector
{
    private $responseContent;

    private $statusCode;

    protected function getHttpClient()
    {
        return new Client($this->responseContent, $this->statusCode);
    }

    /**
     * @param $content
     * @param $code
     * @internal param mixed $responseContent
     */
    public function setResponse($content, $code)
    {
        $this->responseContent = $content;
        $this->statusCode = $code;
    }
}