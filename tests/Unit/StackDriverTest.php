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
use Drewlabs\Envoyer\Drivers;
use Drewlabs\Envoyer\Message;
use Drewlabs\Envoyer\Tests\Stubs\TestDriver;
use Drewlabs\Envoyer\Utils\Command;
use Drewlabs\Envoyer\Utils\StackDriver;
use Drewlabs\Envoyer\Utils\StackResult;
use PHPUnit\Framework\TestCase;

class StackDriverTest extends TestCase
{
    public function test_register_stack_driver_create_driver()
    {
        $this->runTests(function () {
            $this->assertInstanceOf(StackDriver::class, DriverRegistryFacade::create(Drivers::STACK));
        });
    }

    public function test_stack_driver_notify_invoke_all_drivers_configured_in_the_stack()
    {
        $this->runTests(function () {
            /**
             * @var StackResult
             */
            $result = Command::driver(Drivers::STACK)->send(new Message('2338053533', 'Hello World!'));
            $this->assertTrue($result->offsetExists('test'), 'Expect the result to have to contain test as key');
            $this->assertTrue($result->offsetExists('test2'), 'Expect the result to have to contain test2 as key');
            $this->assertCount(2, $result);
        });
    }

    public function test_stack_driver_notify_does_not_throws_exception_is_internal_driver_throws()
    {
        $this->runTests(function () {
            /**
             * @var StackResult
             */
            $result = Command::driver(Drivers::STACK)->send(new Message('2338053533', 'Hello World!'));
            $this->assertArrayHasKey('test', $result->getResults(), 'Expect the result to have to contain test as key');
            $this->assertArrayHasKey('test2', $result->getResults(), 'Expect the result to have to contain test2 as key');
            $this->assertInstanceOf(\Throwable::class, $result['error'], 'Except the result of the error driver to be an instance of PHP throwable');
            $this->assertSame('Test driver throws', $result['error']->getMessage());
            $this->assertCount(3, $result);
        }, true);
    }

    private function runTests(Closure $test, $errored = false)
    {
        DriverRegistryFacade::flushDrivers();
        DriverRegistryFacade::defineDriver('test', static function () {
            return new TestDriver(false);
        });
        DriverRegistryFacade::defineDriver('test2', static function () {
            return new TestDriver(false);
        });
        if ($errored) {
            DriverRegistryFacade::defineDriver('error', static function () {
                return new TestDriver(true);
            });
        }
        DriverRegistryFacade::defineDriver(Drivers::STACK, static function () use ($errored) {
            return StackDriver::new($errored ? array_map(static function ($item) {
                return trim($item);
            }, explode(',', 'test, test2, error')) : ['test', 'test2']);
        });
        $test();
    }
}
