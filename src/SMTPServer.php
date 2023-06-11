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

use Drewlabs\Envoyer\Contracts\ClientSecretKeyAware;
use Drewlabs\Envoyer\Contracts\EncryptionAware;
use Drewlabs\Envoyer\Traits\HasClientSecretKey;

class SMTPServer extends Server implements ClientSecretKeyAware, EncryptionAware
{
    use HasClientSecretKey;

    /**
     * @var string
     */
    private $encryption;

    /**
     * Creates class instance.
     *
     * @throws \InvalidArgumentException
     *
     * @return void
     */
    public function __construct(string $host, int $port = 587, string $client = null, string $secret = null)
    {
        parent::__construct($host, $port);

        $this->client = $client;
        $this->secret = $secret;
    }

    /**
     * immutable `encryption` setter method.
     *
     * @return static
     */
    public function withEncryption(string $encryption = 'tls')
    {
        $self = clone $this;
        $self->encryption = $encryption ?? 'tls';

        return $self;
    }

    public function getEncryption()
    {
        return $this->encryption;
    }
}
