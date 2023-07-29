<?php declare(strict_types=1);

namespace Mobilly\Mpay;

/**
 * Security context for message signing and verification.
 * @package Mobilly\Mpay
 */
class SecurityContext
{
    private string $mpayUser;
    private string $privateKey;
    private string $privateKeySecret;
    private string $publicKey;

    public function __construct(string $mpayUser, string $privateKey, string $privateKeySecret, string $publicKey)
    {
        $this->mpayUser = $mpayUser;
        $this->privateKey = $privateKey;
        $this->privateKeySecret = $privateKeySecret;
        $this->publicKey = $publicKey;
    }

    public function getSigner(): Signer
    {
        return new Signer($this->privateKey, $this->privateKeySecret, $this->publicKey);
    }

    public function getUser(): string
    {
        return $this->mpayUser;
    }
}