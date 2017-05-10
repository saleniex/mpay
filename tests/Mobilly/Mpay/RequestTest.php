<?php

namespace Tests\Mobilly\Mpay;

require_once 'src/Mobilly/Mpay/Request.php';
require_once 'src/Mobilly/Mpay/SecurityContext.php';
require_once 'src/Mobilly/Mpay/RequestException.php';


use Mobilly\Mpay\Request;
use Mobilly\Mpay\SecurityContext;


class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $context = new SecurityContext('testuser', 'tests/private.pem', 'test', 'tests/public.pem');
        $request = new Request($context);
        $request
            ->setAmount(123)
            ->setContacts('Firstname', 'Lastname', 'user@mobilly.lv')
            ->setResultUrl('http://mobilly.lv/result')
            ->setReturnUrl('http://mobilly.lv/return')
            ->setServiceId(678)
            ->setSummary('Test transaction')
            ->setPostProcessor('PostProcessor', '{"param1":"val1"}');

        $data = $request->get();

        $this->assertEquals(123, $data['amount']);
        $this->assertEquals('EUR', $data['currency']);
        $this->assertEquals('Firstname', $data['firstname']);
        $this->assertEquals('Lastname', $data['lastname']);
        $this->assertEquals('user@mobilly.lv', $data['email']);
        $this->assertEquals('http://mobilly.lv/result', $data['result_url']);
        $this->assertEquals('http://mobilly.lv/return', $data['return_url']);
        $this->assertEquals(678, $data['service_id']);
        $this->assertEquals('Test transaction', $data['summary']);
        $this->assertTrue((new \DateTime()) >= (new \DateTime($data['timestamp'])));
        $this->assertTrue( ! empty($data['signature']));
        $this->assertEquals('PostProcessor', $data['post_processor']);
        $this->assertEquals('{"param1":"val1"}', $data['post_process_data']);
    }
}
