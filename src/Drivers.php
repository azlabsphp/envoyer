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

/**
 * Provides an enumerated list of supported drivers.
 */
class Drivers
{
    /**
     * Whatsapp web HTTP driver.
     *
     * @var string
     */
    public const WHATSAPP = 'whatsapp';

    /**
     * SMPP API standard driver.
     *
     * @var string
     */
    public const SMPP = 'smpp';

    /**
     * TWILIO API driver.
     *
     * @var string
     */
    public const TWILIO = 'twilio';

    /**
     * SMTP gateway driver.
     *
     * @var string
     */
    public const SMTP = 'smtp';

    /**
     * Sendgrid mail driver.
     *
     * @var string
     */
    public const SENDGRID = 'sendgrid';

    /**
     * Amazon AWS SES driver.
     *
     * @var string
     */
    public const AWS_SES = 'ses';

    /**
     * Custom stack driver enumerated value.
     *
     * @var string
     */
    public const STACK = 'stack';
}
