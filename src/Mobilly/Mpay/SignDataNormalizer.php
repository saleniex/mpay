<?php
/**
 * Created by PhpStorm.
 * User: uldis
 * Date: 17.28.2
 * Time: 16:01
 */

namespace Mobilly\Mpay;


/**
 * Sign data normalizer.
 *
 * @package Mpay
 */
class SignDataNormalizer
{
    public function normalize($data)
    {
        if (is_string($data)) {
            return $data;
        }

        if (is_array($data)) {
            return $this->concat($data);
        }

        throw new \Exception('Cannot normalize data if not either string of array');
    }

    /**
     * Concat array data.
     *
     * @param array $data Data to concat.
     * @return string
     *
     * @throws \Exception In case of invalid data.
     */
    private function concat(array $data)
    {
        $result = '';
        foreach ($data as $item) {
            if ( ! is_array($item) && ! is_string($item) && ! is_numeric($item)) {
                throw new \Exception('Cannot normalize data as it contains something except string and array.');
            }
            if ($result) {
                $result .= '.';
            }
            $result .= is_array($item) ? $this->concat($item) : $item;
        }

        return $result;
    }
}