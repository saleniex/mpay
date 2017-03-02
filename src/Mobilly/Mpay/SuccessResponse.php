<?php

namespace Mobilly\Mpay;

/**
 * Successfully created transaction response.
 * @package Mobilly\Mpay
 */
class SuccessResponse extends Response
{
    public function getTransactionId()
    {
        return $this->data[self::F_TRANSACTION_ID];
    }
}