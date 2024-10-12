<?php

namespace Webgrip\TelemetryService\Infrastructure\Services;

use Monolog\Level;
use Monolog\Logger;
use OpenTelemetry\API\Logs\LoggerProviderInterface;
use OpenTelemetry\API\Trace\TracerInterface;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use OpenTelemetry\Contrib\Logs\Monolog\Handler;
use Psr\Log\LoggerInterface;
use Webgrip\TelemetryService\Core\Domain\Services\TelemetryServiceInterface;

final readonly class TelemetryService implements TelemetryServiceInterface
{
    public function __construct(
        private LoggerProviderInterface $loggerProvider,
        private TracerProviderInterface $tracerProvider,
        private Logger $logger,
    )
    {
        $this->logger->pushHandler(
            new Handler(
                $this->loggerProvider,
                Level::Debug
            )
        );
    }

    public function tracer(): TracerInterface
    {
        return $this->tracerProvider->getTracer('io.opentelemetry.contrib.php');
    }

    public function logger(): LoggerInterface
    {
        return $this->logger;
    }
}
