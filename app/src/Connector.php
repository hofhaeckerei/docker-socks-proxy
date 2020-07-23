<?php
declare(strict_types=1);
namespace OliverHader\PhpProxies;

use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use React\Socket\ConnectorInterface;

class Connector implements ConnectorInterface
{
    /**
     * @var LoopInterface
     */
    private $loop;

    /**
     * @var ConnectorInterface
     */
    private $defaultConnector;

    public function __construct(LoopInterface $loop, ConnectorInterface $defaultConnector = null)
    {
        $this->loop = $loop;
        $this->defaultConnector = $defaultConnector ?? new \React\Socket\Connector($loop);
    }

    public function connect($uri): PromiseInterface
    {
        return $this->defaultConnector->connect($uri);
    }
}
