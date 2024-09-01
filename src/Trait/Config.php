<?php

namespace YukataRm\Laravel\Logging\Http\Trait;

/**
 * Config trait
 * 
 * @package YukataRm\Laravel\Logging\Http\Trait
 */
trait Config
{
    /**
     * get config or default
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function config(string $key, mixed $default): mixed
    {
        return config("yukata-roommate.logging.http.{$key}", $default);
    }
}
