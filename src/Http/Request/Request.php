<?php

namespace App\Http\Request;

/**
 * Class Request
 * @package App\Http\Request
 */
class Request implements RequestInterface
{
    /**
     * @var array
     */
    private $params = [];

    /**
     * Return uuid
     *
     * @return string
     */
    public static function genUuid(): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * Return params from json request
     *
     * @return array
     */
    private function getJsonData(): array
    {
        $json = file_get_contents('php://input');

        return json_decode($json, true) ?? [];
    }

    /**
     * Return params from post request
     *
     * @return array
     */
    private function getPostData(): array
    {
        return $_POST ? $_POST : [];
    }

    /**
     * Check data
     *
     * @throws \Exception
     */
    private function checkData(): void
    {
        if (!$this->params['data']) {
            throw new \Exception('Data not found', 404);
        }
    }

    /**
     * Check param token
     */
    private function checkToken(): void
    {
        $pattern = '/[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-4[0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}/i';
        if (!$this->params['token'] || !preg_match($pattern, $this->params['token'])) {
            $this->params['token'] = Request::genUuid();
        }
    }

    /**
     * Check param token
     */
    private function checkType(): void
    {
        if (!$this->params['type']) {
            $this->params['type'] = getenv('APP_DEFAULT_TYPE');
        }
    }

    /**
     * Validate params
     *
     * @throws \Exception
     */
    private function valid(): void
    {
        $this->checkToken();
        $this->checkData();
        $this->checkType();
    }

    /**
     * @inheritdoc
     */
    public function getAll(): array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
                $this->params = $this->getJsonData();
            } else if ($_POST['data']) {
                $this->params = $this->getPostData();
            }
            $this->valid();
        } else {
            throw new \Exception('Method Not Allowed', 405);
        }

        return $this->params;
    }
}
