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

class EmailAddress implements Addressable
{
    /**
     * @var string
     */
    private $email;

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
    public function __construct(string $email, string $name = null)
    {
        if (empty($email) || !filter_var($email, \FILTER_VALIDATE_EMAIL)) {
            throw InvalidAddressException::mail($email);
        }
        $this->email = $email;
        $this->name = $name;
    }

    public function __toString()
    {
        return sprintf('%s', $this->email);
    }

    public function name()
    {
        return $this->name;
    }

    /**
     * Set the name attached to the email.
     *
     * @return static
     */
    public function setName(string $value)
    {
        $this->name = $value;

        return $this;
    }
}
