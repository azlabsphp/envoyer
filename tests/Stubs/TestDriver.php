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

namespace Drewlabs\Envoyer\Tests\Stubs;

use Drewlabs\Envoyer\Contracts\ClientInterface;
use Drewlabs\Envoyer\Contracts\NotificationInterface;
use Drewlabs\Envoyer\Contracts\NotificationResult;
use RuntimeException;

class TestDriver implements ClientInterface
{
    /**
     * Simulate a driver that throws error.
     *
     * @var bool
     */
    private $throws;

    public function __construct(bool $throws = false)
    {
        $this->throws = $throws;
    }

    public function sendRequest(NotificationInterface $instance): NotificationResult
    {
        if ($this->throws) {
            throw new RuntimeException('Test driver throws');
        }

        return new Result();
    }
}
