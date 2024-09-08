<?php

namespace YukataRm\Laravel\Logging\Http;

use YukataRm\Laravel\Logging\Http\Trait\Config;

use YukataRm\Timer\Interface\TimerInterface;

use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

/**
 * Contents
 * 
 * @package YukataRm\Laravel\Logging\Http
 */
class Contents
{
    use Config {
        config as parentConfig;
    }

    /**
     * constructor
     * 
     * @param \YukataRm\Timer\Interface\TimerInterface $timer
     * @param \Illuminate\Http\Request $request
     * @param \Symfony\Component\HttpFoundation\Response
     */
    public function __construct(TimerInterface $timer, Request $request, Response $response)
    {
        $this->timer    = $timer;
        $this->request  = $request;
        $this->response = $response;
    }

    /**
     * get contents
     * 
     * @return array<string, mixed>
     */
    public function get(): array
    {
        return [
            "timestamp"         => $this->timestamp(),
            "memory_peak_usage" => $this->memoryPeakUsage(),
            "execution_time"    => $this->executionTime(),

            "request" => [
                "url"         => $this->requestUrl(),
                "http_method" => $this->requestHttpMethod(),
                "user_agent"  => $this->requestUserAgent(),
                "ip_address"  => $this->requestIpAddress(),
                "body"        => $this->requestBody(),
            ],

            "response" => [
                "status" => $this->responseStatus(),
            ],
        ];
    }

    /**
     * get timestamp
     * 
     * @return string
     */
    protected function timestamp(): string
    {
        return date("Y-m-d H:i:s");
    }

    /**
     * get memory peak usage
     * 
     * @return int|string
     */
    protected function memoryPeakUsage(): int|string
    {
        return $this->configMemoryPeakUsage() ? memory_get_peak_usage() : "";
    }

    /*----------------------------------------*
     * Timer
     *----------------------------------------*/

    /**
     * Timer instance
     *
     * @var \YukataRm\Timer\Interface\TimerInterface
     */
    protected TimerInterface $timer;

    /**
     * get execution time
     * 
     * @return float|string
     */
    protected function executionTime(): float|string
    {
        return $this->configExecutionTime() ? $this->timer->elapsedMilliseconds() : "";
    }

    /*----------------------------------------*
     * Request
     *----------------------------------------*/

    /**
     * Request instance
     * 
     * @var \Illuminate\Http\Request
     */
    protected Request $request;

    /**
     * get request url
     * 
     * @return string
     */
    protected function requestUrl(): string
    {
        return $this->configRequestUrl() ? $this->request->getRequestUri() : "";
    }

    /**
     * get request http method
     * 
     * @return string
     */
    protected function requestHttpMethod(): string
    {
        return $this->configRequestHttpMethod() ? $this->request->method() : "";
    }

    /**
     * get request user agent
     * 
     * @return string
     */
    protected function requestUserAgent(): string
    {
        return $this->configRequestUserAgent() ? $this->request->userAgent() : "";
    }

    /**
     * get request ip address
     * 
     * @return string
     */
    protected function requestIpAddress(): string
    {
        return $this->configRequestIpAddress() ? $this->request->ip() : "";
    }

    /**
     * get request body
     * 
     * @return array<string, mixed>
     */
    protected function requestBody(): array
    {
        return $this->configRequestBody() ? $this->request->all() : [];
    }

    /*----------------------------------------*
     * Response
     *----------------------------------------*/

    /**
     * Response instance
     * 
     * @var \Symfony\Component\HttpFoundation\Response
     */
    protected Response $response;

    /**
     * get response status
     * 
     * @return int|string
     */
    protected function responseStatus(): int
    {
        return $this->configResponseStatus() ? $this->response->getStatusCode() : "";
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
        return $this->parentConfig("contents.{$key}", $default);
    }

    /**
     * get config memory peak usage
     * 
     * @return bool
     */
    public function configMemoryPeakUsage(): bool
    {
        return $this->config("memory_peak_usage", false);
    }

    /**
     * get config execution time
     * 
     * @return bool
     */
    public function configExecutionTime(): bool
    {
        return $this->config("execution_time", false);
    }

    /**
     * get config request url
     * 
     * @return bool
     */
    public function configRequestUrl(): bool
    {
        return $this->config("request_url", false);
    }

    /**
     * get config request http method
     * 
     * @return bool
     */
    public function configRequestHttpMethod(): bool
    {
        return $this->config("request_http_method", false);
    }

    /**
     * get config request user agent
     * 
     * @return bool
     */
    public function configRequestUserAgent(): bool
    {
        return $this->config("request_user_agent", false);
    }

    /**
     * get config request ip address
     * 
     * @return bool
     */
    public function configRequestIpAddress(): bool
    {
        return $this->config("request_ip_address", false);
    }

    /**
     * get config request body
     * 
     * @return bool
     */
    public function configRequestBody(): bool
    {
        return $this->config("request_body", false);
    }

    /**
     * get config response status
     * 
     * @return bool
     */
    public function configResponseStatus(): bool
    {
        return $this->config("response_status", false);
    }
}
