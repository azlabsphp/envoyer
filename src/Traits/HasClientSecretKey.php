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

trait HasClientSecretKey
{
    /**
     * @var string|null
     */
    private $client;

    /**
     * @var string|null
     */
    private $secret;

    /**
     * immutable credentials setter method.
     *
     * @return static
     */
    public function withAuthCredential(string $user, string $password)
    {
        $self = clone $this;
        $self->client = $user;
        $self->secret = $password;

        return $self;
    }

    public function getClientId(): string
    {
        return $this->client ?? '';
    }

    public function getClientSecret(): string
    {
        return $this->secret ?? '';
    }
}
