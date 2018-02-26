<?php

namespace App\File;

/**
 * Interface FileManagerInterface
 * @package App\File
 */
interface FileManagerInterface
{
    /**
     * Return path created file ontology
     */
    public function create(): string;
}