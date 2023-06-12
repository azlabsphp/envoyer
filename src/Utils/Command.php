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

namespace Drewlabs\Envoyer\Utils;

use Drewlabs\Envoyer\Contracts\NotificationInterface;
use Drewlabs\Envoyer\Contracts\NotificationResult;
use Drewlabs\Envoyer\Exceptions\DriverProviderNotFoundException;
use Drewlabs\Envoyer\Exceptions\InvalidAddressException;
use Drewlabs\Envoyer\Contracts\DriverFactoryInterface;
use InvalidArgumentException;

class Command
{
    /**
     * Command backend driver factory.
     *
     * @var DriverFactoryInterface
     */
    private $factory;

    /**
     * private constructor.
     */
    private function __construct()
    {
    }

    /**
     * Createa a command instance for the driver parameter.
     * 
     * @param DriverFactoryInterface|string $driver 
     * @return static 
     */
    public static function driver($driver)
    {
        $object = new static();
        $factory = is_string($driver) ? new StringDriverFactory($driver) : $driver;
        return $object->withFactory($factory);
    }

    /**
     * `immutable` factory property setter
     * 
     * @param DriverFactoryInterface $factory
     * 
     * @return static 
     */
    public function withFactory(DriverFactoryInterface $factory)
    {
        $self = clone $this;
        $self->factory = $factory;
        return $self;
    }

    /**
     * Send the notification command.
     *
     * @throws DriverProviderNotFoundException
     * @throws InvalidAddressException
     * @throws \InvalidArgumentException
     *
     * @return NotificationResult
     */
    public function send(NotificationInterface $message)
    {
        return $this->factory->create()->sendRequest($message);
    }
}
