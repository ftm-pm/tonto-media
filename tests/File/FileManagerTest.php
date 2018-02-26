<?php

namespace App\Tests\File;

use App\File\FileManager;
use PHPUnit\Framework\TestCase;

/**
 * Class FileManagerTest
 * @package App\Tests\File
 */
class FileManagerTest extends TestCase
{
    /**
     * Test get file name
     *
     * @dataProvider paramsProvider
     */
    public function testCreate($params)
    {
        $_SERVER['HTTPS'] = 'on';
        $_SERVER['SERVER_NAME'] = 'ftm.pm/';
        define('ROOT_PATH', sys_get_temp_dir());
        $upload = getenv('APP_UPLOAD');
        $fileManager = new FileManager($params);
        $path = 'https://ftm.pm/' . $upload . $params['type'] . '/' . $params['token'] . '.' . $params['type'];
        $filePath = $fileManager->create();
        $this->assertSame($path, $filePath);
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
                'params' => [
                    'data' => 'test data',
                    'type' => 'owl',
                    'token' => '2b1ec9db-c6f9-4c7c-bdd7-ffeb8c4cd250'
                ]
            ]
        ];
    }
}