<?php
/**
 * Created by PhpStorm.
 * User: uldis
 * Date: 17.24.2
 * Time: 16:17
 */

namespace Mobilly\Mpay;


class Response
{
    const ERR_DATA_VALIDATION = 100;
    const ERR_SERVICE_NOT_FOUND = 101;
    const ERR_INVALID_AMOUNT = 102;
    const ERR_INVALID_RETURN = 103;
    const ERR_INVALID_RESULT = 104;
    const ERR_INVALID_CURRENCY = 105;
    const ERR_AUTHENTICATION = 200;
    const ERR_NON_EXISTENT_USER = 201;
    const ERR_INVALID_SIGNATURE = 202;
    const ERR_INVALID_TIME_STAMP = 203;
    const ERR_SERVER = 500;

    const F_TRANSACTION_ID = 'transaction_id';
    const F_TIMESTAMP = 'timestamp';
    const F_SIGNATURE = 'signature';

    protected $data;

    public function __construct($content)
    {
        $this->data = json_decode($content, true);
    }

}