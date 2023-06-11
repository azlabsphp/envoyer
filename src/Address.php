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

use Drewlabs\Envoyer\Contracts\Addressable;
use Drewlabs\Envoyer\Exceptions\InvalidAddressException;

class Address implements Addressable
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $name;

    /**
     * Creates class instance.
     *
     * @throws InvalidAddressException
     *
     * @return static
     */
    public function __construct(string $value, string $name = null)
    {
        if (null === $value) {
            throw InvalidAddressException::textMessage($value);
        }
        $this->value = str_starts_with($value, '+') ? substr($value, 1) : $value;
        $this->name = $name;
    }

    public function __toString()
    {
        return sprintf('%s', $this->value);
    }

    public function name()
    {
        return $this->name;
    }
}
