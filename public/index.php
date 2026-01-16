<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$app = (require __DIR__ . '/../src/Bootstrap/app.php')();

(require __DIR__ . '/../src/Http/routes.php')($app);

$app->run();
