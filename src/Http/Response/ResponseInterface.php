<?php

namespace App\Http\Response;

/**
 * Interface ResponseInterface
 * @package App\Http\Response
 */
interface ResponseInterface
{
    /**
     * Set headers
     */
    public function setHeaders(): void;

    /**
     * Return server response
     */
    public function send();

    /**
     * Return server protocol
     *
     * @return string
     */
    public static function getServerName(): string;

    /**
     * Return server protocol
     *
     * @return string
     */
    public static function getProtocol(): string;
}