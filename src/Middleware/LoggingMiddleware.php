<?php

namespace YukataRm\Laravel\Logging\Http\Middleware;

use YukataRm\Laravel\Middleware\BaseMiddleware;
use Symfony\Component\HttpFoundation\Response;

use YukataRm\Laravel\Logging\Http\Logger;
use YukataRm\Laravel\Logging\Http\Contents;

use YukataRm\Laravel\Logging\Http\Trait\Config;

use YukataRm\Timer\Interface\TimerInterface;
use YukataRm\Timer\Proxy\Timer;

use YukataRm\Warehouse\Proxy\Warehouse;

/**
 * Logging Middleware
 * 
 * @package YukataRm\Laravel\Logging\Http\Middleware
 */
class LoggingMiddleware extends BaseMiddleware
{
    use Config;

    /**
     * Timer instance
     *
     * @var \YukataRm\Timer\Interface\TimerInterface
     */
    public TimerInterface $timer;

    /**
     * run the middleware handle
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function runHandle(): Response
    {
        if (!$this->isEnable()) return $this->next();

        $this->timer = Timer::start();

        return $this->next();
    }

    /**
     * run the middleware terminate
     * 
     * @return void
     */
    public function runTerminate(): void
    {
        if (!$this->isEnable()) return;

        $this->timer->stop();

        $contents = new Contents($this->timer, $this->request, $this->response);

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
