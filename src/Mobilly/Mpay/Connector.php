<?php declare(strict_types=1);

namespace Mobilly\Mpay;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Connector to Mpay service.
 * @package Mobilly\Mpay
 */
class Connector
{
    const string SERVICE_ENDPOINT = 'https://mpay.mobilly.lv/transaction';
    const string SERVICE_ENDPOINT_TEST = 'https://mpay-test.mobilly.lv/transaction';


    protected ?Client $client = null;

    private string $serviceEndpoint;

    private SecurityContext $context;

    private string $lastResponseContent;

    public function __construct(SecurityContext $context, $serviceEndpoint = self::SERVICE_ENDPOINT)
    {
        $this->serviceEndpoint = $serviceEndpoint;
        $this->context = $context;
    }


    public function send(Request $request): SuccessResponse|ErrorResponse
    {
        try {
            $response = $this->getHttpClient()->post($this->serviceEndpoint, [
                'body' => $request->getJson(),
            ]);

        } catch (Exception $e) {
            return ErrorResponse::withMessage($e->getMessage());

        } catch (GuzzleException $e) {
            return ErrorResponse::withMessage($e->getMessage());
        }

        $this->lastResponseContent = $response->getBody()->getContents();

        if (201 != $response->getStatusCode()) {
            return new ErrorResponse($this->lastResponseContent);
        }

        $data = json_decode($this->lastResponseContent, true);
        $signature = $data[Response::F_SIGNATURE];
        unset($data[Response::F_SIGNATURE]);

        $signer = $this->context->getSigner();
        try {
            if ( ! $signer->verify($data, $signature)) {
                return ErrorResponse::withMessage('Invalid response signature.');
            }
        } catch (Exception $e) {
            return ErrorResponse::withMessage($e->getMessage());
        }

        return new SuccessResponse($this->lastResponseContent);
    }


    protected function getHttpClient(): Client
    {
        if ( ! $this->client) {
            $this->client = new Client();
        }

        return $this->client;
    }
}