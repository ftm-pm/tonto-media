<?php

namespace App\Kernel;

use App\File\FileManager;
use App\File\FileManagerInterface;
use App\Http\Request\RequestInterface;
use App\Http\Response\Response;
use App\Http\Response\ResponseInterface;

/**
 * Class Kernel
 * @package App\Kernel
 */
class Kernel implements KernelInteface
{
    /**
     * @var FileManagerInterface
     */
    private $fileManager;

    /**
     * @inheritdoc
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        try {
            $params = $request->getAll();
            $this->fileManager = new FileManager($params);
            $path = $this->fileManager->create();
            $response = new Response(['url' => $path], 200);
        } catch (\Exception $exception) {
            $response = new Response(['message' => $exception->getMessage()], $exception->getCode());
        }

        return $response;
    }
}
