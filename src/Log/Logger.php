<?php

declare(strict_types=1);

namespace UserTestProject\Log;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;

/**
 * Class Logger
 */
class Logger extends MonologLogger
{
    /**
     * Logger constructor
     */
    public function __construct()
    {
        parent::__construct('user_test_project');
        $this->pushHandler(new StreamHandler(__DIR__ . '/../../logs/app.log', MonologLogger::DEBUG));
    }
}