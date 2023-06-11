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

use Drewlabs\Envoyer\Contracts\ClientSecretKeyAware;
use Drewlabs\Envoyer\Server;
use Drewlabs\Envoyer\Traits\HasClientSecretKey;

class ClientSecretAuthServer extends Server implements ClientSecretKeyAware
{
    use HasClientSecretKey;

    /**
     * Creates class instance.
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public function __construct(string $host, string $client = null, string $secret = null)
    {
        parent::__construct($host);

        $this->client = $client;
        $this->secret = $secret;
    }
}
