<?php declare(strict_types=1);

namespace Mobilly\Mpay;


use DateTime;
use PHPUnit\Framework\TestCase;


class RequestTest extends TestCase
{
    public function testGet()
    {
        $privateKeyPath = dirname(__FILE__, 3) . '/private.pem';
        $publicKeyPath = dirname(__FILE__, 3) . '/public.pem';
        $context = new SecurityContext('testuser', $privateKeyPath, 'test', $publicKeyPath);
        $request = new Request($context);
        $request
            ->setAmount(123)
            ->setContacts('Firstname', 'Lastname', 'user@mobilly.lv')
            ->setResultUrl('https://mobilly.lv/result')
            ->setReturnUrl('https://mobilly.lv/return')
            ->setServiceId(678)
            ->setSummary('Test transaction')
            ->setPostProcessor('PostProcessor', '{"param1":"val1"}');

        $data = $request->get();

        $this->assertEquals(123, $data['amount']);
        $this->assertEquals('EUR', $data['currency']);
        $this->assertEquals('Firstname', $data['firstname']);
        $this->assertEquals('Lastname', $data['lastname']);
        $this->assertEquals('user@mobilly.lv', $data['email']);
        $this->assertEquals('https://mobilly.lv/result', $data['result_url']);
        $this->assertEquals('https://mobilly.lv/return', $data['return_url']);
        $this->assertEquals(678, $data['service_id']);
        $this->assertEquals('Test transaction', $data['summary']);
        $this->assertTrue((new DateTime()) >= (new DateTime($data['timestamp'])));
        $this->assertNotEmpty($data['signature']);
        $this->assertEquals('PostProcessor', $data['post_processor']);
        $this->assertEquals('{"param1":"val1"}', $data['post_process_data']);
    }
}
