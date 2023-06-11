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

use DateTimeImmutable;
use Drewlabs\Envoyer\Contracts\NotificationResult;

class Result implements NotificationResult
{
    /**
     * @var bool
     */
    private $isOk = true;

    /**
     * @var string
     */
    private $id;

    /**
     * @var DateTimeImmutable
     */
    private $date;

    /**
     * Creates class instance.
     *
     * @param bool $isOk
     */
    public function __construct($isOk = true)
    {
        $this->isOk = $isOk;
        $this->id = (string) (random_int(1000, 100000).time());
        $this->date = new DateTimeImmutable();
    }

    public function date()
    {
        return $this->date;
    }

    public function id()
    {
        return $this->id;
    }

    public function isOk()
    {
        return $this->isOk;
    }
}
