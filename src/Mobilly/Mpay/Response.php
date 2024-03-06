<?php declare(strict_types=1);

namespace Mobilly\Mpay;

/**
 * Abstract response.
 * @package Mobilly\Mpay
 */
abstract class Response
{
    const int ERR_DATA_VALIDATION = 100;
    const int ERR_SERVICE_NOT_FOUND = 101;
    const int ERR_INVALID_AMOUNT = 102;
    const int ERR_INVALID_RETURN = 103;
    const int ERR_INVALID_RESULT = 104;
    const int ERR_INVALID_CURRENCY = 105;
    const int ERR_AUTHENTICATION = 200;
    const int ERR_NON_EXISTENT_USER = 201;
    const int ERR_INVALID_SIGNATURE = 202;
    const int ERR_INVALID_TIME_STAMP = 203;
    const int ERR_SERVER = 500;

    const string F_TRANSACTION_ID = 'transaction_id';
    const string F_TIMESTAMP = 'timestamp';
    const string F_SIGNATURE = 'signature';

    protected array $data = [];

    public function __construct(string $content)
    {
        $this->data = json_decode($content, true) ?? [];
    }
}
