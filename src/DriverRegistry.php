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

use Drewlabs\Envoyer\Contracts\ClientInterface;
use Drewlabs\Envoyer\Exceptions\DriverProviderNotFoundException;

/**
 * @method static void            flushDrivers()
 * @method static ClientInterface create(string $name)
 * @method static void            defineDriver(string $name, callable $factory, callable $argsFactory = null)
 */
final class DriverRegistry
{
    /**
     * @var static
     */
    private static $__INSTANCE__;

    /**
     * @var array<string,\Closure,\Closure>
     */
    private $drivers = [];

    /**
     * Private constructor to not be called externally as the registry is a singleton.
     */
    private function __construct()
    {
    }

    /**
     * Proxy static calls to singleton instance.
     *
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return \call_user_func_array([static::getInstance(), $name], $arguments);
    }

    /**
     * get the class singleton.
     *
     * @return DriverRegistry|static
     */
    public static function getInstance()
    {
        if (null === static::$__INSTANCE__) {
            static::$__INSTANCE__ = new static();
        }

        return static::$__INSTANCE__;
    }

    /**
     * Create the notification driver matching the driver name.
     *
     * @throws DriverProviderNotFoundException
     */
    public function create(string $name): ClientInterface
    {
        return $this->createDriver($name);
    }

    /**
     * This static method allows application users to register driver factory,
     * that might or can be resolve using Driver::create().
     *
     * Becareful as the method is static and registered driver factories
     * are static and redefining an exisiting factory using the override parameter
     * with override previously configured driver factories.
     *
     * @param \Closure|callable $factory
     * @param \Closure|callable $argsFactory
     *
     * @return void
     */
    public function defineDriver(string $name, callable $factory, callable $argsFactory = null)
    {
        $this->drivers[$name] = [$factory, $argsFactory ?? static function () {
            return [];
        }];
    }

    /**
     * reset or cleanup the custom drivers cache to it default state.
     *
     * @return void
     */
    public function flushDrivers()
    {
        $this->drivers = [];
    }

    /**
     * Resolve custom driver instance if exists.
     *
     * @throws \RuntimeException
     * @throws DriverProviderNotFoundException
     */
    private function createDriver(string $name): ClientInterface
    {
        if (\array_key_exists($name, $this->drivers)) {
            [$factory, $argsFactory] = $this->drivers[$name];

            return \call_user_func_array($factory, $argsFactory());
        }
        throw new DriverProviderNotFoundException($name);
    }
}
