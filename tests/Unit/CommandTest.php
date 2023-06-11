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

use Drewlabs\Envoyer\DriverRegistryFacade;
use Drewlabs\Envoyer\Message;
use Drewlabs\Envoyer\Tests\Stubs\Result;
use Drewlabs\Envoyer\Tests\Stubs\TestDriver;
use Drewlabs\Envoyer\Utils\Command;
use PHPUnit\Framework\TestCase;
use Drewlabs\Envoyer\Exceptions\DriverProviderNotFoundException;

class CommandTest extends TestCase
{
    public function test_command_fails_for_missing_driver_instance()
    {
        DriverRegistryFacade::flushDrivers();
        $this->expectException(DriverProviderNotFoundException::class);
        Command::driver('test')->send(new Message());
    }

    public function test_command_send_completes_successfully()
    {
        DriverRegistryFacade::flushDrivers();
        DriverRegistryFacade::defineDriver('test', static function () {
            return new TestDriver();
        });
        $result = Command::driver('test')->send(new Message('2338053533', 'Hello World!'));
        $this->assertInstanceOf(Result::class, $result);
    }
}
