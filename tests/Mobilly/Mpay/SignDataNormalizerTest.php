<?php
/**
 * Created by PhpStorm.
 * User: uldis
 * Date: 17.2.3
 * Time: 12:33
 */

namespace Tests\Mobilly\Mpay;

require_once 'src/Mobilly/Mpay/SignDataNormalizer.php';

use Mobilly\Mpay\SignDataNormalizer;


class SignDataNormalizerTest extends \PHPUnit_Framework_TestCase
{
    public function testNormalize()
    {
        $normalizer = new SignDataNormalizer();
        $normalized = $normalizer->normalize([
            'a' => 'A',
            'b' => [
                'ba' => 'BA',
                'bc' => 'BC',
            ],
            'c' => 'C',
        ]);
        $this->assertEquals('A.BA.BC.C', $normalized);
    }
}
