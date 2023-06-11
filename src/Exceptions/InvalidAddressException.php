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

namespace Drewlabs\Envoyer\Exceptions;

class InvalidAddressException extends \InvalidArgumentException
{
    /**
     * @param mixed $value
     * @param bool  $forReceiver
     *
     * @return InvalidAddressException
     */
    public static function mail($value, $forReceiver = false, \Throwable $e = null)
    {
        return new self(sprintf('Expect the %s email address to be a valid mail, %s given', $forReceiver ? 'to' : 'from', \gettype($value)), null !== $e ? $e->getCode() : 0, $e);
    }

    /**
     * @param mixed $value
     *
     * @return InvalidAddressException
     */
    public static function textMessage($value, \Throwable $e = null)
    {
        return new self(sprintf('Expect phone number to be a valid string, % given', \gettype($value)), null !== $e ? $e->getCode() : 0, $e);
    }
}
