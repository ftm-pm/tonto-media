<?php

namespace App\Kernel;

use App\Http\Request\RequestInterface;
use App\Http\Response\ResponseInterface;

/**
 * Interface KernelInteface
 * @package App\Kernel
 */
interface KernelInteface
{
    /**
     * Return response
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request): ResponseInterface;
}