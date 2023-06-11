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

use Drewlabs\Envoyer\Contracts\ApiKeyAware;

class ApiKeyServer extends Server implements ApiKeyAware
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * Creates class instance.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $host, string $apiKey)
    {
        parent::__construct($host);
        $this->apiKey = $apiKey;
    }

    /**
     * immutable method for setting the api key for a copy of the current instance.
     *
     * @return static
     */
    public function withApiKey(string $value)
    {
        $self = clone $this;
        $self->apiKey = $value;

        return $self;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }
}
