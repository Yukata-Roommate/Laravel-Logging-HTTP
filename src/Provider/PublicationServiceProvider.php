<?php

namespace YukataRm\Laravel\Logging\Http\Provider;

use YukataRm\Laravel\Provider\PublicationServiceProvider as BaseServiceProvider;

/**
 * Publication Service Provider
 * 
 * @package YukataRm\Laravel\Logging\Http\Provider
 */
class PublicationServiceProvider extends BaseServiceProvider
{
    /**
     * base path
     * 
     * @var string
     */
    protected string $basePath = __DIR__;

    /**
     * publish common group
     * 
     * @var string
     */
    protected string $commonGroup = "yukata-roommate";

    /**
     * get publications
     * 
     * @return array<string, array<string, string>>
     */
    protected function publications(): array
    {
        return [
            "ym-logging-http" => [
                "config" => config_path("yukata-roommate"),
            ],
        ];
    }
}
