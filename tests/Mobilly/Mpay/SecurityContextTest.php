<?php declare(strict_types=1);

namespace Mobilly\Mpay;

use PHPUnit\Framework\TestCase;


class SecurityContextTest extends TestCase
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
