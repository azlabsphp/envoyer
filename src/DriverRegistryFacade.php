<?php

namespace Drewlabs\Envoyer;

use Drewlabs\Envoyer\Contracts\ClientInterface;

/**
 * @method static void            flushDrivers()
 * @method static ClientInterface create(string $name)
 * @method static void            defineDriver(string $name, callable $factory, callable $argsFactory = null)
 */
final class DriverRegistryFacade
{
    /**
     * Proxy static calls to singleton instance.
     *
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return \call_user_func_array([DriverRegistry::getInstance(), $name], $arguments);
    }
}
