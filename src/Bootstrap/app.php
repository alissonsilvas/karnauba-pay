<?php

declare(strict_types=1);

use Slim\App;
use Slim\Factory\AppFactory;

return function (): App {
    return AppFactory::create();
};
