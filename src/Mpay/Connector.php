<?php
/**
 * Created by PhpStorm.
 * User: uldis
 * Date: 17.24.2
 * Time: 16:17
 */

namespace Mpay;


class Connector
{
    /**
     * @var Signer
     */
    private $signer;

    public function __construct(Signer $signer)
    {
        $this->signer = $signer;
    }

    public function send(Request $request)
    {
        return new Response('{}');
    }
}