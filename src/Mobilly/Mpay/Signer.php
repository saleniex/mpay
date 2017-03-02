<?php

namespace Mobilly\Mpay;

/**
 * Signer.
 * @package Mobilly\Mpay
 */
class Signer
{
    private $privateKey;
    private $privateKeySecret;
    private $publicKey;

    public function __construct($privateKey, $privateKeySecret, $publicKey)
    {
        $this->privateKey = $privateKey;
        $this->privateKeySecret = $privateKeySecret;
        $this->publicKey = $publicKey;
    }

    /**
     * Sign data.
     *
     * @param array $data
     *
     * @return string Base64 encoded signature
     *
     * @throws \Exception In case of sign error.
     */
    public function sign(array $data)
    {
        $dataNormalizer = new SignDataNormalizer();

        $privateKey = openssl_pkey_get_private('file://' . $this->privateKey, $this->privateKeySecret);
        if (false === $privateKey) {
            throw new \Exception(sprintf('Cannot sign. Cannot open private key "%s" with pass "%s".', $this->privateKey, $this->privateKeySecret));
        }

        $signature = null;
        $result = openssl_sign(
            $dataNormalizer->normalize($data),
            $signature,
            $privateKey,
            OPENSSL_ALGO_SHA256);

        if ( ! $result) {
            throw new \Exception(sprintf('Error while signing data "%s".', $data));
        }

        return base64_encode($signature);
    }

    /**
     * Verify signature.
     *
     * @param array $data
     * @param string $signature Base64 encoded signature.
     *
     * @return bool TRUE if signature is valid.
     *
     * @throws \Exception
     */
    public function verify(array $data, $signature)
    {
        $dataNormalizer = new SignDataNormalizer();

        $publicKey = openssl_pkey_get_public('file://' . $this->publicKey);
        if (false === $publicKey) {
            throw new \Exception(sprintf('Cannot verify signature. Cannot open public key "%s".', $this->publicKey));
        }

        $binSignature = base64_decode($signature);
        $result = openssl_verify(
            $dataNormalizer->normalize($data),
            $binSignature,
            $publicKey,
            OPENSSL_ALGO_SHA256);

        if (0 > $result) {
            throw new \Exception(sprintf('Error while verifying signature for "%s".', $data));
        }

        return 1 === $result;
    }
}