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

use Drewlabs\Envoyer\Contracts\ClientInterface;
use Drewlabs\Envoyer\Contracts\NotificationInterface;
use Drewlabs\Envoyer\DriverRegistryFacade as DriverRegistry;
use Drewlabs\Envoyer\Exceptions\DriverProviderNotFoundException;

/**
 * **Note**
 * In order not to prevent other driver request to fail due to a given
 * driver request failure the implementation wrap call to each driver
 * sendRequest() method with a try catch block and return the exception object
 * to the caller.
 * Therefore, callers must check if the return result is not an instance
 * of `PHP` `\Throwable` before proceeding any further with handler results.
 */
class StackDriver implements ClientInterface
{
    /**
     * @var string[]
     */
    private $drivers = [];

    /**
     * creates a driver instance.
     */
    public function __construct(array $drivers = [])
    {
        $this->drivers = $drivers ?? [];
    }

    /**
     * Creates a stack driver instance.
     *
     * @return static
     */
    public static function new(array $drivers)
    {
        return new static($drivers);
    }

    public function sendRequest(NotificationInterface $instance): StackResult
    {
        return new StackResult(iterator_to_array($this->sendRequests($instance)));
    }

    /**
     * Send request using notification drivers configured for the
     * in stack drivers configuration.
     *
     * **Note**
     * In order not to prevent other driver request to fail due to a given
     * driver request failure the implementation wrap call to each driver
     * notify() method with a try catch block and return the exception object
     * to the caller.
     * Therefore, callers must check if the return result is not an instance
     * of `PHP` `\Throwable` before proceeding any further with handler results
     *
     * @throws DriverProviderNotFoundException
     *
     * @return \Generator<string, mixed, mixed, void>
     */
    private function sendRequests(NotificationInterface $instance)
    {
        foreach ($this->drivers as $driver) {
            // In order not to block the other drivers when request using a given driver fails
            // we wrap the calls in a try catch block that returns the exception to the caller
            // as an object
            try {
                yield $driver => DriverRegistry::create($driver)->sendRequest($instance);
            } catch (\Throwable $e) {
                yield $driver => $e;
            }
        }
    }
}
