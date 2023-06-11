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
