<?php

namespace App\Tests\Http\Response;

use App\Http\Response\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class ResponseTest
 * @package App\Tests\Http\Response
 */
class ResponseTest extends TestCase
{
    /**
     * Test get protocol
     */
    public function testGetProtocol()
    {
        $_SERVER['HTTPS'] = null;
        $protocol = Response::getProtocol();
        $this->assertSame('http://', $protocol);

        $_SERVER['HTTPS'] = 'off';
        $protocol = Response::getProtocol();
        $this->assertSame('http://', $protocol);

        $_SERVER['HTTPS'] = 'on';
        $protocol = Response::getProtocol();
        $this->assertSame('https://', $protocol);
    }

    /**
     * Test get server name
     */
    public function testGetServerName()
    {
        $_SERVER['SERVER_NAME'] = 'ftm.pm';
        $responseName = Response::getServerName();
        $this->assertSame( $_SERVER['SERVER_NAME'], $responseName);
    }
}