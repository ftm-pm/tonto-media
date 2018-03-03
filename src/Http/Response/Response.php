<?php

namespace App\Http\Response;

/**
 * Class Response
 * @package App\Http\Response
 */
class Response implements ResponseInterface
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var integer
     */
    private $code;

    /**
     * Response constructor.
     * @param mixed $data
     * @param int $code
     */
    public function __construct($data = null, int $code = 200)
    {
        $this->data = $data;
        $this->code = $code;
    }

    /**
     * @inheritdoc
     */
    public static function getProtocol(): string
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://' : 'http://';
    }

    /**
     * @inheritdoc
     */
    public static function getServerName(): string
    {
        return $_SERVER['SERVER_NAME'];
    }

    /**
     * @inheritdoc
     */
    public function setHeaders(): void
    {
        if (!headers_sent()) {
            if (isset($_SERVER['HTTP_ORIGIN'])) {
                header("Access-Control-Allow-Origin: *");
                header('Access-Control-Allow-Credentials: true');
                header('Access-Control-Max-Age: 86400');
            }

            // Access-Control headers are received during OPTIONS requests
            if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
                if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
                }
                if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                    header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
                }
            }
            // header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
        }
    }

    /**
     * @inheritdoc
     */
    public function send(): void
    {
        $this->setHeaders();
        if ($this->data) {
            echo json_encode($this->data);
        }
    }
}