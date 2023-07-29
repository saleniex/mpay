<?php declare(strict_types=1);

namespace Mobilly\Mpay;

use PHPUnit\Framework\TestCase;


class SignDataNormalizerTest extends TestCase
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
