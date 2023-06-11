# Envoyer

Client library for sending text message, email, etc... notification using various adapters / drivers.

## Usage

The library requires drivers for supported providers like [ `Amazon AWS SES` ], [ `TWILIO Sendgrid` ] driver (for sending mail using [ `Twilio Sendgrid PHP API` ]), [SMTP] driver (for sending mails using an SMTP connection), [ `Twilio Message API` ] (For sending Text message using Twilio), and SMPP driver (for sending message using an SMPP connection to an SMPP server), etc.

-- Sending an mail

For simple mail (mail without attachment), there is no need to implements [Drewlabs\Contracts\Notification\AttachmentsNotification] as it is only required for mails with attachments.

```php

// Create a notification class

// Mail.php

use Drewlabs\Envoyer\Contracts\AttachmentsAware;
use Drewlabs\Envoyer\Contracts\NotificationInterface;
use SplFileInfo;

/** @package Drewlabs\Notifications\Tests\Stubs */
class Mail implements NotificationInterface, AttachmentsAware
{

    public function setAttachments($attachments = [])
    {
    }

    public function getAttachments()
    {
        return [
            new SplFileInfo(__DIR__ . '/../contents/bordereau.pdf'),
        ];
    }
    public function getCc()
    {
        return null;
    }

    public function getSubject()
    {
        return "Successful registration";
    }

    public function getSender()
    {
        return new Address;
    }

    public function getReceiver()
    {
        return "azandrewdevelopper@gmail.com";
    }

    public function getContent()
    {
        return "<p>Hey Azandrew! Thank you for your registration</p>";
    }
}

// defines a test driver to use
DriverRegistryFacade::defineDriver('test', static function () {
    return new TestDriver();
});

// Send notification using command interface
$result = $command->driver('test')->send(new Mail);
```

- SMTP

-- Integration

> composer require drewlabs/envoyer-smtp

-- Sending mail

```php
// SendMail.php
$result = $command->driver('smtp')->send(new Mail);
```

- Twilio Message API

-- Installation

> composer require drewlabs/envoyer-twilio

-- Sending Text Message

```php

// SendMessage.php
$result = $command->driver('smtp')->send(new Message);
```

- SMPP Server

-- Installation

> composer require drewlabs/envoyer-smpp

-- Sending Text messages

```php

// SendMessage.php
$result = $command->driver('smpp')->send(new Message);
```

- Custom Driver

Custom / Thrird party drivers implementations must implements [Drewlabs\Envoyer\Contracts\ClientInterface] and define the custom logic to send notification.

```php

use Drewlabs\Envoyer\Contracts\ClientInterface;
use Drewlabs\Envoyer\Contracts\NotificationInterface;
use Drewlabs\Envoyer\Contracts\NotificationResult;
use RuntimeException;

class TestDriver implements ClientInterface
{

    public function __construct()
    {
    }

    public function sendRequest(NotificationInterface $instance): NotificationResult
    {
        // TODO : Provide send request implementation logic
    }
}
```

## API

- Mail builder

The `mail builder` class is a fluent interface for building mail notifications.

Example:

```php

// Start building the mail
$mail = \Drewlabs\Envoyer\Mail::new()
    ->from('...', '...')
    ->to('...')
    ->bCc('...')
    ->subject('...')
    ->attach(new SplFileInfo(__DIR__ . '/...'))
    ->content(require __DIR__ . '/...');

// TODO: Send the mail messge using the required driver API

```

- Text Messages builder

The `text message builder` is a fluent interface for building text messages to be send as notification instance.

```php

// Create a messageable class
$message = Messageable::new()
                        ->from('...')
                        ->to('...')
                        ->content("...");
    
// Use required driver to send the notification message
```

- Driver Enum

To avoid typo error for driver names, implementation comes with PHP constant that can be use when contructing command:

```php
use Drewlabs\Notifications\Command;
use Drewlabs\Notifications\Drivers;

$result = Command::driver(Drivers::AWS_SES)->send(/* ... */);
```

- The Drivers registry

The `drivers registry` is a singleton class that allow application developper to register and create notification drivers.

```php
use Drewlabs\Envoyer\DriverRegistryFacade;

DriverRegistryFacade::defineDriver('test', static function () {
    return new TestProvider();
});
```

**Note** The factory function/closure passed as parameter to `defineDriver` must return an instance of `Drewlabs\Envoyer\Contracts\ClientInterface` else the driver resolver will throw an exception.
