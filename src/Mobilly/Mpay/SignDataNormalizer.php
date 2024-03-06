<?php declare(strict_types=1);

namespace Mobilly\Mpay;


use Exception;

/**
 * Sign data normalizer.
 *
 * @package Mobilly\Mpay
 */
class SignDataNormalizer
{
    /**
     * @param $data
     * @return string
     * @throws Exception In case of invalid data, e.g. contains something that is not array, string or int
     */
    public function normalize($data): string
    {
        if (is_string($data)) {
            return $data;
        }

        if (is_array($data)) {
            return $this->concat($data);
        }

        throw new Exception('Cannot normalize data if not either string of array');
    }

    /**
     * Concat array data.
     *
     * @param array $data Data to concat.
     * @return string
     *
     * @throws Exception In case of invalid data.
     */
    private function concat(array $data): string
    {
        $result = '';
        foreach ($data as $item) {
            if ( ! is_array($item) && ! is_string($item) && ! is_numeric($item)) {
                throw new Exception('Cannot normalize data as it contains something except string and array.');
            }
            if ($result) {
                $result .= '.';
            }
            $result .= is_array($item) ? $this->concat($item) : $item;
        }

        return $result;
    }
}
