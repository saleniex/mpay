<?php
/**
 * Created by PhpStorm.
 * User: uldis
 * Date: 17.28.2
 * Time: 14:54
 */

namespace Mpay;

/**
 * Security context for message signing and verification.
 *
 * @package Mpay
 */
class SecurityContext
{
    private $mpayUser;
    private $privateKey;
    private $privateKeySecret;
    private $publicKey;

    public function __construct($mpayUser, $privateKey, $privateKeySecret, $publicKey)
    {
        $this->mpayUser = $mpayUser;
        $this->privateKey = $privateKey;
        $this->privateKeySecret = $privateKeySecret;
        $this->publicKey = $publicKey;
    }

    public function getSigner()
    {
        return new Signer($this->privateKey, $this->privateKeySecret, $this->publicKey);
    }

    public function getUser()
    {
        return $this->mpayUser;
    }
}