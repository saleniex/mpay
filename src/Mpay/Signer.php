<?php
/**
 * Created by PhpStorm.
 * User: uldis
 * Date: 17.24.2
 * Time: 16:17
 */

namespace Mpay;


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

        $signature = null;
        $result = openssl_sign(
            $dataNormalizer->normalize($data),
            $signature,
            $this->privateKey,
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

        $binSignature = base64_decode($signature);
        $result = openssl_verify(
            $dataNormalizer->normalize($data),
            $binSignature,
            $this->publicKey,
            OPENSSL_ALGO_SHA256);

        if (0 > $result) {
            throw new \Exception(sprintf('Error while verifying signature for "%s".', $data));
        }

        return 1 === $result;
    }
}