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
        header('Content-Type: application/json');
    }

    /**
     * @inheritdoc
     */
    public function send(): void
    {
        $this->setHeaders();
        echo json_encode($this->data);
    }
}