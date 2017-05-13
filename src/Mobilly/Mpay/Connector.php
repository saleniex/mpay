<?php

namespace Mobilly\Mpay;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Connector to Mpay service.
 * @package Mobilly\Mpay
 */
class Connector
{
    const SERVICE_ENDPOINT = 'https://mpay.mobilly.lv';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    private $serviceEndpoint;

    /**
     * @var SecurityContext
     */
    private $context;

    /** @var  ResponseInterface */
    private $lastResponse;


    public function __construct(SecurityContext $context, $serviceEndpoint = self::SERVICE_ENDPOINT)
    {
        $this->serviceEndpoint = $serviceEndpoint;
        $this->context = $context;
    }


    public function send(Request $request)
    {
        $this->lastResponse = $this->getHttpClient()->post($this->serviceEndpoint, [
            'body' => $request->getJson(),
        ]);

        $content = $this->lastResponse->getBody()->getContents();

        if (201 != $this->lastResponse->getStatusCode()) {
            return new ErrorResponse($content);
        }

        $data = json_decode($content, true);
        $signature = $data[Response::F_SIGNATURE];
        unset($data[Response::F_SIGNATURE]);

        $signer = $this->context->getSigner();
        if ( ! $signer->verify($data, $signature)) {
            throw new ResponseException('Invalid response signature.');
        }

        return new SuccessResponse($content);
    }


    public function getLastResponse()
    {
        return $this->lastResponse;
    }


    protected function getHttpClient()
    {
        if ( ! $this->client) {
            $this->client = new Client();
        }

        return $this->client;
    }
}