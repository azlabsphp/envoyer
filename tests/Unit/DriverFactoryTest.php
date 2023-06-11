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

use Drewlabs\Envoyer\Contracts\ClientInterface;
use Drewlabs\Envoyer\DriverRegistryFacade;
use Drewlabs\Envoyer\Exceptions\DriverProviderNotFoundException;
use Drewlabs\Envoyer\Tests\Stubs\TestDriver;
use PHPUnit\Framework\TestCase;

class DriverFactoryTest extends TestCase
{
    public function test_create_throws_exception_if_no_custom_driver_is_define()
    {
        DriverRegistryFacade::flushDrivers();
        $this->expectException(DriverProviderNotFoundException::class);
        $this->expectExceptionMessage('No driver configured for test driver');
        DriverRegistryFacade::create('test');
    }

    public function test_create_throws_exception_if_custom_driver_factory_return_non_client_instance()
    {
        DriverRegistryFacade::flushDrivers();
        DriverRegistryFacade::defineDriver('test', static function () {
            return [];
        });
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('Drewlabs\Envoyer\DriverRegistry::createDriver(): Return value must be of type Drewlabs\Envoyer\Contracts\ClientInterface, array returned');
        DriverRegistryFacade::create('test');
    }

    public function test_create_returns_client_instance()
    {
        DriverRegistryFacade::flushDrivers();
        DriverRegistryFacade::defineDriver('test', static function () {
            return new TestDriver();
        });
        $driver = DriverRegistryFacade::create('test');
        $this->assertInstanceOf(ClientInterface::class, $driver);
    }
}
