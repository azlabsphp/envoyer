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
use Drewlabs\Envoyer\DriverRegistryFacade as DriverRegistry;
use Drewlabs\Envoyer\Exceptions\DriverProviderNotFoundException;
use Drewlabs\Envoyer\Exceptions\InvalidAddressException;

class Command
{
    /**
     * Command backend driver.
     *
     * @var string
     */
    private $driver;

    /**
     * private constructor.
     */
    private function __construct()
    {
    }

    /**
     * Createa a command instance for the driver parameter.
     *
     * @return static
     */
    public static function driver(string $name)
    {
        $object = new static();
        $object->driver = $name;

        return $object;
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
        return DriverRegistry::create($this->driver)->sendRequest($message);
    }
}
