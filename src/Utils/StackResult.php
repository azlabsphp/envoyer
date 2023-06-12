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

use Drewlabs\Envoyer\Contracts\NotificationResult;

class StackResult implements NotificationResult, \Countable, \ArrayAccess
{
    /**
     * @var array<NotificationResult>
     */
    private $results = [];

    /**
     * @var string
     */
    private $id;

    /**
     * @var \DateTimeImmutable
     */
    private $date;

    /**
     * Creates class instance.
     */
    public function __construct(array $results)
    {
        $this->results = $results;
        $this->id = (string) (random_int(1000, 100000).time());
        $this->date = new \DateTimeImmutable();
    }

    public function date()
    {
        return $this->date;
    }

    public function id()
    {
        return $this->id;
    }

    public function isOk()
    {
        $isOk = true;
        foreach ($this->results as $result) {
            if ($result instanceof \Throwable) {
                $isOk = false;
                break;
            }
            if (!$result->isOk()) {
                $isOk = false;
                break;
            }
        }

        return $isOk;
    }

    /**
     * returns the list of notification results.
     *
     * @return NotificationResult[]
     */
    public function getResults()
    {
        return $this->results ?? [];
    }

    /**
     * Get result of a given driver.
     *
     * @return NotificationResult|null
     */
    public function getResult(string $driver)
    {
        return $this->results[$driver] ?? null;
    }

    public function count(): int
    {
        return \count($this->results);
    }

    public function offsetExists($offset): bool
    {
        return \array_key_exists($offset, $this->results);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->results[$offset] ?? null;
    }

    #[\ReturnTypeWillChange]
    public function offsetSet(mixed $offset, mixed $value)
    {
        $this->results[$offset] = $value;
    }

    #[\ReturnTypeWillChange]
    public function offsetUnset(mixed $offset)
    {
        unset($this->results[$offset]);
    }
}
