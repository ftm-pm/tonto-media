<?php

namespace App\Tests\Kernel;

use App\Http\Request\Request;
use App\Http\Response\Response;
use App\Kernel\Kernel;
use PHPUnit\Framework\TestCase;

/**
 * Class KernelTest
 * @package App\Tests\Kernel
 */
class KernelTest extends TestCase
{
    /**
     * Test kernel handle
     *
     * @dataProvider paramsProvider
     *
     * @param array $params
     * @param string $https
     * @param string $serverName
     * @param string $upload
     */
    public function testHandle(array $params, string $https, string $serverName, string $upload)
    {
        define('ROOT_PATH', sys_get_temp_dir());
        $_POST = $params;
        $_SERVER['HTTPS'] = $https;
        $_SERVER['SERVER_NAME'] = $serverName;

        $path = 'https://' . $serverName . $upload . $params['type'] . '/' . $params['token'] . '.' . $params['type'];
        $response = new Response(['url'  => $path], 200);

        $kernel = new Kernel();
        $kernelResponse  = $kernel->handle(new Request());

        $this->assertEquals($response, $kernelResponse);
    }

    /**
     * Params provider
     *
     * @return array
     */
    public function paramsProvider()
    {
        return [
            [
                'post' => [
                    'data' => 'test data',
                    'type' => 'owl',
                    'token' => '2b1ec9db-c6f9-4c7c-bdd7-ffeb8c4cd250'
                ],
                'https' => 'on',
                'serverName' => 'ftm.pm/',
                'upload' => getenv('APP_UPLOAD')
            ]
        ];
    }
}