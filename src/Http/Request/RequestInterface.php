<?php

namespace App\Http\Request;

/**
 * Interface RequestInterface
 * @package App\Http\Request
 */
interface RequestInterface
{
    /**
     * Return request params
     *
     * @return mixed
     */
    public function getAll(): array;
}