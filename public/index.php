<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

(require __DIR__ . '/../src/Http/routes.php')($app);

$app->run();
