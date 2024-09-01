<?php

namespace YukataRm\Laravel\Logging\Http\Provider;

use YukataRm\Laravel\Provider\MiddlewareServiceProvider as BaseServiceProvider;

use YukataRm\Laravel\Logging\Http\Middleware\LoggingMiddleware;

/**
 * Middleware Service Provider
 * 
 * @package YukataRm\Laravel\Logging\Http\Provider
 */
class MiddlewareServiceProvider extends BaseServiceProvider
{
    /**
     * get middlewares
     * 
     * @return array<string>
     */
    protected function middlewares(): array
    {
        return [
            LoggingMiddleware::class,
        ];
    }
}
