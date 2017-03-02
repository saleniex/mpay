<?php

namespace Tests\Mobilly\Mpay;

require_once 'src/Mobilly/Mpay/SecurityContext.php';
require_once 'src/Mobilly/Mpay/Signer.php';

use Mobilly\Mpay\SecurityContext;
use Mobilly\Mpay\Signer;


class SecurityContextTest extends \PHPUnit_Framework_TestCase
{
    public function testGetUser()
    {
        $context = new SecurityContext('user', 'private.pem', 'testkey', 'publickey');

        $this->assertEquals('user', $context->getUser());
    }

    public function testGetSigner()
    {
        $context = new SecurityContext('user', 'private.pem', 'testkey', 'publickey');
        $this->assertTrue($context->getSigner() instanceof Signer);
    }
}
