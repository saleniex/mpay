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
    private $client;

    /**
     * @var string
     */
    private $serviceEndpoint;

    /**
     * @var SecurityContext
     */
    private $context;


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

        $content = $response->getBody()->getContents();

        if (201 != $response->getStatusCode()) {
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

    protected function getHttpClient()
    {
        if ( ! $this->client) {
            $this->client = new Client();
        }

        return $this->client;
    }
}