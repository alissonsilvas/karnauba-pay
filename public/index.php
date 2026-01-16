<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use App\Http\Middleware\ExceptionMiddleware;

$app = AppFactory::create();
$app->add(new ExceptionMiddleware());

(require __DIR__ . '/../src/Http/routes.php')($app);

$app->run();
