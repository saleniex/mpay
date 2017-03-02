<?php
/**
 * Created by PhpStorm.
 * User: uldis
 * Date: 17.2.3
 * Time: 12:43
 */

namespace Tests\Mobilly\Mpay;

require_once 'src/Mobilly/Mpay/Signer.php';

use Mobilly\Mpay\Signer;


class SignerTest extends \PHPUnit_Framework_TestCase
{
    private $data;
    private $signature;

    protected function setUp()
    {
        $this->data = [
            'a' => 'A',
            'b' => [
                'ba' => 'BA',
                'bc' => 'BC',
            ],
            'c' => 'C',
        ];
        $this->signature = 'IzF0bV3VfQ7nntpHtaiOP2gLBG9NN4LrQEunmOAeZRFycGXCAQwgZBY7fSWu1jiGvVcdYSdLbcNbPc/ykd0caTl/tSEUHtqb3+dXd85JyouiE4zcY7DuY3WBMzA2NWuANBn9GgP9RvekFKjGdsRhIIGKTJ6fq8BhjcfSsOc4NrneDt3AOhEpcC3CVJSRB2ilJorx8+fvB4t06xwwbBMX76K+s3wQmbU8eLntb9ptjh+ehlvxIz2niKmMy1iC8QBcAdaM5fNDmyvDLmfmfYUZWSxK/2p1qVUvNpk021ciG/1eIit4L7n/OFjRFoN0W6Aq/b0LogWkeHynOnsiINnz2wlXJFciX0Mz8+dVTlMVPLaE/vEjqAG4mndhULJjkUwcj36gsv54hcJ8npYmGfYoafFoX0FLRBQTX9cHfAFV+AU7OqkwgecQCuKfJXnaiEYwuqUkAiFxnL1F56M7XNiiMHjTxKEtSyPTK3LCc8bFBUjLAkII6lLT5iiCXZJ20RwDEJLEIMmZWkDTPn1AI1AhLuR+5gbOR0n5CAbrQG7uDVqCdFYp88nw+n1+HMRd0hG+skUzQ1Svyf0+Utrk9Js9+XSuOy0bCzUF/KRbpPhi9GqucCjYM1fS7T2M6Yslg3v8DI5YdiLXPgLhzSZ0zDh+lJLOf46RWdGn+Err31Q4rJ8=';
    }

    public function testSign()
    {
        $signer = new Signer('tests/private.pem', 'test', 'tests/public.pem');
        $signature = $signer->sign($this->data);
        $this->assertEquals(
            $this->signature,
            $signature);
    }

    public function testVerify()
    {
        $signer = new Signer('tests/private.pem', 'test', 'tests/public.pem');
        $this->assertTrue($signer->verify($this->data, $this->signature));
    }
}
