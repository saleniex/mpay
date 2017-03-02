<?php
/**
 * Created by PhpStorm.
 * User: uldis
 * Date: 17.24.2
 * Time: 16:46
 */

namespace Mobilly\Mpay;

/**
 * Successfully created transaction response.
 *
 * @package Mpay
 */
class SuccessResponse extends Response
{
    public function getTransactionId()
    {
        return $this->data[self::F_TRANSACTION_ID];
    }
}