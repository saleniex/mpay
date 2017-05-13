<?php

namespace Mobilly\Mpay;

use GuzzleHttp\Client;

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

    /** @var  string */
    private $lastResponseContent;


    public function __construct(SecurityContext $context, $serviceEndpoint = self::SERVICE_ENDPOINT)
    {
        $this->serviceEndpoint = $serviceEndpoint;
        $this->context = $context;
    }


    public function send(Request $request)
    {
        $response = $this->getHttpClient()->post($this->serviceEndpoint, [
            'body' => $request->getJson(),
        ]);

        $this->lastResponseContent = $response->getBody()->getContents();

        if (201 != $response->getStatusCode()) {
            return new ErrorResponse($this->lastResponseContent);
        }

        $data = json_decode($this->lastResponseContent, true);
        $signature = $data[Response::F_SIGNATURE];
        unset($data[Response::F_SIGNATURE]);

        $signer = $this->context->getSigner();
        if ( ! $signer->verify($data, $signature)) {
            throw new ResponseException('Invalid response signature.');
        }

        return new SuccessResponse($this->lastResponseContent);
    }


    public function getLastResponse()
    {
        return $this->lastResponseContent;
    }


    protected function getHttpClient()
    {
        if ( ! $this->client) {
            $this->client = new Client();
        }

        return $this->client;
    }
}