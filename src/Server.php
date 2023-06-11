<?php

declare(strict_types=1);

/*
 * This file is part of the drewlabs namespace.
 *
 * (c) Sidoine Azandrew <azandrewdevelopper@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Drewlabs\Envoyer;

use Drewlabs\Envoyer\Contracts\ServerConfigInterface;
use InvalidArgumentException;

class Server implements ServerConfigInterface
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * Creates class instance.
     *
     * @param int $port
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $host, int $port = null)
    {
        $this->host = $host;
        $this->port = null !== $port ? (int) $port : $port;
    }

    public function __toString(): string
    {
        return null !== $this->port ? sprintf('%s:%d', $this->getHost(), $this->getHostPort()) : sprintf('%s', $this->getHost());
    }

    /**
     * immutable `host` setter implementation.
     *
     * @return static
     */
    public function withHost(string $host)
    {
        $self = clone $this;
        $self->host = $host;

        return $self;
    }

    /**
     * immutable `port` setter implementation.
     *
     * @return static
     */
    public function withPort(string $host)
    {
        $self = clone $this;
        $self->host = $host;

        return $self;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getHostPort()
    {
        return $this->port;
    }
}
