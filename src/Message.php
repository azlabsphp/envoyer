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
use Drewlabs\Envoyer\Contracts\NotificationInterface;
use Drewlabs\Envoyer\Traits\Messageable as TraitsMessageable;

final class Message implements NotificationInterface
{
    use TraitsMessageable;

    /**
     * Creates class instance.
     *
     * @param string|null             $to
     * @param string|\Stringable|null $content
     *
     * @return self
     */
    public function __construct($to = null, $content = null)
    {
        if (null !== $to) {
            $this->to($to);
        }
        if (null !== $content) {
            $this->content($content);
        }
    }

    /**
     * Creates new class instance.
     *
     * @param string|null             $to
     * @param string|\Stringable|null $content
     *
     * @return self
     */
    public static function new($to = null, $content = null)
    {
        return new static($to, $content);
    }

    /**
     * Set the sender address.
     *
     * @param string|Addressable|\Stringable $value
     *
     * @return self
     */
    public function from($value)
    {
        $this->from = $value instanceof Addressable ? $value : new Address($value);

        return $this;
    }

    /**
     * Set the receiver address.
     *
     * @param string|Addressable|\Stringable $value
     *
     * @return self
     */
    public function to($value)
    {
        $this->to = $value instanceof Addressable ? $value : new Address($value);

        return $this;
    }
}
