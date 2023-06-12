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

use Drewlabs\Envoyer\Contracts\AttachmentsAware;
use Drewlabs\Envoyer\Contracts\NotificationInterface;
use Drewlabs\Envoyer\Contracts\SubjectAware;
use Drewlabs\Envoyer\Traits\Messageable;
use Psr\Http\Message\StreamInterface;

final class Mail implements NotificationInterface, AttachmentsAware, SubjectAware
{
    use Messageable;

    /**
     * @var resource[]|\SplFileInfo[]|StreamInterface[]
     */
    private $attachments = [];

    /**
     * @var string
     */
    private $subject;

    /**
     * @var mixed
     */
    private $bcc;

    /**
     * Creates class instance.
     *
     * @param string|\Stringable|null $content
     *
     * @return static
     */
    public function __construct(string $to = null, $content = null)
    {
        if ($to) {
            $this->to = new EmailAddress($to);
        }
        if ($content) {
            $this->content = (string) $content;
        }
    }

    /**
     * Creates new class instance.
     *
     * @param string $to
     * @param string $content
     *
     * @return static
     */
    public static function new(string $to = null, string $content = null)
    {
        return new static($to, $content);
    }

    /**
     * @return static
     */
    public function bCc(string $value)
    {
        $this->bcc = $value;

        return $this;
    }

    /**
     * Set the mail sender address.
     *
     * @return static
     */
    public function from(string $email, string $name = null)
    {
        $this->from = new EmailAddress($email, $name);

        return $this;
    }

    /**
     * Set the mail receiver address.
     *
     * @return static
     */
    public function to(string $email)
    {
        $this->to = new EmailAddress($email);

        return $this;
    }

    public function subject(string $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    public function attach($resource)
    {
        if (null === $resource) {
            return;
        }
        if (!(($resource instanceof StreamInterface) || (($resource instanceof \SplFileInfo) && $resource->isFile()) || (\is_string($resource) || \is_resource($resource)))) {
            throw new \InvalidArgumentException('Expected resource type are string, \SplFileInfo or '.StreamInterface::class);
        }
        $this->attachments[] = $resource;

        return $this;
    }

    public function getCc()
    {
        return \is_array($this->bcc) ?
            implode(',', $this->bcc) :
            $this->bcc ?? '';
    }

    public function getSubject(): string
    {
        return $this->subject ?? 'No Subject';
    }

    public function getAttachments(): array
    {
        return $this->attachments ?? [];
    }

    public function setAttachments($attachments = [])
    {
        foreach ($attachments as $value) {
            $this->attach($value);
        }
    }
}
