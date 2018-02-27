<?php

namespace App\File;

use App\Http\Response\Response;

/**
 * Class FileManager
 * @package App\File
 */
class FileManager implements FileManagerInterface
{
    /**
     * @var array
     */
    private $params = [];

    /**
     * @var string
     */
    private $upload;

    /**
     * FileManager constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
        $this->upload = getenv('APP_UPLOAD');
        $this->checkExistFolder(ROOT_PATH . $this->upload);
    }

    /**
     * Return file path
     *
     * @return string
     */
    private function getFileFolder(): string
    {
        return $this->upload . $this->params['type'] . '/';
    }

    /**
     * Return file name
     *
     * @return string
     */
    private function getFileName(): string
    {
        return $this->params['token'] . '.' . $this->params['type'];
    }

    /**
     * Return ontology file path
     *
     * @return string
     */
    private function getFilePath(): string
    {
        return $this->getFileFolder() . $this->getFileName();
    }

    /**
     * Check the existence of the folder
     *
     * @param $folder
     */
    private function checkExistFolder($folder): void
    {
        if (!file_exists($folder)) {
            mkdir($folder, 0700);
        }
    }

    /**
     * Return file content
     *
     * @return string
     */
    private function getFileContent(): string
    {
        return $this->params['type'] === 'json' ? $this->params['data'] : $this->params['data'];
    }

    /**
     * Return web path
     *
     * @param $filePath
     * @return string
     */
    private function getPath($filePath): string
    {
        return Response::getProtocol() . Response::getServerName() . $filePath;
    }

    /**
     * @inheritdoc
     */
    public function create(): string
    {
        $this->checkExistFolder(ROOT_PATH . $this->getFileFolder());
        $filePath = ROOT_PATH . $this->getFilePath();
        $file = fopen($filePath, 'w');
        fwrite($file, $this->getFileContent());
        fclose($file);

        return $this->getPath($this->getFilePath());
    }
}
