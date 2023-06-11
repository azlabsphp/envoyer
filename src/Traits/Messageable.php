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

namespace Drewlabs\Envoyer\Traits;

use Drewlabs\Envoyer\Contracts\Addressable;

trait Messageable
{
    /**
     * @var Addressable
     */
    private $to;

    /**
     * @var string
     */
    private $content;

    /**
     * @var Addressable
     */
    private $from;

    /**
     * Set the mail content.
     *
     * @param string|\Stringable $value
     *
     * @return self
     */
    public function content($value)
    {
        $this->content = (string) $value;

        return $this;
    }

    /**
     * returns the messageable `id` value.
     *
     * @return string
     */
    public function id()
    {
        return (string) (random_int(1000, 100000).time());
    }

    /**
     * returns the messageable `sender`.
     */
    public function getSender(): Addressable
    {
        return $this->from;
    }

    /**
     * returns the messageable `receiver`.
     */
    public function getReceiver(): Addressable
    {
        return $this->to;
    }

    public function getContent()
    {
        return (string) ($this->content ?? '');
    }
}
