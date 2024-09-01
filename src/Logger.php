<?php

namespace YukataRm\Laravel\Logging\Http;

use YukataRm\Laravel\Logging\Http\Trait\Config;

use YukataRm\Laravel\Logger\Interface\LoggerInterface;
use YukataRm\Laravel\Logger\Facade\Logger as Facade;
use YukataRm\Logger\Enum\LogFormatEnum;

/**
 * Logger
 * 
 * @package YukataRm\Laravel\Logging\Http
 */
class Logger
{
    use Config {
        config as parentConfig;
    }

    /**
     * logging
     * 
     * @param array<string, mixed> $contents
     * @return void
     */
    public function logging(array $contents): void
    {
        $logger = $this->getLogger();

        $logger->add($contents);

        $logger->logging();
    }

    /**
     * get Logger instance
     * 
     * @return \YukataRm\Laravel\Logger\Interface\LoggerInterface
     */
    protected function getLogger(): LoggerInterface
    {
        $logger = Facade::info();

        $logger->setBaseDirectory($this->configBaseDirectory());

        $logger->setDirectory($this->configDirectory());

        $logger->setFileNameFormat($this->configFileNameFormat());

        $logger->setFileExtension($this->configFileExtension());

        $logger->setFileMode($this->configFileMode());

        if (!is_null($this->configFileOwner())) $logger->setFileOwner($this->configFileOwner());

        if (!is_null($this->configFileGroup())) $logger->setFileGroup($this->configFileGroup());

        $logger->setLogFormat(LogFormatEnum::MESSAGE);

        return $logger;
    }

    /*----------------------------------------*
     * Config
     *----------------------------------------*/

    /**
     * get config or default
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function config(string $key, mixed $default): mixed
    {
        return $this->parentConfig("logging.{$key}", $default);
    }

    /**
     * get config base directory
     * 
     * @return string
     */
    protected function configBaseDirectory(): string
    {
        return $this->config("base_directory", storage_path("logs"));
    }

    /**
     * get config directory
     * 
     * @return string
     */
    protected function configDirectory(): string
    {
        return $this->config("directory", "http");
    }

    /**
     * get config file name format
     * 
     * @return string
     */
    protected function configFileNameFormat(): string
    {
        return $this->config("file.name_format", "Y-m-d");
    }

    /**
     * get config file extension
     * 
     * @return string
     */
    protected function configFileExtension(): string
    {
        return $this->config("file.extension", "log");
    }

    /**
     * get config file mode
     * 
     * @return int
     */
    protected function configFileMode(): int
    {
        return $this->config("file.mode", 0666);
    }

    /**
     * get config file owner
     * 
     * @return string|null
     */
    protected function configFileOwner(): string|null
    {
        return $this->config("file.owner", null);
    }

    /**
     * get config file group
     * 
     * @return string|null
     */
    protected function configFileGroup(): string|null
    {
        return $this->config("file.group", null);
    }
}
