<?php

namespace YukataRm\Laravel\Logging\Http\Middleware;

use YukataRm\Laravel\Logging\Http\Logger;
use YukataRm\Laravel\Logging\Http\Contents;

use YukataRm\Laravel\Logging\Http\Trait\Config;

use YukataRm\Timer\Interface\TimerInterface;
use YukataRm\Timer\Proxy\Timer;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

use YukataRm\Warehouse\Proxy\Warehouse;

/**
 * Logging Middleware
 * 
 * @package YukataRm\Laravel\Logging\Http\Middleware
 */
class LoggingMiddleware
{
    use Config;

    /**
     * Timer instance
     *
     * @var \YukataRm\Timer\Interface\TimerInterface
     */
    public TimerInterface $timer;

    /**
     * handle an incoming request
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     */
    public function handle(Request $request, \Closure $next): SymfonyResponse
    {
        if (!$this->isEnable()) return $next($request);

        $this->timer = Timer::start();

        return $next($request);
    }

    /**
     * terminate an incoming request
     *
     * @param \Illuminate\Http\Request $request
     * @param IlluminateResponse|RedirectResponse|JsonResponse $response
     * @return void
     */
    public function terminate(Request $request, IlluminateResponse|RedirectResponse|JsonResponse $response): void
    {
        if (!$this->isEnable()) return;

        $this->timer->stop();

        $contents = new Contents($this->timer, $request, $response);

        $masked = Warehouse::maskingRecursive(
            $contents->get(),
            $this->configMaskingParameters(),
            $this->configMaskingText()
        );

        $logger = new Logger();

        $logger->logging($masked);
    }

    /**
     * whether enable
     * 
     * @return bool
     */
    public function isEnable(): bool
    {
        return $this->configEnable();
    }

    /*----------------------------------------*
     * Config
     *----------------------------------------*/

    /**
     * get config enable
     * 
     * @return bool
     */
    public function configEnable(): bool
    {
        return $this->config("enable", false);
    }

    /**
     * get config masking text
     * 
     * @return string
     */
    public function configMaskingText(): string
    {
        return $this->config("masking.text", "********");
    }

    /**
     * get config masking parameters
     * 
     * @return array<string>
     */
    public function configMaskingParameters(): array
    {
        return $this->config("masking.parameters", []);
    }
}
