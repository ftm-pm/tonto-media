<?php

namespace App\Tests\Http\Request;

use App\Http\Request\Request;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestTest
 * @package App\Tests\Http\Request
 */
class RequestTest extends TestCase
{
    /**
     * Test generate uuid
     */
    public function testGenUuid()
    {
        $pattern = '/[0-9a-fA-F]{4}-4[0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}/i';
        $uuid = Request::genUuid();

        $this->assertSame(1, preg_match($pattern, $uuid));
    }

    /**
     * Test getAll with type "owl"
     * @throws \Exception
     */
    public function testGetAllOwl()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'data' => 'test data',
            'type' => 'owl',
            'token' => '2b1ec9db-c6f9-4c7c-bdd7-ffeb8c4cd250'
        ];
        $requestData = (new Request())->getAll();
        $this->assertSame($_POST, $requestData);
    }

    /**
     * Test getAll with type "json"
     * @throws \Exception
     */
    public function testGetAllDataJson()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'data' => 'test data',
            'type' => 'json',
            'token' => '2b1ec9db-c6f9-4c7c-bdd7-ffeb8c4cd250'
        ];
        $requestData = (new Request())->getAll();
        $this->assertSame($_POST, $requestData);
    }

    /**
     * Test getAll with empty type
     * @throws \Exception
     */
    public function testGetAllEmptyType()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $data = [
            'data' => 'test data',
            'token' => '2b1ec9db-c6f9-4c7c-bdd7-ffeb8c4cd250'
        ];
        $_POST = $data;
        $requestData = (new Request())->getAll();
        $data['type'] = getenv('APP_DEFAULT_TYPE');
        $this->assertSame($data, $requestData);
    }
}
