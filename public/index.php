<?php

use App\Kernel\Kernel;
use App\Http\Request\Request;
use Symfony\Component\Dotenv\Dotenv;

define('ROOT_PATH', realpath(dirname(__FILE__)));
require __DIR__ . '/../vendor/autoload.php';

// The check is to ensure we don't use .env in production
if (!isset($_SERVER['APP_ENV'])) {
    if (!class_exists(Dotenv::class)) {
        throw new \RuntimeException('APP_ENV environment variable is not defined. You need to define environment variables for configuration or add "symfony/dotenv" as a Composer dependency to load variables from a .env file.');
    }
    (new Dotenv())->load(__DIR__ . '/../.env');
}

$kernel = new Kernel();
$request = new Request();
$response = $kernel->handle($request);
$response->send();
